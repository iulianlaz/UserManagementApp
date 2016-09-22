$(document).ready(function(){
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

    /* Clear general container */
    $('#generalContainer').empty();

    /* Check user Session */
    $.ajax({
        url: "backend/rest.php/auth/check",
        //contentType: "application/json",
        //data: JSON.stringify(data),
        type: "GET",
        //dataType: "json",
        success: function (response) {
            var data = JSON.parse(response);
            console.log(data);

            if (data.hasOwnProperty('auth')) {
                console.log(data.auth);

                /* If user is authenticated, then show page */
                if (data.auth) {
                    $('#generalContainer').append('<p>' + data.result.username + ' ' + data.result.role + '</p>');
                /* If is not authenticated, the show login form */
                } else {
                    $('#generalContainer').append(loginForm);
                }
            }
        }
    });
});