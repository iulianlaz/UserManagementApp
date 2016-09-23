/**
 *  Add buttons for grid refreshing and user add
 */
var userManagementButtons = '<div class="row"> \
            <div class="col-md-2"> \
            <button id="newUser" class="btn btn-primary" type="submit">Add New User</button>\
            </div> \
            <div class="col-md-2"> \
            <button id="refreshGrid" class="btn btn-primary" type="submit">Refresh Grid</button>\
            </div> \
            <div class="col-md-2"> \
            <button id="deleteUsers" class="btn btn-primary" type="submit">Delete Selected Users</button>\
            </div> \
            </div>';

var filterButton = '<br><div class="row"> \
        <div class="col-md-2"> \
            <div class="input-group">\
                <span class="input-group-btn">\
                    <input type="email" id="filterInputId" class="form-control" placeholder="Add filter"> \
                    <button id="filterSubmitId" class="btn btn-primary" type="submit">Filter</button>\
                </span>\
                <input type="hidden" id="filterInputHiddenId" class="form-control""> \
            </div>\
        </div> \
    </div><p></p>';

/**
 * Header for user management grid
 * @type {string}
 */
var header = '<div class="row show-grid grid-custom-user"> \
                    <div  class="col-md-2 grid-custom"><h4>Role\
                    <div class="dropdown">\
                        <button class="btn btn-small btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Sort\
                        <span class="caret"></span></button>\
                        <ul class="dropdown-menu">\
                            <li><a href="#">Asc</a></li>\
                            <li><a href="#">Desc</a></li>\
                        </ul>\
                    </div>\
                    </h4></div> \
                    <div class="col-md-2 grid-custom"><h4> Username \
                    <div class="dropdown">\
                        <button class="btn btn-small btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Sort\
                        <span class="caret"></span></button>\
                        <ul class="dropdown-menu">\
                            <li><a href="#">Asc</a></li>\
                            <li><a href="#">Desc</a></li>\
                        </ul>\
                    </div>\
                    </h4></div>\
                    <div  class="col-md-2 grid-custom"><h4> Email \
                    <div class="dropdown">\
                        <button class="btn btn-small btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Sort\
                        <span class="caret"></span></button>\
                        <ul class="dropdown-menu">\
                            <li><a href="#">Asc</a></li>\
                            <li><a href="#">Desc</a></li>\
                        </ul>\
                    </div>\
                    </h4></div>\
                    <div  class="col-md-2 grid-custom"><h4> Edit User</h4></div> \
                    <div  class="col-md-2 grid-custom"><h4> Select</h4></div> \
                </div>';