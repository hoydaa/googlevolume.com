<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');

$t = new lime_test(4, new lime_output_color());

ProjectConfiguration::getApplicationConfiguration('frontend', 'test', true);
$engine = new GoogleRegexp();

$result = $engine->findResultCount(file_get_contents(dirname(__FILE__).'/google.umut.utkan.html'));
$t->is($result, 789, 'Result count has to be 789 for file google.umut.utkan.html');

$result = $engine->findResultCount(file_get_contents(dirname(__FILE__).'/google.less.than.10.html'));
$t->is($result, 1, 'Result count has to be 1 for google.less.than.10.html');

$result = $engine->findResultCount(file_get_contents(dirname(__FILE__).'/google.nothing.html'));
$t->is($result, 0, 'Result count has to be 0 for google.nothing.html');

$result = $engine->findResultCount(file_get_contents(dirname(__FILE__).'/google.very.much.results.html'));
$t->is($result, 95700000, 'Result count has to be 95700000 for google.very.much.results.html');