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
    <div class="col-xs-12 col-sm-12">
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-arrows"></i>
                    <span><?php echo Fuel\Core\Lang::get('title.add_product'); ?></span>
                </div>
                <div class="box-icons">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
                <div class="no-move"></div>
            </div>
            <div class="box-content">
                <form id="create-product-form" method="post" action="<?php echo \Fuel\Core\Uri::create('/admin/product/create', array(), array()); ?>" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo Fuel\Core\Lang::get('label.category'); ?></label>
                        <div class="col-sm-6">
                            <select multiple="multiple" id="category_id" class="populate placeholder" name="category_ids">
                                <?php foreach ($category as $k => $v): ?>
                                    <option value="<?php echo $v['id']; ?>">
                                        <?php echo $v['category_name_display']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo Fuel\Core\Lang::get('label.product_name'); ?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="product_name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-styles"><?php echo Fuel\Core\Lang::get('label.description'); ?></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="10" name="product_description"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-styles"><?php echo Fuel\Core\Lang::get('label.information'); ?></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="10" id="product_info" name="product_info"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo Fuel\Core\Lang::get('label.main_photo'); ?></label>
                        <div class="col-sm-6">
                            <div id="product-photo-uploader"></div>
                        </div>
                    </div>
                    <div class="form-group text-center panel-heading">
                        <input type="hidden" name="id" />
                        <button type="submit" class="btn btn-primary"><?php echo Fuel\Core\Lang::get('button.submit'); ?></button>
                        <button type="button" id="reset" class="btn btn-default"><?php echo Fuel\Core\Lang::get('button.reset'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/template" id="product-photo-template">
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
