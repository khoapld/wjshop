<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?></title>
        <link rel="shortcut icon" type="image/x-icon" href="/assets/favicon.ico">
        <link href="/plugins/bootstrap/bootstrap.css" rel="stylesheet">
        <?php echo Asset::css(['sticky-footer-navbar.css']); ?>
    </head>
    <body>
        <?php echo $header; ?>
        <div class="container">
            <?php echo $content; ?>
        </div>
        <?php echo $footer; ?>
        <?php echo $script; ?>
    </body>
</html>