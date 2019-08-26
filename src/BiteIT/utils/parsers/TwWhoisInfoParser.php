<?php
/**
 * User: Manwe
 */

namespace BiteIT\Utils\Parsers;


class TwWhoisInfoParser extends WhoisInfoParser
{

    public function parseText($text): ?\DateTime
    {
        preg_match('/expires on (\d{4}\-\d{2}\-\d{2})/i', $text, $matches);

        if($matches){
            $date = trim($matches[1]);

            return new \DateTime( $date );
        }

        return null;
    }

    public function getTLD(): string
    {
        return 'tw';
    }
}