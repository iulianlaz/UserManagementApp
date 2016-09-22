#!/bin/bash
# This script will add an admin user in mongo database (people database, users collection)
# If an admin user already exists, it will not be touched
# If you run this with forcedel argument, then existent admin username will be deleted
# You can run this script as follows:
#   sh populatedb.sh <forcedel>

cd backend/Datasource/
php initDatabase.php $1