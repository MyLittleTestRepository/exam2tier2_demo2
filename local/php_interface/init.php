<?
//const
define('CONTENT_EDITORS_GROUP_ID',5);
//include
$arInclude=['EventHandler'];

foreach($arInclude as $filename)
{
	$path=dirname(__FILE__).'/include/'.$filename.'.php';
	if(file_exists($path))
		include_once $path;
}

function mydebug($str,$die=false,$fname='')
{
	$file=$_SERVER['DOCUMENT_ROOT'].'/debug_'.$fname.'.txt';
	file_put_contents($file, date('H:i:s').PHP_EOL.mydump($str));
	if($die) die();
}

