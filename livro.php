<?php 
require('common.inc.php'); 

$regraBiblia = new Biblia();
$capitulos = $regraBiblia->listarCapitulo(ID_VERSAO, ID_LIVRO);
$livro = $regraBiblia->pegarLivro(ID_LIVRO);
$livroAnterior = null;
if ((ID_LIVRO - 1) > 0)
    $livroAnterior = $regraBiblia->pegarLivro(ID_LIVRO - 1);
$livroProximo = $regraBiblia->pegarLivro(ID_LIVRO + 1);
?>
<?php require('header.inc.php'); ?>
<?php require('menu-principal.inc.php'); ?>
<div class="container" style="margin-top: 80px">
    <div class="row">
        <div class="col-md-9">
            <h1 class="text-center">
            <?php if (!is_null($livroAnterior)) : ?>
            <div class="pull-left">
                <a class="btn btn-primary" href="<?php echo '/'.VERSAO.'/'.TESTAMENTO.'/'.$livroAnterior->id_livro; ?>">
                    <i class="icon icon-chevron-left"></i> <?php echo $livroAnterior->nome; ?>
                </a>
            </div>
            <?php endif; ?>
            <?php if (!is_null($livroProximo)) : ?>
            <div class="pull-right">
                <a class="btn btn-primary" href="<?php echo '/'.VERSAO.'/'.TESTAMENTO.'/'.$livroProximo->id_livro; ?>">
                    <?php echo $livroProximo->nome; ?> <i class="icon icon-chevron-right"></i>
                </a>
            </div>
            <?php endif; ?>
            <?php echo $livro->nome; ?>
            </h1>
            <?php if (ID_TESTAMENTO == ANTIGO_TESTAMENTO) : ?>
            <?php require('testamento-antigo.inc.php'); ?>
            <?php else : ?>
            <?php require('testamento-novo.inc.php'); ?>
            <?php endif; ?>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Capítulos</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php foreach ($capitulos as $capitulo) : ?>
                        <div class="col-md-2 text-right" style="font-size: 110%">
                            <?php if ($capitulo == ID_CAPITULO) : ?>
                            <strong><?php echo ($capitulo < 10) ? "0$capitulo" : $capitulo; ?></strong>
                            <?php else : ?>
                            <a href="<?php echo '/'.VERSAO.'/'.TESTAMENTO.'/'.ID_LIVRO.'/'.$capitulo; ?>"><?php echo ($capitulo < 10) ? "0$capitulo" : $capitulo; ?></a>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div><!--panel-body-->
            </div><!--panel-->
            <?php include('banner.inc.php'); ?>
        </div>
    </div>
</div>
<?php require('footer.inc.php'); ?>