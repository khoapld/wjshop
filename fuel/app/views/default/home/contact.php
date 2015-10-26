<div id="contact-page" class="container">
    <div class="bg">
        <div class="row">
            <div class="col-sm-6">
                <div class="contact-info">
                    <h2 class="title text-center">Contact <strong>Us</strong></h2>
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
                <h2 class="title text-center">MAP</h2>
                <div id="gmap" class="contact-map">
                </div>
            </div>
        </div>
    </div>
</div>