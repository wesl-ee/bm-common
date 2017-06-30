<?php
// Require users to authenticate to access files
define("CONFIG_REQUIRE_AUTHENTICATION", false);
// Open the account registration page to everyone instead of using one-time
// keys
define("CONFIG_OPEN_REGISTRATION", false);

// MySQL server config options (more to come)
define("CONFIG_DB_SERVER", "DB_SERVER");
define("CONFIG_DB_USERNAME", "DB_USER");
define("CONFIG_DB_PASSWORD", "DB_PASSWORD");
define("CONFIG_DB_DATABASE", "DB_DATABASE");
define("CONFIG_DB_TABLE", "DB_TABLE");

define("CONFIG_COMMON_PATH", "/var/http/common/");
define("CONFIG_COMMON_WEBPATH", "/common/");

define("CONFIG_WEBHOMEPAGE", "/hooYa/");

// Logs
define("CONFIG_AUTHLOG_FILE", "/path/to/auth.log");
define("CONFIG_ACCESSLOG_FILE", "/path/to/access.log");
?>