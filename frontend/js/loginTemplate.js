/* Login form that will be shown */
var loginForm = '<center> \
        <div class="container"> \
            <div class="form-signin"> \
                <h4 class="form-signin-heading">Please Log In </h4> \
                <p id="UserErrLog" class="label label-danger"></p> \
                <p></p> \
                <label for="inputEmail" class="sr-only">Username</label> \
                <input type="email" id="inputUser" class="form-control" placeholder="User" autofocus required> \
                <label for="inputPassword" class="sr-only">Password</label> \
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" required> \
                <button id="toSend" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button> \
            </div> \
        </div> <!-- /container --> \
        </center>';