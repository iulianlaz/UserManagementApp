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

    var pageNo = '';
    if ($(this).attr('id') === 'pageNumberValue') {
        pageNo = $(this).text();
    }

    var data = {};
    if (pageNo == '') {
        data.page = 1;
    } else {
        data.page = pageNo;
    }

    console.log(data.page);

    $.ajax({
        url: "backend/rest.php/user/find?page=" + data.page,
        contentType: "application/json",
        //data: JSON.stringify(data),
        type: "POST",
        dataType: "json",
        success: function (data) {
            /* Check authentication */
            if (data.hasOwnProperty('auth')) {
                /* If user is not authenticated, then show login form */
                if (!data.auth) {
                    $('#generalContainer').empty();
                    $('#generalContainer').append(loginForm);
                    return;
                }
            }

            $('#mainBody').append(header);

            /* Get current user (this will be updated - because it is unique - it is like an id)*/
            var welcomeCurrentUser = $('#uniqueUser').text();
            welcomeCurrentUser = welcomeCurrentUser.substring(0, welcomeCurrentUser.length - 1);
            var currUser = welcomeCurrentUser.replace('Welcome, ', '');

            if (data.hasOwnProperty('result')) {

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
                            '<button id="'+ data.result[userItem].username + '" class="btn-small btn btn-primary editUserClass" type="submit">Edit User</button>' +
                            '<p></p></div>';

                        userList += '<div class="col-md-2 grid-custom">' +
                            '<input type="checkbox" name="user-del-checkbox" value="' + data.result[userItem].username +'">' +
                            '<p></p></div>';


                        $('#mainBody').append(userList);
                    }

                }
            }

            /* Add pagination */
            if (data.hasOwnProperty('totalPages')) {
                var newPageLink = ('<p></p>' +
                    '<nav aria-label="Page navigation" class="grid-custom-user-pag">' +
                    '<ul class="pagination">'
                );

                for(var no = 1; no <= data.totalPages; no++) {
                    newPageLink += '<li><a href="#" id="pageNumberValue"> ' + no + '</a></li>';
                }
                newPageLink += '</ul></nav>';

                $('#mainBody').append(newPageLink);
            }
        }
    });
}

/**
 * Handles the following:
 *  - Generates user management grid
 *  - Handles the logic for adding a user into system
 *  - Handles the refreshing grid
 */
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
                /* Check authentication */
                if (data.hasOwnProperty('auth')) {
                    /* If user is not authenticated, then show login form */
                    if (!data.auth) {
                        $('#generalContainer').empty();
                        $('#generalContainer').append(loginForm);
                        return;
                    }
                }

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

    /* ================= Each page view  ================ */
    $('#generalContainer').on('click', '#pageNumberValue',  buildUserList);

});