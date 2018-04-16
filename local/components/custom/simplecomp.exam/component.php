<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if(!$USER->IsAuthorized())
	return;

//clear params
foreach($arParams as $key=>$val)
{
	$val=trim($val);
	if(is_numeric($val))
		$val=intval($val);
	$arParams[$key]=$val;
}

//check params
if(!$arParams['NEWS_IBLOCK_ID'] or !$arParams['NEWS_LINK_CODE'] or !$arParams['UF_AUTHOR_CODE'])
	return;

$myID=$USER->GetID();
if($this->StartResultCache(false,$myID))
{
	
	//get user author type
	$arFilter=['ID'=>$myID,
			   $arParams['UF_AUTHOR_CODE']];
	$arSelect=[];
	$arSelect['SELECT'][]=$arParams['UF_AUTHOR_CODE'];
	$arSelect['FIELDS']=['ID','LOGIN'];
	
	$Res=CUser::GetList($by, $order, $arFilter, $arSelect);
	
	if(!$Res->SelectedRowsCount())
	{
		$this->AbortResultCache();
		return;
	}
	
	$myType=$Res->Fetch()[$arParams['UF_AUTHOR_CODE']];

	
	//get other users my type
	$arFilter=['ACTIVE'=>'Y',
			   $arParams['UF_AUTHOR_CODE']=>$myType];
	unset($arSelect['SELECT']);
	
	$Res=CUser::GetList($by, $order, $arFilter, $arSelect);
	
	if(!$Res->SelectedRowsCount())
	{
		$this->AbortResultCache();
		return;
	}
	
	$arUsers=&$arResult['USERS'];
	while($user=$Res->Fetch())
		$arUsers[$user['ID']]=$user;

	
	//get news for users my type
	$linkPoperty='PROPERTY_'.$arParams['NEWS_LINK_CODE'];
	$arFilter=['ACTIVE'=>'Y',
			   "IBLOCK_ID" => $arParams['NEWS_IBLOCK_ID'],
			   $linkPoperty => array_keys($arUsers)];
	$arSelect=['ID',
			   $linkPoperty,
			   'NAME',
			   'DATE_ACTIVE_FROM'];
	
	$Res=CIBlockElement::GetList('', $arFilter, false, false, $arSelect);
	
	if(!$Res->SelectedRowsCount())
	{
		$this->AbortResultCache();
		return;
	}

	$arNews=&$arResult['NEWS'];
	$linkValue=$linkPoperty.'_VALUE';
	$linkValueID=$linkValue.'_ID';
	$arMyNews=[];
	while($news=$Res->Fetch())
	{
		$newsID=$news['ID'];

		//find my news
		if($news[$linkValue]==$myID)
			$arMyNews[$newsID]=true;
			
		//clear my news
		if($arMyNews[$newsID])
		{
			unset($arNews[$newsID]);
			continue;
		}
		
		//link news to user
		$arUsers[$news[$linkValue]]['NEWS_ID'][$newsID]=$newsID;
		
		//write news
		unset($news[$linkPoperty]);
		unset($news[$linkValue]);
		unset($news[$linkValueID]);
		$arNews[$newsID]=$news;
	}
	
	//clear my
	unset($arUsers[$myID]);
	
	$count=count($arNews);
	if($count)
	{
		$arResult['COUNT']=$count;
		$this->setResultCacheKeys(['COUNT']);
	}
	
	$this->includeComponentTemplate();	
}

$this->AddIncludeAreaIcon(
    array(
        'URL'   => '/bitrix/admin/'.CIBlock::GetAdminElementListLink($arParams['NEWS_IBLOCK_ID']),
        'TITLE' => "ИБ в админке",
		'IN_PARAMS_MENU' => true,
		'IN_MENU' => false
	)
);

if($arResult['COUNT'])
	$APPLICATION->SetTitle(GetMessage("COUNT").$arResult['COUNT']);