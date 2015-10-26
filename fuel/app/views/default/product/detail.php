<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="product-details">
                    <div class="col-sm-5">
                        <?php if (!empty($product['sub_photo'])): ?>
                            <div class="sp-wrap">
                                <?php foreach ($product['sub_photo'] as $photo): ?>
                                    <a href="<?php echo $photo['l']; ?>"><img src="<?php echo $photo['m']; ?>" alt=""></a>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="view-product">
                                <img src="<?php echo $product['product_photo_display']; ?>" alt="" />
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-7">
                        <div class="product-information">
                            <h2><?php echo $product['product_name']; ?></h2>
                            <p><?php echo nl2br($product['product_description']); ?></p>
                            <hr>
                            <?php echo html_entity_decode($product['product_info'], ENT_QUOTES); ?>
                        </div>
                    </div>
                </div>

                <?php if (!empty($products)): ?>
                    <div class="features_items">
                        <h2 class="title text-center">Category Product</h2>
                        <?php foreach ($products as $p): ?>
                            <?php if ($p['id'] != $product['id']): ?>
                                <div class="col-sm-3">
                                    <a href="/product/<?php echo $p['id']; ?>">
                                        <div class="product-image-wrapper">
                                            <div class="single-products">
                                                <div class="productinfo">
                                                    <img src="<?php echo $p['product_photo_display']; ?>" alt="" />
                                                    <h4><?php echo $p['product_name']; ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>
