<?php
/*
 * @copyright Copyright (c) 2023 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\controllers;

use Altum\Alerts;
use Altum\Response;
use Altum\Uploads;

class UpscaledImageCreate extends Controller {

    public function index() {
        \Altum\Authentication::guard();

        if(!settings()->aix->upscaled_images_is_enabled) {
            redirect('dashboard');
        }

        /* Team checks */
        if(\Altum\Teams::is_delegated() && !\Altum\Teams::has_access('create.upscaled_images')) {
            Alerts::add_info(l('global.info_message.team_no_access'));
            redirect('upscaled-images');
        }

        /* Check for the plan limit */
        $upscaled_images_current_month = db()->where('user_id', $this->user->user_id)->getValue('users', '`aix_upscaled_images_current_month`');
        if($this->user->plan_settings->upscaled_images_per_month_limit != -1 && $upscaled_images_current_month >= $this->user->plan_settings->upscaled_images_per_month_limit) {
            Alerts::add_info(l('global.info_message.plan_feature_limit'));
            redirect('upscaled-images');
        }

        /* Check for exclusive personal API usage limitation */
        if($this->user->plan_settings->exclusive_personal_api_keys && empty($this->user->preferences->clipdrop_api_key)) {
            Alerts::add_error(sprintf(l('account_preferences.error_message.aix.clipdrop_api_key'), '<a href="' . url('account-preferences') . '"><strong>' . l('account_preferences.menu') . '</strong></a>'));
        }

        /* Get available projects */
        $projects = (new \Altum\Models\Projects())->get_projects_by_user_id($this->user->user_id);

        /* Clear $_GET */
        foreach($_GET as $key => $value) {
            $_GET[$key] = input_clean($value);
        }

        $values = [
            'name' => $_GET['name'] ?? $_POST['name'] ?? sprintf(l('image_create.name_x'), \Altum\Date::get()),
            'scale' => $_GET['scale'] ?? $_POST['scale'] ?? 2,
            'project_id' => $_GET['project_id'] ?? $_POST['project_id'] ?? null,
        ];

        /* Prepare the View */
        $data = [
            'values' => $values,
            'projects' => $projects ?? [],
        ];

        $view = new \Altum\View(THEME_PATH . 'views/upscaled-image-create/index', (array) $this, true);

        $this->add_view_content('content', $view->run($data));

    }

    public function create_ajax() {
        //ALTUMCODE:DEMO if(DEMO) if($this->user->user_id == 1) Response::json('Please create an account on the demo to test out this function.', 'error');

        if(empty($_POST)) {
            redirect();
        }

        set_time_limit(0);

        \Altum\Authentication::guard();

        if(!settings()->aix->upscaled_images_is_enabled) {
            redirect('dashboard');
        }

        /* Team checks */
        if(\Altum\Teams::is_delegated() && !\Altum\Teams::has_access('create.upscaled_images')) {
            Response::json(l('global.info_message.team_no_access'), 'error');
        }

        /* Check for the plan limit */
        $upscaled_images_current_month = db()->where('user_id', $this->user->user_id)->getValue('users', '`aix_upscaled_images_current_month`');
        if($this->user->plan_settings->upscaled_images_per_month_limit != -1 && $upscaled_images_current_month >= $this->user->plan_settings->upscaled_images_per_month_limit) {
            Response::json(l('global.info_message.plan_feature_limit'), 'error');
        }

        /* Get available projects */
        $projects = (new \Altum\Models\Projects())->get_projects_by_user_id($this->user->user_id);

        $_POST['name'] = input_clean($_POST['name'], 64);
        $_POST['scale'] = $_POST['scale'] < 2 || $_POST['scale'] > 4 ? 2 : (int) $_POST['scale'];
        $_POST['project_id'] = !empty($_POST['project_id']) && array_key_exists($_POST['project_id'], $projects) ? (int) $_POST['project_id'] : null;

        /* Check for any errors */
        $required_fields = ['name'];
        foreach($required_fields as $field) {
            if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]) && $_POST[$field] != '0')) {
                Response::json(l('global.error_message.empty_fields'), 'error');
            }
        }

        if(empty($_FILES['original_image']['name'])) {
            Response::json(l('global.error_message.empty_fields'), 'error');
        }

        if(!\Altum\Csrf::check('global_token')) {
            Response::json(l('global.error_message.invalid_csrf_token'), 'error');
        }

        \Altum\Uploads::validate_upload('upscaled_images', 'original_image', $this->user->plan_settings->upscaled_images_file_size_limit);

        /* Get size of the original image */
        $uploaded_image_size_info = getimagesize($_FILES['original_image']['tmp_name']);

        /* Set the target height / width */
        $target_width = $uploaded_image_size_info[0] * $_POST['scale'] > 4096 ? 4096 : $uploaded_image_size_info[0] * $_POST['scale'];
        $target_height = $uploaded_image_size_info[1] * $_POST['scale'] > 4096 ? 4096 : $uploaded_image_size_info[1] * $_POST['scale'];

        /* Try to increase the database timeout as well */
        database()->query("set session wait_timeout=600;");

        /* Do not use sessions anymore to not lockout the user from doing anything else on the site */
        session_write_close();

        try {
            $response = \Unirest\Request::post(
                'https://clipdrop-api.co/image-upscaling/v1/upscale',
                [
                    'x-api-key' => get_random_line_from_text($this->user->plan_settings->exclusive_personal_api_keys ? $this->user->preferences->clipdrop_api_key : settings()->aix->clipdrop_api_key),
                ],
                \Unirest\Request\Body::multipart([
                    'target_width' => $target_width,
                    'target_height' => $target_height,
                ], [
                    'image_file' => $_FILES['original_image']['tmp_name']
                ])
            );

            if($response->code >= 400) {
                /* Delete temp */
                unlink($_FILES['original_image']['tmp_name']);

                Response::json($response->body->error, 'error');
            }

        } catch (\Exception $exception) {
            /* Delete temp */
            unlink($_FILES['original_image']['tmp_name']);

            Response::json($exception->getMessage(), 'error');
        }

        /* Save the image */
        $original_image = \Altum\Uploads::process_upload(null, 'upscaled_images', 'original_image', 'original_image_remove', $this->user->plan_settings->upscaled_images_file_size_limit);

        /* Generate new name for image */
        $upscaled_image = md5(time() . rand() . rand()) . '.png';

        /* Save the upscaled image */
        sleep(1);
        $temp_upscaled_image_full_path = UPLOADS_PATH . Uploads::get_path('upscaled_images') . $upscaled_image;
        file_put_contents($temp_upscaled_image_full_path, $response->raw_body);

        /* Fake uploaded */
        $_FILES['upscaled_images'] = [
            'name' => $upscaled_image,
            'tmp_name' => $temp_upscaled_image_full_path,
            'error' => null,
            'size' => 0,
        ];

        $upscaled_image = \Altum\Uploads::process_upload_fake('upscaled_images', 'upscaled_images', 'json_error', null);

        /* Get size of the upscaled image */
        $upscaled_image_size_info = getimagesize($temp_upscaled_image_full_path);
        $upscaled_image_size = $upscaled_image_size_info[0] . 'x' . $upscaled_image_size_info[1];

        /* Get size of the original image */
        $original_image_size_info = getimagesize($_FILES['original_image']['tmp_name']);
        $original_image_size = $original_image_size_info[0] . 'x' . $original_image_size_info[1];

        /* Get info after the request */
        $info = \Unirest\Request::getInfo();

        /* Some needed variables */
        $api_response_time = $info['total_time'] * 1000;

        $settings = json_encode([]);

        /* Prepare the statement and execute query */
        $upscaled_image_id = db()->insert('upscaled_images', [
            'user_id' => $this->user->user_id,
            'project_id' => $_POST['project_id'],
            'name' => $_POST['name'],
            'original_image' => $original_image,
            'upscaled_image' => $upscaled_image,
            'original_size' => $original_image_size,
            'upscaled_size' => $upscaled_image_size,
            'scale' => $_POST['scale'],
            'settings' => $settings,
            'api_response_time' => $api_response_time,
            'datetime' => \Altum\Date::$date,
        ]);

        /* Prepare the statement and execute query */
        db()->where('user_id', $this->user->user_id)->update('users', [
            'aix_upscaled_images_current_month' => db()->inc(1)
        ]);

        /* Set a nice success message */
        Response::json(sprintf(l('global.success_message.create1'), '<strong>' . $_POST['name'] . '</strong>'), 'success', ['url' => url('upscaled-image-update/' . $upscaled_image_id)]);

    }

}
