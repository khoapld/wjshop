<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="features_items"><!--features_items-->
                    <h2 class="title text-center">Products</h2>
                    <?php if (!empty($products)): ?>
                        <div class="col-sm-12 text-right">
                            <ul class="pagination"></ul>
                        </div>

                        <div class="col-sm-12">
                            <div class="row" id="product-list">
                                <?php foreach ($products as $product): ?>
                                    <div class="col-sm-4">
                                        <a href="/product/<?php echo $product['code']; ?>">
                                            <div class="product-image-wrapper">
                                                <div class="single-products">
                                                    <div class="productinfo">
                                                        <img src="<?php echo $product['product_photo_display']; ?>" alt="" />
                                                        <h4><?php echo $product['product_name']; ?></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="col-sm-12 text-right">
                            <ul class="pagination"></ul>
                        </div>
                    <?php else: ?>
                        <h4 class="text-center">This category has not any product.</h4>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
