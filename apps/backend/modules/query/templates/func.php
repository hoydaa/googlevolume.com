<?php

function addTrailingSpaces($num)
{
	$str = "";
	for($i = 0; $i < 20 - strlen($num); $i++) 
	{
		$str .= "&nbsp;";
	}
	return $str . $num;
}