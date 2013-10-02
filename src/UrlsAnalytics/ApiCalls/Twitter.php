<?php

namespace UrlsAnalytics\ApiCalls;

/**
 * Get result of twitter api. 
 * @param array $urls (array of urls)
 * @return array (array of fb api results)
 */


class Twitter extends ApiCalls
{

	const API = 'http://urls.api.twitter.com/1/urls/count.json?url=';
	
}