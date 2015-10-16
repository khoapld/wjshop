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
                    <span>Product List</span>
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
                <div class="form-group text-right">
                    <a class="btn btn-lg btn-primary" href="/admin/product/new">New Product</a>
                </div>
                <table class="table table-striped table-bordered table-hover table-heading table-datatable no-border-bottom">
                    <thead>
                        <tr>
                            <th class="text-center">Product</th>
                            <th class="col-sm-1 text-center">Status</th>
                            <th class="col-sm-1 text-center">Highlight</th>
                            <th class="col-sm-1 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="product-list">
                        <?php foreach ($product as $value): ?>
                            <tr data-id="<?php echo $value['id']; ?>">
                                <td>
                                    <img class="img-rounded" src="<?php echo $value['product_photo_display']; ?>">
                                    <span><?php echo $value['product_name'] ?></span>
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
                                    <div class="toggle-switch-status toggle-switch-warning-status">
                                        <label>
                                            <input type="checkbox" name="highlight" <?php echo $value['highlight'] === 1 ? 'checked' : ''; ?>>
                                            <div class="toggle-switch-inner-status"></div>
                                            <div class="toggle-switch-switch-status"><i class="fa fa-check"></i></div>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-danger" href="/admin/product/<?php echo $value['id']; ?>">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="form-group text-right">
                    <ul id="pagination" class="pagination-sm"></ul>
                </div>
            </div>
        </div>
    </div>
</div>
