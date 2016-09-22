$(document).ready(function(){
    /* Add delegate because #toSend element is dynamically generated */
    $('#generalContainer').on('click', '#toSend',  function(){

        $('#userErrLog').empty();
        var user = $('#inputUser').val();
        var pass = $('#inputPassword').val();
        var data = {'username': user, 'password':pass};

        $.ajax({
            url: "backend/rest.php/auth/login",
            contentType: "application/json",
            data: JSON.stringify(data),
            type: "POST",
            dataType: "json",
            success: function (data) {
                if (data.hasOwnProperty('auth')) {
                    $('#generalContainer').empty();

                    /* If user is authenticated, then show page */
                    if (data.auth) {
                        generateManagementPage(data.result);

                    /* If error occurs, then show error */
                    } else {
                        $('#inputUser').val("");
                        $('#inputPassword').val("");
                        if (data.hasOwnProperty('error')) {
                            $('#userErrLog').empty();
                            $('#userErrLog').append(data.error);
                        }
                    }
                } else {
                    $('#inputUser').val("");
                    $('#inputPassword').val("");

                    if (data.hasOwnProperty('error')) {
                        $('#userErrLog').empty();
                        $('#userErrLog').append(data.error);
                    }
                }
            }
        });


    });

});