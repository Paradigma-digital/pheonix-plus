<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<p>
	<a href="<?=$arResult["URL_TO_LIST"]?>"><?=GetMessage("SALE_RECORDS_LIST")?></a>
</p>

<div class="bx_my_order_cancel">
	<?if(strlen($arResult["ERROR_MESSAGE"])<=0):?>
		<form method="post" action="<?=POST_FORM_ACTION_URI?>">
			
			<input type="hidden" name="CANCEL" value="Y">
			<?=bitrix_sessid_post()?>
			<input type="hidden" name="ID" value="<?=$arResult["ID"]?>">
			
			<p>
				<?=GetMessage("SALE_CANCEL_ORDER1") ?>
				<a href="<?=$arResult["URL_TO_DETAIL"]?>"><?=GetMessage("SALE_CANCEL_ORDER2")?> #<?=$arResult["ACCOUNT_NUMBER"]?></a>?
				<b><?= GetMessage("SALE_CANCEL_ORDER3") ?></b>
			</p>
			
			<?= GetMessage("SALE_CANCEL_ORDER4") ?>:
			
			<textarea name="REASON_CANCELED" class="form-text form-item--textarea"></textarea>
			<br />
			
			<button type="submit" name="action" class="btn btn--blue" value="<?=GetMessage("SALE_CANCEL_ORDER_BTN") ?>"><?=GetMessage("SALE_CANCEL_ORDER_BTN") ?></button>

		</form>
	<?else:?>
		<?=ShowError($arResult["ERROR_MESSAGE"]);?>
	<?endif;?>

</div>