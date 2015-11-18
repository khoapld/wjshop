<div class="row">
    <div id="breadcrumb" class="col-md-12">
        <ol class="breadcrumb">
            <?php foreach (\Fuel\Core\Uri::segments() as $k => $segment): ?>
                <?php $url = empty($url) ? 'admin' : $url . '/' . $segment; ?>
                <li><a href="/<?php echo $url; ?>"><?php echo \Fuel\Core\Str::ucfirst($segment); ?></a></li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-8">
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-arrows"></i>
                    <span><?php echo Fuel\Core\Lang::get('title.configuration'); ?></span>
                </div>
                <div class="box-icons">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
                <div class="no-move"></div>
            </div>
            <div class="box-content">
                <form id="update-config-form" method="post" action="<?php echo \Fuel\Core\Uri::create('/admin/dashboard/update_config', array(), array()); ?>" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo Fuel\Core\Lang::get('label.maintenance'); ?></label>
                        <div class="col-sm-4">
                            <label class="switch-light well">
                                <input type="checkbox" name="maintenance" <?php echo $config->maintenance != 1 ? '' : 'checked'; ?>>
                                <span>
                                    <span><?php echo Fuel\Core\Lang::get('text.off'); ?></span>
                                    <span><?php echo Fuel\Core\Lang::get('text.on'); ?></span>
                                </span>
                                <a class="btn btn-danger"></a>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo Fuel\Core\Lang::get('label.shop_name'); ?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="shop_name" value="<?php echo $config->shop_name; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo Fuel\Core\Lang::get('label.fb_url'); ?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="fb_url" value="<?php echo $config->fb_url; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo Fuel\Core\Lang::get('label.email'); ?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="email" value="<?php echo $config->email; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo Fuel\Core\Lang::get('label.telephone'); ?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="telephone" value="<?php echo $config->telephone; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo Fuel\Core\Lang::get('label.address'); ?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="address" value="<?php echo $config->address; ?>" />
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary"><?php echo Fuel\Core\Lang::get('button.update'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
