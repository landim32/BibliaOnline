<?php 
$regraBiblia = new Biblia();
$versao = $regraBiblia->pegarVersao();
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-book"></i> Antigo Testamento</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <?php $livros = $regraBiblia->listarLivro(ANTIGO_TESTAMENTO); ?>
            <?php $colunas = array_partition($livros, 3); ?>
            <?php foreach ($colunas as $coluna) : ?>
            <div class="col-md-4">
                <ul style="font-size: 120%">
                    <?php foreach ($coluna as $id => $livro) : ?>
                    <?php if ($livro->id_livro == ID_LIVRO) : ?>
                    <li><strong><?php echo $livro->nome; ?></strong></li>
                    <?php else : ?>
                    <li><a href="<?php echo "/$versao/at/$livro->id_livro"; ?>"><?php echo $livro->nome; ?></a></li>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>
    </div><!--panel-body-->
</div><!--panel-->