<?php
echo Asset::js(array(
    '../../plugins/jquery/jquery-2.1.0.min.js',
    '../../plugins/bootstrap/js/bootstrap.min.js',
    '../../plugins/jquery-scrollup/jquery.scrollUp.min.js',
    'main.min.js'
));
?>

<?php if ($controller === 'Controller_Product'): ?>
    <?php echo Asset::js(array('../../plugins/smoothproducts/js/smoothproducts.min.js')); ?>
    <script>
        $('.sp-wrap').smoothproducts();
    </script>
<?php endif; ?>

<?php if ($controller === 'Controller_Category' && in_array($action, array('index')) && $total_page > 1): ?>
    <?php echo Asset::js(array('../../plugins/jQuery-pagination/jquery.pagination.js')); ?>
    <script>
        var code = "<?php echo Fuel\Core\Uri::segment(2); ?>";
        $('.pagination').jqueryPagination({
            totalPages: <?php echo $total_page; ?>,
            visiblePages: <?php echo _DEFAULT_VISIBLE_PAGES_; ?>,
            prev: '&laquo;',
            next: '&raquo;',
            first: false,
            last: false,
            onPageClick: function (event, page) {
                var posting = $.post('/category/list', {page: page, code: code});
                posting.done(function (data) {
                    if (data.products) {
                        var html = '';
                        $.each(data.products, function (index, value) {
                            html += ' \
                                    <div class="col-sm-3"> \
                                        <a href="/product/' + value.code + '"> \
                                            <div class="product-image-wrapper"> \
                                                <div class="single-products"> \
                                                    <div class="productinfo"> \
                                                        <img src="' + value.product_photo_display + '" alt="" /> \
                                                        <h4>' + value.product_name + '</h4> \
                                                    </div> \
                                                </div> \
                                            </div> \
                                        </a> \
                                    </div> \
                                    ';
                        });
                        $('#product-list').html(html);
                    }
                });
            }
        });
    </script>
<?php endif; ?>
