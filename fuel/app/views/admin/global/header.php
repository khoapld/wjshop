<header class="navbar">
    <div class="container-fluid expanded-panel">
        <div class="row">
            <div id="logo" class="col-xs-12 col-sm-2">
                <a href="/">WJ SHOP</a>
            </div>
            <div id="top-panel" class="col-xs-12 col-sm-10">
                <div class="row">
                    <div class="col-xs-8 col-sm-4">
                        <a href="#" class="show-sidebar">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <div class="col-xs-4 col-sm-8 top-panel-right">
                        <ul class="nav navbar-nav pull-right panel-menu">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle account" data-toggle="dropdown">
                                    <div class="avatar">
                                        <img src="<?php echo $user['user_photo_display']; ?>" class="img-rounded" alt="avatar" />
                                    </div>
                                    <i class="fa fa-angle-down pull-right"></i>
                                    <div class="user-mini pull-right">
                                        <span class="welcome"><?php echo Fuel\Core\Lang::get('text.welcome'); ?></span>
                                        <span><?php echo $user['username']; ?></span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo Uri::base(); ?>admin/facebook">
                                            <i class="fa fa-facebook"></i>
                                            <span><?php echo Fuel\Core\Lang::get('menu.facebook'); ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Uri::base(); ?>admin/profile">
                                            <i class="fa fa-user"></i>
                                            <span><?php echo Fuel\Core\Lang::get('menu.profile'); ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Uri::base(); ?>admin/signout">
                                            <i class="fa fa-power-off"></i>
                                            <span><?php echo Fuel\Core\Lang::get('menu.sign_out'); ?></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
