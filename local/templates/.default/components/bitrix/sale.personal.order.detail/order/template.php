<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\Page\Asset;

if($arParams['GUEST_MODE'] !== 'Y') {
	Asset::getInstance()->addJs("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/script.js");
}

CJSCore::Init(array('clipboard', 'fx'));

if(!empty($arResult['ERRORS']['FATAL'])) {
	foreach ($arResult['ERRORS']['FATAL'] as $error) {
		ShowError($error);
	}
	$component = $this->__component;
	if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED])) {
		$APPLICATION->AuthForm('', false, false, 'N', false);
	}
} else {
	if(!empty($arResult['ERRORS']['NONFATAL'])) {
		foreach ($arResult['ERRORS']['NONFATAL'] as $error) {
			ShowError($error);
		}
	}
	?>


	<?php //deb($arResult); ?>


	<h2>
		<?= Loc::getMessage('SPOD_LIST_MY_ORDER', array(
			'#ACCOUNT_NUMBER#' => htmlspecialcharsbx(($arResult['ACCOUNT_NUMBER'])),
			'#DATE_ORDER_CREATE#' => ($arResult["DATE_INSERT_FORMATED"]),
		)) ?>
	</h2>
	
	<?php if($arResult["PROPS"]["1C_ACCOUNT"]): ?>
		<p><b>Учетный №: <?php echo $arResult["PROPS"]["1C_ACCOUNT"]; ?></b></p>
	<?php endif; ?>

	<?php if ($arParams['GUEST_MODE'] !== 'Y'): ?>
		<a href="<?= htmlspecialcharsbx($arResult["URL_TO_LIST"]) ?>">
			&larr; <?= Loc::getMessage('SPOD_RETURN_LIST_ORDERS') ?>
		</a>
	<?php endif; ?>
	
	<table class="order-detail">
		<tr>
			<th colspan="3" class="separator">Информация о заказе</th>
		</tr>
		<tr>
			<td>
				<?php if($arParams["USER_TYPE"] == "SIMPLE"): ?>
					<?php if($arResult["PAYED"] == "Y"): ?>
						Оплачен
					<?php else: ?>
						<?php if($arResult["PROPS"]["CANCELLED"] != "Y" && $arResult["STATUS_ID"] != "DZ"): ?>
							<a href="/personal/orders/payment.php?ORDER_ID=<?php echo $arResult["ID"]; ?>" target="_blank" class="btn btn--red">Оплатить</a>
						<?php endif; ?>
					<?php endif; ?>
				<?php else: ?>
					Грузополучатель
					<br />
					<b><?php echo $arResult["PROPS"]["COMPANY"]["UF_NAME"]; ?></b>
				<?php endif; ?>
				
				
			</td>
			
			<td>
				<?php echo Loc::getMessage('SPOD_LIST_CURRENT_STATUS', array(
						'#DATE_ORDER_CREATE#' => $arResult["DATE_INSERT_FORMATED"]
					));
				?>
				<br />
				<b>
					<?php if($arResult['CANCELED'] !== 'Y' && $arResult["PROPS"]["CANCELLED"] != "Y"): ?>
						<?php echo htmlspecialcharsbx($arResult["STATUS"]["NAME"]); ?>
					<?php else: ?>
						<?php echo Loc::getMessage('SPOD_ORDER_CANCELED'); ?>
					<?php endif; ?>
				</b>
				
				<?php if($arResult["PROPS"]["DELIVERY_LINK"]): ?>
					<br /><a href="<?php echo $arResult["PROPS"]["DELIVERY_LINK"]; ?>" target="_blank">Посмотреть статус доставки</a>
				<?php endif; ?>
			</td>
			
			<td class="right">
				<?php if ($arParams['GUEST_MODE'] !== 'Y'): ?>
					<a href="<?=$arResult["URL_TO_COPY"]?>" class="btn btn--blue">
						<?= Loc::getMessage('SPOD_ORDER_REPEAT') ?>
					</a>
					<br /><br />

					<?php if($arParams["USER_TYPE"] == "SIMPLE" && !$arResult["PROPS"]["CANCELLED"] && $arResult["STATUS_ID"] != "DZ"): ?>
						<a href="#cancel-popup" class="popup" data-type="inline">
							<?= Loc::getMessage('SPOD_ORDER_CANCEL') ?>
						</a>
					<?php endif; ?>
					</div>
				<?php endif; ?>
			</td>
			
		</tr>
		
		<?php if($arResult["UPD"]): ?>
			<tr>
				<td colspan="3">
					<div class="page-inner page-inner--w2">
						<div class="page-text">
							<?php foreach($arResult["UPD"] as $arUPDItem): ?>
								<p>
									<a href="/personal/orders/<?php echo $arResult["ID"]; ?>/upd/<?php echo $arUPDItem["ID"]; ?>/" class="link link--black">УПД <?php echo $arUPDItem["UF_NOMERUPD"]; ?> от <?php echo $arUPDItem["UF_DATA"]->toString(new \Bitrix\Main\Context\Culture(array("FORMAT_DATETIME" => "DD.MM.YYYY"))); ?> на <?php echo $arUPDItem["UF_SUMMADOKUMENTA"]; ?> руб.</a>
									
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									
									<?php if($arUPDItem["ACT"]): ?>
	
										<a href="/personal/orders/<?php echo $arResult["ID"]; ?>/doc/<?php echo $arUPDItem["ID"]; ?>/" class="link link--black">Акт <?php echo $arUPDItem["ACT"]["UF_NOMER"]; ?> от <?php echo $arUPDItem["ACT"]["UF_DATASOZDANIYA"]->toString(new \Bitrix\Main\Context\Culture(array("FORMAT_DATETIME" => "DD.MM.YYYY"))); ?> (<?php echo $arUPDItem["ACT"]["UF_STATUS"]; ?>)</a>
										
									<?php else: ?>
									
										<a href="/personal/orders/<?php echo $arResult["ID"]; ?>/doc/<?php echo $arUPDItem["ID"]; ?>/" class="link link--black"><span>Создать акт приемки</span></a>
									
									<?php endif; ?>
									
								</p>
							<?php endforeach; ?>
						</div>
					</div>
				</td>
			</tr>
		<?php endif; ?>
		
		
		<?php if($arResult["STATUS_ID"] == "F" && 0): ?>
		<tr>
			<td colspan="3">
				<div class="page-inner page-inner--w2">
					<div class="page-text">
						<p>
							<a href="/personal/orders/<?php echo $arResult["ID"]; ?>/refund/" class="link link--black">Заявка на возврат</a>
						</p>
					</div>
				</div>
			</td>
		</tr>
		<?php endif; ?>
	
		
		<tr>
			<th class="separator" colspan="2">Содержимое заказа</th>
			<th class="separator" style="text-align: center;">

			</th>
		</tr>
		
		<tr>
			<td colspan="3">
				
				<table>
					<tr>
						<th class="simple">Наименование</th>
						<th class="simple">Цена</th>
						<th class="simple">Кол-во</th>
						<th class="simple">Сумма</th>



						<?php if($arResult["NDS_INFO"]["BASKET_COL_VAT_RATE"]["DISPLAY"] == "Y"): ?>
							<th class="simple"><?php echo $arResult["NDS_INFO"]["BASKET_COL_VAT_RATE"]["TITLE"]; ?></th>
						<?php endif; ?>
						
						<?php if($arResult["NDS_INFO"]["BASKET_COL_VAT_VALUE"]["DISPLAY"] == "Y"): ?>
							<th class="simple"><?php echo $arResult["NDS_INFO"]["BASKET_COL_VAT_VALUE"]["TITLE"]; ?></th>
						<?php endif; ?>
						
						<?php if($arResult["NDS_INFO"]["BASKET_COL_SUMMARY_VALUE"]["DISPLAY"] == "Y"): ?>
							<th class="simple"><?php echo $arResult["NDS_INFO"]["BASKET_COL_SUMMARY_VALUE"]["TITLE"]; ?></th>
						<?php endif; ?>



						<th class="simple">Статус резерва</th>
					</tr>
					
					<?php foreach($arResult["BASKET"] as $arBasketItem): 
						
						//deb($arBasketItem, false);
					?>
						<tr>
							<td>
								<a href="<?=$arBasketItem['DETAIL_PAGE_URL']?>" class="order-detail-link">
									<?php if($arBasketItem['PICTURE']): ?>
										<img src="<?php echo $arBasketItem['PICTURE']["SRC"]; ?>" />
									<?php endif; ?>
									<span class="order-detail-link-name"><?=htmlspecialcharsbx($arBasketItem['NAME'])?></span>
								</a>
							</td>
							<td>
								<?php if($arBasketItem["CUSTOM_PRICE"] && (int)$arBasketItem["PRICE"] == 0): ?>
									<!--<span class="old-price"><?=$arBasketItem['BASE_PRICE_FORMATED']?></span>-->
									<!--<span class="action-price"><?=$arBasketItem['PRICE_FORMATED']?></span>-->
									<?=$arBasketItem['FORMATED_SUM']?>
								<?php else: ?>
									<?=$arBasketItem['PRICE_FORMATED']?>
								<?php endif; ?>
							</td>
							<td>
								<?=$arBasketItem['QUANTITY']?>
							</td>
							<td>
								<?php if($arBasketItem["CUSTOM_PRICE"] && (int)$arBasketItem["PRICE"] == 0): ?>
									<!--<span class="old-price"><?=CurrencyFormat($arBasketItem['BASE_PRICE'] * $arBasketItem["QUANTITY"], "RUB")?></span>-->
									<!--<span class="action-price"><?=$arBasketItem['FORMATED_SUM']?></span>-->
									<?=$arBasketItem['FORMATED_SUM']?>
								<?php else: ?>
									<?=$arBasketItem['FORMATED_SUM']?>
								<?php endif; ?>
							</td>
							
							
							
							<?php if($arResult["NDS_INFO"]["BASKET_COL_VAT_RATE"]["DISPLAY"] == "Y"): ?>
								<td>
								
									<?=(int)($arBasketItem['VAT_RATE']*100)?>%
								</td>
							<?php endif; ?>
							
							<?php if($arResult["NDS_INFO"]["BASKET_COL_VAT_VALUE"]["DISPLAY"] == "Y"): //deb($arItem, false); ?>
								<td>
								<?php if($arResult["NDS_INFO"]["TYPE"] == "OVER"): ?>
									<span id="custom_tax_<?=$arBasketItem["ID"]?>"><?=$arBasketItem["NDS_FORMATED"];?></span>
								<?php else: ?>
									<span id="tax_<?=$arBasketItem["ID"]?>"><?=$arBasketItem["NDS_FORMATED"];?></span>
								<?php endif; ?>
								</td>
							<?php endif; ?>
							
							
							<?php if($arResult["NDS_INFO"]["BASKET_COL_SUMMARY_VALUE"]["DISPLAY"] == "Y"): ?>
								<td class="basket-item-tax-holder" id="sum_with_tax_<?=$arBasketItem["ID"]?>">
									<?=$arBasketItem['SUM_FULL_PRICE_FORMATED']?>
								</td>
							<?php endif; ?>
							
					
							
							
							
							
							<td>
								<?php foreach($arBasketItem["PROPS"] as $arBasketItemProp):
									if($arBasketItemProp["NAME"] != "СтатусРезерва") {
										continue;
									}
								?>
									<?php echo $arBasketItemProp["VALUE"]; ?>
								<?php endforeach; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</table>
				
			</td>
		</tr>
		
		<?php if($arResult["USER_DESCRIPTION"]): ?>
			<tr>
				<th class="separator" colspan="3">Комментарий к заказу</th>
			</tr>
			<tr>
				<td colspan="3">
					<table>
						<tr>
							<td>
								<?php echo $arResult["USER_DESCRIPTION"]; ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		<?php endif; ?>
		
		<tr>
			<td colspan="3">
				<div class="order-detail-summary">
					<div class="order-detail-summary-item">Товарных позиций: <?php echo count($arResult["BASKET"]); ?></div>
					<div class="order-detail-summary-item">На сумму: <?php echo $arResult["PRODUCT_SUM_FORMATED"]; ?></div>
					<?php if($arResult["NDS_INFO"]["TYPE"] != "NO"): ?>
						<div class="order-detail-summary-item">Сумма НДС: <?php echo $arResult["TAX_VALUE_FORMATED"]; ?></div>
					<?php endif; ?>
					<div class="order-detail-summary-item">Итого: <?php echo $arResult["PRICE_FORMATED"]; ?></div>
				</div>
			</td>
		</tr>
		
	</table>
	
	<?php //deb($arResult); ?>
	
	<?php if ($arParams['GUEST_MODE'] !== 'Y'): ?>
		<a href="<?= htmlspecialcharsbx($arResult["URL_TO_LIST"]) ?>">
			&larr; <?= Loc::getMessage('SPOD_RETURN_LIST_ORDERS') ?>
		</a>
	<?php endif; ?>
	

	<?php
		$javascriptParams = array(
			"url" => CUtil::JSEscape($this->__component->GetPath().'/ajax.php'),
			"templateFolder" => CUtil::JSEscape($templateFolder),
			"templateName" => $this->__component->GetTemplateName(),
			"paymentList" => $paymentData
		);
		$javascriptParams = CUtil::PhpToJSObject($javascriptParams);
	?>
	<script>
		BX.Sale.PersonalOrderComponent.PersonalOrderDetail.init(<?=$javascriptParams?>);
		
		if(location.hash && location.hash == "#payed") {
			console.log("payed aim");
			ym(48640211,'reachGoal','order_payed', {
				"order_id": "<?php echo $arResult['ACCOUNT_NUMBER']; ?>"
			});
		}
		
	</script>
<? } ?>



<div id="cancel-popup" class="page-popup mfp-hide">
    <div class="page-popup-title">Отмена заказа</div>
	<div class="page-popup-content">
						
		<form class="form form--large order-cancel-form" action="/personal/orders/cancel.php">
			<input name="order_id" type="hidden" value="<?php echo $arResult["ID"]; ?>" />
			<div class="form-row">
				<label for="cancel_reason" class="form-label form-label--block">
					<span class="form-label-inner">Причина отмены:</span><span class="form-required">*</span>
				</label>
				<div class="form-item-holder form-item-holder--block">
					<textarea id="cancel_reason" data-error="Поле обязательно для заполнения" name="cancel_reason" class="form-item form-item--text" required></textarea>
				</div>
			</div>
			
			<div class="form-row form-row--btn">
				<button type="submit" name="cancel" value="Y" class="btn btn--fullwidth btn--red">Отправить заказ на отмену</button>
			</div>
		</form>
			
	</div>
</div>



