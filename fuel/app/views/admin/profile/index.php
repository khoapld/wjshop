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
                </div>
                <div class="box-icons">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
                <div class="no-move"></div>
            </div>
            <div class="box-content">
                <fieldset>
                    <legend><?php echo Fuel\Core\Lang::get('title.account_info'); ?></legend>
                    <form id="update-username-form" method="post" action="<?php echo \Fuel\Core\Uri::create('/admin/profile/update_username', array(), array()); ?>" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo Fuel\Core\Lang::get('label.username'); ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="username" value="<?php echo $user['username']; ?>" />
                            </div>
                            <div class="col-sm-3 text-center">
                                <button type="submit" class="btn btn-primary"><?php echo Fuel\Core\Lang::get('button.update'); ?></button>
                            </div>
                        </div>
                    </form>
                    <form id="update-email-form" method="post" action="<?php echo \Fuel\Core\Uri::create('/admin/profile/update_email', array(), array()); ?>" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo Fuel\Core\Lang::get('label.email'); ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="email" value="<?php echo $user['email']; ?>" />
                            </div>
                            <div class="col-sm-3 text-center">
                                <button type="submit" class="btn btn-primary"><?php echo Fuel\Core\Lang::get('button.update'); ?></button>
                            </div>
                        </div>
                    </form>
                    <form id="update-group-form" method="post" action="<?php echo \Fuel\Core\Uri::create('/admin/profile/update_group', array(), array()); ?>" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo Fuel\Core\Lang::get('label.group'); ?></label>
                            <div class="col-sm-6">
                                <select class="populate placeholder" name="group" id="s2_group" disabled>
                                    <?php foreach ($user_config['group'] as $k => $v): ?>
                                        <option value="<?php echo $k; ?>" <?php echo $user['group'] != $k ? : 'selected'; ?> ><?php echo $v; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </fieldset>
                <fieldset>
                    <legend></legend>
                    <form id="update-user-form" method="post" action="<?php echo \Fuel\Core\Uri::create('/admin/profile/update_info', array(), array()); ?>" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo Fuel\Core\Lang::get('label.full_name'); ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="full_name" value="<?php echo $user['full_name']; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo Fuel\Core\Lang::get('label.gender'); ?></label>
                            <div class="col-sm-6">
                                <select class="populate placeholder" name="gender" id="s2_gender">
                                    <?php foreach ($user_config['gender'] as $k => $v): ?>
                                        <option value="<?php echo $k; ?>" <?php echo $user['gender'] != $k ? : 'selected'; ?> ><?php echo $v; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo Fuel\Core\Lang::get('label.birthday'); ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" placeholder="YYYY/MM/DD" name="birthday" value="<?php echo $user['birthday']; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo Fuel\Core\Lang::get('label.telephone'); ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="telephone" value="<?php echo $user['telephone']; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo Fuel\Core\Lang::get('label.address'); ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="address" value="<?php echo $user['address']; ?>" />
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary"><?php echo Fuel\Core\Lang::get('button.submit'); ?></button>
                        </div>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4">
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-arrows"></i>
                </div>
                <div class="box-icons">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
                <div class="no-move"></div>
            </div>
            <div class="box-content">
                <form id="update-password-form" method="post" action="<?php echo \Fuel\Core\Uri::create('/admin/profile/update_password', array(), array()); ?>" class="form-horizontal">
                    <fieldset>
                        <legend><?php echo Fuel\Core\Lang::get('title.update_password'); ?></legend>
                        <div class="form-group">
                            <label class="col-sm-5 control-label"><?php echo Fuel\Core\Lang::get('label.password'); ?></label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control" name="password" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 control-label"><?php echo Fuel\Core\Lang::get('label.confirm_password'); ?></label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control" name="confirm_password" />
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary"><?php echo Fuel\Core\Lang::get('button.submit'); ?></button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4">
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-arrows"></i>
                </div>
                <div class="box-icons">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
                <div class="no-move"></div>
            </div>
            <div class="box-content">
                <legend><?php echo Fuel\Core\Lang::get('title.update_icon_photo'); ?></legend>
                <form id="update-icon-form" class="form-horizontal" method="post"
                      action="<?php echo \Fuel\Core\Uri::create('/admin/profile/update_icon', array(), array()); ?>">
                    <div class="form-group">
                        <div id="update-icon-uploader"></div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary"><?php echo Fuel\Core\Lang::get('button.submit'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/template" id="update-icon-template">
    <div class="qq-uploader-selector qq-uploader span12">
    <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
    </div>
    <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
    <span class="qq-upload-drop-area-text-selector"></span>
    </div>
    <div class="qq-upload-button-selector qq-upload-button btn btn-primary" style="width: auto;">
    <div><i class="fa fa-upload icon-white"></i> <?php echo Fuel\Core\Lang::get('text.select_file'); ?></div>
    </div>
    <div class="col-sm-12 main-icon">
    <br>
    <img src="<?php echo $user['user_photo_display']; ?>" alt="icon" class="img-thumbnail">
    </div>
    <ul class="qq-upload-list-selector qq-upload-list text-center" aria-live="polite" aria-relevant="additions removals">
    <li>
    <div class="qq-upload-settings">
    <a id="qq-cancel-link" class="qq-upload-cancel-selector qq-upload-cancel" href="#"><?php echo Fuel\Core\Lang::get('text.cancel'); ?></a>
    </div>
    <div class="qq-progress-bar-container-selector">
    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
    </div>
    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
    <img class="qq-thumbnail-selector" qq-server-scale>
    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
    <div class="qq-upload-filename">
    <span class="qq-upload-file-selector qq-upload-file"></span>
    <span class="qq-upload-size-selector qq-upload-size"></span>
    <span class="qq-upload-status-text-selector qq-upload-status-text"></span>
    </div>
    </li>
    </ul>
    </div>
</script>
