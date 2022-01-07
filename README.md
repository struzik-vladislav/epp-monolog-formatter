# EPP Formatter

A EPP requests/responses formatter for Monolog. Proposed for hiding authorization information of clients, domains and contacts in logs.

## Usage

```php
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
$handler = new StreamHandler('php://stdout', Logger::DEBUG);
$handler->setFormatter(new EPPFormatter());
$log->pushHandler($handler);

$log->addInfo($message);
/*
[2017-04-30 18:09:28] EPPFormatter DEMO.INFO: <?xml version="1.0" encoding="UTF-8" standalone="no"?>
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
</epp>
*/
```
