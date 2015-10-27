<meta charset="utf-8">
<meta name="description" content="wjshop">
<meta name="author" content="wjshop">
<meta name="keywords" content="wjshop">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

<?php if (!empty($product)): ?>
    <meta property="fb:app_id" content="720949771381958">
    <meta property="og:type" content="article">
    <meta property="og:locale" content="en_US">
    <meta property="og:site_name" content="WJ-SHOP"/>
    <meta property="og:url" content="<?php echo \Fuel\Core\Uri::create('/product/' . $product['id']); ?>">
    <meta property="og:title" content="<?php echo $product['product_name']; ?>">
    <meta property="og:description" content="<?php echo str_replace(["\r\n", "\n", "\r"], " \\", $product['product_description']); ?>">
    <meta property="og:image" content="<?php echo _PATH_PRODUCT_ . $product['product_photo']; ?>">
<?php endif; ?>

<?php
echo Asset::css(array(
    '../../plugins/bootstrap/css/bootstrap.min.css',
    '../../plugins/bootstrap/css/font-awesome.min.css',
    'main.min.css'
));
?>

<?php if ($controller === 'Controller_Product'): ?>
    <?php echo Asset::css('../../plugins/smoothproducts/css/smoothproducts.css'); ?>
<?php endif; ?>

<!--[if lt IE 9]>
    <script src="http://getbootstrap.com/docs-assets/js/html5shiv.js"></script>
    <script src="http://getbootstrap.com/docs-assets/js/respond.min.js"></script>
<![endif]-->
