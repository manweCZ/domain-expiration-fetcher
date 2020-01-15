<?php
/**
 * User: Manwe
 */

namespace BiteIT\Utils\Parsers;


class PlWhoisInfoParser extends WhoisInfoParser
{

    public function parseText($text): ?\DateTime
    {
        preg_match('/renew.*?:\s*([^\n]+)/i', $text, $matches);

        if($matches){
            list($date, $time) = explode(' ', trim($matches[1]));

            return new \DateTime( str_replace('.', '-', $date) );
        }

        return null;
    }

    public function getTLD(): string
    {
        return 'pl';
    }
}