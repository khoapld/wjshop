<div class="row">
    <div id="breadcrumb" class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="/admin">Dashboard</a></li>
            <li><a href="/admin/product">Product</a></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12">
        <div class="box no-drop">
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
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-10 text-right">
                        <a class="btn btn-primary" href="/admin/product/new">New Product</a>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-heading table-datatable no-border-bottom">
                    <thead>
                        <tr>
                            <th class="text-center">Product</th>
                            <th class="col-sm-1 text-center">Status</th>
                            <th class="col-sm-1 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="sortable" id="product-list">
                        <?php foreach ($product as $value): ?>
                            <tr>
                                <td>
                                    <img class="img-rounded" src="<?php echo $value['product_photo_display']; ?>">
                                    <span><?php echo $value['product_name'] ?></span>
                                </td>
                                <td><?php echo $value['status'] ?></td>
                                <td>Edit</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
