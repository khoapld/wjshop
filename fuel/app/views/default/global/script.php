<script src="/plugins/jquery/jquery-2.1.0.min.js"></script>
<script src="/plugins/bootstrap/bootstrap.min.js"></script>
<script src="/plugins/jquery-scrollup/jquery.scrollUp.min.js"></script>

<?php echo Asset::js(['main.js']); ?>

<?php if ($controller === 'Controller_Product'): ?>
    <script src="/plugins/smoothproducts/js/smoothproducts.min.js"></script>
    <script>
        $('.sp-wrap').smoothproducts();</script>
<?php endif; ?>

<?php if ($controller === 'Controller_Category' && in_array($action, array('index')) && $total_page > 1): ?>
    <script src="/plugins/jQuery-pagination/jquery.pagination.js"></script>
    <script>
        var category_id = "<?php echo Fuel\Core\Uri::segment(2); ?>";
        $('.pagination').jqueryPagination({
            totalPages: <?php echo $total_page; ?>,
            visiblePages: <?php echo _DEFAULT_VISIBLE_PAGES_; ?>,
            prev: '&laquo;',
            next: '&raquo;',
            first: false,
            last: false,
            onPageClick: function (event, page) {
                var posting = $.post('/category/list', {page: page, category_id: category_id});
                posting.done(function (data) {
                    if (data.products) {
                        var html = '';
                        $.each(data.products, function (index, value) {
                            html += ' \
                                    <div class="col-sm-4"> \
                                        <a href="/product/' + value.id + '"> \
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
