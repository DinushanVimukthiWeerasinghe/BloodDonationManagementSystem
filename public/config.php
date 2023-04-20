<?php
const DEVELOPMENT = 'DEV';
define("MODE", $_ENV['MODE']);
if (MODE == DEVELOPMENT) {
    define("HOST", $_ENV['DEV_HOST']);
    define("DB_DSN", $_ENV['DB_DEV_DSN']);
}else if (MODE == 'TEST') {
    define("HOST", $_ENV['TEST_HOST']);
    define("DB_DSN", $_ENV['DB_TEST_DSN']);
}
else {
    define("HOST", $_ENV['PROD_HOST']);
    define("DB_DSN", $_ENV['DB_PROD_DSN']);
}

//Define Encryption Key and Algorithm
define("ENCRYPTION_KEY", $_ENV['ENCRYPTION_KEY']);
define("ENCRYPTION_METHOD", $_ENV['ENCRYPTION_METHOD']);
define("ENCRYPTION_IV", $_ENV['ENCRYPTION_IV']);

