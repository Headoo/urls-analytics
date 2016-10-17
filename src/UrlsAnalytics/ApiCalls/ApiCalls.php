<?php

namespace UrlsAnalytics\ApiCalls;

use \Exception;
/**
 * Get result of an api. 
 * @param array $urls (array of urls)
 * @return array (array of fb api results)
 * Ref : https://developers.facebook.com/docs/reference/fql/link_stat
 */


class ApiCalls implements ApiCallsInterface
{

	protected $apiFormat = "https://free.sharedcount.com/?url=%s&apikey=<YOUR_API_KEY>";

	protected $debug = false;
	protected $limit = 30;
    protected $errors = array();
    protected $appId;
    protected $appSecret;
    
	public function __construct ($format = null, $appId = null, $appSecret = null) {
		if (is_string($format)) {
			$this->apiFormat = $format;
		}

        if (!empty($appId)) {
            $this->appId = $appId;
        }

        if (!empty($appSecret)) {
            $this->appSecret = $appSecret;
        }
	}

	public function setApiFormat($format) {
		$this->apiFormat = $format;
	}

	public function setDebug($level) {
		$this->debug = $level;
	}
	public function setLimit($limit) {
		$this->limit = $limit;
	}

    // Cette fonction peut être consommatrice en temps (file_get_contents) et donc est plutôt destinée à être utilisée en mode console
    public function get(array $urls) {
        $res = array();
        
		if (empty($urls)) {
	    	return false;
        }
		array_splice ($urls, $this->limit);
		
        foreach ($urls as $url) {
			echo ".";

            $query = sprintf($this->apiFormat, urlencode($url));

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

    // deprecated ??
    public function getErrors() {
	    return $this->errors;
    }


}