<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?></title>
        <meta name="description" content="description">
        <meta name="author" content="khoapld">
        <meta name="keywords" content="wjshop">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php echo Asset::css(array('../../plugins/bootstrap/css/bootstrap.min.css', 'admin.min.css', 'admin_signin.min.css')); ?>
        <?php echo Asset::js(array('../../plugins/jquery/jquery-2.1.0.min.js', 'admin_signin.min.js')); ?>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
                <script src="http://getbootstrap.com/docs-assets/js/html5shiv.js"></script>
                <script src="http://getbootstrap.com/docs-assets/js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container-fluid">
            <div id="page-login" class="row">
                <form id="signin-form" method="post" action="<?php echo \Fuel\Core\Uri::create('/admin/signin', array(), array()); ?>">
                    <div class="col-xs-12 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                        <div class="text-right">
                            <a href="/" class="txt-default"><?php echo Fuel\Core\Lang::get('menu.home_page'); ?></a>
                        </div>
                        <div class="box">
                            <div class="box-content">
                                <div class="text-center">
                                    <h3 class="page-header"><?php echo Fuel\Core\Lang::get('title.sign_in'); ?></h3>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo Fuel\Core\Lang::get('label.email'); ?></label><span class="red error email"></span>
                                    <input type="text" class="form-control" name="email" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo Fuel\Core\Lang::get('label.password'); ?></label><span class="red error password"></span>
                                    <input type="password" class="form-control" name="password" />
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary"><?php echo Fuel\Core\Lang::get('button.sign_in'); ?></button>
                                </div>
                                <div class="text-center">
                                    <span class="red error signin"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
