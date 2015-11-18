<ul class="nav main-menu">
    <li>
        <a href="/admin" class="<?php echo $controller == 'Controller_Admin_Dashboard' ? 'active' : ''; ?>">
            <i class="fa fa-dashboard"></i>
            <span class="hidden-xs"><?php echo Fuel\Core\Lang::get('menu.dashboard'); ?></span>
        </a>
    </li>
    <li>
        <a href="/admin/category" class="<?php echo $controller == 'Controller_Admin_Category' ? 'active' : ''; ?>">
            <i class="fa fa-list"></i>
            <span class="hidden-xs"><?php echo Fuel\Core\Lang::get('menu.category'); ?></span>
        </a>
    </li>
    <li>
        <a href="/admin/product" class="<?php echo $controller == 'Controller_Admin_Product' ? 'active' : ''; ?>">
            <i class="fa fa-dropbox"></i>
            <span class="hidden-xs"><?php echo Fuel\Core\Lang::get('menu.product'); ?></span>
        </a>
    </li>
</ul>
