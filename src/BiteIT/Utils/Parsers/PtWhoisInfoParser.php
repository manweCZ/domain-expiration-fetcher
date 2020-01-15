<?php
/**
 * User: Manwe
 */

namespace BiteIT\Utils\Parsers;


class PtWhoisInfoParser extends WhoisInfoParser
{

    public function parseText($text): ?\DateTime
    {
        preg_match('/Expiration Date: (\d{2})\/(\d{2})\/(\d{4})/i', $text, $matches);

        if($matches){
            return new \DateTime( $matches[1].'.'.$matches[1].'.'.$matches[2] );
        }

        return null;
    }

    public function getTLD(): string
    {
        return 'pt';
    }
}