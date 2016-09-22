$(document).ready(function() {

    $('#generalContainer').on('click', '#deleteUsers', function (e) {
        e.preventDefault();
        var answer = confirm('Do you want to delete the selected users?');
        if (answer) {
            var delUsers = [];
            $("input:checkbox[name=user-del-checkbox]:checked").each(function(){
                delUsers.push($(this).val());
            });
            console.log(delUsers);

            if (delUsers.length > 0) {
                $.ajax({
                    url: "backend/rest.php/user/delete",
                    contentType: "application/json",
                    data: JSON.stringify(delUsers),
                    type: "POST",
                    dataType: "json",
                    success: function (data) {
                        $('#inputEditAccountUsername').val("");
                        $('#inputEditAccountPassword').val("");
                        if (data.hasOwnProperty('message')) {
                            buildUserList();
                            alert(data.message);
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