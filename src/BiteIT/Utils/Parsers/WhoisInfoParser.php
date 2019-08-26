<?php
/**
 * User: Manwe
 */

namespace BiteIT\Utils\Parsers;


abstract class WhoisInfoParser
{
    abstract public function parseText($text): ?\DateTime;
    abstract public function getTLD(): string;
}