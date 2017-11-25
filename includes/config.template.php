<?php
// Require users to authenticate to access files
define("CONFIG_REQUIRE_AUTHENTICATION", true);
// Open the account registration page to everyone instead of using one-time
// keys
define("CONFIG_OPEN_REGISTRATION", false);
define("CONFIG_ALLOW_INVITES", false);
define("CONFIG_INVITE_COOLDOWN", "7 days");

// MySQL server config options
define("CONFIG_DB_SERVER", "localhost");
define("CONFIG_DB_USERNAME", "MYSQL_USER");
define("CONFIG_DB_PASSWORD", "MYSQL_PASSWORD");
define("CONFIG_DB_DATABASE", "MYSQL_DB");

define("CONFIG_COMMON_PATH", "/var/http/hub/common/");
define("CONFIG_COMMON_WEBPATH", "/hub/common/");

// Where you want to drop users when they want to go to your
// main site
define("CONFIG_WEBHOMEPAGE", "/hub/");
// Default Theme
define("CONFIG_DEFAULT_THEME", "20XX");

// pieces of bigmike
// if you do not implement a component, simply set its value to false
// BUT DO NOT comment out the definition, this causes unexpected
// behavior
define("CONFIG_HOOYA_PATH", "/var/http/hub/hooYa/");
define("CONFIG_HOOYA_WEBPATH", "/hub/hooYa/");

define("CONFIG_BMFFD_PATH", "/var/http/hub/bmffd/");
define("CONFIG_BMFFD_WEBPATH", "/hub/bmffd/");
?>
