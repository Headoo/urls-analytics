<?php
namespace UrlsAnalytics\ApiCalls;

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

echo "Welcome to Test";

require_once __DIR__.'/ApiCallsInterface.php';
require_once __DIR__.'/ApiCalls.php';

$urls = ["http://google.com", "http://headoo.com", "http://facebook.com", "BAD_FORMATTED_URL"];

$sharedCount = new ApiCalls('https://free.sharedcount.com/?url=%s&apikey=<YOUR_API_KEY>');

print_r($sharedCount->get($urls));

echo PHP_EOL, 'FIN', PHP_EOL;
