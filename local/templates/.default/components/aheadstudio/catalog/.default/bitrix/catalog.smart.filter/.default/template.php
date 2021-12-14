<?
global $USER;
?>
	<div id="filter" class="filter-holder">
	    <div class="filter-title">Фильтр</div>
	    <form class="filter" name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter">
		<?foreach($arResult["HIDDEN"] as $arItem):?>
			<input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
		<?endforeach;?>
			
			
		<?
		
		if ($USER->IsAuthorized())
		{
		foreach($arResult["ITEMS"] as $key=>$arItem)//prices
		{
			if($key != "Канц Анонс") continue;
			$key = $arItem["ENCODED_ID"];
			if(isset($arItem["PRICE"])) 
			{ 
				if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
				{
					continue;
				}
				
				$step_num = 4;
				$step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / $step_num;
				$prices = array();
				if (Bitrix\Main\Loader::includeModule("currency"))
				{
					for ($i = 0; $i < $step_num; $i++)
					{
						$prices[$i] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MIN"]["VALUE"] + $step*$i, $arItem["VALUES"]["MIN"]["CURRENCY"], false);
					}
					$prices[$step_num] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MAX"]["VALUE"], $arItem["VALUES"]["MAX"]["CURRENCY"], false);
				}
				else
				{
					$precision = ($arItem["DECIMALS"]? $arItem["DECIMALS"]: 0);
					for ($i = 0; $i < $step_num; $i++)
					{
						$prices[$i] = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step*$i, $precision, ".", "");
					}
					$prices[$step_num] = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
				}
				
				$minV = floor(!empty($arItem["VALUES"]["MIN"]["HTML_VALUE"]) ? $arItem["VALUES"]["MIN"]["HTML_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"]);
				$maxV = ceil(!empty($arItem["VALUES"]["MAX"]["HTML_VALUE"]) ? $arItem["VALUES"]["MAX"]["HTML_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"]);
//				deb($arItem["VALUES"], false);
				?>
			
				<div class="filter-item open">
					<div class="filter-item-header"><span class="filter-item-header-title">Цена</span><span class="filter-item-header-toggler"></span></div>
					<div class="filter-item-content filter-item-content filter-item-content--price">
					    <div class="filter-slider filter-item-variant">
						<div class="filter-slider-fields-holder">
						    <div class="filter-slider-field filter-slider-field--left">
							<input type="text" onchange="smartFilter.keyup(this)" name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>" id="filter-price-from" value="<?=$minV?>" class="filter-slider-field-input form-item form-item--text"><span class="filter-slider-field-note">₽</span>
						    </div>
						    <div class="filter-slider-field filter-slider-field--right">
							<input type="text" onchange="smartFilter.keyup(this)" name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>" id="filter-price-to" value="<?=$maxV?>" class="filter-slider-field-input form-item form-item--text"><span class="filter-slider-field-note">₽</span>
						    </div>
						</div>
						<input type="range" multiple value="<?=$minV?>,<?=$maxV?>" min="<?=floor($arItem["VALUES"]["MIN"]["VALUE"])?>" max="<?=ceil($arItem["VALUES"]["MAX"]["VALUE"])?>" step="1" data-from="#filter-price-from" data-to="#filter-price-to" id="filter-price-range" class="filter-range form-item form-item--range filter-slider-price">
					    </div>
					</div>
				</div>
			<? }
		} 
		} ?>
		<? foreach($arResult["ITEMS"] as $key=>$arItem)
		{
			if(empty($arItem["VALUES"]) || isset($arItem["PRICE"]))
			{
				continue;
			}

			if ($arItem["DISPLAY_TYPE"] == "A" && ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0))
			{
				continue;
			}
			
			$arCur = current($arItem["VALUES"]);
			switch ($arItem["DISPLAY_TYPE"]) {
				case "A"://NUMBERS_WITH_SLIDER
				case "B"://NUMBERS
				
				$minV = floor(!empty($arItem["VALUES"]["MIN"]["HTML_VALUE"]) ? $arItem["VALUES"]["MIN"]["HTML_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"]);
				$maxV = ceil(!empty($arItem["VALUES"]["MAX"]["HTML_VALUE"]) ? $arItem["VALUES"]["MAX"]["HTML_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"]);
				    ?>
				<div class="filter-item<?if ($arItem["DISPLAY_EXPANDED"]== "Y") { ?> open<? } ?>">
					<div class="filter-item-header"><span class="filter-item-header-title"><?=$arItem["NAME"]?></span><span class="filter-item-header-toggler"></span></div>
					<div class="filter-item-content">
					    <div class="filter-slider filter-item-variant">
						<div class="filter-slider-fields-holder">
						    <div class="filter-slider-field filter-slider-field--left">
							<input type="text" onchange="smartFilter.keyup(this)" name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>" id="filter-<?=$arItem["ID"]?>-from" value="<?=$minV?>" class="filter-slider-field-input form-item form-item--text">
						    </div>
						    <div class="filter-slider-field filter-slider-field--right">
							<input type="text" onchange="smartFilter.keyup(this)" name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>" id="filter-<?=$arItem["ID"]?>-to" value="<?=$maxV?>" class="filter-slider-field-input form-item form-item--text">
						    </div>
						</div>
						<input type="range" multiple value="<?=$minV?>,<?=$maxV?>" min="<?=floor($arItem["VALUES"]["MIN"]["VALUE"])?>" max="<?=ceil($arItem["VALUES"]["MAX"]["VALUE"])?>" step="1" data-from="#filter-<?=$arItem["ID"]?>-from" data-to="#filter-<?=$arItem["ID"]?>-to" class="filter-range form-item form-item--range filter-slider-price">
					    </div>
					</div>
				</div>
				    <?
				    break;
				case "G"://CHECKBOXES_WITH_PICTURES
				case "H"://CHECKBOXES_WITH_PICTURES_AND_LABELS
				case "P"://DROPDOWN
				case "R"://DROPDOWN_WITH_PICTURES_AND_LABELS
				case "K"://RADIO_BUTTONS
				case "U"://CALENDAR
				default://CHECKBOXES
					
				?>
				    <div class="filter-item<?if ($arItem["DISPLAY_EXPANDED"]== "Y") { ?> open<? } ?>">
					    <div class="filter-item-header"><span class="filter-item-header-title"><?=$arItem["NAME"]?></span><span class="filter-item-header-toggler"></span></div>
					    <div class="filter-item-content">
						<?foreach($arItem["VALUES"] as $val => $ar) { ?>
							<label class="filter-checkbox filter-item-variant">
							    <input type="checkbox" 
									value="<? echo $ar["HTML_VALUE"] ?>"
									name="<? echo $ar["CONTROL_NAME"] ?>"
									id="<? echo $ar["CONTROL_ID"] ?>"
									<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
									onclick="smartFilter.click(this)" class="filter-checkbox-field form-item form-item--checkbox"><span class="filter-checkbox-title"><?=$ar["VALUE"];?></span>
							</label>
						<? } ?>
					    </div>
					</div>
				<? break; 
			} 
			
			
		} ?>
			
