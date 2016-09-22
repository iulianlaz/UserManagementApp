/* Add buttons for grid refreshing and user add */
var userManagementButtons = '<div class="row"> \
            <div class="col-md-2"> \
            <button id="newUser" class="btn btn-primary" type="submit">Add New User</button>\
            </div> \
            <div class="col-md-2"> \
            <button id="refreshGrid" class="btn btn-primary" type="submit">Refresh Grid</button>\
            </div> \
            <div class="col-md-2"> \
            <button id="deleteUsers" class="btn btn-primary" type="submit">Delete Selected Users</button>\
            </div> \
            </div>';

/**
 * Header for user management grid
 * @type {string}
 */
var header = '<div class="row show-grid grid-custom-user"> \
                    <div  class="col-md-2 grid-custom"><h4>Role\
                    <div class="dropdown">\
                        <button class="btn btn-small btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Sort\
                        <span class="caret"></span></button>\
                        <ul class="dropdown-menu">\
                            <li><a href="#">Asc</a></li>\
                            <li><a href="#">Desc</a></li>\
                        </ul>\
                    </div>\
                    </h4></div> \
                    <div class="col-md-2 grid-custom"><h4> Username \
                    <div class="dropdown">\
                        <button class="btn btn-small btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Sort\
                        <span class="caret"></span></button>\
                        <ul class="dropdown-menu">\
                            <li><a href="#">Asc</a></li>\
                            <li><a href="#">Desc</a></li>\
                        </ul>\
                    </div>\
                    </h4></div>\
                    <div  class="col-md-2 grid-custom"><h4> Email \
                    <div class="dropdown">\
                        <button class="btn btn-small btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Sort\
                        <span class="caret"></span></button>\
                        <ul class="dropdown-menu">\
                            <li><a href="#">Asc</a></li>\
                            <li><a href="#">Desc</a></li>\
                        </ul>\
                    </div>\
                    </h4></div>\
                    <div  class="col-md-2 grid-custom"><h4> Edit User</h4></div> \
                    <div  class="col-md-2 grid-custom"><h4> Select</h4></div> \
                </div>';

/**
 * Method used to build the list of users
 * It is called when a operation has been done on the list:
 *  - On click on "User management button"
 *  - delete user
 */
var buildUserList = function(){

    /* Main body must be cleared */
    $('#mainBody').empty();

    $('#mainBody').append(userManagementButtons);
    $('#mainBody').append("<p></p>");

    $.ajax({
        url: "backend/rest.php/user/find",
        contentType: "application/json",
        //data: JSON.stringify(data),
        type: "POST",
        dataType: "json",
        success: function (data) {

            $('#mainBody').append(header);

            /* Get current user (this will be updated - because it is unique - it is like an id)*/
            var welcomeCurrentUser = $('#uniqueUser').text();
            welcomeCurrentUser = welcomeCurrentUser.substring(0, welcomeCurrentUser.length - 1);
            var currUser = welcomeCurrentUser.replace('Welcome, ', '');

            if (data.hasOwnProperty('result')) {
                console.log('----here-----');
                console.log(data.result1);

                for (var userItem in data.result) {
                    if (data.result.hasOwnProperty(userItem)) {
                        var userList = '<div class="row show-grid grid-custom-user">';

                        if (data.result[userItem].hasOwnProperty('role')) {
                            userList += '<div class="col-md-2 grid-custom">' +
                                data.result[userItem].role +
                                '<p></p></div>';
                        } else {
                            userList += '<div class="col-md-2 grid-custom"><</div>';
                        }

                        if (data.result[userItem].hasOwnProperty('username')) {
                            var iAmHere = '';

                            /* Mark current auth user */
                            if (currUser === data.result[userItem].username) {
                                iAmHere = '(you)';
                            }

                            userList += '<div class="col-md-2 grid-custom">' +
                                data.result[userItem].username + ' ' + iAmHere +
                                '<p></p></div>';
                        } else {
                            userList += '<div class="col-md-2 grid-custom">p></p></div>';
                        }

                        if (data.result[userItem].hasOwnProperty('email')) {
                            userList += '<div class="col-md-2 grid-custom">' +
                                data.result[userItem].email +
                                '<p></p></div>';
                        } else {
                            userList += '<div class="col-md-2 grid-custom">p></p></div>';
                        }

                        userList += '<div class="col-md-2 grid-custom">' +
                            '<button id="edit_'+ data.result[userItem].username + '" class="btn-small btn btn-primary" type="submit">Edit User</button>' +
                            '<p></p></div>';

                        userList += '<div class="col-md-2 grid-custom">' +
                            '<input type="checkbox" name="user-del-checkbox" value="' + data.result[userItem].username +'">' +
                            '<p></p></div>';


                        $('#mainBody').append(userList);
                    }

                }


            }
        }
    });
}

$(document).ready(function(){
    /* ============ Generate user management grid ============= */
    $('#generalContainer').on('click', '#uniqueUserManagement',  buildUserList);

    /* ============ Add user template =========== */
    $('#generalContainer').on('click', '#newUser',  function(){
        $('#mainBody').empty();
        $('#mainBody').append(addUserTemplate);
    });

    /* ================= Add new user into the system ================ */
    $('#generalContainer').on('click', '#saveAddUser',  function(){

        $('#userAddUserErrLog').empty();
        var user = $('#inputAddUserUsername').val();
        var pass = $('#inputAddUserPassword').val();
        var email = $('#inputAddUserEmail').val();
        var role = $('#inputAddUserRole').val();

        var data = {};
        if (user) {
            data.username = user;
        }

        if (pass) {
            data.password = pass;
        }

        if (email) {
            data.email = email;
        }

        if (role) {
            data.role = role;
        }

        /* Send request in order to add user */
        $.ajax({
            url: "backend/rest.php/user/add",
            contentType: "application/json",
            data: JSON.stringify(data),
            type: "POST",
            dataType: "json",
            success: function (data) {
                $('#inputAddUserUsername').val("");
                $('#inputAddUserPassword').val("");
                $('#inputAddUserEmail').val("");
                $('#inputAddUserRole').val("");

                if (data.hasOwnProperty('message')) {
                    $('#userAddUserErrLog').empty();
                    $('#userAddUserErrLog').removeClass('label-danger').addClass('label-success');
                    $('#userAddUserErrLog').append(data.message);
                }

                if (data.hasOwnProperty('error')) {
                    $('#userAddUserErrLog').empty();
                    $('#userAddUserErrLog').removeClass('label-success').addClass('label-danger');
                    $('#userAddUserErrLog').append(data.error);
                }
            }
        });
    });

    /* ================= Refresh Grid  ================ */
    $('#generalContainer').on('click', '#refreshGrid',  buildUserList);

});