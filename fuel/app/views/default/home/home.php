<?php if (!empty($highlight_product)): ?>
    <?php $i = 0; ?>
    <?php $j = 0; ?>
    <section id="slider">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php foreach ($highlight_product as $product): ?>
                                <li class="<?php echo $i === 0 ? 'active' : ''; ?>" data-target="#slider-carousel" data-slide-to="<?php echo $i++; ?>"></li>
                            <?php endforeach; ?>
                        </ol>
                        <div class="carousel-inner">
                            <?php foreach ($highlight_product as $product): ?>
                                <div class="item <?php echo $j === 0 ? 'active' : ''; ?>">
                                    <a href="/product/<?php echo $product['code']; ?>">
                                        <div class="col-sm-7">
                                            <h2><?php echo $product['product_name']; ?></h2>
                                            <p><?php echo nl2br(\Fuel\Core\Str::truncate($product['product_description'], 150)); ?></p>
                                        </div>
                                        <div class="col-sm-4">
                                            <img src="<?php echo $product['product_photo_display']; ?>" class="girl img-responsive" alt="<?php echo $j++; ?>" />
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if (!empty($new_product)): ?>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">

                    <div class="features_items">
                        <h2 class="title text-center">New Product</h2>
                        <?php foreach ($new_product as $product): ?>
                            <div class="col-sm-4">
                                <a href="/product/<?php echo $product['code']; ?>">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo">
                                                <img src="<?php echo $product['product_photo_display']; ?>" alt="" />
                                                <h4><?php echo $product['product_name']; ?></h4>
                                            </div>
                                            <img src="/assets/img/new.png" class="new" alt="" />
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if (!empty($product_category)): ?>
                        <?php $i = 0; ?>
                        <?php $j = 0; ?>
                        <div class="category-tab">
                            <div class="col-sm-12">
                                <ul class="nav nav-tabs">
                                    <?php foreach ($product_category as $v): ?>
                                        <li class="<?php echo $i === 0 ? 'active' : ''; ?>"><a href="#<?php echo $v['code']; ?>" data-toggle="tab"><?php echo $v['category_name']; ?></a></li>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <?php foreach ($product_category as $v): ?>
                                    <div class="tab-pane fade <?php echo $j === 0 ? 'active in' : ''; ?>" id="<?php echo $v['code'] ?>" >
                                        <?php foreach ($v['product'] as $product): ?>
                                            <div class="col-sm-3">
                                                <a href="/product/<?php echo $product['code']; ?>">
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
<?php endif; ?>
