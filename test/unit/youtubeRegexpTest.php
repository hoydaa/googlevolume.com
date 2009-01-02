<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');

$t = new lime_test(2, new lime_output_color());

ProjectConfiguration::getApplicationConfiguration('frontend', 'test', true);
$engine = new YoutubeRegexp();

$result = $engine->findResultCount(file_get_contents(dirname(__FILE__).'/youtube.very.much.results.html'));
$t->is($result, 25200, 'Result count has to be 25200 for file youtube.very.much.results.html');

$result = $engine->findResultCount(file_get_contents(dirname(__FILE__).'/youtube.nothing.html'));
$t->is($result, 0, 'Result count has to be 0 for youtube.nothing.html');

function getResult($filename) {
	return file_get_contents(dirname(__FILE__).'/'.$filename);
}