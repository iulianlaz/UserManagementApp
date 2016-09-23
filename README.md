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

### Implementation

#### Backend

#### Frontend

##### Login Section
##### Edit Account Section
##### Add User Section
##### Edit User Section
##### Add User Section
##### Filter User Section
##### Sort User Section
##### Delete User Section

