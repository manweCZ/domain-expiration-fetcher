Fetches Domain Expiration information from WHOIS servers

**Usage:**

```php
$ds = new \BiteIT\Utils\DomainExpirationFetcher();
if($ds->canFetchInfoAbout('com'){
    $date = $ds->fetchExpirationDate($domain);
    var_dump($date);
}
```

There are certain WHOIS servers that do not publish expiration dates, they are specified in DomainExpirationFetcher::TLDS_WITH_NO_INFO, and as of this date I found out these are the TLDs:
'de', 'eu', 'at', 'bg', 'cy', 'es', 'gr', 'hu', 'ch',
                                'be', 'lu', 'lv', 'ph', 'no', 'name', 'kz', 'ge', 'az' 

If you want to customize any parser or add your own, check WhoisInfoParser.php abstract class and its implementation in whois-parsers folders.
You can then set the parser by using
```php
$ds->setWhoisParser($instanceOfMyParser, 'mytld')
```
