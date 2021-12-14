<?php
// sdemon72 20200524

class PhoenixPlusUtils
{

	// sdemon72 20200524
	// преобразует строковое представление числа в значение с плавающей точкой
	public function ToFloat($str)
	{
		static $search = false;
		static $replace = false;
		if (!$search)
		{
			$search = array("\xc2\xa0", "\xa0", " ", ",");
			$replace = array("", "", "", ".");
		}
		
		$res1 = str_replace($search, $replace, $str);
		$res2 = doubleval($res1);

		return $res2;
	}
	
	// возвращает массив с размерами товара
	public function GetProductDimensions($productXmlId)
	{
		$dimensions = false;
		
		// Найти товар по внешнему ид
		$r = \CIBlockElement::GetList(
		array(),
		array("=XML_ID" => $productXmlId, "ACTIVE" => "Y"),
		false,
		[
			"nTopCount" => "1"
		],
		array("ID", "IBLOCK_ID", "XML_ID", "NAME", "DETAIL_PAGE_URL")
		);
		if($ar = $r->GetNext())
		{
			// получить свойства товарного предложения
			$product = \CCatalogProduct::GetByID($ar["ID"]);
			
			// получить размеры
			if (!empty($product['WIDTH']) && !empty($product['HEIGHT']) && !empty($product['LENGTH']))
			{
				$dimensions = array(
				'WIDTH' => $product['WIDTH'], 
				'HEIGHT' => $product['HEIGHT'], 
				'LENGTH' => $product['LENGTH']);
			}
		}

		return $dimensions;
	}
	
	
	
}


?>
