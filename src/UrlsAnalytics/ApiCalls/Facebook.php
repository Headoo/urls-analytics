<?php

namespace UrlsAnalytics\ApiCalls;
/**
 * Get result of facebook api. 
 * @param array $urls (array of urls)
 * @return array (array of fb api results)
 * Ref : https://developers.facebook.com/docs/reference/fql/link_stat
 */


class Facebook extends ApiCalls
{

	protected $apiFormat = "http://graph.facebook.com/?fields=og_object{likes.limit(0).summary(true)},share&ids=%s";
	private $step = 400;
    protected $debug = false;
    public function get(array $urls) {
		echo "Entrée dans ".get_class().PHP_EOL;
        $res = array();

        if (empty($urls)) {
			$this->errors[] = "LINE ".__LINE__.' $urls is empty';
	    	return false;
        }
		array_splice ($urls, $this->limit);

        for ($i = 0; $i < count($urls); $i += $this->step) {
            $slices = array_slice($urls, $i, $this->step);

            $gluedUrls = implode(",", $slices);
            $query = sprintf($this->apiFormat, urlencode($gluedUrls));


            if ($this->debug == true) {
				echo  __FILE__.':'.__FUNCTION__.':'.__LINE__.':'.PHP_EOL;
                echo $query.PHP_EOL;
            }

            $incoming = file_get_contents($query);
			echo ".";
            if ($incoming === false) {
				$this->errors[] = "LINE ".__LINE__.'$incoming is false';
	            return false;
            }

            /* 
            TODO : Il faudrait plutot utiliser curl à la place de file_get_contents (plus performant, plus propre. Voir littérature web sur le sujet
            
            Exemple de query : 
            http://graph.facebook.com/?ids=http://apple.com,http://microsoft.com,http://developers.facebook.com/,http://headoo.com/fr/photo/19024?access_token=b4b849663771ef2163bba64b69a55b3f
            */

            $incoming = json_decode($incoming, true);
            // On ne fait le merge que si facebook ne retourne pas une erreur
            // Si erreur

            if (isset($incoming["error"])) {
                // Si le step est au dessus de 1, on va appeler cette fonction pour notre slices avec un step de 1
                if ($this->step > 1) {
                    $chunk = $this->get($slices, 1);
					//  $res = array_merge($res, $chunk); array_merge is too slow. Keys are not numeric
                    foreach ($chunk as $value) {
                        $res[$value["url"]] = $value;
                    }
                    

                /* Si step est à 1, on a trouvé l'URL qui déconne. 
                 Si  chunk contient au moins 2 urls, on la répare
                 Sinon, on ne fera rien, on laisse tomber cette url et on passe à la suivante;
                 */
                } elseif (count($urls) > 1) {
                    file_get_contents("https://developers.facebook.com/tools/debug/og/object?q=".$slices[0]);
                    $unit = $this->get($slices, 1);
                    // $res = array_merge($res, $unit); array_merge is too slow. Keys are not numeric
                    foreach ($unit as $value) {
                        $res[$value["url"]] = $value;
                    }
                } else {
                    // On ne fait rien
                }
            // Si pas d'erreur retournée par facebook, on merge.
            } else {
                return $incoming;
            }
		}
		return $res;
    }
    
    public function setStep($step) {
    	$this->step = $step;
    }
}