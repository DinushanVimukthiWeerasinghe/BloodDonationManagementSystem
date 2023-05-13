<?php
const DEVELOPMENT = 'DEV';
define("MODE", $_ENV['MODE']);
if (MODE == DEVELOPMENT) {
    define("HOST", $_ENV['DEV_HOST']);
    define("DB_USER", $_ENV['DB_DEV_USER']);
    define("DB_DSN", $_ENV['DB_DEV_DSN']);
    define("DB_PASSWORD", $_ENV['DB_DEV_PASSWORD']);
    define("DB_HOST", $_ENV['DB_DEV_HOST']);
    define("DEV_EMAIL", $_ENV['DEV_EMAIL']);
}else if (MODE == 'TEST') {
    define("DB_USER", $_ENV['DB_TEST_USER']);
    define("DB_PASSWORD", $_ENV['DB_TEST_PASSWORD']);
    define("DB_HOST", $_ENV['DB_TEST_HOST']);
    define("DB_NAME", $_ENV['DB_TEST_NAME']);
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

// Hashing Algorithm
define("HASH_ALGORITHM", $_ENV['HASH_ALGORITHM']);

