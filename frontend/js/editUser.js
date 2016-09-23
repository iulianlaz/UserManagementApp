/**
 * Handles the way a user is edited
 */
$(document).ready(function(){
    /* ============ Add user template =========== */
    $('#generalContainer').on('click', '.editUserClass',  function(){

        /* Get the username that will be modified and save it */
        $usernameChanged = $(this).attr('id');

        $('#mainBody').empty();
        $('#mainBody').append(editUserTemplate);

        $('#usernameChanged').attr("value", $usernameChanged);
    });

    /* ================= Add new user into the system ================ */
    $('#generalContainer').on('click', '#saveEditUser',  function(){

        $('#userEditUserErrLog').empty();
        var user = $('#inputEditUserUsername').val();
        var pass = $('#inputEditUserPassword').val();
        var role = $('#inputEditUserRole').val();

        /* username that will be edited */
        var usernameChanged = $('#usernameChanged').attr('value');

        /* Get current user (this will be updated - because it is unique - it is like an id)*/
        var welcomeCurrentUser = $('#uniqueUser').text();
        welcomeCurrentUser = welcomeCurrentUser.substring(0, welcomeCurrentUser.length - 1);
        var currUser = welcomeCurrentUser.replace('Welcome, ', '');

        var data = {};

        if (usernameChanged) {
            data.currentUsername = usernameChanged;
        }

        if (user) {
            data.username = user;
        }

        if (pass) {
            data.password = pass;
        }

        if (role) {
            data.role = role;
        }

        /* Send request in order to add user */
        $.ajax({
            url: "backend/rest.php/user/edit",
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

                $('#inputEditUserUsername').val("");
                $('#inputEditUserPassword').val("");
                $('#inputEditUserRole').val("");

                if (data.hasOwnProperty('message')) {
                    $('#userEditUserErrLog').empty();
                    $('#userEditUserErrLog').removeClass('label-danger').addClass('label-success');
                    $('#userEditUserErrLog').append(data.message);


                    if (data.hasOwnProperty('result') && data.result.hasOwnProperty('username') &&
                        (currUser == usernameChanged)) {
                        /* Update username from welcome (right top corner) */
                        $('#uniqueUser').empty();
                        $('#uniqueUser').text('Welcome, ' + data.result.username + '!');
                    }
                }

                if (data.hasOwnProperty('error')) {
                    $('#userEditUserErrLog').empty();
                    $('#userEditUserErrLog').removeClass('label-success').addClass('label-danger');
                    $('#userEditUserErrLog').append(data.error);
                }
            }
        });
    });
});