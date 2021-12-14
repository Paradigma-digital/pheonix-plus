<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<div class="page-inner page-inner--w2">
	<div class="page-text"><blockquote><?php echo $arResult["VOTE"]["DESCRIPTION"]; ?></blockquote><br /></div>
	
	<?php if(!empty($arResult["ERROR_MESSAGE"])): ?>
		<div class="form-error"><?=ShowError($arResult["ERROR_MESSAGE"])?></div>
	<?php endif; ?>
	
	<?php if(!empty($arResult["OK_MESSAGE"])): ?>
		<div class="form-success"><?=ShowNote($arResult["OK_MESSAGE"])?></div>
	<?php endif; ?>
</div>

<?php if(!$arResult["OK_MESSAGE"]): ?>
<div class="page-inner page-inner--w2">
	<div class="profile">			
		<form action="<?=POST_FORM_ACTION_URI?>" method="post" class="vote-form">
			<input type="hidden" name="vote" value="Y">
			<input type="hidden" name="PUBLIC_VOTE_ID" value="<?=$arResult["VOTE"]["ID"]?>">
			<input type="hidden" name="VOTE_ID" value="<?=$arResult["VOTE"]["ID"]?>">
			<?=bitrix_sessid_post()?>
			
			<div class="profile-section">
				<div class="profile-section-inner">
					<?php foreach ($arResult["QUESTIONS"] as $arQuestion): ?>
						<div class="profile-section-inner-row">
							<div class="profile-section-title"><?php echo $arQuestion["QUESTION"]; ?><?php if($arQuestion["REQUIRED"] == "Y"): ?><span class="required">*</span><?php endif; ?></div>
							<?php foreach ($arQuestion["ANSWERS"] as $arAnswer): ?>
								<div class="form-row">
									<?php
										switch ($arAnswer["FIELD_TYPE"]):
											case 0://radio
												$value=(isset($_REQUEST['vote_radio_'.$arAnswer["QUESTION_ID"]]) && 
													$_REQUEST['vote_radio_'.$arAnswer["QUESTION_ID"]] == $arAnswer["ID"]) ? 'checked="checked"' : '';
											break;
											case 1://checkbox
												$value=(isset($_REQUEST['vote_checkbox_'.$arAnswer["QUESTION_ID"]]) && 
													array_search($arAnswer["ID"],$_REQUEST['vote_checkbox_'.$arAnswer["QUESTION_ID"]])!==false) ? 'checked="checked"' : '';
											break;
											case 2://select
												$value=(isset($_REQUEST['vote_dropdown_'.$arAnswer["QUESTION_ID"]])) ? $_REQUEST['vote_dropdown_'.$arAnswer["QUESTION_ID"]] : false;
											break;
											case 3://multiselect
												$value=(isset($_REQUEST['vote_multiselect_'.$arAnswer["QUESTION_ID"]])) ? $_REQUEST['vote_multiselect_'.$arAnswer["QUESTION_ID"]] : array();
											break;
											case 4://text field
												$value = isset($_REQUEST['vote_field_'.$arAnswer["ID"]]) ? htmlspecialcharsbx($_REQUEST['vote_field_'.$arAnswer["ID"]]) : '';
											break;
											case 5://memo
												$value = isset($_REQUEST['vote_memo_'.$arAnswer["ID"]]) ?  htmlspecialcharsbx($_REQUEST['vote_memo_'.$arAnswer["ID"]]) : '';
											break;
										endswitch;
									?>
									<?php
										switch ($arAnswer["FIELD_TYPE"]):
											case 0://radio
						?>
												<div class="form-radio">
													<input type="radio" <?=$value?> name="vote_radio_<?=$arAnswer["QUESTION_ID"]?>" <?
														?>id="vote_radio_<?=$arAnswer["QUESTION_ID"]?>_<?=$arAnswer["ID"]?>" <?
														?>value="<?=$arAnswer["ID"]?>" <?=$arAnswer["~FIELD_PARAM"]?> 
														class="form-item form-item--radio" 
														/>
													<label class="form-radio-label" for="vote_radio_<?=$arAnswer["QUESTION_ID"]?>_<?=$arAnswer["ID"]?>"><?=$arAnswer["MESSAGE"]?></label>
												</div>
						<?
											break;
											case 1://checkbox?>
												<span class="vote-answer-item vote-answer-item-checkbox">
													<input <?=$value?> type="checkbox" name="vote_checkbox_<?=$arAnswer["QUESTION_ID"]?>[]" value="<?=$arAnswer["ID"]?>" <?
														?> id="vote_checkbox_<?=$arAnswer["QUESTION_ID"]?>_<?=$arAnswer["ID"]?>" <?=$arAnswer["~FIELD_PARAM"]?> />
													<label for="vote_checkbox_<?=$arAnswer["QUESTION_ID"]?>_<?=$arAnswer["ID"]?>"><?=$arAnswer["MESSAGE"]?></label>
												</span>
											<?break?>
						
											<?case 2://dropdown?>
												<span class="vote-answer-item vote-answer-item-dropdown">
													<select name="vote_dropdown_<?=$arAnswer["QUESTION_ID"]?>" <?=$arAnswer["~FIELD_PARAM"]?>>
														<option value=""><?=GetMessage("VOTE_DROPDOWN_SET")?></option>
													<?foreach ($arAnswer["DROPDOWN"] as $arDropDown):?>
														<option value="<?=$arDropDown["ID"]?>" <?=($arDropDown["ID"] === $value)?'selected="selected"':''?>><?=$arDropDown["MESSAGE"]?></option>
													<?endforeach?>
													</select>
												</span>
											<?break?>
						
											<?case 3://multiselect?>
												<span class="vote-answer-item vote-answer-item-multiselect">
													<select name="vote_multiselect_<?=$arAnswer["QUESTION_ID"]?>[]" <?=$arAnswer["~FIELD_PARAM"]?> multiple="multiple">
													<?foreach ($arAnswer["MULTISELECT"] as $arMultiSelect):?>
														<option value="<?=$arMultiSelect["ID"]?>" <?=(array_search($arMultiSelect["ID"], $value)!==false)?'selected="selected"':''?>><?=$arMultiSelect["MESSAGE"]?></option>
													<?endforeach?>
													</select>
												</span>
											<?break?>
						
											<?case 4://text field?>
												<span class="vote-answer-item vote-answer-item-textfield">
												
													<input class="form-item form-item--text" type="text" name="vote_field_<?=$arAnswer["ID"]?>" id="vote_field_<?=$arAnswer["ID"]?>" <?
														?>value="<?=$value?>" size="<?=$arAnswer["FIELD_WIDTH"]?>" <?=$arAnswer["~FIELD_PARAM"]?> placeholder="<?=$arAnswer["MESSAGE"]?>" /></span>
											<?break?>
						
											<?case 5://memo?>
												<span class="vote-answer-item vote-answer-item-memo">
													<label for="vote_memo_<?=$arAnswer["ID"]?>"><?=$arAnswer["MESSAGE"]?></label><br />
													<textarea name="vote_memo_<?=$arAnswer["ID"]?>" id="vote_memo_<?=$arAnswer["ID"]?>" <?
														?><?=$arAnswer["~FIELD_PARAM"]?> cols="<?=$arAnswer["FIELD_WIDTH"]?>" <?
													?>rows="<?=$arAnswer["FIELD_HEIGHT"]?>"><?=$value?></textarea>
												</span>
											<?break;
										endswitch;
									?>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endforeach; ?>
					
					<div class="form-row form-row--btn">
						<button type="submit" name="vote" value="<?=GetMessage("VOTE_SUBMIT_BUTTON")?>" class="btn btn--red btn--large btn--full">Отправить</button>
					</div>
					
				</div>
			</div>
		</form>
	</div>
</div>
<?php endif; ?>