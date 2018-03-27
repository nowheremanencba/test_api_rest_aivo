# API REST 

*PHP built-in server

Download proyect from git. Run the following command in terminal to start localhost web server, assuming ./public/ is public-accessible directory with index.php file:

php -S localhost:8888 -t public public/index.php


*Using the Application with xampp

1. Create table user in db called api_rest_aivo
2. Download proyect from git and copy it in htdocs of xampp
3. URL example: http://localhost:8090/test_api_rest_aivo-master/apirestFacebook/public/index.php/profile/facebook/12



*Test with php unit
Run PHPUnit against TodoTest.php :
In the folder vendor/bin run phpunit with path TodoTest.php
./vendor/bin/phpunit ./test/TodoTest.php

You should see something related to this as output

PHPUnit 5.4.8 by Sebastian Bergmann and contributors.

.                                                      1 / 1 (100%)

Time: 45 ms, Memory: 3.25MB

OK (2 test, 2 assertion)
 
