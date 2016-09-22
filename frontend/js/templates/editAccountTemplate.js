/* Edit Account form that will be shown */
var editAccountTemplate = '<center> \
        <div class="container"> \
            <div class="form-signin"> \
                <h4 class="form-signin-heading">Edit your account </h4> \
                <p id="userEditAccountErrLog" class="label label-danger"></p> \
                <p></p> \
                <input type="email" id="inputEditAccountUserName" class="form-control" placeholder="New Username" > \
                <input type="password" id="inputEditAccountPassword" class="form-control" placeholder="New Password"> \
                <button id="saveEditAccount" class="btn btn-lg btn-primary btn-block" type="submit">Save</button> \
            </div> \
        </div> <!-- /container --> \
        </center>';