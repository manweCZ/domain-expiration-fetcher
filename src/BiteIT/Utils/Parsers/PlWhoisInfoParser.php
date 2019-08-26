<?php
/**
 * User: Manwe
 */

namespace BiteIT\Utils\Parsers;


class PlWhoisInfoParser extends WhoisInfoParser
{

    public function parseText($text): ?\DateTime
    {
        vd($text);
        preg_match('/renew.*?:\s*([^\n]+)/i', $text, $matches);

        vd($matches);

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