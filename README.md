## Simple User Management Web Application
---

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
   accepted). After that, a Request object is created with available information. The Request object contains attributes
   such as: resource name, resource operation, query parameters and payload. For example, if a request `/rest.php/user/find?page=1`
   arrives, the resourceName=user, resourceOperation=find and queryParameters=\["page": 1\].
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

##### Login Section
##### Edit Account Section
##### Add User Section
##### Edit User Section
##### Add User Section
##### Filter User Section
##### Sort User Section
##### Delete User Section

