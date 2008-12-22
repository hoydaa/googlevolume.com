<?php

function addTrailingSpaces($num)
{
	$str = $num;
	while(strlen($str) != 15)
	{
		$str = " $str";
	}
	return $str;
}