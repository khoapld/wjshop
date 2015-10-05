<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <form id="form-signup" method="POST" action="/signup">
            <h2 class="text-center">Please Sign Up</h2>
            <div class="form-group">
                <label for="inputUserName">Username: <span class="text-danger error username"></span></label>
                <input type="text" placeholder="Username" class="form-control" name="username">
            </div>
            <div class="form-group">
                <label for="inputEmail">Email: <span class="text-danger error email"></span></label>
                <input type="text" placeholder="Email address" class="form-control" name="email">
            </div>
            <div class="form-group">
                <label for="inputPassword">Password: <span class="text-danger error password"></span></label>
                <input type="password" placeholder="Password" class="form-control" name="password">
            </div>
            <div class="form-group">
                <label for="inputConfirmPassword">Confirm Password: <span class="text-danger error confirm_password"></span></label>
                <input type="password" placeholder="Confirm Password" class="form-control" name="confirm_password">
            </div>
            <div class="checkbox">
                <label class="col-md-offset-10">
                    <a href="/signin">Sign In!!!</a>
                </label>
            </div>
            <button type="submit" id="btn-signup" class="btn btn-lg btn-primary btn-block">Sign Up</button>
        </form>
    </div>
</div>