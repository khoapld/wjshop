<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 padding-right">
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
                            <img src="/plugins/wjshop/images/product-details/new.jpg" class="newarrival" alt="" />
                            <h2><?php echo $product['product_name']; ?></h2>
                            <p><?php echo $product['product_description']; ?></p>
                            <?php echo nl2br(htmlspecialchars_decode($product['product_info'])); ?>
                        </div>
                    </div>
                </div>

                <?php if (!empty($product_category)): ?>
                    <?php $i = 0; ?>
                    <?php $j = 0; ?>
                    <div class="category-tab">
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs">
                                <?php foreach ($category as $v): ?>
                                    <li class="<?php echo $i === 0 ? 'active' : ''; ?>"><a href="#<?php echo $v['id']; ?>" data-toggle="tab"><?php echo $v['category_name']; ?></a></li>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <?php foreach ($product_category as $v): ?>
                                <div class="tab-pane fade <?php echo $j === 0 ? 'active in' : ''; ?>" id="<?php echo $v['id'] ?>" >
                                    <?php foreach ($v['product'] as $product): ?>
                                        <div class="col-sm-3">
                                            <a href="/product/<?php echo $product['id']; ?>">
                                                <div class="product-image-wrapper">
                                                    <div class="single-products">
                                                        <div class="productinfo text-center">
                                                            <img src="<?php echo $product['product_photo_display']; ?>" alt="" />
                                                            <h4><?php echo $product['product_name']; ?></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php $j++; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>