<?php 
require('common.inc.php'); 

$versiculo = $GLOBALS['_versiculo'];

$regraBiblia = new Biblia();

if (count($_POST) > 0) {
    $regraComentario = new Comentario();
    $comentario = $regraComentario->pegarDoPost();
    $regraComentario->inserir($comentario);
}

$livro = $regraBiblia->pegarLivro(ID_LIVRO);
$capitulos = $regraBiblia->listarCapitulo(ID_VERSAO, ID_LIVRO);
$versiculos = $regraBiblia->listarVersiculo(ID_VERSAO, ID_LIVRO, ID_CAPITULO);

$numVersiculos = array();
foreach ($versiculos as $versiculo)
    $numVersiculos[] = $versiculo->num_versiculo;

//$versiculo = $regraBiblia->pegarVersiculo(ID_VERSAO, ID_LIVRO, ID_CAPITULO, NUM_VERSICULO);

$outrasVersoes = $regraBiblia->listarVersiculoVersao(ID_VERSAO, ID_LIVRO, ID_CAPITULO, NUM_VERSICULO);

define('NOME_VERSICULO', $livro->nome.' '.ID_CAPITULO.':'.$num_versiculo);

?>
<?php require('header.inc.php'); ?>
<?php require('menu-principal.inc.php'); ?>
<?php require('comentarioModal.inc.php'); ?>
<div class="container" style="margin-top: 80px">
    <div class="row">
        <div class="col-md-8">
            <h1 class="text-center">
                <?php if (($num_versiculo - 1) > 0) : ?>
                <div class="pull-left">
                    <a class="btn btn-primary" href="<?php echo '/'.VERSAO.'/'.TESTAMENTO.'/'.ID_LIVRO.'/'.ID_CAPITULO.'/'.($num_versiculo - 1); ?>">
                        <i class="icon icon-chevron-left"></i> <?php echo ID_CAPITULO.":".($num_versiculo - 1); ?>
                    </a>
                </div>
                <?php endif; ?>
                <?php if (in_array(($num_versiculo + 1), $numVersiculos)) : ?>
                <div class="pull-right">
                    <a class="btn btn-primary" href="<?php echo '/'.VERSAO.'/'.TESTAMENTO.'/'.ID_LIVRO.'/'.ID_CAPITULO.'/'.($num_versiculo + 1); ?>">
                        <?php echo ID_CAPITULO.":".($num_versiculo + 1); ?> <i class="icon icon-chevron-right"></i>
                    </a>
                </div>
                <?php endif; ?>
                <?php echo $livro->nome; ?> <?php echo ID_CAPITULO.':'.$num_versiculo; ?>
            </h1>
            <div class="pull-right" style="font-size: 150%;">
                <?php versiculo_opcao($versiculo); ?>
            </div>
            <div>
                <span class='st_sharethis_large' displayText='ShareThis'></span>
                <span class='st_facebook_large' displayText='Facebook'></span>
                <span class='st_twitter_large' displayText='Tweet'></span>
                <span class='st_linkedin_large' displayText='LinkedIn'></span>
                <span class='st_pinterest_large' displayText='Pinterest'></span>
                <span class='st_email_large' displayText='Email'></span>
            </div>
            <div class="clearfix"></div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <blockquote>
                        <p style="font-size: 150%;"><?php echo $versiculo->texto; ?></p>
                        <p><small><?php echo $versiculo->versao; ?></small></p>
                    </blockquote>
                </div><!--panel-body-->
            </div><!--panel-->
            
            <?php //require('comentario.inc.php'); ?>
            <?php require('comentarios.inc.php'); ?>
            
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4>Este versículo em outras versões da Bíblia</h4>
                    <?php foreach ($outrasVersoes as $versao) : ?>
                    <blockquote>
                        <p><?php echo $versao->texto; ?></p>
                        <p><small><?php echo $versao->versao; ?></small></p>
                    </blockquote>
                    <?php endforeach; ?>
                </div><!--panel-body-->
            </div><!--panel-->
        </div>
        <div class="col-md-4">
            <h3><a href="<?php echo '/'.VERSAO.'/'.TESTAMENTO.'/'.ID_LIVRO.'/'.ID_CAPITULO; ?>"><?php echo $livro->nome; ?> <?php echo ID_CAPITULO; ?></a></h3>
            <?php $i = 0; ?>
            <?php foreach ($versiculos as $versiculo) : ?>
            <?php if ($versiculo->num_versiculo >= ($num_versiculo - 5) && $versiculo->num_versiculo <= ($num_versiculo + 5)) : ?>
            <?php if ($num_versiculo == $versiculo->num_versiculo) : ?>
            <div class="row" style="<?php echo ($i % 2 == 0) ? 'background: #fff' : 'background: #eee'; ?>">
                <div class="col-md-2 text-right" style="margin: 5px 0px">
                    <strong><?php echo ($versiculo->num_versiculo < 10) ? "0$versiculo->num_versiculo" : $versiculo->num_versiculo; ?></strong>
                </div>
                <div class="col-md-10" style="margin: 5px 0px 5px 0px">
                    <strong><?php echo $versiculo->texto; ?></strong>
                </div>
            </div>
            <?php else : ?>
            <div class="row" style="<?php echo ($i % 2 == 0) ? 'background: #fff' : 'background: #eee'; ?>">
                <div class="col-md-2 text-right" style="margin: 5px 0px">
                    <a href="<?php echo '/'.VERSAO.'/'.TESTAMENTO.'/'.ID_LIVRO.'/'.ID_CAPITULO.'/'.$versiculo->num_versiculo; ?>">
                        <?php echo ($versiculo->num_versiculo < 10) ? "0$versiculo->num_versiculo" : $versiculo->num_versiculo; ?>
                    </a>
                </div>
                <div class="col-md-10" style="margin: 5px 0px 5px 0px">
                    <?php echo $versiculo->texto; ?>
                </div>
            </div>
            <?php endif; ?>
            <?php endif; ?>
            <?php $i++; ?>
            <?php endforeach; ?>
            <hr />
            <?php include('banner.inc.php'); ?>
        </div>
    </div>
</div>
<?php require('footer.inc.php'); ?>