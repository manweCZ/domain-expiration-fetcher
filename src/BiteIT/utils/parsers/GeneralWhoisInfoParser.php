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

        if($matches){
            if(is_array($matches[2])){
                foreach ($matches[0] as $i => $text){
                    if(stripos($text, 'date') !== false)
                        return new \DateTime( $matches[2][$i] );
                }

                return new \DateTime( $matches[2][ count($matches[2])-1 ] );
            }

            return new \DateTime( $matches[2] );
        }

        return null;
    }

    public function getTLD(): string
    {
        return '_default';
    }
}