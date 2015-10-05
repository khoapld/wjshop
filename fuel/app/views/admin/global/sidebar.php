<ul class="nav main-menu">
    <li>
        <a href="/admin" class="<?php echo $controller == 'Controller_Admin_Dashboard' ? 'active' : ''; ?>">
            <i class="fa fa-dashboard"></i>
            <span class="hidden-xs">Dashboard</span>
        </a>
    </li>
    <li>
        <a href="/admin/category/list" class="<?php echo $controller == 'Controller_Admin_Category' ? 'active' : ''; ?>">
            <i class="fa fa-folder-open-o"></i>
            <span class="hidden-xs">Category List</span>
        </a>
    </li>
    <li>
        <a href="/admin/product/list" class="<?php echo $controller == 'Controller_Admin_Product' ? 'active' : ''; ?>">
            <i class="fa fa-shopping-cart"></i>
            <span class="hidden-xs">Product List</span>
        </a>
    </li>
</ul>
