$(document).ready(function(){
    /* Add Edit account template */
    $('#generalContainer').on('click', '#uniqueEditAccount',  function(){

        $('#mainBody').empty();
        $('#mainBody').append(editAccountTemplate);
    });

    /* Update account */
    $('#generalContainer').on('click', '#saveEditAccount',  function(){

        $('#userEditAccountErrLog').empty();
        var user = $('#inputEditAccountUsername').val();
        var pass = $('#inputEditAccountPassword').val();

        /* Get current user (this will be updated - because it is unique - it is like an id)*/
        var welcomeCurrentUser = $('#uniqueUser').text();
        welcomeCurrentUser = welcomeCurrentUser.substring(0, welcomeCurrentUser.length - 1);
        var currUser = welcomeCurrentUser.replace('Welcome, ', '');

        var data = {};
        if (currUser) {
            data.currentUsername = currUser;
        }

        if (user) {
            data.username = user;
        }

        if (pass) {
            data.password = pass;
        }

        $.ajax({
            url: "backend/rest.php/user/edit",
            contentType: "application/json",
            data: JSON.stringify(data),
            type: "POST",
            dataType: "json",
            success: function (data) {
                $('#inputEditAccountUsername').val("");
                $('#inputEditAccountPassword').val("");
                 if (data.hasOwnProperty('message')) {
                     $('#userEditAccountErrLog').empty();
                     $('#userEditAccountErrLog').removeClass('label-danger').addClass('label-success');
                     $('#userEditAccountErrLog').append(data.message);

                     /* Update username from welcome (right top corner) */
                     $('#uniqueUser').empty();
                     $('#uniqueUser').text('Welcome, ' + data.result.username + '!');
                 }

                if (data.hasOwnProperty('error')) {
                    $('#userEditAccountErrLog').empty();
                    $('#userEditAccountErrLog').removeClass('label-success').addClass('label-danger');
                    $('#userEditAccountErrLog').append(data.error);
                }
            }
        });


    });

});