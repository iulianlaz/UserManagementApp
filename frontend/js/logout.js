$(document).ready(function(){
    /* Add delegate because #toSend element is dynamically generated */
    $('#generalContainer').on('click', '#userLogout',  function(){

        $.ajax({
            url: "backend/rest.php/auth/logout",
            type: "GET",
            dataType: "json",
            success: function (data) {
                if (data.hasOwnProperty('auth')) {
                    /* If user is not authenticated, then show login page */
                    if (!data.auth) {
                        $('#generalContainer').empty();
                        $('#generalContainer').append(loginForm);
                    }
                }
            }
        });


    });

});