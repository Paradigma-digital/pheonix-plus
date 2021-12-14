<?php CJSCore::Init("jquery"); ?>

<script>
	$.expr[':'].icontains = $.expr.createPseudo(function(text) {
	    return function(e) {
	        return $(e).text().toUpperCase().indexOf(text.toUpperCase()) >= 0;
	    };
	});
	
	$(document).ready(function() {
		if(location.pathname == "/bitrix/admin/user_edit.php") {
			var $holder = $(".adm-detail-content#edit2 .adm-detail-content-item-block");
			
			$holder.prepend(
				'<div style="margin: 0 auto 10px auto; width: 80%;">' + 
					'<label for="custom_group_filter" style="display: block; font-size: 12px; line-height: 1; margin-bottom: 2px;">Фильтр по группам</label>' + 
					'<input type="text" id="custom_group_filter" placeholder="Название группы" size="40" style="height: 30px; font-size: 14px;" />' + 
					'<label style="margin-left: 15px;">' +
						'<input type="checkbox" id="custom_current_groups" value="1" class="adm-designed-checkbox" />' + 
						'<label class="adm-designed-checkbox-label" title=""></label>' + 
						'<span style="margin-left: 5px;">Только выбранные</div>' + 	
					'</label>' +
				'</div>'
			);
			$("#custom_group_filter").on("keyup", function() {
				var $input = $(this),
					search = $input.val();
					
				if(search.length < 3) {
					$holder.find("table.adm-detail-content-table table tr:gt(0)").show();
					return false;
				}
				$holder.find("table.adm-detail-content-table table tr:gt(0)").hide();
				$holder.find("table.adm-detail-content-table table tr td.align-left label[for*='GROUP_ID_ACT_ID']:icontains('" + search + "')").closest("tr").show();
			});
			
			$("#custom_current_groups").on("change", function() {
				var $chk = $(this);
				
				if($chk.prop("checked")) {
					$holder.find("table.adm-detail-content-table table tr:gt(0)").hide();
					$holder.find("table.adm-detail-content-table table tr td input.adm-designed-checkbox:checked").closest("tr").show();
				} else {
					$holder.find("table.adm-detail-content-table table tr:gt(0)").show();
				}
			});
		}
	});
</script>