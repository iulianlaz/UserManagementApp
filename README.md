## Simple User Management Web Application

### Overview

#### Video tutorial
 https://drive.google.com/open?id=0BzywImwXO-pweUdUVTJMOHFvUzQ

### Installation

#### Step 0
 In order to run this, you need:
 + Web server (e.g. Apache)
 + PHP
 + MongoDB

#### Step 1: Install Apache
 Run this command:
`sudo apt-get install apache2`

#### Step 2: Install PHP
 Run this command:
 ```
 sudo apt-get install php5 libapache2-mod-php5 php5-mcrypt
 sudo apt-get install php-pear
 sudo apt-get install php5-dev
 sudo apt-get install libpcre3 libpcre3-dev
 ```

#### Step 3: Install MongoDB
 Follow the instructions from: https://docs.mongodb.com/v3.0/tutorial/install-mongodb-on-ubuntu/  
 After that, install mongodb extension:  
 `pecl install mongodb`  
 Put `extension=mongodb.so` in php.ini file (more info here: https://github.com/mongodb/mongo-php-library).

#### Step 4: Init repo
 Clone this repo in `/var/www/html`.  
 Run `populateDb.sh` in order to create admin user in database.    
 Now, you should be able to login from: localhost/UserManagementApp/ with username: `admin` and password: `admin123#` (please
 change this).

### API
 The following methods are implemented in backend:
 + user/add
 + user/edit
 + user/find
 + user/delete
 + auth/login
 + auth/logout
 + auth/check


### Implementation
 The project is structured in two main components: backend and frontend.

#### Backend
 It is structured  in the following layers:
 + endpoint layer
 + authentication layer
 + interceptor layer
 + datasource layer

##### Rest endpoint
 The endpoint for all requests is located at `backend/rest.php`. When a request arrives, it is processed as follows:
 + An interceptor for the request is created. Here, the request is validated (only application/json content-type is
   accepted). After that, a Request object is created with available information (htmlentites method is called for 
   input data). The Request object contains attributes such as: resource name, resource operation, query parameters and 
   payload. For example, if a request `/rest.php/user/find?page=1` arrives, the resourceName=user, resourceOperation=find 
   and queryParameters=\["page": 1\].
 + Based on resource name from Request object a particular handler will be initialized (e.g. user handler, auth handler)
 + Before a request is handled, it is checked if user is authenticated. If it is, we move on, otherwise, an error is returned.
 
##### Request Handler
 As is mentioned above, a particular handler for a resource is called based on request's data. Each handler has a list of
 supported operations. If an operation is not supported, the request fails.

##### User Resource Handler
 The handler for user resource supports the following operations:
 + Add user operation: First, it validates the data received. After that, it is checked if the username already exists
   (must be unique). Then, it is verified if the user can add a new user (is admin). Also, the password is encrypted in
    this step. Finally, method from data access object is called and information is added into database and response is 
    returned.
 + Edit user: Firstly, it is checked if the username for the user that must be edited is provided. After that, data is
   validated, permissions are checked (here, a user can be edited by admin or by himself). If currently authenticated
   user edits his information, then the data from session must be update (username and role).
 + Find user: It is validated the request query (only some attributes are allowed: e.g. page) and the query from payload
   (allowed attributes are: filterValue, sortBy and sortOrder). After this step, input queries are mapped to database
   queries and relevant documents are fetched from database. Also, if page is provided, this method will handle pagination.
 + Delete user: If the user has permissions to delete an array with ids, then the documents with these ids are deleted. 

#### Authentication Handler
 Authentication handler has the following supported operation:
 + Check operation: Checks if an user is authenticated or not
 + Login operation: Logs a user into the system if the input data is correct. Also, it sets the session details for logged
   in user.
 + Logout operation: Logs out a user from the system. The session is destroyed.  

#### Frontend
 It is structured as follows:
 + `templates/` directory contains elements for each view (relevant names for each view exist in this folder - 
    managementTemplate.js contains the elements for entire user management area).
 + Each javascript file handles one single event except userManagementView.js (userManagementView.js handles all events
   that occur in user management view area (add user, refresh grid, build grid, except users deletion)).
 + generateManagementPage.js is used to load initial page (used in buildInitialPage.js and loginSubmit.js)
 + If it is received from backend a `auth=false` response, then login form will be shown 
 
##### Login Section
 When index.html is loaded, buildInitialPage.js will populate the page with relevant elements. If user is authenticated,
 then user management page will be generated. Otherwise, login form will be shown.
 
##### Edit Account Section
 Username or password values are sent to the server, but also the current username of authenticated user (based on this
 username the document from database will be updated).
 
##### Add User Section
 Data are sent to the server through `rest.php/user/add` endpoint. 

##### Edit User Section
 When users are created into the grid, elements will store their `username` (in order to find the user we want to edit
 based on his username). Thus, when a user is edited, we already have his username. Also, authenticated user `username`
 is obtained, because if current user is edited, we must reload the element (`Welocome, <user_name>`) with the new 
 username.
 
##### Build Grid Section (User Management View) 
 Firstly, we should obtain few information here:
 + What page we should load
 + If sort or filters are applied, then do not remove them  
 
 
 Page number is obtained from pagination section (will be discussed). If it does not exist, then set default value to 1.  
 Filter value and sort value are obtained from previously saved values (if any).  
 A query to the `rest.php/user/find/page=\<no\>` will be sent. Now, we should obtain the users according to our query.  
 Grid will be created.  
 Current user will be marked with `(you)` near his username.  
 Based on response from server, pagination is built also. An element with page number value will be saved.  
 
##### Filter User Section
 When a filter is applied, it will look in `username`, `role` and `email` values to find relevant information.

##### Sort User Section
 Sort each column based on criteria: asc or desc. Grid will be reloaded

##### Delete User Section
 It Deletes selected users. An array with `username` values are sent to the server. Grid will be reloaded if users were
 deleted.

