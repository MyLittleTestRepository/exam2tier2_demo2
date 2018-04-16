<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if($arParams['LINK_IBLOCK_ID'])
{
	$arFilter=['IBLOCK_ID'=>$arParams['LINK_IBLOCK_ID'],
			   'ACTIVE'=>'Y',
			   'PROPERTY_NEWS_LINK'=>$arParams['ELEMENT_ID']
			   ];
	$arSelectedFields=['NAME'];
	$Res=CIBlockElement::GetList('',$arFilter,false,false,$arSelectFields);
	if($Res->SelectedRowsCount())
	{
		$arResult['CANONICAL_URL']=$Res->Fetch()['NAME'];
		$this->__component->SetResultCacheKeys(['CANONICAL_URL']);
	}
}