<?php
/**
 * User: Manwe
 */

namespace BiteIT\Utils\Parsers;


class GeneralWhoisInfoParser extends WhoisInfoParser
{

    public function parseText($text): ?\DateTime
    {
        if(strpos($text, 'NOT FOUND') !== false || strpos($text, 'No Data Found') !== false)
            return null;

        preg_match_all('/(expir|valid|renew|paid\-till).*?:\s*([^\n]+)/i', $text, $matches);

        $match = null;
        if($matches){
            if(is_array($matches[2])){
                foreach ($matches[0] as $i => $text){
                    if(stripos($text, 'date') !== false)
                        $match = $matches[2][$i];
                }

                if(!$match)
                    $match = $matches[2][count($matches[2]) - 1];
            }

            if(!$match)
                $match = $matches[2];
        }

        if($match){
            list($date, ) = explode(' ', $match);
            return new \DateTime( trim($date) );
        }

        return null;
    }

    public function getTLD(): string
    {
        return '_default';
    }
}