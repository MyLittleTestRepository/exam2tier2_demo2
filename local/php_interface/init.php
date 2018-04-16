<?
//const
define('CONTENT_EDITORS_GROUP_ID',5);
//include
$path=$_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/EventHandler.php';
if(file_exists($path))
	include_once $path;
unset($path);