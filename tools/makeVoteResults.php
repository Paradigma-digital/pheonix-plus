<?php
	require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
	CModule::IncludeModule("vote");
	
	$arResult = [];
	$arParams["VOTE_ID"] = GetVoteDataByID(
		"2",
		$arResult["CHANNEL"],
		$arResult["VOTE"],
		$arResult["QUESTIONS"],
		$arAnswers, $arDropDown, $arMultiSelect,
		$arResult["GROUP_ANSWERS"],
		array(
			"bGetMemoStat" => "Y"
		)
	);
	
	$arResultData = [];
	
	foreach($arResult["QUESTIONS"] as $arQuestion) {
		$arResultData[$arQuestion["ID"]] = [
			"NAME" => $arQuestion["QUESTION"],
			"ID" => $arQuestion["ID"],
			"RESULTS" => [],
		];
	}
	
	//deb($arResult["GROUP_ANSWERS"]);
	
	foreach($arResult["GROUP_ANSWERS"] as $arGroup) {
		foreach($arGroup as $arAnswer) {
			if(!$arResultData[$arAnswer["QUESTION_ID"]]["RESULTS"][$arAnswer["MESSAGE"]]) {
				$arResultData[$arAnswer["QUESTION_ID"]]["RESULTS"][$arAnswer["MESSAGE"]] = 1;
			} else {
				$arResultData[$arAnswer["QUESTION_ID"]]["RESULTS"][$arAnswer["MESSAGE"]] = $arResultData[$arAnswer["QUESTION_ID"]]["RESULTS"][$arAnswer["MESSAGE"]] + 1;
			}
		}
		arsort($arResultData[$arAnswer["QUESTION_ID"]]["RESULTS"]);
	}
	
	//deb($arResultData);
?>
<?php
$file="vote_results.xls";
header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header("Content-Transfer-Encoding: binary ");
header("Content-Disposition: attachment; filename=$file");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>vote_results</title>
	</head>
	<body>
		<table cellspacing="5" cellpadding="5">
			<thead>
				<tr>
					<th>Номинация</th>
					<th>Участник</th>
					<th>Голосов</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($arResultData as $arResultItem): ?>
					<tr>
						<td><b><?php echo $arResultItem["NAME"]; ?></b></td>
						<td></td>
						<td></td>
					</tr>
					<?php foreach($arResultItem["RESULTS"] as $rowName => $rowCount): ?>
						<tr>
							<td></td>
							<td><?php echo $rowName; ?></td>
							<td><?php echo $rowCount; ?></td>
						</tr>
					<?php endforeach; ?>
					<tr>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</body>
</html>