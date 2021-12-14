<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\Page\Asset;

Loc::loadMessages(__FILE__);

if(!empty($arResult['ERRORS']['FATAL'])) {
	foreach($arResult['ERRORS']['FATAL'] as $error) {
		ShowError($error);
	}
	$component = $this->__component;
	if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED])) {
		$APPLICATION->AuthForm('', false, false, 'N', false);
	}
} else {
	if(!empty($arResult['ERRORS']['NONFATAL'])) {
		foreach($arResult['ERRORS']['NONFATAL'] as $error) {
			ShowError($error);
		}
	}
}
?>

<?php if($arResult["ORDERS"]): ?>

	<?php foreach($arResult["ORDERS"] as $arOrder):  ?>
				
		<table class="order-item">
			
			<tr class="order-item-row">
				
				<td class="order-item-col">
					<b>
						<?php echo Loc::getMessage('SPOL_TPL_ORDER'); ?>
						<?php echo Loc::getMessage('SPOL_TPL_NUMBER_SIGN').($arOrder['ORDER']['ACCOUNT_NUMBER']); ?>
						<?php echo Loc::getMessage('SPOL_TPL_FROM_DATE')?>
						<?php echo ($arOrder['ORDER']['DATE_INSERT']->format($arParams['ACTIVE_DATE_FORMAT'])); ?>
					</b>
				</td>
				<td class="order-item-col">
					<?php echo $arOrder["PROPS"]["COMPANY"]["UF_NAME"]; ?>
				</td>
				<td class="order-item-col">
						<?php echo count($arOrder['BASKET_ITEMS']); ?>
						<?
							$count = count($arOrder['BASKET_ITEMS']) % 10;
							if($count == '1') {
								echo Loc::getMessage('SPOL_TPL_GOOD');
							} elseif ($count >= '2' && $count <= '4') {
								echo Loc::getMessage('SPOL_TPL_TWO_GOODS');
							} else {
								echo Loc::getMessage('SPOL_TPL_GOODS');
							}
						?>
						<?php echo Loc::getMessage('SPOL_TPL_SUMOF'); ?>
						<?php echo $arOrder['ORDER']['FORMATED_PRICE']; ?>
				</td>
				
			</tr>
			
			<tr class="order-item-row">
				<td class="order-item-col">
					<?php if($arOrder["PROPS"]["1C_ACCOUNT"]): ?>
						<b>
							Учетный №: <?php echo $arOrder["PROPS"]["1C_ACCOUNT"]; ?>
						</b>
					<?php endif; ?>
					
					<?php if($arParams["USER_TYPE"] == "SIMPLE"): ?>
						<?php if($arOrder["ORDER"]["PAYED"] == "Y"): ?>
							Оплачен
						<?php else: ?>
							<?php if($arOrder["PROPS"]["CANCELLED"] != "Y" && $arOrder["ORDER"]["STATUS_ID"] != "DZ"): ?>
								<a href="/personal/orders/payment.php?ORDER_ID=<?php echo $arOrder["ORDER"]["ID"]; ?>" target="_blank" class="btn btn--red">Оплатить</a>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
				</td>
				<td class="order-item-col">
					<i>
						<?php if($arOrder["ORDER"]["CANCELED"] == "Y" || $arOrder["PROPS"]["CANCELLED"] == "Y"): ?>
							Заказ отменен
						<?php else: ?>
							<?php echo $arResult["INFO"]["STATUS"][$arOrder["ORDER"]["STATUS_ID"]]["NAME"]; ?>
						<?php endif; ?>
					</i>
				</td>
				
				
				<td class="order-item-col">
					<a class="sale-order-list-about-link" href="<?php echo htmlspecialcharsbx($arOrder["ORDER"]["URL_TO_DETAIL"]); ?>"><?php echo Loc::getMessage('SPOL_TPL_MORE_ON_ORDER'); ?></a>
				</td>
			</tr>
			
			<?php if($arOrder["ORDER"]["USER_DESCRIPTION"]): ?>
				<tr class="order-item-row">
					<td class="order-item-col" colspan="3">
						<b>Комментарий:</b> <?php echo $arOrder["ORDER"]["USER_DESCRIPTION"]; ?>
					</td>
				</tr>
			<?php endif; ?>
			
		</table>
		
	<?php endforeach; ?>
	<?php
		echo $arResult["NAV_STRING"];
	?>
	
<?php else: ?>
	
	<div class="form-success">У вас нет активных заказов</div>
	
<?php endif; ?>
	