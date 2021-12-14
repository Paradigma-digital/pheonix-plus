<?php

//ajax post requests without notice
class perPageClass
{
	private static $value = 9;
	public static $points = array(
	    '9' => '9',
	    '18' => '18',
	    '27' => '27',
	    '90' => '90',
	    //'all' => 'Все'
	);

	public static function getValue()
	{
		self::$value = !empty($_SESSION['oc_perpage'])?$_SESSION['oc_perpage']:self::$value;

		if (!empty($_GET['perpage']) && !empty(self::$points[$_GET['perpage']]))
		{
			self::$value = $_GET['perpage'];
			$_SESSION['oc_perpage'] = self::$value;
		}
		
		return self::$value;
	}
	public static function getValueEx()
	{
		if (self::$value == 'all')
		{
			return 100000;
		}
		else
		{
			return self::$points[self::$value];
		}
	}
}


class perSearchPageClass
{
	private static $value = 12;
	public static $points = array(
		"12" => "12",
		"24" => "24",
		"36" => "36",
		"all"=> "Все"
	);
	public static function getValue()
	{
		//self::$value = !empty($_SESSION['oc_perpage'])?$_SESSION['oc_perpage']:self::$value;

		if (!empty($_GET['perpage']) && !empty(self::$points[$_GET['perpage']]))
		{
			self::$value = $_GET['perpage'];
			//$_SESSION['oc_perpage'] = self::$value;
		}
		
		return self::$value;
	}
	public static function getValueEx()
	{
		if (self::$value == 'all')
		{
			return 100000;
		}
		else
		{
			return self::$points[self::$value];
		}
	}
}