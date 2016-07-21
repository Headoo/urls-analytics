<?php

namespace UrlsAnalytics\ApiCalls;

use \Exception;

/**
 * Get result of twitter api. 
 * @param array $urls (array of urls)
 * @return array (array of fb api results)
 */


class Twitter extends ApiCalls
{

	protected $apiFormat = "http://tweetcount.io/api/url?url=%s";
    // exemple http://tweetcount.io/api/url?url=ef0bdd815d2a39741c4c30842b7f9488 on passe uniquement access_token


    public function get(array $urls) {
        $res = array();
        
		if (empty($urls)) {
	    	return false;
        }
		array_splice ($urls, $this->limit);
		
        foreach ($urls as $url) {
			echo ".";
            parse_str(parse_url($url, PHP_URL_QUERY), $output);
            $query = sprintf($this->apiFormat, $output['access_token']);

            // TODO : Il faudrait plutot utiliser curl à la place de file_get_contents (plus performant, plus propre. Voir littérature web sur le sujet
            try {
    			$incoming = @file_get_contents($query);
            } catch (Exception $e) {
    			$res[$url] = ['error' => $e];
    			continue;
            }
            if ($incoming === false) {
                $e = new Exception(sprintf('file_get_contents(%s) is false', $query));
                $res[$url] = ['error' => $e];
                continue;
            }

            $incoming = json_decode($incoming, true);
			$res[$url] = $incoming;
		}
        return $res;
    }



	
}