<!--		<div class="filter-item open">
                    <div class="filter-item-header"><span class="filter-item-header-title">Цена</span><span class="filter-item-header-toggler"></span></div>
                    <div class="filter-item-content">
			<div class="filter-slider filter-item-variant">
			    <div class="filter-slider-fields-holder">
				<div class="filter-slider-field filter-slider-field--left">
				    <input type="text" id="filter-price-from" value="20" class="filter-slider-field-input form-item form-item--text"><span class="filter-slider-field-note">₽</span>
				</div>
				<div class="filter-slider-field filter-slider-field--right">
				    <input type="text" id="filter-price-to" value="100" class="filter-slider-field-input form-item form-item--text"><span class="filter-slider-field-note">₽</span>
				</div>
			    </div>
			    <input type="range" multiple value="20,100" min="1" max="120" step="0.2" data-from="#filter-price-from" data-to="#filter-price-to" id="filter-price-range" class="form-item form-item--range filter-slider-price">
			</div>
                    </div>
		</div>
		<div class="filter-item">
                    <div class="filter-item-header"><span class="filter-item-header-title">Датировка</span><span class="filter-item-header-toggler"></span></div>
                    <div class="filter-item-content">
			<label class="filter-checkbox filter-item-variant">
			    <input type="checkbox" class="filter-checkbox-field form-item form-item--checkbox"><span class="filter-checkbox-title">Сверх мягкая</span>
			</label>
			<label class="filter-checkbox filter-item-variant">
			    <input type="checkbox" class="filter-checkbox-field form-item form-item--checkbox"><span class="filter-checkbox-title">Мягкая</span>
			</label>
			<label class="filter-checkbox filter-item-variant">
			    <input type="checkbox" class="filter-checkbox-field form-item form-item--checkbox"><span class="filter-checkbox-title">Жесткая</span>
			</label>
			<label class="filter-checkbox filter-item-variant">
			    <input type="checkbox" class="filter-checkbox-field form-item form-item--checkbox"><span class="filter-checkbox-title">Сверх жесткая</span>
			</label>
			<label class="filter-checkbox filter-item-variant">
			    <input type="checkbox" class="filter-checkbox-field form-item form-item--checkbox"><span class="filter-checkbox-title">Уникальная</span>
			</label>
                    </div>
		</div>
		<div class="filter-item">
                    <div class="filter-item-header"><span class="filter-item-header-title">Твердость обложки</span><span class="filter-item-header-toggler"></span></div>
                    <div class="filter-item-content">
			<label class="filter-checkbox filter-item-variant">
			    <input type="checkbox" class="filter-checkbox-field form-item form-item--checkbox"><span class="filter-checkbox-title">Сверх мягкая</span>
			</label>
			<label class="filter-checkbox filter-item-variant">
			    <input type="checkbox" class="filter-checkbox-field form-item form-item--checkbox"><span class="filter-checkbox-title">Мягкая</span>
			</label>
			<label class="filter-checkbox filter-item-variant">
			    <input type="checkbox" class="filter-checkbox-field form-item form-item--checkbox"><span class="filter-checkbox-title">Жесткая</span>
			</label>
			<label class="filter-checkbox filter-item-variant">
			    <input type="checkbox" class="filter-checkbox-field form-item form-item--checkbox"><span class="filter-checkbox-title">Сверх жесткая</span>
			</label>
			<label class="filter-checkbox filter-item-variant">
			    <input type="checkbox" class="filter-checkbox-field form-item form-item--checkbox"><span class="filter-checkbox-title">Уникальная</span>
			</label>
                    </div>
		</div>-->
		<div class="filter-controls">
                    <button id="set_filter" type="submit" class="filter-control-item filter-control-item--submit btn btn--red" name="set_filter" value="<?=GetMessage("CT_BCSF_SET_FILTER")?>">Показать <span id="modef_num2"></span></button>
                    
                    <?php if(0): ?><button type="submit" 
								id="del_filter"
								name="del_filter"
								value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>" class="filter-control-item filter-control-item--reset btn btn--gray">Сбросить</button><?php endif; ?>
					
					<button type="submit" 
								id="del_filter"
								name="del_filter"
								value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>" class="filter-control-item filter-control-item--reset link link--black">Сбросить</button>
					
		</div>
		<div class="filter-balloon" id="modef"><span class="filter-balloon-title">Выбрано <span id="modef_num"><?=intval($arResult["ELEMENT_COUNT"])?></span></span><a href="#" class="link link--white">показать</a></div>
	    </form>
	</div>
<script type="text/javascript">
	var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>