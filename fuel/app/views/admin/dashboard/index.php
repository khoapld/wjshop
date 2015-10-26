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
                    <span>Configuration</span>
                </div>
                <div class="box-icons">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="expand-link">
                        <i class="fa fa-expand"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="no-move"></div>
            </div>
            <div class="box-content">
                <form id="update-config-form" method="post" action="<?php echo \Fuel\Core\Uri::create('/admin/dashboard/update_config', [], []); ?>" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Maintenance</label>
                        <div class="col-sm-4">
                            <label class="switch-light well">
                                <input type="checkbox" name="maintenance" <?php echo $config->maintenance !== 1 ? : 'checked'; ?>>
                                <span>
                                    <span>OFF</span>
                                    <span>ON</span>
                                </span>
                                <a class="btn btn-danger"></a>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Email</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="email" value="<?php echo $config->email; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Telephone</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="telephone" value="<?php echo $config->telephone; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">FB URL</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="fb_url" value="<?php echo $config->fb_url; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Shop name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="shop_name" value="<?php echo $config->shop_name; ?>" />
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
