# EPP Formatter
![Build Status](https://github.com/struzik-vladislav/epp-monolog-formatter/actions/workflows/ci.yml/badge.svg?branch=master)
[![Latest Stable Version](https://img.shields.io/github/v/release/struzik-vladislav/epp-monolog-formatter?sort=semver&style=flat-square)](https://packagist.org/packages/struzik-vladislav/epp-monolog-formatter)
[![Total Downloads](https://img.shields.io/packagist/dt/struzik-vladislav/epp-monolog-formatter?style=flat-square)](https://packagist.org/packages/struzik-vladislav/epp-monolog-formatter/stats)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![StandWithUkraine](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/badges/StandWithUkraine.svg)](https://github.com/vshymanskyy/StandWithUkraine/blob/main/docs/README.md)

A EPP requests/responses formatter for Monolog. Proposed for hiding authorization information of clients, domains and contacts in logs.

## Usage

```php
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Struzik\EPPMonolog\Formatter\EPPFormatter;

$message = <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
    <command>
        <login>
            <clID>ClientX</clID>
            <pw>foo-BAR2</pw>
            <newPW>bar-FOO2</newPW>
            <options>
                <version>1.0</version>
                <lang>en</lang>
            </options>
            <svcs>
                <objURI>urn:ietf:params:xml:ns:obj1</objURI>
                <objURI>urn:ietf:params:xml:ns:obj2</objURI>
                <objURI>urn:ietf:params:xml:ns:obj3</objURI>
                <svcExtension>
                    <extURI>http://custom/obj1ext-1.0</extURI>
                </svcExtension>
            </svcs>
        </login>
        <clTRID>ABC-12345</clTRID>
    </command>
</epp>
XML;

$log = new Logger('EPPFormatter DEMO');
$handler = new StreamHandler('php://stdout', Level::Debug);
$handler->setFormatter(new EPPFormatter(allowInlineLineBreaks: true));
$log->pushHandler($handler);

$log->info($message);
/*
[2023-08-22T21:02:54.922492+03:00] EPPFormatter DEMO.INFO: <?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
    <command>
        <login>
            <clID>ClientX</clID>
            <pw>*****</pw>
            <newPW>*****</newPW>
            <options>
                <version>1.0</version>
                <lang>en</lang>
            </options>
            <svcs>
                <objURI>urn:ietf:params:xml:ns:obj1</objURI>
                <objURI>urn:ietf:params:xml:ns:obj2</objURI>
                <objURI>urn:ietf:params:xml:ns:obj3</objURI>
                <svcExtension>
                    <extURI>http://custom/obj1ext-1.0</extURI>
                </svcExtension>
            </svcs>
        </login>
        <clTRID>ABC-12345</clTRID>
    </command>
</epp> [] []
*/
```
