<?php

function addTrailingSpaces($num)
{
	$str = $num;
	while(strlen($str) != 20)
	{
		$str = " $str";
	}
	return $str;
}