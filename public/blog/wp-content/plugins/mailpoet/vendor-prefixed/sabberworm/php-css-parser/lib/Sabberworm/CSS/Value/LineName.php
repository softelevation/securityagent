<?php

namespace MailPoetVendor\Sabberworm\CSS\Value;

if (!defined('ABSPATH')) exit;


use MailPoetVendor\Sabberworm\CSS\Parsing\ParserState;
use MailPoetVendor\Sabberworm\CSS\Parsing\UnexpectedTokenException;
class LineName extends \MailPoetVendor\Sabberworm\CSS\Value\ValueList
{
    public function __construct($aComponents = array(), $iLineNo = 0)
    {
        parent::__construct($aComponents, ' ', $iLineNo);
    }
    public static function parse(\MailPoetVendor\Sabberworm\CSS\Parsing\ParserState $oParserState)
    {
        $oParserState->consume('[');
        $oParserState->consumeWhiteSpace();
        $aNames = array();
        do {
            if ($oParserState->getSettings()->bLenientParsing) {
                try {
                    $aNames[] = $oParserState->parseIdentifier();
                } catch (\MailPoetVendor\Sabberworm\CSS\Parsing\UnexpectedTokenException $e) {
                }
            } else {
                $aNames[] = $oParserState->parseIdentifier();
            }
            $oParserState->consumeWhiteSpace();
        } while (!$oParserState->comes(']'));
        $oParserState->consume(']');
        return new \MailPoetVendor\Sabberworm\CSS\Value\LineName($aNames, $oParserState->currentLine());
    }
    public function __toString()
    {
        return $this->render(new \MailPoetVendor\Sabberworm\CSS\OutputFormat());
    }
    public function render(\MailPoetVendor\Sabberworm\CSS\OutputFormat $oOutputFormat)
    {
        return '[' . parent::render(\MailPoetVendor\Sabberworm\CSS\OutputFormat::createCompact()) . ']';
    }
}
