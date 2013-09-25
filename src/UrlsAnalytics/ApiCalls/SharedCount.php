<?php

namespace UrlsAnalytics\ApiCalls;
use UrlsAnalytics\UrlsAnalytics;
/**
 * Get result of SharedCount api. 
 * @param array $urls (array of urls)
 * @return array (array of sharedcount api results)
 */


class SharedCount implements UrlsAnalytics
{

	private $debug = false;
    public function get(array $urls) {

        $res = array();
        if (!empty($urls)) {
            foreach ($urls as $url) {
                $query = 'http://api.sharedcount.com/?url='.urlencode($url);

                // TODO : Il faudrait plutot utiliser curl à la place de file_get_contents (plus performant, plus propre. Voir littérature web sur le sujet
				$incoming = file_get_contents($query);

                if ($incoming === false) {
	                return false;
                }

                $incoming = json_decode($incoming, true);
				$res[$url] = $incoming["count"];
			}
		}
		return $res;
	}
}