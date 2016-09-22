/* Add buttons for grid refreshing and user add */
var userManagementButtons = '<div class="row"> \
            <div class="col-md-2"> \
            <button id="newUser" class="btn btn-primary" type="submit">Add New User</button>\
            </div> \
            <div class="col-md-2"> \
            <button id="refreshGrid" class="btn btn-primary" type="submit">Refresh Grid</button>\
            </div> \
            </div>';

$(document).ready(function(){
    /* ============ Generate user management grid ============= */
    $('#generalContainer').on('click', '#uniqueUserManagement',  function(){

        /* Main body must be cleared */
        $('#mainBody').empty();

        $('#mainBody').append(userManagementButtons);


        // $.ajax({
        //     url: "backend/rest.php/user/find",
        //     contentType: "application/json",
        //     data: JSON.stringify(data),
        //     type: "POST",
        //     dataType: "json",
        //     success: function (data) {
        //         $('#inputEditAccountUsername').val("");
        //         $('#inputEditAccountPassword').val("");
        //         if (data.hasOwnProperty('message')) {
        //             $('#userEditAccountErrLog').empty();
        //             $('#userEditAccountErrLog').removeClass('label-danger').addClass('label-success');
        //             $('#userEditAccountErrLog').append(data.message);
        //
        //             /* Update username from welcome (right top corner) */
        //             $('#uniqueUser').empty();
        //             $('#uniqueUser').text('Welcome, ' + data.result.username + '!');
        //         }
        //
        //         if (data.hasOwnProperty('error')) {
        //             $('#userEditAccountErrLog').empty();
        //             $('#userEditAccountErrLog').removeClass('label-success').addClass('label-danger');
        //             $('#userEditAccountErrLog').append(data.error);
        //         }
        //     }
        // });

    });

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

});