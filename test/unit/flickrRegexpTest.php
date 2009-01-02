<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');

$t = new lime_test(3, new lime_output_color());

ProjectConfiguration::getApplicationConfiguration('frontend', 'test', true);
$engine = new FlickrRegexp();

$result = $engine->findResultCount(file_get_contents(dirname(__FILE__).'/flickr.very.much.results.html'));
$t->is($result, 691594, 'Result count has to be 691594 for file flickr.very.much.results.html');

$result = $engine->findResultCount(file_get_contents(dirname(__FILE__).'/flickr.nothing.html'));
$t->is($result, 0, 'Result count has to be 0 for flickr.nothing.html');

$result = $engine->findResultCount(file_get_contents(dirname(__FILE__).'/flickr.armut.html'));
$t->is($result, 3291, 'Result count has to be 3291 for file flickr.armut.html');

function getResult($filename) {
	return file_get_contents(dirname(__FILE__).'/'.$filename);
}