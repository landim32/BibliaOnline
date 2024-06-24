<?php
require('config.inc.php');
require('core/mysql-parser.inc.php');
require('core/function.inc.php');
require('core/Biblia.inc.php');
require('core/Usuario.inc.php');
require('core/Comentario.inc.php');

$timeout = 60 * 60 * 24 * 30; // 30 dias
@ini_set('session.gc_maxlifetime', $timeout);
@ini_set('session.cookie_lifetime', $timeout);
session_cache_expire($timeout);
session_set_cookie_params($timeout);
session_start();
//unset($_SESSION['usuario_atual']);

$regraBiblia = new Biblia();
$regraUsuario = new Usuario();

define('ID_VERSAO', $regraBiblia->pegarIdVersao());
define('ID_TESTAMENTO', $regraBiblia->pegarIdTestamento());
define('VERSAO', $regraBiblia->pegarVersao());
define('TESTAMENTO', $regraBiblia->pegarTestamento());

$id_livro = $regraBiblia->pegarIdLivro();
if ($id_livro > 0)
    define('ID_LIVRO', $id_livro);

$id_capitulo = $regraBiblia->pegarIdCapitulo();
if ($id_capitulo > 0)
    define('ID_CAPITULO', $id_capitulo);

$num_versiculo = intval($_GET['versiculo']);
if ($num_versiculo > 0) {
    define('NUM_VERSICULO', $num_versiculo);
    $GLOBALS['_versiculo'] = $regraBiblia->pegarVersiculo(ID_VERSAO, ID_LIVRO, ID_CAPITULO, NUM_VERSICULO);
}



if (count($_POST) > 0) {
    if (array_key_exists('acao', $_POST)) {
        if ($_POST['acao'] == 'logar') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $usuario = $regraUsuario->logar($email, $senha);
            if (is_null($usuario)) {
                $GLOBALS['msgerro'] = 'Email ou senha inválida!';
            }
        }
    }
}