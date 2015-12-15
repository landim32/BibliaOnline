<?php
require('config.inc.php');
require('core/mysql-parser.inc.php');
require('core/function.inc.php');
require('core/Biblia.inc.php');

$regraBiblia = new Biblia();
$id_versao = $regraBiblia->pegarIdVersao();
$versiculos = $regraBiblia->autoCompletarVersiculo($id_versao, $_REQUEST['palavra']);
echo json_encode($versiculos);
exit();

