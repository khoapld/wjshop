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
        <div class="box no-drop">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-arrows"></i>
                    <span>Edit Product</span>
                </div>
                <div class="box-icons">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
                <div class="no-move"></div>
            </div>
            <div class="box-content">
                <form id="update-product-form" method="post"
                      action="<?php echo \Fuel\Core\Uri::create('/admin/product/update', array(), array()); ?>"
                      class="form-horizontal">
                    <div class="form-group text-center">
                        <div class="col-sm-12">
                            <button class="btn btn-primary <?php echo $product['status'] === 1 ? '' : 'disabled'; ?>"
                                    type="button" id="feed-fb-btn" data-id="<?php echo $product['id']; ?>">Feed FB</button>
                        </div>
                    </div>
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
                        <label class="col-sm-3 control-label">Highlight</label>
                        <div class="col-sm-4">
                            <label class="switch-light well" data-id="<?php echo $product['id']; ?>">
                                <input type="checkbox" name="highlight" <?php echo $product['highlight'] === 1 ? 'checked' : ''; ?>>
                                <span>
                                    <span>Hide</span>
                                    <span>Show</span>
                                </span>
                                <a class="btn btn-warning"></a>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Category</label>
                        <div class="col-sm-9">
                            <select multiple="multiple" class="populate placeholder"
                                    id="category_id" name="category_ids[]">
                                        <?php foreach ($category as $k => $v): ?>
                                    <option value="<?php echo $v['id']; ?>" <?php echo!in_array($v['id'], $product['category'])? : 'selected'; ?>>
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
                            <textarea class="form-control"
                                      rows="10"
                                      name="product_description"><?php echo $product['product_description']; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="form-styles">Description</label>
                        <div class="col-sm-9">
                            <textarea class="form-control"
                                      rows="10"
                                      id="product_info"
                                      name="product_info"><?php echo $product['product_info']; ?></textarea>
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
        <div class="box no-drop">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-arrows"></i>
                    <span>Main Photo</span>
                </div>
                <div class="box-icons">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
                <div class="no-move"></div>
            </div>
            <div class="box-content">
                <form id="update-product-photo-form" method="post"
                      action="<?php echo \Fuel\Core\Uri::create('/admin/product/main_photo', array(), array()); ?>"
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
    <div class="col-xs-12 col-sm-8">
        <div class="box no-drop">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-arrows"></i>
                    <span>Create Sub Photo</span>
                </div>
                <div class="box-icons">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
                <div class="no-move"></div>
            </div>
            <div class="box-content">
                <form id="sub-product-photo-form" method="post"
                      action="<?php echo \Fuel\Core\Uri::create('/admin/product/sub_photo', array(), array()); ?>"
                      class="form-horizontal">
                    <div class="form-group">
                        <div id="sub-product-photo-uploader"></div>
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
        <div class="box no-drop">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-arrows"></i>
                    <span>Sub Photo</span>
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
                            <th class="text-center">Photo</th>
                            <th class="col-sm-1 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="sub-photo-list" class="sortable" data-id="<?php echo $product['id']; ?>">
                        <?php foreach ($product['sub_photo'] as $k => $photo): ?>
                            <tr id="photo-<?php echo $k; ?>" data-id="<?php echo $k; ?>">
                                <td class="text-center">
                                    <img class="img-rounded" src="<?php echo $photo['s']; ?>">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger delete-btn">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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
    <div class="col-sm-12 main-icon">
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

<script type="text/template" id="sub-product-photo-template">
    <div class="qq-uploader-selector qq-uploader span12">
    <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
    </div>
    <div class="qq-upload-button-selector qq-upload-button btn btn-primary" style="width: auto;">
    <div><i class="fa fa-upload icon-white"></i> Select file</div>
    </div>
    <div class="col-sm-12 main-icon">
    <br>
    <img src="<?php echo _PATH_NO_IMAGE_; ?>" alt="icon" class="img-thumbnail">
    </div>
    <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
    <li class="col-sm-3">
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
