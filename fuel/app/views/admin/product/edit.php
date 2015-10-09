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
    <div class="col-xs-12 col-sm-8">
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-arrows"></i>
                    <span>Edit Product</span>
                </div>
                <div class="box-icons">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="expand-link">
                        <i class="fa fa-expand"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="no-move"></div>
            </div>
            <div class="box-content">
                <form id="update-product-form" method="post"
                      action="<?php echo \Fuel\Core\Uri::create('/admin/product/update', [], []); ?>"
                      class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-4">
                            <label class="switch-light well" data-id="<?php echo $product['id']; ?>">
                                <input type="checkbox" name="status" <?php echo $product['status'] === 1 ? 'checked' : ''; ?>>
                                <span>
                                    <span>Hide</span>
                                    <span>Show</span>
                                </span>
                                <a class="btn btn-info"></a>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Category</label>
                        <div class="col-sm-9">
                            <select multiple="multiple" class="populate placeholder"
                                    id="category_id" name="category_ids[]">
                                        <?php foreach ($category as $k => $v): ?>
                                    <option value="<?php echo $k; ?>" <?php echo!in_array($k, $product['category'])? : 'selected'; ?>>
                                        <?php echo $v['category_name_display']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Product name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control"
                                   name="product_name"
                                   value="<?php echo $product['product_name']; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="form-styles">Description</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="10" id="product_description"
                                      name="product_description">
                                          <?php echo $product['product_description']; ?>
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group text-center panel-heading">
                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>"/>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4">
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-arrows"></i>
                    <span>Main Photo</span>
                </div>
                <div class="box-icons">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="expand-link">
                        <i class="fa fa-expand"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="no-move"></div>
            </div>
            <div class="box-content">
                <form id="update-product-photo-form" method="post"
                      action="<?php echo \Fuel\Core\Uri::create('/admin/product/main_photo', [], []); ?>"
                      class="form-horizontal">
                    <div class="form-group">
                        <div id="product-photo-uploader"></div>
                    </div>
                    <div class="form-group text-center panel-heading">
                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>"/>
                        <button type="submit" class="btn btn-primary">Submit</button>
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
    <div><i class="fa fa-upload icon-white"></i> Select file</div>
    </div>
    <div class="col-sm-12" id="main-icon">
    <br>
    <img src="<?php echo $product['product_photo_display']; ?>" alt="icon" class="img-thumbnail">
    </div>
    <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
    <li>
    <div class="qq-upload-settings">
    <a id="qq-cancel-link" class="qq-upload-cancel-selector qq-upload-cancel" href="#">Cancel</a>
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
