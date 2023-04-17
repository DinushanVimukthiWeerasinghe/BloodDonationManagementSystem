<?php
const DEVELOPMENT = 'DEV';
define("MODE", $_ENV['MODE']);
if (MODE == DEVELOPMENT) {
    define("HOST", $_ENV['DEV_HOST']);
} else {
    define("HOST", $_ENV['PROD_HOST']);
}

//Define Encryption Key and Algorithm
define("ENCRYPTION_KEY", $_ENV['ENCRYPTION_KEY']);
define("ENCRYPTION_METHOD", $_ENV['ENCRYPTION_METHOD']);
define("ENCRYPTION_IV", $_ENV['ENCRYPTION_IV']);

