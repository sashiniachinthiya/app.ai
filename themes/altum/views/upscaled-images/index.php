<?php defined('ALTUMCODE') || die() ?>


<div class="container">
    <?= \Altum\Alerts::output_alerts() ?>

    <div class="row mb-4">
        <div class="col-12 col-lg d-flex align-items-center mb-3 mb-lg-0 text-truncate">
            <h1 class="h4 m-0 text-truncate"><i class="fas fa-fw fa-xs fa-expand-arrows-alt mr-1"></i> <?= l('upscaled_images.header') ?></h1>

            <div class="ml-2">
                <span data-toggle="tooltip" title="<?= l('upscaled_images.subheader') ?>">
                    <i class="fas fa-fw fa-info-circle text-muted"></i>
                </span>
            </div>
        </div>

        <div class="col-12 col-lg-auto d-flex d-print-none">
            <div>
                <?php if(($this->user->plan_settings->upscaled_images_per_month_limit != -1 && $data->upscaled_images_current_month >= $this->user->plan_settings->upscaled_images_per_month_limit)): ?>
                    <button type="button" class="btn btn-primary disabled" data-toggle="tooltip" title="<?= l('global.info_message.plan_feature_limit') ?>">
                        <i class="fas fa-fw fa-plus-circle fa-sm mr-1"></i> <?= l('upscaled_images.create') ?>
                    </button>
                <?php else: ?>
                    <a href="<?= url('upscaled-image-create') ?>" class="btn btn-primary" data-toggle="tooltip" data-html="true" title="<?= get_plan_feature_limit_info($data->upscaled_images_current_month, $this->user->plan_settings->upscaled_images_per_month_limit, isset($data->filters) ? !$data->filters->has_applied_filters : true) ?>">
                        <i class="fas fa-fw fa-plus-circle fa-sm mr-1"></i> <?= l('upscaled_images.create') ?>
                    </a>
                <?php endif ?>
            </div>

            <div class="ml-3">
                <div class="dropdown">
                    <button type="button" class="btn btn-light dropdown-toggle-simple" data-toggle="dropdown" data-boundary="viewport" data-tooltip title="<?= l('global.export') ?>" data-tooltip-hide-on-click>
                        <i class="fas fa-fw fa-sm fa-download"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right d-print-none">
                        <a href="<?= url('upscaled-images?' . $data->filters->get_get() . '&export=csv')  ?>" target="_blank" class="dropdown-item">
                            <i class="fas fa-fw fa-sm fa-file-csv mr-2"></i> <?= sprintf(l('global.export_to'), 'CSV') ?>
                        </a>
                        <a href="<?= url('upscaled-images?' . $data->filters->get_get() . '&export=json') ?>" target="_blank" class="dropdown-item">
                            <i class="fas fa-fw fa-sm fa-file-code mr-2"></i> <?= sprintf(l('global.export_to'), 'JSON') ?>
                    </a>
                    <a href="#" onclick="window.print();return false;" class="dropdown-item">
                        <i class="fas fa-fw fa-sm fa-file-pdf mr-2"></i> <?= sprintf(l('global.export_to'), 'PDF') ?>
                    </a>
                    </div>
                </div>
            </div>

            <div class="ml-3">
                <div class="dropdown">
                    <button type="button" class="btn <?= $data->filters->has_applied_filters ? 'btn-dark' : 'btn-light' ?> filters-button dropdown-toggle-simple" data-toggle="dropdown" data-boundary="viewport" data-tooltip title="<?= l('global.filters.header') ?>" data-tooltip-hide-on-click>
                        <i class="fas fa-fw fa-sm fa-filter"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right filters-dropdown">
                        <div class="dropdown-header d-flex justify-content-between">
                            <span class="h6 m-0"><?= l('global.filters.header') ?></span>

                            <?php if($data->filters->has_applied_filters): ?>
                                <a href="<?= url(\Altum\Router::$original_request) ?>" class="text-muted"><?= l('global.filters.reset') ?></a>
                            <?php endif ?>
                        </div>

                        <div class="dropdown-divider"></div>

                        <form action="" method="get" role="form">
                            <div class="form-group px-4">
                                <label for="filters_search" class="small"><?= l('global.filters.search') ?></label>
                                <input type="search" name="search" id="filters_search" class="form-control form-control-sm" value="<?= $data->filters->search ?>" />
                            </div>

                            <div class="form-group px-4">
                                <label for="filters_search_by" class="small"><?= l('global.filters.search_by') ?></label>
                                <select name="search_by" id="filters_search_by" class="custom-select custom-select-sm">
                                    <option value="name" <?= $data->filters->search_by == 'name' ? 'selected="selected"' : null ?>><?= l('global.name') ?></option>
                                </select>
                            </div>

                            <div class="form-group px-4">
                                <label for="filters_scale" class="small"><?= l('upscaled_images.scale') ?></label>
                                <select name="scale" id="filters_scale" class="custom-select custom-select-sm">
                                    <option value=""><?= l('global.all') ?></option>
                                    <?php foreach(['2', '3', '4'] as $key): ?>
                                        <option value="<?= $key ?>" <?= isset($data->filters->filters['scale']) && $data->filters->filters['scale'] == $key ? 'selected="selected"' : null ?>><?= $key . 'x' ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group px-4">
                                <div class="d-flex justify-content-between">
                                    <label for="filters_project_id" class="small"><?= l('projects.project_id') ?></label>
                                    <a href="<?= url('project-create') ?>" target="_blank" class="small mb-2"><i class="fas fa-fw fa-sm fa-plus mr-1"></i> <?= l('global.create') ?></a>
                                </div>
                                <select name="project_id" id="filters_project_id" class="custom-select custom-select-sm">
                                    <option value=""><?= l('global.all') ?></option>
                                    <?php foreach($data->projects as $project_id => $project): ?>
                                        <option value="<?= $project_id ?>" <?= isset($data->filters->filters['project_id']) && $data->filters->filters['project_id'] == $project_id ? 'selected="selected"' : null ?>><?= $project->name ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group px-4">
                                <label for="filters_order_by" class="small"><?= l('global.filters.order_by') ?></label>
                                <select name="order_by" id="filters_order_by" class="custom-select custom-select-sm">
                                    <option value="datetime" <?= $data->filters->order_by == 'datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_datetime') ?></option>
                                    <option value="last_datetime" <?= $data->filters->order_by == 'last_datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_last_datetime') ?></option>
                                    <option value="name" <?= $data->filters->order_by == 'name' ? 'selected="selected"' : null ?>><?= l('global.name') ?></option>
                                </select>
                            </div>

                            <div class="form-group px-4">
                                <label for="filters_order_type" class="small"><?= l('global.filters.order_type') ?></label>
                                <select name="order_type" id="filters_order_type" class="custom-select custom-select-sm">
                                    <option value="ASC" <?= $data->filters->order_type == 'ASC' ? 'selected="selected"' : null ?>><?= l('global.filters.order_type_asc') ?></option>
                                    <option value="DESC" <?= $data->filters->order_type == 'DESC' ? 'selected="selected"' : null ?>><?= l('global.filters.order_type_desc') ?></option>
                                </select>
                            </div>

                            <div class="form-group px-4">
                                <label for="filters_results_per_page" class="small"><?= l('global.filters.results_per_page') ?></label>
                                <select name="results_per_page" id="filters_results_per_page" class="custom-select custom-select-sm">
                                    <?php foreach($data->filters->allowed_results_per_page as $key): ?>
                                        <option value="<?= $key ?>" <?= $data->filters->results_per_page == $key ? 'selected="selected"' : null ?>><?= $key ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group px-4 mt-4">
                                <button type="submit" name="submit" class="btn btn-sm btn-primary btn-block"><?= l('global.submit') ?></button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(count($data->upscaled_images)): ?>
        <div class="table-responsive table-custom-container">
            <table class="table table-custom">
                <thead>
                <tr>
                    <th><?= l('upscaled_images.images') ?></th>
                    <th><?= l('upscaled_images.scale') ?></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <?php foreach($data->upscaled_images as $row): ?>

                    <tr>
                        <td class="text-nowrap">
                            <div class="d-flex align-items-center">
                                <a href="<?= \Altum\Uploads::get_full_url('upscaled_images') . $row->original_image ?>" target="_blank">
                                    <img src="<?= \Altum\Uploads::get_full_url('upscaled_images') . $row->original_image ?>" class="img-fluid rounded mr-3" style="width: 50px; height: 50px;min-width: 50px; min-height: 50px;" data-toggle="tooltip" data-html="true" title="<?= l('global.view') . '<br />' . $row->original_size ?>" />
                                </a>

                                <i class="fas fa-fw fa-sm fa-arrow-right mr-3"></i>

                                <a href="<?= \Altum\Uploads::get_full_url('upscaled_images') . $row->upscaled_image ?>" target="_blank">
                                    <img src="<?= \Altum\Uploads::get_full_url('upscaled_images') . $row->upscaled_image ?>" class="img-fluid rounded mr-3" style="width: 50px; height: 50px;min-width: 50px; min-height: 50px;" data-toggle="tooltip" data-html="true" title="<?= l('global.view') . '<br />' . $row->upscaled_size ?>" />
                                </a>

                                <div>
                                    <a href="<?= url('upscaled-image-update/' . $row->upscaled_image_id) ?>"><?= $row->name ?></a>
                                </div>
                            </div>
                        </td>

                        <td class="text-nowrap">
                            <span class="badge badge-light"><?= $row->scale . 'x' ?></span>
                        </td>

                        <td class="text-nowrap">
                            <div class="d-flex align-items-center">
                                <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('global.datetime_tooltip'), '<br />' . \Altum\Date::get($row->datetime, 2) . '<br /><small>' . \Altum\Date::get($row->datetime, 3) . '</small>') ?>">
                                    <i class="fas fa-fw fa-clock text-muted"></i>
                                </span>

                                <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('global.last_datetime_tooltip'), ($row->last_datetime ? '<br />' . \Altum\Date::get($row->last_datetime, 2) . '<br /><small>' . \Altum\Date::get($row->last_datetime, 3) . '</small>' : '-')) ?>">
                                    <i class="fas fa-fw fa-history text-muted"></i>
                                </span>
                            </div>
                        </td>

                        <td>
                            <div class="d-flex justify-content-end">
                                <?= include_view(THEME_PATH . 'views/upscaled-images/upscaled_image_dropdown_button.php', ['id' => $row->upscaled_image_id, 'resource_name' => $row->name, 'upscaled_image' => $row->upscaled_image, 'upscaled_image_url' => \Altum\Uploads::get_full_url('upscaled_images') . $row->upscaled_image]) ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>

                </tbody>
            </table>
        </div>

        <div class="mt-3"><?= $data->pagination ?></div>
    <?php else: ?>

        <?= include_view(THEME_PATH . 'views/partials/no_data.php', [
            'filters_get' => $data->filters->get ?? [],
            'name' => 'upscaled_images',
            'has_secondary_text' => true,
        ]); ?>

    <?php endif ?>
</div>

<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/partials/universal_delete_modal_form.php', [
    'name' => 'upscaled_image',
    'resource_id' => 'upscaled_image_id',
    'has_dynamic_resource_name' => true,
    'path' => 'upscaled-images/delete'
]), 'modals'); ?>
