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
use Altum\Title;

class ReplacedBackgroundImageUpdate extends Controller {

    public function index() {
        \Altum\Authentication::guard();

        if(!settings()->aix->replaced_background_images_is_enabled) {
            redirect('dashboard');
        }

        /* Team checks */
        if(\Altum\Teams::is_delegated() && !\Altum\Teams::has_access('update.images')) {
            Alerts::add_info(l('global.info_message.team_no_access'));
            redirect('dashboard');
        }

        $replaced_background_image_id = isset($this->params[0]) ? (int) $this->params[0] : null;

        /* Get image details */
        if(!$replaced_background_image = db()->where('replaced_background_image_id', $replaced_background_image_id)->where('user_id', $this->user->user_id)->getOne('replaced_background_images')) {
            redirect();
        }

        $replaced_background_image->settings = json_decode($replaced_background_image->settings ?? '');

        /* Get available projects */
        $projects = (new \Altum\Models\Projects())->get_projects_by_user_id($this->user->user_id);

        if(!empty($_POST)) {
            $_POST['name'] = input_clean($_POST['name'], 64);
            $_POST['project_id'] = !empty($_POST['project_id']) && array_key_exists($_POST['project_id'], $projects) ? (int) $_POST['project_id'] : null;

            //ALTUMCODE:DEMO if(DEMO) if($this->user->user_id == 1) Alerts::add_error('Please create an account on the demo to test out this function.');

            /* Check for any errors */
            $required_fields = ['name'];
            foreach($required_fields as $field) {
                if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]) && $_POST[$field] != '0')) {
                    Alerts::add_field_error($field, l('global.error_message.empty_field'));
                }
            }

            if(!\Altum\Csrf::check()) {
                Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            }

            if(!Alerts::has_field_errors() && !Alerts::has_errors()) {

                /* Database query */
                db()->where('replaced_background_image_id', $replaced_background_image->replaced_background_image_id)->update('replaced_background_images', [
                    'project_id' => $_POST['project_id'],
                    'name' => $_POST['name'],
                    'last_datetime' => \Altum\Date::$date,
                ]);

                /* Set a nice success message */
                Alerts::add_success(sprintf(l('global.success_message.update1'), '<strong>' . $_POST['name'] . '</strong>'));

                redirect('replaced-background-image-update/' . $replaced_background_image->replaced_background_image_id);
            }
        }

        /* Set a custom title */
        Title::set(sprintf(l('replaced_background_image_update.title'), $replaced_background_image->name));

        /* Main View */
        $data = [
            'replaced_background_image' => $replaced_background_image,
            'projects' => $projects ?? [],
        ];

        $view = new \Altum\View(THEME_PATH . 'views/replaced-background-image-update/index', (array) $this, true);

        $this->add_view_content('content', $view->run($data));
    }

}
