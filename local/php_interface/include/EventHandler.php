<?
AddEventHandler("main", "OnBuildGlobalMenu", array("EventHandler", "onBuildGlobalMenu"));

class EventHandler
{
	function onBuildGlobalMenu(&$arGlobalMenu, &$arModuleMenu)
	{
		global $USER;
		
		if($USER->IsAdmin())
			return;
		
		if(!CSite::InGroup([CONTENT_EDITORS_GROUP_ID]))
			return;
		
		$content_global_menu_id='global_menu_content';
		$content_child_menu_id='menu_iblock_/news';
		foreach($arGlobalMenu as $key=>$val)
			if($key!=$content_global_menu_id)
				unset($arGlobalMenu[$key]);
		foreach($arModuleMenu as $key=>$val)
			if($arModuleMenu[$key]['parent_menu']!=$content_global_menu_id)
				unset($arModuleMenu[$key]);
		
		foreach($arModuleMenu as $key=>$val)
			if($arModuleMenu[$key]['items_id']!=$content_child_menu_id)
				unset($arModuleMenu[$key]);
	}
}