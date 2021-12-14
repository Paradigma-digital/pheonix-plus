<?php
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

	CGCUser::loginIfNotAuth($USER);

	$APPLICATION->SetTitle("Профиль партнера");
?>
<?php
	$arUserSale = CGCUser::getSaleInfo($USER->GetID());
	$arUserInfo = CGCUser::getUserInfo([
		"ID" => $USER->GetID()
	]);
	if($arUserSale["GROUP"]["GROUP"]):
		$arProfiles = CGCUser::getProfiles($USER->GetID());
		$arManager = CGCUser::getManager($USER->GetID());
?>
	<div class="profile">
		<div class="profile-section">
			<div class="page-inner page-inner--w2">
				
				<dl>
					<dt>Имя входа (E-mail):</dt>
					<dd>
						<b><?php echo $arUserInfo["EMAIL"]; ?>&nbsp;</b>
					</dd>
					<dt>Ф.И.О.:</dt>
					<dd>
						<b><?php echo $arUserInfo["NAME"]; ?>&nbsp;</b>
					</dd>
					<dt>Организация:</dt>
					<dd>
						<b><?php echo $arUserInfo["WORK_COMPANY"]; ?>&nbsp;</b>
					</dd>
				</dl>
				
				<dl>
					<dt>Персональный менеджер:</dt>
					<dd>
						<b><?php echo $arManager["NAME"]; ?>&nbsp;</b>
					</dd>
					<?php if($arManager["PHONE"]): ?>
						<dt>Телефон:</dt>
						<dd>
							<b><?php echo $arManager["PHONE"]; ?></b>
						</dd>
					<?php endif; ?>
					<?php if($arManager["EMAIL"]): ?>
						<dt>Электронная почта:</dt>
						<dd>
							<b><?php echo $arManager["EMAIL"]; ?></b>
						</dd>
					<?php endif; ?>
				</dl>
				
				
				
				<h3>Грузополучатели:</h3>
				<?php if($arProfiles): ?>
					<div class="table-wrapper">
						<table class="table">
							<thead>
								<tr>
									<th>Наименование</th>
									<th>ИНН</th>
									<th>КПП</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($arProfiles as $arProfile): ?>
									<tr>
										<td><?php echo $arProfile["COMPANY_NAME"]; ?></td>
										<td><?php echo $arProfile["COMPANY_INN"]; ?></td>
										<td><?php echo $arProfile["COMPANY_KPP"]; ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				<?php endif; ?> 
				
			</div>
		</div>
	</div>
<?php else: ?>
	<?php if($arUserInfo["UF_PROFILE_COMPLETE"]): //deb($arUserInfo); ?>
		
		<div class="page-text">
			<blockquote>Ваш запрос обрабатывается менеджером.</blockquote>
		</div>
	
	<?php else: ?>
	
		<?php
			$APPLICATION->IncludeComponent(
				"bitrix:main.profile",
				"partner",
				Array(
					"CHECK_RIGHTS" => "N",
					"SEND_INFO" => "N",
					"SET_TITLE" => "N",
					"USER_PROPERTY" => array("UF_INN"),
					"USER_PROPERTY_NAME" => "",
					"NEW_USER" => "Y",
					"CACHE_TYPE" => "N",
				)
		); ?>
	
	<?php endif; ?>
		
<?php endif; ?>
<?php
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>