<?php

namespace Struzik\EPPMonolog\Formatter;

use Monolog\Formatter\LineFormatter;
use Monolog\Level;
use Monolog\LogRecord;
use PHPUnit\Framework\TestCase;

class EPPFormatterTest extends TestCase
{
    /**
     * @covers \Struzik\EPPMonolog\Formatter\EPPFormatter::format
     */
    public function testHideDomainAuthInfo(): void
    {
        $xmlInput = <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
    <command>
        <info>
            <domain:info xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                <domain:name hosts="all">example.com</domain:name>
                <domain:authInfo>
                    <domain:pw>2fooBAR</domain:pw>
                </domain:authInfo>
            </domain:info>
        </info>
        <clTRID>ABC-12345</clTRID>
    </command>
</epp>
XML;
        $xmlOutput = <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
    <command>
        <info>
            <domain:info xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                <domain:name hosts="all">example.com</domain:name>
                <domain:authInfo>
                    <domain:pw>*****</domain:pw>
                </domain:authInfo>
            </domain:info>
        </info>
        <clTRID>ABC-12345</clTRID>
    </command>
</epp>
XML;
        $eppFormatter = new EPPFormatter('%message%');
        $eppMessage = $eppFormatter->format(new LogRecord(new \DateTimeImmutable(), 'default', Level::Debug, $xmlInput));

        $lineFormatter = new LineFormatter('%message%');
        $lineMessage = $lineFormatter->format(new LogRecord(new \DateTimeImmutable(), 'default', Level::Debug, $xmlOutput));

        $this->assertEquals($lineMessage, $eppMessage);
    }

    /**
     * @covers \Struzik\EPPMonolog\Formatter\EPPFormatter::format
     */
    public function testHideContactAuthInfo(): void
    {
        $xmlInput = <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
    <command>
        <info>
            <contact:info xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
                <contact:id>sh8013</contact:id>
                <contact:authInfo>
                    <contact:pw>2fooBAR</contact:pw>
                </contact:authInfo>
            </contact:info>
        </info>
        <clTRID>ABC-12345</clTRID>
    </command>
</epp>
XML;
        $xmlOutput = <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
    <command>
        <info>
            <contact:info xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
                <contact:id>sh8013</contact:id>
                <contact:authInfo>
                    <contact:pw>*****</contact:pw>
                </contact:authInfo>
            </contact:info>
        </info>
        <clTRID>ABC-12345</clTRID>
    </command>
</epp>
XML;
        $eppFormatter = new EPPFormatter('%message%');
        $eppMessage = $eppFormatter->format(new LogRecord(new \DateTimeImmutable(), 'default', Level::Debug, $xmlInput));

        $lineFormatter = new LineFormatter('%message%');
        $lineMessage = $lineFormatter->format(new LogRecord(new \DateTimeImmutable(), 'default', Level::Debug, $xmlOutput));

        $this->assertEquals($lineMessage, $eppMessage);
    }

    /**
     * @covers \Struzik\EPPMonolog\Formatter\EPPFormatter::format
     */
    public function testHideClientsAuthInfo(): void
    {
        $xmlInput = <<<'XML'
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
        $xmlOutput = <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
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
XML;
        $eppFormatter = new EPPFormatter('%message%');
        $eppMessage = $eppFormatter->format(new LogRecord(new \DateTimeImmutable(), 'default', Level::Debug, $xmlInput));

        $lineFormatter = new LineFormatter('%message%');
        $lineMessage = $lineFormatter->format(new LogRecord(new \DateTimeImmutable(), 'default', Level::Debug, $xmlOutput));

        $this->assertEquals($lineMessage, $eppMessage);
    }
}
