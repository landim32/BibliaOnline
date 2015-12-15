<?php 
require('common.inc.php'); 

$regraUsuario = new Usuario();
$regraBiblia = new Biblia();
$regraComentario = new Comentario();

//$livro = $regraBiblia->pegarLivro(ID_LIVRO);
//$capitulos = $regraBiblia->listarCapitulo(ID_VERSAO, ID_LIVRO);
$usuario = $regraUsuario->pegarAtual();
if (!is_null($usuario))
    $id_usuario = $usuario->id_usuario;

switch($_GET['tipo']) {
    case 'favoritos':
        $titulo = 'Meus Versículos Favoritos';
        $tipo = MARCA_FAVORITO;
        $versiculos = $regraBiblia->listarMarcado($id_usuario, $tipo);
        break;
    case 'gostei':
        $titulo = 'Versículos que mais gosto';
        $tipo = MARCA_GOSTEI;
        $versiculos = $regraBiblia->listarMarcado($id_usuario, $tipo);
        break;
    case 'desgostei':
        $titulo = 'Versículos que não gosto';
        $tipo = MARCA_DESGOSTEI;
        $versiculos = $regraBiblia->listarMarcado($id_usuario, $tipo);
        break;
    case 'comentarios':
        $titulo = 'Meus comentários';
        $versiculos = $regraComentario->listarPorUsuario($id_usuario);
        break;
}

?>
<?php require('header.inc.php'); ?>
<?php require('menu-principal.inc.php'); ?>
<div class="container" style="margin-top: 80px">
    <div class="row">
        <div class="col-md-9">
            <h2><?php echo $titulo; ?></h2>
            <?php $i = 0; ?>
            <?php foreach ($versiculos as $versiculo) : ?>
            <div class="row" style="<?php echo ($i % 2 == 0) ? 'background: #fff' : 'background: #eee'; ?>">
                <div class="col-md-9" style="font-size: 140%; margin: 10px 0px 20px 0px">
                    <p><?php echo $versiculo->texto; ?></p>
                </div>
                <div class="col-md-3 text-right" style="margin: 12px 0px">
                    <?php versiculo_opcao($versiculo); ?><br />
                    <a href="<?php echo '/'.VERSAO.'/'.TESTAMENTO.'/'.$versiculo->id_livro.'/'.$versiculo->id_capitulo.'/'.$versiculo->num_versiculo; ?>"><?php echo $versiculo->versiculo; ?></a>
                </div>
            </div>
            <?php $i++; ?>
            <?php endforeach; ?>
        </div>
        <div class="col-md-3">
            <?php //require('login.inc.php'); ?>
            <?php require('banner.inc.php'); ?>
        </div>
    </div>
</div>
<?php require('footer.inc.php'); ?>