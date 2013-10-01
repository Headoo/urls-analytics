<?php

namespace UrlsAnalytics\ApiCalls;
/**
 * Get result of facebook api. 
 * @param array $urls (array of urls)
 * @return array (array of fb api results)
 * Ref : https://developers.facebook.com/docs/reference/fql/link_stat
 */


class Facebook extends ApiCalls implements ApiCallsInterface
{

	private $step = 400;
    
    public function get(array $urls) {

        $res = array();

        if (empty($urls)) {
			$this->errors[] = "LINE ".__LINE__.' $urls is empty';
	    	return false;
        }
		$urls = array_splice ($urls, $this->limit);

        for ($i = 0; $i < count($urls); $i += $this->step) {
            $slices = array_slice($urls, $i, $this->step);

            $query = 'SELECT url, normalized_url, share_count, like_count, comment_count, total_count, commentsbox_count, comments_fbid, click_count FROM link_stat WHERE url in ';

            $gluedUrls = implode('","', $slices);
            $query .= '("'.$gluedUrls.'")';
            $query = 'https://api.facebook.com/method/fql.query?format=json&query='.urlencode($query);

            if ($this->debug == true) {
                echo $query;
            }

            $incoming = file_get_contents($query);
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
                    foreach ($chunk as $key => $value) {
                        $res[$key] = $value;
                    }
                    

                /* Si step est à 1, on a trouvé l'URL qui déconne. 
                 Si  chunk contient au moins 2 urls, on la répare
                 Sinon, on ne fera rien, on laisse tomber cette url et on passe à la suivante;
                 */
                } elseif (count($urls) > 1) {
                    file_get_contents("https://developers.facebook.com/tools/debug/og/object?q=".$url);
                    $unit = $this->get(array($url), 1);
                    // $res = array_merge($res, $unit); array_merge is too slow. Keys are not numeric
                    foreach ($unit as $key => $value) {
                        $res[$key] = $value;
                    }
                } else {
                    // On ne fait rien
                }
            // Si pas d'erreur retournée par facebook, on merge.
            } else {
                // $res = array_merge($res, $incoming); array_merge is too slow. Keys are not numeric
				foreach ($incoming as $key => $value) {
                    $res[$key] = $value;
                }
            }
		}
		return $res;
    }
    
    public function setStep($step) {
    	$this->step = $step;
    }
    
    public function getErrors() {
	    return $this->errors;
    }

}