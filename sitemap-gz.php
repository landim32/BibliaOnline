<?php

require('common.inc.php');

$regraBiblia = new Biblia();

//header('Content-type: text/xml; charset=UTF-8');

$xml = $regraBiblia->gerarXML();
$data = $xml->outputMemory(TRUE);
$supportsGzip = strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false;
ob_start();
if ($supportsGzip) {
    echo gzencode(trim(preg_replace('/\s+/', ' ', $data)), 9);
} else {
    echo $data;
}
$content = ob_get_contents();
header("content-type: text/html; charset: UTF-8");
header("cache-control: must-revalidate");
$offset = 60 * 60;
$expire = "expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
header($expire);
header('Content-Length: ' . strlen($content));
header('Vary: Accept-Encoding');
ob_end_clean();
echo $content;
