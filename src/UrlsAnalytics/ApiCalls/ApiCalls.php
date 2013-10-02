<?php

namespace UrlsAnalytics\ApiCalls;

/**
 * Get result of an api. 
 * @param array $urls (array of urls)
 * @return array (array of fb api results)
 * Ref : https://developers.facebook.com/docs/reference/fql/link_stat
 */


class ApiCalls implements ApiCallsInterface
{

	const API = "http://api.sharedcount.com/?url=";
	protected $debug = false;
	protected $limit = 30;
    protected $errors = array();
    

    public function get(array $urls) {
        $res = array();
        
		if (empty($urls)) {
	    	return false;
        }
		array_splice ($urls, $this->limit);
		
        foreach ($urls as $url) {

			$c = get_called_class();
            $query = $c::API.urlencode($url);

            // TODO : Il faudrait plutot utiliser curl à la place de file_get_contents (plus performant, plus propre. Voir littérature web sur le sujet
			$incoming = file_get_contents($query);
			echo ".";
            if ($incoming === false) {
                return false;
            }

            $incoming = json_decode($incoming, true);
			$res[$url] = $incoming;
		}
        return $res;
    }

    public function getErrors() {
	    return $this->errors;
    }


}