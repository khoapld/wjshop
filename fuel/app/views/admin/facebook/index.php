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
                    <span><?php echo Fuel\Core\Lang::get('title.facebook'); ?></span>
                </div>
                <div class="box-icons">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
                <div class="no-move"></div>
            </div>
            <div class="box-content">
                <div class="form-group text-right">
                    <?php if ($is_login_fb == true): ?>
                        <a class="btn btn-lg btn-primary" href="/admin/facebook/login/facebook"><?php echo Fuel\Core\Lang::get('button.sign_in'); ?></a>
                    <?php else: ?>
                        <button class="btn btn-lg btn-danger" href="#" target="_blank" id="delete-fb-user"><?php echo Fuel\Core\Lang::get('button.delete'); ?></button>
                        <a class="btn btn-lg btn-primary" href="https://facebook.com/<?php echo $user_fb['uid']; ?>" target="_blank"><?php echo Fuel\Core\Lang::get('button.go_to_fb'); ?></a>
                    <?php endif; ?>
                </div>
                <?php if ($is_login_fb != true): ?>
                    <form id="feed-fb-form" method="post" action="<?php echo \Fuel\Core\Uri::create('/admin/facebook/feed', array(), array()); ?>" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-styles"><?php echo Fuel\Core\Lang::get('label.message'); ?></label>
                            <div class="col-sm-8">
                                <textarea class="form-control" rows="6" name="message"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?php echo Fuel\Core\Lang::get('label.link'); ?></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="link" />
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary"><?php echo Fuel\Core\Lang::get('button.feed_fb'); ?></button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if ($is_login_fb != true): ?>
        <div class="col-xs-12 col-sm-4">
            <div class="box">
                <div class="box-header">
                    <div class="box-name">
                        <i class="fa fa-arrows"></i>
                        <span><?php echo Fuel\Core\Lang::get('title.group'); ?></span>
                    </div>
                    <div class="box-icons">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                    <div class="no-move"></div>
                </div>
                <div class="box-content">
                    <form id="create-group-fb-form" method="post" action="<?php echo \Fuel\Core\Uri::create('/admin/facebook/add_group', array(), array()); ?>" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo Fuel\Core\Lang::get('label.name_or_id'); ?></label>
                            <div class="col-sm-8">
                                <input type="text" id="group-fb" class="form-control" name="group" />
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary"><?php echo Fuel\Core\Lang::get('button.submit'); ?></button>
                        </div>
                    </form>
                    <div class="form-group" id="group-fb-container">
                        <table class="table table-striped table-bordered table-hover table-heading table-datatable no-border-bottom">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th class="col-sm-1 text-center"><?php echo Fuel\Core\Lang::get('title.action'); ?></th>
                                </tr>
                            </thead>
                            <tbody id="group-fb-list">
                                <?php if (!empty($group)): ?>
                                    <?php foreach ($group as $k => $v): ?>
                                        <tr data-id="<?php echo $v['id']; ?>">
                                            <td><?php echo $v['group_name']; ?></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger delete-btn"><?php echo Fuel\Core\Lang::get('button.delete'); ?></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
