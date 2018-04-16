<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"NEWS_IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("NEWS_IBLOCK_ID"),
			"TYPE" => "STRING",
			"DEFAULT" => "1"
		),
		"NEWS_LINK_CODE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("NEWS_LINK_CODE"),
			"TYPE" => "STRING",
			"DEFAULT" => "AUTHOR_LINK"
		),
		"UF_AUTHOR_CODE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("UF_AUTHOR_CODE"),
			"TYPE" => "STRING",
			"DEFAULT" => "UF_AUTHOR_TYPE"
		),
		"CACHE_TIME" => array(
			"DEFAULT" => "3600000"
		),
	),
);