<?php

require('common.inc.php');

$regraBiblia = new Biblia();

header('Content-type: text/xml; charset=UTF-8');

$xml = $regraBiblia->gerarXML();
echo $xml->outputMemory(true);
