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
                    <span>Facebook</span>
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
                <div class="form-group text-right">
                    <?php if ($is_login_fb == true): ?>
                        <a class="btn btn-lg btn-primary" href="/admin/facebook/login/facebook">Login</a>
                    <?php else: ?>
                        <a class="btn btn-lg btn-primary" href="https://facebook.com/<?php echo $user_fb['uid']; ?>" target="_blank">Go to Facebook page</a>
                    <?php endif; ?>
                </div>
                <?php if (!empty($user_fb)): ?>
                    <form id="post-fb-form" method="post" action="<?php echo \Fuel\Core\Uri::create('/admin/facebook/feed', [], []); ?>" class="form-horizontal">
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-4">
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-arrows"></i>
                    <span>Group</span>
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
                <form id="create-group-fb-form" method="post" action="<?php echo \Fuel\Core\Uri::create('/admin/facebook/add_group', [], []); ?>" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Name or ID</label>
                        <div class="col-sm-8">
                            <input type="text" id="group-fb" class="form-control" name="group" />
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                <table class="table table-striped table-bordered table-hover table-heading table-datatable no-border-bottom">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="col-sm-1 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="group-fb-list">
                        <?php if (!empty($group)): ?>
                            <?php foreach ($group as $k => $v): ?>
                                <tr data-id="<?php echo $v['id']; ?>">
                                    <td><?php echo $v['group_name']; ?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger delete-btn">Delete</button>
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
