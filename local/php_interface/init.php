<?
//include

function mydebug($str,$die=false,$fname='')
{
	$file=$_SERVER['DOCUMENT_ROOT'].'/debug_'.$fname.'.txt';
	file_put_contents($file, date('H:i:s').PHP_EOL.mydump($str));
	if($die) die();
}

