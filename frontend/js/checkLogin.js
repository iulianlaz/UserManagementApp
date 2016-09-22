$(document).ready(function(){

    /* Clear general container */
    $('#generalContainer').empty();

    /* Check user Session */
    $.ajax({
        url: "backend/rest.php/auth/check",
        type: "GET",
        dataType: "json",
        success: function (data) {
            if (data.hasOwnProperty('auth')) {

                /* If user is authenticated, then show page */
                if (data.auth) {
                    $('#generalContainer').append(managementTemplate);
                    console.log(data.result.username);
                    $('#uniqueUser').empty();
                    $('#uniqueUser').text('Welcome, ' +  data.result.username + '!');
                /* If is not authenticated, the show login form */
                } else {
                    $('#generalContainer').append(loginForm);
                }
            }
        }
    });
});