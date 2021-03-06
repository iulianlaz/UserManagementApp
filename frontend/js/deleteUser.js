$(document).ready(function() {

    $('#generalContainer').on('click', '#deleteUsers', function (e) {
        e.preventDefault();
        var answer = confirm('Do you want to delete the selected users?');
        if (answer) {
            var delUsers = [];
            $("input:checkbox[name=user-del-checkbox]:checked").each(function(){
                delUsers.push($(this).val());
            });

            if (delUsers.length > 0) {
                $.ajax({
                    url: "backend/rest.php/user/delete",
                    contentType: "application/json",
                    data: JSON.stringify(delUsers),
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

                        $('#inputEditAccountUsername').val("");
                        $('#inputEditAccountPassword').val("");
                        if (data.hasOwnProperty('message')) {
                            buildUserList();
                        }

                        if (data.hasOwnProperty('error')) {
                            alert(data.error);
                        }
                    }
                });

                $("input:checkbox[name=user-del-checkbox]").prop("checked", false);
            }

        }
        else {
            /* Uncheck select checkboxes */
            $("input:checkbox[name=user-del-checkbox]").prop("checked", false);
        }
    });

});