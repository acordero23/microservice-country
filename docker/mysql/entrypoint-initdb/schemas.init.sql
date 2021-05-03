# create core databases
CREATE DATABASE IF NOT EXISTS `countries_information`;

# give all privileges to the work user
GRANT ALL PRIVILEGES ON *.* TO 'admin'@'%' WITH GRANT OPTION;