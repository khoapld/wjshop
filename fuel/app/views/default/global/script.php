<script src="/plugins/wjshop/js/jquery.js"></script>
<script src="/plugins/wjshop/js/bootstrap.min.js"></script>
<script src="/plugins/wjshop/js/jquery.scrollUp.min.js"></script>
<!--<script src="/plugins/wjshop/js/jquery.prettyPhoto.js"></script>-->
<script src="/plugins/smoothproducts/js/smoothproducts.min.js"></script>
<script src="/plugins/wjshop/js/main.js"></script>

<?php if ($controller === 'Controller_Product'): ?>
    <script>
        $('.sp-wrap').smoothproducts();
    </script>
<?php endif; ?>
