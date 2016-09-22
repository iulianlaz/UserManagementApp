/**
 * Generates management page based on input data
 * e.g. If user is admin an extra filed is added to the menu
 */
var generateManagementPage = function(data) {
    $('#generalContainer').append(managementTemplate);

    /* Show current user name */
    $('#uniqueUser').empty();
    $('#uniqueUser').text('Welcome, ' + data.username + '!');

    /* Show Edit Account as default page */
    $('#mainBody').empty();
    $('#mainBody').append(editAccountTemplate);

    /* Show right menu */
    $('#userOptions').empty();
    var options = '';
    if (data.role == 'admin') {
        options += '<li><a href="#" id="uniqueUserManagement">User Management</a></li>';
    }

    options += '<li><a href="#" id="uniqueEditAccount">Edit My Account</a></li> \
            <li><a href="#" id="userLogout">Logout</a></li>';

    $('#userOptions').append(options);
}