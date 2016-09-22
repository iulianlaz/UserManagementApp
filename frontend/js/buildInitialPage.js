$(document).ready(function(){

    /* Clear general container */
    $('#generalContainer').empty();

    /**
     * Checks user Session:
     *  - if user is authenticated, then management template will be loaded
     *  - if is not authenticated, login form will be shown
     */
    $.ajax({
        url: "backend/rest.php/auth/check",
        type: "GET",
        dataType: "json",
        success: function (data) {
            if (data.hasOwnProperty('auth')) {

                /* If user is authenticated, then show page */
                if (data.auth) {
                    generateManagementPage(data.result);
                /* If is not authenticated, the show login form */
                } else {
                    $('#generalContainer').append(loginForm);
                }
            }
        }
    });
});