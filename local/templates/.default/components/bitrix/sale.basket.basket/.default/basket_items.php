<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @var array $arUrls */
/** @var array $arHeaders */
use Bitrix\Sale\DiscountCouponsManager;

if (!empty($arResult["ERROR_MESSAGE"]))
	ShowError($arResult["ERROR_MESSAGE"]);

$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;
$bPriceType    = false;
//deb($arResult);
if ($normalCount > 0):
?>

<?php if($arParams["CHECK"] && $arParams["CHECK"]["ERRORS"]): ?>
	<div class="basket-errors">В корзине обнаружены ошибки</div>
<?php endif; ?>

<div id="basket_items_list">
		<table id="basket_items" class="basket">
		    
			<thead>
				<tr>
					<?
					foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):
						$arHeaders[] = $arHeader["id"];

						// remember which values should be shown not in the separate columns, but inside other columns
						if (in_array($arHeader["id"], array("TYPE")))
						{
							$bPriceType = true;
							continue;
						}
						elseif ($arHeader["id"] == "PROPS")
						{
							$bPropsColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "DELAY")
						{
							$bDelayColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "DELETE")
						{
							$bDeleteColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "WEIGHT")
						{
							$bWeightColumn = true;
						}

						if ($arHeader["id"] == "NAME"):
						?>
							<th class="item" id="col_<?=$arHeader["id"];?>">Товары в корзине</th>
						<?
						elseif ($arHeader["id"] == "PRICE"):
						?>
							<th class="price" id="col_<?=$arHeader["id"];?>">Цена за 1 шт.</th>
						<?
						elseif ($arHeader["id"] == "QUANTITY"):
						?>
							<th class="price" id="col_<?=$arHeader["id"];?>">Количество шт.</th>
						<?
						elseif ($arHeader["id"] == "SUM"):
						?>
							<th class="price" id="col_<?=$arHeader["id"];?>">Стоимость</th>
							
							<?php if($arParams["NDS_INFO"]["BASKET_COL_VAT_RATE"]["DISPLAY"] == "Y"): ?>
								<th class="tax"><?php echo $arParams["NDS_INFO"]["BASKET_COL_VAT_RATE"]["TITLE"]; ?></th>
							<?php endif; ?>
							
							<?php if($arParams["NDS_INFO"]["BASKET_COL_VAT_VALUE"]["DISPLAY"] == "Y"): ?>
								<th class="tax"><?php echo $arParams["NDS_INFO"]["BASKET_COL_VAT_VALUE"]["TITLE"]; ?></th>
							<?php endif; ?>
							
							<?php if($arParams["NDS_INFO"]["BASKET_COL_SUMMARY_VALUE"]["DISPLAY"] == "Y"): ?>
								<th class="tax"><?php echo $arParams["NDS_INFO"]["BASKET_COL_SUMMARY_VALUE"]["TITLE"]; ?></th>
							<?php endif; ?>
						<?
						else:
						?>
							<?php if(0): ?><th class="custom" id="col_<?=$arHeader["id"];?>"></th><?php endif; ?>
						<?
						endif;
						?>
							
					<?
					endforeach;

					if ($bDeleteColumn || $bDelayColumn):
					?>
						<th class="custom"></th>
					<?
					endif;
					?>
				</tr>
			</thead>

			<tbody>
				<?
				$skipHeaders = array('PROPS', 'DELAY', 'DELETE', 'TYPE');

				foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):

					if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):
						
						$arElement_r = CIBlockElement::GetList(array(), array('IBLOCK_ID' => iblock_id_catalog, 'ID' => $arItem['PRODUCT_ID'], 'ACTIVE' => 'Y'));
						
						if (!($arElement_r = $arElement_r->GetNextElement())) continue;
						
						$arElement = $arElement_r->GetFields();
						$arElement['PROPERTIES'] = $arElement_r->GetProperties();
					?>
					<?
						$url = '';
						if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0):
							$url = $arItem["PREVIEW_PICTURE_SRC"];
						elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
							$url = $arItem["DETAIL_PICTURE_SRC"];
						else:
							$url = $templateFolder."/images/no_photo.png";
						endif;
						
						$krat = 1;

						foreach ($arElement['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val)
						{
							if ($arElement['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == 'КратностьОтгрузки')
							{
								$krat = (int)$val;
								break;
							}
						}
						
						//deb($arItem, false);
					?>
					<tr id="<?=$arItem["ID"]?>"
						class="basket-item"
						data-price="<?=$arItem["PRICE"]?>" 
						data-id="<?=$arItem["ID"]?>" 
						data-img="<?=CFile::GetPath($arElement['PREVIEW_PICTURE'])?>"
					    
						 data-item-name="<?=$arItem["NAME"]?>"
						 data-item-brand="<?=$arItem[$arParams['BRAND_PROPERTY']."_VALUE"]?>"
						 data-item-price="<?=$arItem["PRICE"]?>"
						 data-item-currency="<?=$arItem["CURRENCY"]?>"
					>
						<td class="basket-item-name-holder">
							<div class="basket-item-name"><? if (!empty($arElement["PROPERTIES"]["CML2_ARTICLE"]["VALUE"])) { ?>арт. <?=$arElement["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?><br><? } ?><a href="<?=$arElement["DETAIL_PAGE_URL"] ?>" 
												       class="link link--black link--inverse animation-link"><?=$arItem["NAME"]?></a>
												       </div>
												       
							<?php if($arItem["ADD_GIFTS"]): ?>
								<span data-href="/gifts/add/?BASKET_ID=<?php echo $arItem["ID"]; ?>&PRODUCT_ID=<?php echo $arItem["PRODUCT_ID"]; ?>" class="basket-item-add-gifts">+ Выбрать подарки</span>
							<?php endif; ?>
						</td>
						<td class="basket-item-price-holder">
							<div class="basket-item-mobile-title">Цена за 1 шт.</div>
							<div class="basket-item-price"><span id="current_price_<?=$arItem["ID"]?>">

									<?=$arItem['PRICE_FORMATED']?>
						
							</span></div>
						</td>
							<?
							$ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
							$useFloatQuantity = ($arParams["QUANTITY_FLOAT"] == "Y") ? true : false;
							$useFloatQuantityJS = ($useFloatQuantity ? "true" : "false");
							$maxAvailable = ($arItem["AVAILABLE_QUANTITY"] -  ($arItem["AVAILABLE_QUANTITY"] % $krat));
							?>
						<td class="basket-item-quantity-holder <?php if($arParams["CHECK"] && isset($arParams["CHECK"]["ITEMS"][$arItem["PRODUCT_ID"]])): ?>error<?php endif; ?>">
							<div class="basket-item-mobile-title">Количество шт.</div>
							<input type="text"  
							       id="QUANTITY_INPUT_<?=$arItem['ID']?>"
							       name="QUANTITY_INPUT_<?=$arItem['ID']?>" 
							       value="<?=$arItem["QUANTITY"]?>" data-available="<?php echo $maxAvailable; ?>" data-pack="<?=$krat?>" 
							       onchange="PHOENIX.catalog.quantity.checkPack($(this)); updateQuantity('QUANTITY_INPUT_<?=$arItem["ID"]?>', '<?=$arItem["ID"]?>', <?=$ratio?>, <?=$useFloatQuantityJS?>, <?php echo $maxAvailable; ?>, <?php if($arResult["GIFTS"] && $arResult["GIFTS"][$arItem["ID"]]): ?>true<?php else: ?>false<?php endif; ?>)"
							       class="form-item form--number form-item--text product-quantity basket-item-quantity">
							
							<input type="hidden" id="QUANTITY_<?=$arItem['ID']?>" name="QUANTITY_<?=$arItem['ID']?>" value="<?=$arItem["QUANTITY"]?>" />
							
							<?php if($arParams["CHECK"] && isset($arParams["CHECK"]["ITEMS"][$arItem["PRODUCT_ID"]])): ?>
								<div class="basket-item-quantity-error">
									<?php if($arParams["CHECK"]["ITEMS"][$arItem["PRODUCT_ID"]]): ?>
										Доступно: <?php echo $arParams["CHECK"]["ITEMS"][$arItem["PRODUCT_ID"]]; ?> <?php echo $arItem["MEASURE_NAME"]; ?>
									<?php else: ?>
										Товар недоступен к покупке
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</td>
						<td class="basket-item-summary-holder">
							<div class="basket-item-mobile-title">Стоимость</div>
							<div class="basket-item-summary"><span id="sum_<?=$arItem["ID"]?>">

									<?=$arItem['SUM']?>
						
							</span></div>
						</td>
						
						
						<?php if($arParams["NDS_INFO"]["BASKET_COL_VAT_RATE"]["DISPLAY"] == "Y"): ?>
							<td class="basket-item-tax-holder">
								<?=(int)($arItem['VAT_RATE']*100)?>%
							</td>
						<?php endif; ?>
						
						<?php if($arParams["NDS_INFO"]["BASKET_COL_VAT_VALUE"]["DISPLAY"] == "Y"): //deb($arItem, false); ?>
							<td class="basket-item-tax-holder">
							<?php if($arParams["NDS_INFO"]["TYPE"] == "OVER"): ?>
								<span id="custom_tax_<?=$arItem["ID"]?>"><?=$arItem["NDS_FORMATED"];?></span>
							<?php else: ?>
								<span id="tax_<?=$arItem["ID"]?>"><?=$arItem["NDS_FORMATED"];?></span>
							<?php endif; ?>
							</td>
						<?php endif; ?>
						
						
						<?php if($arParams["NDS_INFO"]["BASKET_COL_SUMMARY_VALUE"]["DISPLAY"] == "Y"): ?>
							<td class="basket-item-tax-holder" id="sum_with_tax_<?=$arItem["ID"]?>">
								<?=$arItem['SUM_FULL_PRICE_FORMATED']?>
							</td>
						<?php endif; ?>
						
						
						
						<td class="basket-item-remove-holder"><a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>"
										onclick="return deleteProductRow(this)" title="Удалить" class="basket-item-remove <?php if($arResult["GIFTS"] && $arResult["GIFTS"][$arItem["ID"]]): ?>has-gifts<?php endif; ?>"></a></td>
					</tr>
					
					
					
					<?php if($arResult["GIFTS"] && $arResult["GIFTS"][$arItem["ID"]]): ?>
						<?php foreach($arResult["GIFTS"][$arItem["ID"]] as $arGiftItem): ?>
							<tr
								id="<?php echo $arGiftItem["ID"]; ?>" 
								class="gift basket-item" 
								data-price="<?=$arGiftItem["PRICE"]?>" 
								data-id="<?=$arGiftItem["ID"]?>" 
								data-img="<?=CFile::GetPath($arGiftItem['PREVIEW_PICTURE'])?>" 
								data-item-name="<?=$arGiftItem["NAME"]?>" 
								data-item-brand="<?=$arGiftItem[$arParams['BRAND_PROPERTY']."_VALUE"]?>" 
								data-item-price="<?=$arGiftItem["PRICE"]?>" 
								data-item-currency="<?=$arGiftItem["CURRENCY"]?>" 
							>
								<td class="basket-item-name-holder" colspan="2">
									<div class="basket-item-name">
										<?php if(!empty($arGiftItem["PROPERTIES"]["CML2_ARTICLE"]["VALUE"])) : ?>
											арт. <?php echo $arGiftItem["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]; ?><br />
										<?php endif; ?>
										<a href="<?php echo $arGiftItem["DETAIL_PAGE_URL"]; ?>" class="link link--black link--inverse animation-link"><?php echo $arGiftItem["NAME"]; ?></a>
									</div>					       
								</td>
								
								<td class="basket-item-quantity-holder">
									<div class="basket-item-quantity-gift"><?php echo $arGiftItem["QUANTITY"]; ?></div>
									<input
										type="hidden"  
										id="QUANTITY_<?php echo $arGiftItem["ID"]; ?>"
										name="QUANTITY_<?php echo $arGiftItem["ID"]; ?>" 
										value="<?php echo $arGiftItem["QUANTITY"]; ?>" 
									/>
									<input type="hidden"  
										id="QUANTITY_INPUT_<?=$arGiftItem['ID']?>"
										name="QUANTITY_INPUT_<?=$arGiftItem['ID']?>" 
										value="<?=$$arGiftItem["QUANTITY"]?>" data-available="<?php echo $arGiftItem["AVAILABLE_QUANTITY"]; ?>" data-pack="<?=$krat?>" 
										class="form-item form--number form-item--text product-quantity basket-item-quantity"
							       />
								</td>
								
								<td class="basket-item-summary-holder">
								</td>
								
								<td class="basket-item-tax-holder">
								</td>
								
								<td class="basket-item-tax-holder">
								</td>
								
								<td class="basket-item-remove-holder">
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
					
					
					
					<?
					endif;
				endforeach;
				?>
			</tbody>
			<tfoot>
				<tr>
					<td >&nbsp;</td>
					<td colspan="8">
					  <div class="basket-order">
					    <div class="basket-order-summary">
						    <div class="basket-order-summary-item basket-order-summary-item--novat">Товарных позиций: <span id="allSum_ItemsCount"><?=count($arResult["ITEMS"]["AnDelCanBuy"]); ?></span></div>
					      
					      
					      <div class="basket-order-summary-item basket-order-summary-item--novat">На сумму: 
						       <?php if($arParams["NDS_INFO"]["BASKET_COL_SUMMARY_VALUE"]["DISPLAY"] == "Y"): ?>
							   <span id="allSum_wVAT_FORMATED">
							   	<?=$arResult["allSum_wVAT_FORMATED"]; ?>
							   </span>
						      <?php else: ?>
						      <span id="allSum_FORMATED2">
						      	<?=$arResult["allSum_FORMATED"]; ?>
						      </span>
						      <?php endif; ?>
						   </div>
					      
					      
					      <!--<div class="basket-order-summary-item basket-order-summary-item--novat">Скидка: <span id="PRICE_WITHOUT_DISCOUNT"><?=$arResult["DISCOUNT_PRICE_ALL_FORMATED"]; ?></span></div>-->
					      
					      
					      
					      
					      <?php if($arParams["NDS_INFO"]["SUMMARY_VAT_TITLE"]): ?>
					     	 <div class="basket-order-summary-item"><?php echo $arParams["NDS_INFO"]["SUMMARY_VAT_TITLE"]; ?>: <span id="allVATSum_FORMATED"><?=$arResult["allVATSum_FORMATED"]?></span></div>
					      <?php endif; ?>
					      
					      <div class="basket-order-summary-item basket-order-summary-item--large">

						Итого: <span id="allSum_FORMATED"><?=str_replace(" ", "&nbsp;", $arResult["allSum_FORMATED"])?></span>
					      </div>
					    </div><button type="submit" onclick="checkOut();" class="basket-order-submit btn btn--red btn--large animation-link">Оформить заказ</button>
					  </div>
					</td>
				</tr>
			</tfoot>
		</table>
    
    
	<input type="hidden" id="column_headers" value="<?=htmlspecialcharsbx(implode($arHeaders, ","))?>" />
	<input type="hidden" id="offers_props" value="<?=htmlspecialcharsbx(implode($arParams["OFFERS_PROPS"], ","))?>" />
	<input type="hidden" id="action_var" value="<?=htmlspecialcharsbx($arParams["ACTION_VARIABLE"])?>" />
	<input type="hidden" id="quantity_float" value="<?=($arParams["QUANTITY_FLOAT"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="price_vat_show_value" value="<?=($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="hide_coupon" value="<?=($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="use_prepayment" value="<?=($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="auto_calculation" value="<?=($arParams["AUTO_CALCULATION"] == "N") ? "N" : "Y"?>" />

</div>
<?

//deb($arResult, false);

else:
?>
	<div class="basket-empty" id="basket_items_list">
              <div class="basket-empty-title">Ваша корзина пуста.</div><a href="/catalog/" class="link link--larrow"><span class="link-icon"> </span><span class="link-text">Перейти к покупкам</span></a>
	</div>
<?
endif;
