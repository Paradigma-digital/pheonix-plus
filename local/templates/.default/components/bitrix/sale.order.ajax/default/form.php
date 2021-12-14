<?
$APPLICATION->AddHeadScript($templateFolder."/script.js");

?>
<div class="page-inner page-inner--w1">
            <div class="profile">
	      <form action="<?=$APPLICATION->GetCurPage();?>" class="form" data-order="Y" method="POST" name="ORDER_FORM" id="bx-soa-order-form" enctype="multipart/form-data">
		<?
		echo bitrix_sessid_post();

		if (strlen($arResult['PREPAY_ADIT_FIELDS']) > 0)
		{
			echo $arResult['PREPAY_ADIT_FIELDS'];
		}
		
		//deb($arResult);
		?>
		<input type="hidden" name="<?=$arParams['ACTION_VARIABLE']?>" value="saveOrderAjax">
		<input type="hidden" name="location_type" value="code">
		<input type="hidden" name="BUYER_STORE" id="BUYER_STORE" value="<?=$arResult['BUYER_STORE']?>">
		<input type="hidden" name="PERSON_TYPE" id="PERSON_TYPE" value="<?=$arResult['PERSON_TYPE'][1]['ID']?>">
		<input type="hidden" name="DELIVERY_ID" id="DELIVERY_ID" value="<?=$arResult['ORDER_DATA']['DELIVERY_ID']?>">
		<input type="hidden" name="PAY_SYSTEM_ID" id="PAY_SYSTEM_ID" value="<?=$arResult['ORDER_DATA']['PAY_SYSTEM_ID']?>">
		
		<?
			//deb($arResult['ORDER_PROP']['USER_PROPS_Y']);
		$props = array_merge_keys($arResult['ORDER_PROP']['USER_PROPS_Y'], $arResult['ORDER_PROP']['USER_PROPS_N']);
		//$props = $arResult['ORDER_PROP']['USER_PROPS_Y'];
		
		
		
		$groups = array();
		foreach ($props as $prop)
		{
			if (empty($groups[$prop['PROPS_GROUP_ID']]))
			{
				$groups[$prop['PROPS_GROUP_ID']] = $prop['GROUP_NAME'];
			}
		}
	
		?>
		<? foreach ($groups as $groupID => $groupName) {
			if($groupName == "Служебная информация") {
				continue;
			}
		?>
			
			<div class="profile-section">
			  <div class="profile-section-title"><?=$groupName?></div>
			  <div class="profile-section-inner">
				  
				  <?php if($groupName == "Информация о получателе"): ?>
				  	<div class="form-row">
					  	<label class="form-label">
					  		<span class="form-label-inner">Грузополучатель<span class="form-required">*</span></span>
					  	</label>
					  	<div class="form-item-holder">
						  	<?php if($arResult["USER_PROFILES"]): ?>
							  	<select class="form-item form-item--select" id="order-profile" data-profiles='<?php echo htmlspecialchars(json_encode($arResult["USER_PROFILES"]), ENT_QUOTES, 'UTF-8'); ?>'>
								  	<?php if(count($arResult["USER_PROFILES"]) > 1): ?><option class="hideme">Выберите одного из Ваших грузополучателей</option><?php endif; ?>
								  	<?php foreach($arResult["USER_PROFILES"] as $userProfileID => $arUserProfile): ?>
								  		<option value="<?php echo $userProfileID; ?>"><?php echo $arUserProfile["COMPANY_TITLE"]; ?></option>
								  	<?php endforeach; ?>
							  	</select>
							  	<span class="form-item-note">Выберите из списка</span>
						  	<?php else: ?>
						  		<div class="page-text">
							  		<blockquote>
								  		Для завершения оформления заказа Вам необходимо добавить грузополучателя.<br />
								  		Обратитесь к менеджеру ООО «Феникс+» для согласования и прикрепления грузополучателя к Вашей учётной записи.<br />
								  		<?php if($arResult["USER_MANAGER"]): ?>
								  			<br />Ваш менеджер: <b><?php echo $arResult["USER_MANAGER"]["NAME"]; ?></b><br />
								  			тел.: <b><a href="<?php CGCHelper::printTel($arResult["USER_MANAGER"]["PHONE"]); ?>"><?php echo $arResult["USER_MANAGER"]["PHONE"]; ?></a></b>
								  		<?php endif; ?>
							  		</blockquote>
						  		</div>
						  	<?php endif; ?>
					  	</div>
				  	</div>
				  <?php endif; ?>
				  
				<? foreach ($props as $prop) { ?>
					<? if ($prop['PROPS_GROUP_ID'] == $groupID) { ?>
						<? if ($prop['TYPE'] == 'TEXT' && in_array($prop['CODE'], array('ADDRESS', 'COMMENT'))) { ?>
							<div class="form-row">
								<label for="ff<?=$prop['ID']?>" class="form-label"><span class="form-label-inner"><?=$prop['NAME']?><? if ($prop['REQUIRED'] == 'Y' && 0) { ?><span class="form-required">*</span><? } ?></span></label>
								<div class="form-item-holder">
									<textarea type="text" 
										  id="ff<?=$prop['ID']?>" 
										  name="ORDER_DESCRIPTION" 
										  <? if ($prop['REQUIRED'] == 'Y') { ?>  required<? } ?> 
										  data-error="Ошибка заполнения" 
										  class="form-item form-item--textarea"><?=$prop['VALUE_FORMATED']?></textarea>
								</div>
							</div>
						<? } elseif ($prop['TYPE'] == 'TEXT') { 
							if($prop["CODE"] == "COMPANY_ID"): ?>
								
								<input type="hidden" data-fieldcode="<?php echo $prop["CODE"]; ?>" name="<?=$prop['FIELD_NAME']?>" value="<?=$prop['VALUE_FORMATED']?>"  />
							
							<?php elseif($prop["CODE"] == "NDS_TYPE"): ?>
							
								<input type="hidden" name="<?php echo $prop["FIELD_NAME"]; ?>" value="<?php echo $arParams["NDS_INFO"]["TYPE"]; ?>" />
								
						<?php else:
						?>
							<div class="form-row">
								<label for="ff<?=$prop['ID']?>" class="form-label"><span class="form-label-inner"><?=$prop['NAME']?><? if ($prop['REQUIRED'] == 'Y' && 0) { ?><span class="form-required">*</span><? } ?></span></label>
								<div class="form-item-holder">
									<input type="text" 
									       id="ff<?=$prop['ID']?>" 
									       name="<?=$prop['FIELD_NAME']?>" 
									       <? if ($prop['REQUIRED'] == 'Y') { ?>  required data-error="Ошибка заполнения" <? } ?>
									       value="<?=$prop['VALUE_FORMATED']?>" 
										   <?php if(in_array($prop["CODE"], ["COMPANY_NAME", "COMPANY_INN", "COMPANY_KPP", "COMPANY_OKPO"])): ?>
										   	readonly="readonly"
										   <?php endif; ?>
									       data-fieldcode="<?php echo $prop["CODE"]; ?>" 
									       
									       class="form-item form-item--text<? if ($prop['PATTERN'] == '/[0-9]*/') { ?> form--number<? } ?>"><? if (!empty($prop['DESCRIPTION'])) { ?><span class="form-item-note"><?=$prop['DESCRIPTION']?></span><? } ?>
								</div>
							</div>
							<?php endif; ?>
						<? } ?>
					<? } ?>
				<? } ?>
			  </div>
			</div>
		<? } ?>
                <?php if($arParams["USER_TYPE"] == "SIMPLE"):  ?>
                <div class="profile-section">
                  <div class="profile-section-inner">
                    <div class="page-text">
                      <h3>Способ доставки</h3>
                      
                      <div class="delivery-items"> 
	                      <?php foreach($arResult["DELIVERY"] as $arDelivery): ?>
	                      	<div class="delivery-item">
		                    	<input type="radio" name="DELIVERY_ID" value="<?php echo $arDelivery["ID"]; ?>" class="form-item form-item--radio" />
		                    	<?php if($arDelivery["LOGOTIP"]): ?>
		                    		<div class="delivery-item-image"><img src="<?php echo $arDelivery["LOGOTIP"]["SRC"]; ?>" /></div>
		                    	<?php endif; ?>
		                    	<div class="delivery-item-name"><?php echo $arDelivery["NAME"]; ?></div>
		                    	<div class="delivery-item-description"><?php echo $arDelivery["DESCRIPTION"]; ?></div>
	                      	</div>
	                      <?php endforeach; ?>
                      </div>
                      
                    </div>
                  </div>
                </div>
                <div class="profile-section">
                  <div class="profile-section-inner">
                    <div class="page-text">
                      <h3>Способ оплаты</h3>
 
                      <div class="payment-items"> 
	                      <?php foreach($arResult["PAY_SYSTEM"] as $arPayment): ?>
	                      	<div class="payment-item">
		                    	<input type="radio" name="PAYMENT_ID" value="<?php echo $arPayment["ID"]; ?>" class="form-item form-item--radio" />
		                    	<?php if($arPayment["PSA_LOGOTIP"]): ?>
		                    		<div class="payment-item-image"><img src="<?php echo $arPayment["PSA_LOGOTIP"]["SRC"]; ?>" /></div>
		                    	<?php endif; ?>
		                    	<div class="payment-item-name"><?php echo $arPayment["NAME"]; ?></div>
		                    	<div class="payment-item-description"><?php echo $arPayment["DESCRIPTION"]; ?></div>
	                      	</div>
	                      <?php endforeach; ?>
                      </div>
 
                    </div>
                  </div>
                </div>
                <?php endif; ?>
                
                <div class="profile-section">
                  <div class="profile-section-inner">
                    <div class="order-summary">
	                  <div class="order-summary-item">Товарных позиций: <?=count($arResult['BASKET_ITEMS'])?></div>
                      <div class="order-summary-item">На сумму: <?=$arResult['ORDER_PRICE_FORMATED']?></div>
                      
                      <?php if($arParams["NDS_INFO"]["SUMMARY_VAT_TITLE"]): ?>
                      	<div class="order-summary-item"><?php echo $arParams["NDS_INFO"]["SUMMARY_VAT_TITLE"]; ?>: <?=$arResult['VAT_SUM_FORMATED']?></div>
                      <?php endif; ?>
                      
                      <!--<div class="order-summary-item">Доставка: 240 ₽</div>-->
                      <div class="order-summary-item order-summary-item--large">Итого: <?=$arResult['ORDER_TOTAL_PRICE_FORMATED']?></div>
                    </div>
                    <div class="order-buy">
                      <button type="submit" class="btn btn--red btn--large btn--full" <?php if(!$arResult["USER_PROFILES"]): ?>disabled="disabled"<?php endif; ?>>Заказать</button>
                    </div>
                    <!--<div class="form-note">Нажав кнопку «Оформить заказ» вы соглашаетесь с <a href="#" class="link link--black">условиями оферты</a>.</div>-->
                  </div>
                </div>
              </form>
            </div>
          </div>
