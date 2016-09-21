$(document).ready(function(){

    $('#toSend').click(function(){

        var user = $('#inputUser').val();
        var pass = $('#inputPassword').val();
        var data = {'role': user, 'password':pass, "name": "iulian", "email": "test@dd.com"};

        $.ajax({
            url: "backend/rest.php/user/delete",
            contentType: "application/json",
            data: JSON.stringify(data),
            type: "POST",
            dataType: "json",
            success: function (data) {
                console.log(data);
                //setTimeout(function() {document.location.href = "./php/frontpage.php" });

                // if (data.retResponse == 'success') {
                //     document.location.href = data.showProperties;
                // }
                // // Error
                // else {
                //     $(data.retResponse).empty();
                //     $(data.retResponse).append(data.showProperties);
                // }
            }
        });


    });

});