<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');

$t = new lime_test(4, new lime_output_color());

ProjectConfiguration::getApplicationConfiguration('frontend', 'test', true);
$hitFetcher = new GoogleHitFetcher();

$hit = $hitFetcher->extractHit(file_get_contents(dirname(__FILE__).'/google.umut.utkan.html'));
$t->is($hit, 789, 'Result count has to be 789 for file google.umut.utkan.html');

$hit = $hitFetcher->extractHit(file_get_contents(dirname(__FILE__).'/google.less.than.10.html'));
$t->is($hit, 1, 'Result count has to be 1 for google.less.than.10.html');

$hit = $hitFetcher->extractHit(file_get_contents(dirname(__FILE__).'/google.nothing.html'));
$t->is($hit, 0, 'Result count has to be 0 for google.nothing.html');

$hit = $hitFetcher->extractHit(file_get_contents(dirname(__FILE__).'/google.very.much.results.html'));
$t->is($hit, 95700000, 'Result count has to be 95700000 for google.very.much.results.html');