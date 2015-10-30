<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $title; ?></title>
        <meta charset="utf-8">
        <meta name="description" content="wjshop">
        <meta name="author" content="wjshop">
        <meta name="keywords" content="wjshop">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

        <?php echo Asset::css(array('../../plugins/bootstrap/css/bootstrap.min.css', 'main.min.css')); ?>

        <!--[if lt IE 9]>
            <script src="http://getbootstrap.com/docs-assets/js/html5shiv.js"></script>
            <script src="http://getbootstrap.com/docs-assets/js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container text-center">
            <div class="companyinfo text-center">
                <h2><span><?php echo $config->shop_name; ?></span>-Shop</h2>
            </div>
            <div class="content-404">
                <img src="/assets/img/404.png" class="img-responsive" alt="" />
                <h1><b>OPPS!</b> Maintenance</h1>
                <h2><a href="/">Bring me back later</a></h2>
            </div>
        </div>
    </body>
</html>
