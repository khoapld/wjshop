<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/" class="navbar-brand">Project name</a>
        </div>
        <div class="navbar-collapse collapse" id="navbar">
            <ul class="nav navbar-nav navbar-right">
                <?php if ($user_id): ?>
                    <li><a href="#">Welcome <?php echo $user_info->username; ?></a></li>
                    <li class="active"><a href="/signout">Sign Out</a></li>
                <?php else: ?>
                    <li class="<?php echo $action == 'signin' ? 'active' : ''; ?>"><a href="/signin">Sign In</a></li>
                    <li class="<?php echo $action == 'signup' ? 'active' : ''; ?>"><a href="/signup">Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>