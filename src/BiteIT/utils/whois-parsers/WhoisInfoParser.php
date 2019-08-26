<?php
/**
 * User: Manwe
 */

namespace BiteIT\Utils\WhoisParsers;


abstract class WhoisInfoParser
{
    abstract public function parseText($text): ?\DateTime;
    abstract public function getTLD(): string;
}