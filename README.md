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
 Now, you should be able to login from: localhost/UserManagementApp/

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

##### Rest endpoint
 The endpoint for all requests is located at backend/rest.php. When a request arrives, it is processed as follows:
 + An interceptor for the request is created. Here, the request is validated (only application/json content-type is
   accepted). After that, a Request object is created with available information. The Request object contains attributes
   such as: resource name, resource operation, query parameters and payload. For example, if a request /rest.php/user/find?page=1
   arrives, the resourceName=user, resourceOperation=find and queryParameters=\["page": 1\].
 + Based on resource name from Request object a particular handler will be initialized (e.g. user handler, auth handler)
 + Before a request is handled, it is checked if user is authenticated.

#### Frontend

##### Login Section
##### Edit Account Section
##### Add User Section
##### Edit User Section
##### Add User Section
##### Filter User Section
##### Sort User Section
##### Delete User Section

