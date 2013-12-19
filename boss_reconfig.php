<?php
/**
 * USER INSTRUCTION:
 *
 * 1. upload install.php to your opencart folder (/public_html)
 * 2. configure install.php at CONFIGURE HERE section
 * 3. run install.php from your web browser: http://www.yourdomain.com/install.php
 * 4. delete install.php.
 */

################################################################################
### CONFIGURE HERE
################################################################################

$dbdriver = "mysql";	# Database driver
$dbhost = "database host";	# Database host name
$dbname = "database name"; # Database name
$dbuser = "database user"; # Database username
$dbpass = "database password"; # Database password
$prefix = ""; # Database prefix tables






################################################################################
### DO NOT EDIT BELOW
################################################################################

$file = fopen("config.php","w") or exit("NOT FOUND FILE!");
$content2 = "<?php
// HTTP
define('HTTP_SERVER', 'http://" . $_SERVER['HTTP_HOST'] .rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . "/');
define('HTTP_IMAGE', 'http://" . $_SERVER['HTTP_HOST'] .rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') ."/image/');
define('HTTP_ADMIN', 'http://" . $_SERVER['HTTP_HOST'] .rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') ."/admin/');

// HTTPS
define('HTTPS_SERVER', 'http://" . $_SERVER['HTTP_HOST'] .rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . "/');
define('HTTPS_IMAGE', 'http://" . $_SERVER['HTTP_HOST'] .rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') ."/image/');

// DIR
define('DIR_APPLICATION', '".realpath(dirname(__FILE__)) ."/catalog/');
define('DIR_SYSTEM', '".realpath(dirname(__FILE__)) ."/system/');
define('DIR_DATABASE', '".realpath(dirname(__FILE__)) ."/system/database/');
define('DIR_LANGUAGE', '".realpath(dirname(__FILE__)) ."/catalog/language/');
define('DIR_TEMPLATE', '".realpath(dirname(__FILE__)) ."/catalog/view/theme/');
define('DIR_CONFIG', '".realpath(dirname(__FILE__)) ."/system/config/');
define('DIR_IMAGE', '".realpath(dirname(__FILE__)) ."/image/');
define('DIR_CACHE', '".realpath(dirname(__FILE__)) ."/system/cache/');
define('DIR_DOWNLOAD', '".realpath(dirname(__FILE__)) ."/download/');
define('DIR_LOGS', '".realpath(dirname(__FILE__)) ."/system/logs/');

// DB
define('DB_DRIVER', '".$dbdriver."');
define('DB_HOSTNAME', '".$dbhost."');
define('DB_USERNAME', '".$dbuser."');
define('DB_PASSWORD', '".$dbpass."');
define('DB_DATABASE', '".$dbname."');
define('DB_PREFIX', '".$prefix."');
?>";
$success1 = fwrite($file, $content2);
fclose($file);


########## ADMIN ###########
$file = fopen("admin/config.php","w") or exit("NOT FOUND FILE!");
$content3 = "<?php
// HTTP
define('HTTP_SERVER', 'http://" . $_SERVER['HTTP_HOST'] .rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . "/admin/');
define('HTTP_CATALOG', 'http://" . $_SERVER['HTTP_HOST'] .rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') ."/');
define('HTTP_IMAGE', 'http://" . $_SERVER['HTTP_HOST'] .rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') ."/image/');

// HTTPS
define('HTTPS_SERVER', 'http://" . $_SERVER['HTTP_HOST'] .rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . "/admin/');
define('HTTPS_CATALOG', 'http://" . $_SERVER['HTTP_HOST'] .rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') ."/');
define('HTTPS_IMAGE', 'http://" . $_SERVER['HTTP_HOST'] .rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') ."/image/');

// DIR
define('DIR_APPLICATION', '".realpath(dirname(__FILE__)) ."/admin/');
define('DIR_SYSTEM', '".realpath(dirname(__FILE__)) ."/system/');
define('DIR_DATABASE', '".realpath(dirname(__FILE__)) ."/system/database/');
define('DIR_LANGUAGE', '".realpath(dirname(__FILE__)) ."/admin/language/');
define('DIR_TEMPLATE', '".realpath(dirname(__FILE__)) ."/admin/view/template/');
define('DIR_CONFIG', '".realpath(dirname(__FILE__)) ."/system/config/');
define('DIR_IMAGE', '".realpath(dirname(__FILE__)) ."/image/');
define('DIR_CACHE', '".realpath(dirname(__FILE__)) ."/system/cache/');
define('DIR_DOWNLOAD', '".realpath(dirname(__FILE__)) ."/download/');
define('DIR_LOGS', '".realpath(dirname(__FILE__)) ."/system/logs/');
define('DIR_CATALOG', '".realpath(dirname(__FILE__)) ."/catalog/');

// DB
define('DB_DRIVER', '".$dbdriver."');
define('DB_HOSTNAME', '".$dbhost."');
define('DB_USERNAME', '".$dbuser."');
define('DB_PASSWORD', '".$dbpass."');
define('DB_DATABASE', '".$dbname."');
define('DB_PREFIX', '".$prefix."');
?>";
$success2 = fwrite($file, $content3);
fclose($file);


if($success1 && $success2)
{
 echo "<p style='color: brown; text-align: center; margin: 200px auto; font-size: 120%;'>Install Successfully! </br> Please Delete Install.php File!</p>";
}else{
 echo "<p style='color: brown; text-align: center; margin: 200px auto; font-size: 120%;'>Install Failed! </br> Please configure Install.php File!</p>";
}
?>