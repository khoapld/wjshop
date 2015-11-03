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
    <meta property="og:url" content="<?php echo \Fuel\Core\Uri::create('/product/' . $product['code']); ?>">
    <meta property="og:title" content="<?php echo $product['product_name']; ?>">
    <meta property="og:description" content="<?php echo str_replace(["\r\n", "\n", "\r"], " \\", $product['product_description']); ?>">
    <meta property="og:image" content="<?php echo _PATH_PRODUCT_ . $product['product_photo']; ?>">
<?php endif; ?>

<?php
echo Asset::css(array(
    '../../plugins/bootstrap/css/bootstrap.min.css',
    '//netdna.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.css',
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

<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
    window.$zopim || (function (d, s) {
        var z = $zopim = function (c) {
            z._.push(c)
        }, $ = z.s =
                d.createElement(s), e = d.getElementsByTagName(s)[0];
        z.set = function (o) {
            z.set.
                    _.push(o)
        };
        z._ = [];
        z.set._ = [];
        $.async = !0;
        $.setAttribute("charset", "utf-8");
        $.src = "//v2.zopim.com/?3QgvjM4t4B5Dt5a4Qh20nsJbs1JglE7g";
        z.t = +new Date;
        $.
                type = "text/javascript";
        e.parentNode.insertBefore($, e)
    })(document, "script");
</script>
<!--End of Zopim Live Chat Script-->