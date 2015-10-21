<header id="header"><!--header-->
    <div class="header_top"><!--header_top-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="contactinfo">
                        <ul class="nav nav-pills">
                            <li><a href="#"><i class="fa fa-phone"></i> 0933813800</a></li>
                            <li><a href="#"><i class="fa fa-envelope"></i> email@gmail.com</a></li>
                            <li><a href="https://facebook.com/WJ-SHOP-583864338420265" target="_blank"><i class="fa fa-facebook"></i> wj-shop</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header_top-->

    <div class="header-middle"><!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="logo pull-left">
                        <a href="/"><img src="/plugins/wjshop/images/home/logo.png" alt="" /></a>
                    </div>
                </div>
                <!--                <div class="col-sm-8">
                                    <div class="shop-menu pull-right">
                                        <ul class="nav navbar-nav">
                                            <li><a href="#"><i class="fa fa-user"></i> Account</a></li>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i> Cart</a></li>
                                            <li><a href="#"><i class="fa fa-lock"></i> Login</a></li>
                                        </ul>
                                    </div>
                                </div>-->
            </div>
        </div>
    </div><!--/header-middle-->

    <div class="header-bottom"><!--header-bottom-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="mainmenu pull-right">
                        <ul class="nav navbar-nav collapse navbar-collapse">
                            <li><a href="/" class="<?php echo $action === 'home' ? 'active' : ''; ?>">Home</a></li>
                            <?php if (!empty($category)): ?>
                                <li class="dropdown"><a href="#" class="<?php echo $controller === 'Controller_Category' ? 'active' : ''; ?>">Category<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <?php foreach ($category as $k => $v): ?>
                                            <li>
                                                <a href="/category/<?php echo $k; ?>" class="<?php echo $controller === 'Controller_Category' && Fuel\Core\Uri::segment(2) == $k ? 'active' : ''; ?>">
                                                    <?php echo $v['category_name_display']; ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <li><a href="/contact" class="<?php echo $action === 'contact' ? 'active' : ''; ?>">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-bottom-->
</header><!--/header-->
