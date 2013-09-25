<?php

namespace UrlsAnalytics\ApiCalls;
use UrlsAnalytics\UrlsAnalytics;
use \ErrorException ;

/**
 * Get result of twitter api. 
 * @param array $urls (array of urls)
 * @return array (array of fb api results)
 */


class Twitter implements UrlsAnalytics
{

	private $limit = 100;
	
    public function get(array $urls) {
        $res = array();
        
		if (empty($urls)) {
	    	return false;
        }
		$urls = splice ($urls, $this->limit);
		
        foreach ($urls as $url) {
            $query = 'http://urls.api.twitter.com/1/urls/count.json?url='.urlencode($url);

            // TODO : Il faudrait plutot utiliser curl à la place de file_get_contents (plus performant, plus propre. Voir littérature web sur le sujet
			$incoming = file_get_contents($query);

            if ($incoming === false) {
                return false;
            }

            $incoming = json_decode($incoming, true);
			$res[$url] = $incoming["count"];
		}
        /*
        Exemple de resultat :
        array(2) {
          [0]=>
          array(2) {
            ["count"]=>
            int(0)
            ["url"]=>
            string(95) "http://local.headoo.com/app_dev.php/fr/photo/211/?access_token=03ab28298b35c1d3d400fa543239b464"
          }
          [1]=>
          array(2) {
            ["count"]=>
            int(2)
            ["url"]=>
            string(95) "http://local.headoo.com/app_dev.php/fr/photo/213/?access_token=914d8b31e8fbd5dccce08ef7b6287121"
          }
        */

        return $res;
    }
}