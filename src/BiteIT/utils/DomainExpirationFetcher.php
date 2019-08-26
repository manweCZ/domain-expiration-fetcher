<?php
/**
 * User: Manwe
 */

namespace BiteIT\Utils;

use BiteIT\Utils\WhoisParsers\GeneralWhoisInfoParser;
use BiteIT\Utils\WhoisParsers\WhoisInfoParser;
use Iodev\Whois\Modules\Tld\Parsers\CommonParser;
use Iodev\Whois\Modules\Tld\TldServer;
use Iodev\Whois\Whois;

class DomainExpirationFetcher
{
    protected $whois;
    protected $parsers = [];

    const TLDS_WITH_NO_INFO = ['de', 'eu', 'at', 'bg', 'cy', 'es', 'gr', 'hu', 'ch', 'be', 'lu', 'lv', 'ph', 'no', 'name', 'kz', 'ge',
                        'az'];

    public function canFetchInfoAbout($tld){
        return in_array($tld, static::TLDS_WITH_NO_INFO);
    }

    public function __construct(){
        $this->whois = Whois::create();
        $tldServers = [
            new TldServer('.band', 'whois.1api.net', false, new CommonParser()),
            new TldServer('.golf', 'whois.nic.golf', false, new CommonParser()),
            new TldServer('.pt', 'whois.dns.pt', false, new CommonParser()),
            new TldServer('.eco', 'whois.nic.eco', false, new CommonParser()),
            new TldServer('.art', 'whois.nic.art', false, new CommonParser()),
            new TldServer('.rent', 'whois.nic.rent', false, new CommonParser()),
            new TldServer('.store', 'whois.nic.store', false, new CommonParser()),
            new TldServer('.archi', 'whois.afilias.net', false, new CommonParser()),
            new TldServer('.dance', 'whois.nic.dance', false, new CommonParser()),
        ];
        $this->whois->getTldModule()->addServers($tldServers);
        $this->loadParser();
    }

    protected function loadParser($tld = null){
        if(!$tld)
        {
            require_once __DIR__ . '/whois-parsers/GeneralWhoisInfoParser.php';
            $this->parsers['_default'] = new GeneralWhoisInfoParser();
            return true;
        }

        $tld = ucfirst($tld);
        $className = 'BiteIT\\Utils\\WhoisParsers\\'.$tld.'WhoisInfoParser';
        if(!class_exists($className))
        {
            if (file_exists(__DIR__ . '/whois-parsers/' . $tld . 'WhoisInfoParser.php'))
            {
                require_once __DIR__ . '/whois-parsers/' . $tld . 'WhoisInfoParser.php';
            }
        }

        if(!class_exists($className))
            return false;

        /** @var WhoisInfoParser $obj */
        $obj = new $className();
        $this->parsers[ $obj->getTLD() ] = $obj;
        return true;
    }

    public function setWhoisParser(WhoisInfoParser $parser, $tld){
        $this->parsers[$tld] = $parser;
    }

    /**
     * @param $tld
     * @return WhoisInfoParser
     */
    protected function getWhoisParser($tld){
        if(!isset($this->parsers[$tld])){
            $this->loadParser($tld);
        }

        return $this->parsers[$tld] ?? $this->parsers['_default'];
    }

    protected function getTLD($domain){
        return substr( $domain, strrpos($domain, '.')+1 );
    }

    public function fetchExpirationDate($domain){
        $tld = $this->getTLD($domain);
        if( in_array($tld, static::TLDS_WITH_NO_INFO) )
            return null;

        $text = $this->whois->lookupDomain($domain);
        $parser = $this->getWhoisParser( $tld );
        return $parser->parseText($text->getText());
    }
}