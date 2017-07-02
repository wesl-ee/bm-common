<?php
// Require users to authenticate to access files
define("CONFIG_REQUIRE_AUTHENTICATION", false);
// Open the account registration page to everyone instead of using one-time
// keys
define("CONFIG_OPEN_REGISTRATION", false);
// Allow current users to invite their friends using the new one-time
// password system
define("CONFIG_ALLOW_INVITES", false);
// Site-wide cooldown period between requesting invite codes
define("CONFIG_INVITE_COOLDOWN", "7 days");

// MySQL server config options (more to come)
define("CONFIG_DB_SERVER", "DB_SERVER");
define("CONFIG_DB_USERNAME", "DB_USER");
define("CONFIG_DB_PASSWORD", "DB_PASSWORD");
define("CONFIG_DB_DATABASE", "DB_DATABASE");

define("CONFIG_COMMON_PATH", "/var/http/common/");
define("CONFIG_COMMON_WEBPATH", "/common/");

define("CONFIG_WEBHOMEPAGE", "/hooYa/");

// Logs
define("CONFIG_AUTHLOG_FILE", "/path/to/auth.log");
define("CONFIG_ACCESSLOG_FILE", "/path/to/access.log");
?>