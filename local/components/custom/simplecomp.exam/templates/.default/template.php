<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<?if($arResult['COUNT']):?>
<ul>
	<?foreach($arResult['USERS'] as $userID=>$user):?>
	<li>
		[<?=$userID?>] - <?=$user['LOGIN']?>
		<ul>
			<?foreach($user['NEWS_ID'] as $newsID):?>
			<li>
				<?=$arResult['NEWS'][$newsID]['DATE_ACTIVE_FROM']?> - <?=$arResult['NEWS'][$newsID]['NAME']?>
			</li>
			<?endforeach?>
		</ul>
	</li>
	<?endforeach?>
</ul>
<?endif?>