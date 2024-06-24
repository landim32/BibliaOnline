<?php 
require('common.inc.php'); 

$regraBiblia = new Biblia();

$livro = $regraBiblia->pegarLivro(ID_LIVRO);
$capitulos = $regraBiblia->listarCapitulo(ID_VERSAO, ID_LIVRO);
$versiculos = $regraBiblia->listarVersiculo(ID_VERSAO, ID_LIVRO, ID_CAPITULO);

?>
<?php require('header.inc.php'); ?>
<?php require('menu-principal.inc.php'); ?>
<div class="container" style="margin-top: 80px">
    <div class="row">
        <div class="col-md-9">
            <h1 class="text-center">
                <?php if ((ID_CAPITULO - 1) > 0) : ?>
                <?php $numCap = (ID_CAPITULO - 1); ?>
                <div class="pull-left">
                    <a class="btn btn-primary" href="<?php echo '/'.VERSAO.'/'.TESTAMENTO.'/'.ID_LIVRO.'/'.$numCap; ?>">
                        <i class="icon icon-chevron-left"></i> <?php echo "$livro->nome $numCap"; ?>
                    </a>
                </div>
                <?php endif; ?>
                <?php $numCap = (ID_CAPITULO + 1); ?>
                <?php if (in_array($numCap, $capitulos)) : ?>
                <div class="pull-right">
                    <a class="btn btn-primary" href="<?php echo '/'.VERSAO.'/'.TESTAMENTO.'/'.ID_LIVRO.'/'.$numCap; ?>">
                        <?php echo "$livro->nome $numCap"; ?> <i class="icon icon-chevron-right"></i>
                    </a>
                </div>
                <?php endif; ?>
                <?php echo $livro->nome; ?> <?php echo ID_CAPITULO; ?>
            </h1>
            <?php $i = 0; ?>
            <?php foreach ($versiculos as $versiculo) : ?>
            <div class="row" style="<?php echo ($i % 2 == 0) ? 'background: #fff' : 'background: #eee'; ?>">
                <div class="col-md-1 text-right" style="margin: 12px 0px">
                    <a href="<?php echo '/'.VERSAO.'/'.TESTAMENTO.'/'.ID_LIVRO.'/'.ID_CAPITULO.'/'.$versiculo->num_versiculo; ?>"><?php echo ($versiculo->num_versiculo < 10) ? "0$versiculo->num_versiculo" : $versiculo->num_versiculo; ?></a>
                </div>
                <div class="col-md-8" style="font-size: 140%; margin: 10px 0px 20px 0px">
                    <?php echo $versiculo->texto; ?>
                </div>
                <div class="col-md-3 text-right" style="font-size: 120%; margin: 12px 0px">
                    <?php versiculo_opcao($versiculo); ?>
                </div>
            </div>
            <?php $i++; ?>
            <?php endforeach; ?>
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