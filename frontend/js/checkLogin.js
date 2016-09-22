$(document).ready(function(){

    /* Clear general container */
    $('#generalContainer').empty();

    /* Check user Session */
    $.ajax({
        url: "backend/rest.php/auth/logout",
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