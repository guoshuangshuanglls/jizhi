<?php
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
define('APP_DEBUG',True);
define('APP_ABS_NAME' , '/Application');
define('APP_PATH','.'.APP_ABS_NAME.'/');
define('DS',DIRECTORY_SEPARATOR);
# 网站域名
define('WEB_ROOT',__DIR__);
define('WEB_NAME','http://www.gs9372.com/');
require WEB_ROOT.'/ThinkPHP/ThinkPHP.php';

