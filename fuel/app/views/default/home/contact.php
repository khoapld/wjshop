<div id="contact-page" class="container">
    <div class="bg">
        <div class="row">
            <div class="col-sm-6">
                <div class="contact-info">
                    <h2 class="title text-center">Thông Tin Liên Lạc</h2>
                    <address>
                        <p>Điện Thoại: <?php echo $config->telephone; ?></p>
                        <p>Email: <?php echo $config->email; ?></p>
                        <p>Địa Chỉ: <?php echo $config->address; ?></p>
                        <p>Facebook: <a href="<?php echo $config->fb_url; ?>" target="_blank"><?php echo $config->shop_name; ?>-SHOP</a></p>
                    </address>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="contact-form">
                    <h2 class="title text-center">Tin nhắn</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="contact-form" class="contact-form row" method="post" action="<?php echo \Fuel\Core\Uri::create('/contact', array(), array()); ?>">
                        <div class="form-group col-md-6">
                            <input type="text" name="name" class="form-control" required="required" placeholder="Tên">
                            <span class="text-danger error name"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="email" name="email" class="form-control" required="required" placeholder="Email">
                            <span class="text-danger error email"></span>
                        </div>
                        <div class="form-group col-md-12">
                            <input type="text" name="subject" class="form-control" required="required" placeholder="Chủ đề">
                            <span class="text-danger error subject"></span>
                        </div>
                        <div class="form-group col-md-12">
                            <textarea name="message" id="message" required="required" class="form-control" rows="8" placeholder="Nội dung"></textarea>
                            <span class="text-danger error message"></span>
                        </div>
                        <div class="form-group col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Gửi</button>
                            <br><h2 class="text-success success"></h2>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>