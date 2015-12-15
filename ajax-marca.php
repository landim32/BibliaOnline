<?php
require('config.inc.php');
require('core/mysql-parser.inc.php');
require('core/function.inc.php');
require('core/Biblia.inc.php');
require('core/Usuario.inc.php');

session_start();

//var_dump($_POST);

$regraUsuario = new Usuario();
$versiculo = explode(':', $_POST['versiculo']);
$tipo = intval($_POST['tipo']);
$id_livro = $versiculo[0];
$id_capitulo = $versiculo[1];
$num_versiculo = $versiculo[2];
//var_dump($id_livro, $id_capitulo, $num_versiculo);
echo ($regraUsuario->marcar($id_livro, $id_capitulo, $num_versiculo, $tipo)) ? '1' : '0';
exit();
/*
$regraBiblia = new Biblia();
$id_versao = $regraBiblia->pegarIdVersao();
$versiculos = $regraBiblia->autoCompletarVersiculo($id_versao, $_REQUEST['palavra']);
echo json_encode($versiculos);
exit();
 */

