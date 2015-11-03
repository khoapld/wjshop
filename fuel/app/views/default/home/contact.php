<div id="contact-page" class="container">
    <div class="bg">
        <div class="row">
            <div class="col-sm-6">
                <div class="contact-info">
                    <h2 class="title text-center">Information</h2>
                    <address>
                        <p><?php echo $config->shop_name; ?>-SHOP</p>
                        <p>Telephone: <?php echo $config->telephone; ?></p>
                        <p>Email: <?php echo $config->email; ?></p>
                        <p>Address: <?php echo $config->address; ?></p>
                        <p>Facebook: <a href="<?php echo $config->fb_url; ?>" target="_blank"><?php echo $config->shop_name; ?>-SHOP</a></p>
                    </address>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="contact-form">
                    <h2 class="title text-center">Contact <strong>Us</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="contact-form" class="contact-form row" method="post" action="<?php echo \Fuel\Core\Uri::create('/contact', array(), array()); ?>">
                        <div class="form-group col-md-6">
                            <input type="text" name="name" class="form-control" required="required" placeholder="Your Name">
                            <span class="text-danger error name"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="email" name="email" class="form-control" required="required" placeholder="Your Email">
                            <span class="text-danger error email"></span>
                        </div>
                        <div class="form-group col-md-12">
                            <input type="text" name="subject" class="form-control" required="required" placeholder="Subject">
                            <span class="text-danger error subject"></span>
                        </div>
                        <div class="form-group col-md-12">
                            <textarea name="message" id="message" required="required" class="form-control" rows="8" placeholder="Your Message Here"></textarea>
                            <span class="text-danger error message"></span>
                        </div>
                        <div class="form-group col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Send</button>
                            <br><h2 class="text-success success"></h2>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>