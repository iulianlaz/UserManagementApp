/* Edit User form that will be shown */
var editUserTemplate = '<center> \
        <div class="container"> \
            <div class="form-signin"> \
                <h4 class="form-signin-heading">Edit User </h4> \
                <p id="userEditUserErrLog" class="label label-danger"></p> \
                <p></p>\
                <input type="hidden" id="usernameChanged" class="form-control"  hidden> \
                <input type="email" id="inputEditUserUsername" class="form-control" placeholder="New Username" > \
                <input type="password" id="inputEditUserPassword" class="form-control" placeholder="New Password"> \
                <input type="email" id="inputEditUserRole" class="form-control" placeholder="New Role"> \
                <button id="saveEditUser" class="btn btn-lg btn-primary btn-block" type="submit">Save</button> \
            </div> \
        </div> <!-- /container --> \
        </center>';