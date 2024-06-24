<?php 
require('common.inc.php'); 

$regraUsuario = new Usuario();
$regraBiblia = new Biblia();
$regraComentario = new Comentario();

if (array_key_exists('excluir', $_GET)) {
    $id_comentario = intval($_GET['excluir']);
    $regraComentario->excluir($id_comentario);
    header('Location: /comentario');
    exit();
}

$usuario = $regraUsuario->pegarAtual();
if (!is_null($usuario)) {
    $id_usuario = $usuario->id_usuario;
    $comentarios = $regraComentario->listarPorUsuario($id_usuario);
}

?>
<?php require('header.inc.php'); ?>
<?php require('menu-principal.inc.php'); ?>
<div class="container" style="margin-top: 80px">
    <div class="row">
        <div class="col-md-9">
            <h2>Comentários</h2>
            <?php $i = 0; ?>
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <td>Comentário</td>
                        <td class="text-right">Opções</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comentarios as $comentario) : ?>
                    <tr>
                        <td>
                            <p><a href="/comentario/<?php echo $comentario->id_comentario; ?>"><?php echo $comentario->texto; ?></a></p>
                            <?php foreach ($comentario->versiculos as $versiculo) : ?>
                            <span class="label label-default"><?php echo $versiculo->versiculo; ?></span>
                            <?php endforeach; ?><br />
                        </td>
                        <td class="text-right" style="min-width: 150px">
                            <a href="/comentario?excluir=<?php echo $comentario->id_comentario; ?>"><i class="icon icon-remove"></i> Remover</a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php //echo '<pre>'; var_dump($comentarios); echo '</pre>'; ?>
        </div>
        <div class="col-md-3">
            <?php //require('login.inc.php'); ?>
            <?php require('banner.inc.php'); ?>
        </div>
    </div>
</div>
<?php require('footer.inc.php'); ?>