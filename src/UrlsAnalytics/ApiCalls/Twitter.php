<?php

namespace UrlsAnalytics\ApiCalls;

/**
 * Get result of twitter api. 
 * @param array $urls (array of urls)
 * @return array (array of fb api results)
 */


class Twitter extends ApiCalls
{

	protected $apiFormat = "http://tweetcount.io/api/url?url=%s";

	
}