<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>
    </head>
    <body>
        <?php echo $header; ?>

        <div id="main" class="container-fluid">
            <div class="row">
                <div id="sidebar-left" class="col-xs-2 col-sm-2">
                    <?php echo $sidebar; ?>
                </div>

                <!--Start Content-->
                <div id="content" class="col-xs-12 col-sm-10">
                    <div class="row">
                        <div id="alert" class="modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content"></div>
                            </div>
                        </div>
                    </div>
                    <?php echo $content; ?>
                </div>
                <!--End Content-->
            </div>
        </div>

        <?php echo $script; ?>
    </body>
</html>
