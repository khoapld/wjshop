<ul class="nav main-menu">
    <li>
        <a href="/admin" class="<?php echo $controller == 'Controller_Admin_Dashboard' ? 'active' : ''; ?>">
            <i class="fa fa-dashboard"></i>
            <span class="hidden-xs">Dashboard</span>
        </a>
    </li>
    <li>
        <a href="/admin/category" class="<?php echo $controller == 'Controller_Admin_Category' ? 'active' : ''; ?>">
            <i class="fa fa-list"></i>
            <span class="hidden-xs">Category</span>
        </a>
    </li>
    <li>
        <a href="/admin/product" class="<?php echo $controller == 'Controller_Admin_Product' ? 'active' : ''; ?>">
            <i class="fa fa-dropbox"></i>
            <span class="hidden-xs">Product</span>
        </a>
    </li>
</ul>
