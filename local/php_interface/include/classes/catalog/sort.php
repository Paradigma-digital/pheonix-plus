<?php

//ajax post requests without notice
class sortClass
{
	private static $value = 'popular';
	public static $points = array(
	    'popular' => array(
		'TEXT' => 'популярности',
		'SORT' => array(
		    'FIELD' => 'propertysort_STATUS_TOVARA',
		    'ORDER' => 'asc,nulls',
		),
		"SORT2" => Array(
			"FIELD" => "PROPERTY_CML2_ARTICLE",
			"ORDER" => "desc",
		)
	    ),
	    'price_asc' => array(
		'TEXT' => 'увеличению цены',
		'SORT' => array(
		    'FIELD' => 'catalog_PRICE_4',
		    'ORDER' => 'asc',
		),
	    ),
	    'price_desc' => array(
		'TEXT' => 'уменьшению цены',
		'SORT' => array(
		    'FIELD' => 'catalog_PRICE_4',
		    'ORDER' => 'desc',
		),
	    ),
	    


	    'art_asc' => array(
			'TEXT' => 'возрастанию артикула',
			'SORT' => array(
		    	'FIELD' => 'property_CML2_ARTICLE',
				'ORDER' => 'asc',
			),
	    ),
	    'art_desc' => array(
			'TEXT' => 'убыванию артикула',
			'SORT' => array(
		    	'FIELD' => 'property_CML2_ARTICLE',
				'ORDER' => 'desc',
			),
	    ),


	    
	    /*
	    'promo' => array(
		'TEXT' => 'акции',
		'SORT' => array(
		    'FIELD' => 'property_SKIDKA',
		    'ORDER' => 'desc',
		),
	    ),
	    
	    
	    'hit' => array(
		'TEXT' => 'хиты',
		'SORT' => array(
		    'FIELD' => 'property_KHIT',
		    'ORDER' => 'desc',
		),
	    ),
	    'new' => array(
		'TEXT' => 'новинки',
		'SORT' => array(
		    'FIELD' => 'property_NOVINKA',
		    'ORDER' => 'desc',
		),
	    ),
	    */
	);

	public static function getValue()
	{
		self::$value = !empty($_SESSION['oc_sort'])?$_SESSION['oc_sort']:self::$value;
		
		if (!empty($_GET['sort']) && !empty(self::$points[$_GET['sort']]))
		{
			self::$value = $_GET['sort'];
			$_SESSION['oc_sort'] = self::$value;
		}
		
		return self::$value;
	}
	public static function getValueField()
	{
		return self::$points[self::$value]['SORT']['FIELD'];
	}
	public static function getValueOrder()
	{
		return self::$points[self::$value]['SORT']['ORDER'];
	}
	
	public static function getValueField2()
	{
		return (self::$points[self::$value]['SORT2'] ? self::$points[self::$value]['SORT2']['FIELD'] : "SORT");
	}
	public static function getValueOrder2()
	{
		return (self::$points[self::$value]['SORT2'] ? self::$points[self::$value]['SORT2']['ORDER'] : "ASC");
	}
}