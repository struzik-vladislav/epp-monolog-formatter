<?php

namespace Struzik\EPPMonolog\Formatter;

use Monolog\Formatter\LineFormatter;
use Monolog\LogRecord;

class EPPFormatter extends LineFormatter
{
    /**
     * {@inheritdoc}
     */
    public function format(LogRecord $record): string
    {
        $line = parent::format($record);

        // Hide client's authorization information
        $line = preg_replace('/(<pw>)(.*)(<\/pw>)/iu', '${1}*****${3}', $line);
        $line = preg_replace('/(<newPW>)(.*)(<\/newPW>)/iu', '${1}*****${3}', $line);
        // Hide authorization information associated with the domain object
        $line = preg_replace('/(<domain:pw>)(.*)(<\/domain:pw>)/iu', '${1}*****${3}', $line);
        $line = preg_replace('/(<domain:ext>)(.*)(<\/domain:ext>)/iu', '${1}*****${3}', $line);
        // Hide authorization information associated with the contact object
        $line = preg_replace('/(<contact:pw>)(.*)(<\/contact:pw>)/iu', '${1}*****${3}', $line);
        $line = preg_replace('/(<contact:ext>)(.*)(<\/contact:ext>)/iu', '${1}*****${3}', $line);

        return $line;
    }
}
