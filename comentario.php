<?php 
require('common.inc.php'); 

$regraBiblia = new Biblia();
$regraComentario = new Comentario();

if (count($_POST) > 0) {
    $comentario = $regraComentario->pegarDoPost();
    $regraComentario->inserir($comentario);
}

$id_comentario = intval($_GET['id']);
$_comentario = $regraComentario->pegar($id_comentario);
$GLOBALS['_comentarios'] = $_comentario->comentarios;
?>
<?php require('header.inc.php'); ?>
<?php require('menu-principal.inc.php'); ?>
<?php require('comentarioModal.inc.php'); ?>
<div class="container" style="margin-top: 80px">
    <div class="row">
        <div class="col-md-8">
            <?php //var_dump($_comentario); ?>
            <h1>
                <div class="pull-right">
                    <span class='st_sharethis_large' displayText='ShareThis'></span>
                    <span class='st_facebook_large' displayText='Facebook'></span>
                    <span class='st_twitter_large' displayText='Tweet'></span>
                    <span class='st_linkedin_large' displayText='LinkedIn'></span>
                    <span class='st_pinterest_large' displayText='Pinterest'></span>
                    <span class='st_email_large' displayText='Email'></span>
                </div>
                Comentário
            </h1>
            <div class="clearfix"></div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <blockquote>
                        <p style="font-size: 150%;"><?php echo $_comentario->texto; ?></p>
                        <p><small><?php echo $_comentario->nome; ?></small></p>
                    </blockquote>
                </div><!--panel-body-->
            </div><!--panel-->
            
            <?php //require('comentario.inc.php'); ?>
            <?php require('comentarios.inc.php'); ?>
        </div>
        <div class="col-md-4">
            <?php if (count($_comentario->versiculos) > 0) : ?>
            <h3>Versículos</h3>
            <?php $i = 0; ?>
            <?php foreach ($_comentario->versiculos as $versiculo) : ?>
            <div class="row">
                <div class="col-md-12" style="<?php echo ($i % 2 == 0) ? 'background: #fff' : 'background: #eee'; ?>">
                    <div>
                        <a href="<?php echo '/'.VERSAO.'/'.TESTAMENTO.'/'.$versiculo->id_livro.'/'.$versiculo->id_capitulo.'/'.$versiculo->num_versiculo; ?>">
                            "<?php echo $versiculo->texto; ?>"
                        </a>
                    </div>
                    <div class="text-right">
                        <a href="<?php echo '/'.VERSAO.'/'.TESTAMENTO.'/'.$versiculo->id_livro.'/'.$versiculo->id_capitulo.'/'.$versiculo->num_versiculo; ?>">
                            <?php echo $versiculo->versiculo; ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php $i++; ?>
            <?php endforeach; ?>
            <hr />
            <?php endif; ?>
            <?php include('banner.inc.php'); ?>
        </div>
    </div>
</div>
<?php require('footer.inc.php'); ?>