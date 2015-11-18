<div class="row">
    <div id="breadcrumb" class="col-md-12">
        <ol class="breadcrumb">
            <?php foreach (\Fuel\Core\Uri::segments() as $k => $segment): ?>
                <?php $url = empty($url) ? 'admin' : $url . '/' . $segment; ?>
                <li><a href="/<?php echo $url; ?>"><?php echo \Fuel\Core\Str::ucfirst($segment); ?></a></li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12" id="add-category">
        <div class="box no-drop">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-arrows"></i>
                    <span><?php echo Fuel\Core\Lang::get('title.add_category'); ?></span>
                </div>
                <div class="box-icons">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-down"></i>
                    </a>
                </div>
                <div class="no-move"></div>
            </div>
            <div class="box-content" style="display: none;">
                <form id="create-category-form" method="post" action="<?php echo \Fuel\Core\Uri::create('/admin/category/create', array(), array()); ?>" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo Fuel\Core\Lang::get('label.parent_category'); ?></label>
                        <div class="col-sm-6">
                            <select class="populate placeholder" name="parent_category_id">
                                <option value="" >--- <?php echo Fuel\Core\Lang::get('text.select_category'); ?> ---</option>
                                <?php foreach ($category as $k => $v): ?>
                                    <option value="<?php echo $v['id']; ?>" ><?php echo $v['category_name_display']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo Fuel\Core\Lang::get('label.category_name'); ?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="category_name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo Fuel\Core\Lang::get('label.category_photo'); ?></label>
                        <div class="col-sm-6">
                            <div id="category-uploader"></div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <input type="hidden" name="id" />
                        <button type="submit" class="btn btn-primary"><?php echo Fuel\Core\Lang::get('button.submit'); ?></button>
                        <button type="button" id="reset" class="btn btn-default"><?php echo Fuel\Core\Lang::get('button.reset'); ?></button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12">
        <div class="box no-drop">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-arrows"></i>
                    <span><?php echo Fuel\Core\Lang::get('title.category_list'); ?></span>
                </div>
                <div class="box-icons">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
                <div class="no-move"></div>
            </div>
            <div class="box-content">
                <table class="table table-striped table-bordered table-hover table-heading table-datatable no-border-bottom">
                    <thead>
                        <tr>
                            <th class="text-center"><?php echo Fuel\Core\Lang::get('title.category'); ?></th>
                            <th class="col-sm-1 text-center"><?php echo Fuel\Core\Lang::get('title.status'); ?></th>
                            <th class="col-sm-1 text-center"><?php echo Fuel\Core\Lang::get('title.action'); ?></th>
                        </tr>
                    </thead>
                    <tbody class="sortable" id="category-list">
                        <?php foreach ($category as $value): ?>
                            <tr id="category-<?php echo $value['id']; ?>"
                                data-id="<?php echo $value['id']; ?>"
                                data-parent-id="<?php echo $value['parent_category_id']; ?>"
                                data-category-name="<?php echo $value['category_name']; ?>">
                                <td class="category_name">
                                    <a href="/admin/product/category/<?php echo $value['id']; ?>">
                                        <img class="img-rounded" src="<?php echo $value['category_photo_display']; ?>">
                                        <span><?php echo $value['category_name_display']; ?></span>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <div class="toggle-switch-status toggle-switch-primary-status">
                                        <label>
                                            <input type="checkbox" name="status" <?php echo $value['status'] === 1 ? 'checked' : ''; ?>>
                                            <div class="toggle-switch-inner-status"></div>
                                            <div class="toggle-switch-switch-status"><i class="fa fa-check"></i></div>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger edit"><?php echo Fuel\Core\Lang::get('button.edit'); ?></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/template" id="category-template">
    <div class="qq-uploader-selector qq-uploader span12">
    <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
    </div>
    <div class="qq-upload-button-selector qq-upload-button btn btn-primary" style="width: auto;">
    <div><i class="fa fa-upload icon-white"></i> <?php echo Fuel\Core\Lang::get('text.select_file'); ?></div>
    </div>
    <div class="col-sm-12 main-icon">
    <br>
    <img src="<?php echo _PATH_NO_IMAGE_; ?>" alt="icon" class="img-thumbnail">
    </div>
    <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
    <li>
    <div class="qq-upload-settings">
    <a id="qq-cancel-link" class="qq-upload-cancel-selector qq-upload-cancel" href="#"><?php echo Fuel\Core\Lang::get('text.cancel'); ?></a>
    </div>
    <div class="qq-progress-bar-container-selector">
    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
    </div>
    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
    <img class="qq-thumbnail-selector" qq-server-scale>
    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
    <div class="qq-upload-filename">
    <span class="qq-upload-file-selector qq-upload-file"></span>
    <span class="qq-upload-size-selector qq-upload-size"></span>
    <span class="qq-upload-status-text-selector qq-upload-status-text"></span>
    </div>
    </li>
    </ul>
    </div>
</script>
