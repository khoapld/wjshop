<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <form id="form-signin"method="POST" action="/signin">
            <h2 class="text-center">Please Sign In</h2>
            <div class="form-group">
                <label for="inputEmail">Email: <span class="text-danger error email"></span></label>
                <input type="text" placeholder="Email" class="form-control" name="email">
            </div>
            <div class="form-group">
                <label for="inputPassword">Password: <span class="text-danger error password"></span></label>
                <input type="password" placeholder="Password" class="form-control" name="password">
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" value="1"> Remember me
                </label>
                <label class="col-md-offset-8">
                    <a href="/signup">Sign Up!!!</a>
                </label>
            </div>
            <button type="submit" id="btn-siginin" class="btn btn-lg btn-primary btn-block">Sign In</button>
        </form>
    </div>
</div>