/* Add Userform that will be shown */
var addUserTemplate = '<center> \
        <div class="container"> \
            <div class="form-signin"> \
                <h4 class="form-signin-heading">Add New User </h4> \
                <p id="userAddUserErrLog" class="label label-danger"></p> \
                <p></p>\
                <input type="email" id="inputAddUserUsername" class="form-control" placeholder="Username" > \
                <input type="password" id="inputAddUserPassword" class="form-control" placeholder="Password"> \
                <input type="email" id="inputAddUserEmail" class="form-control" placeholder="Email" > \
                <input type="email" id="inputAddUserRole" class="form-control" placeholder="Role"> \
                <button id="saveAddUser" class="btn btn-lg btn-primary btn-block" type="submit">Save</button> \
            </div> \
        </div> <!-- /container --> \
        </center>';