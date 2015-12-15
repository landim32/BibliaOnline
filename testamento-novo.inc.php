<?php 
$regraBiblia = new Biblia(); 
$versao = $regraBiblia->pegarVersao();
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-book"></i> Novo Testamento</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <?php $livros = $regraBiblia->listarLivro(NOVO_TESTAMENTO); ?>
            <?php $colunas = array_partition($livros, 3); ?>
            <?php foreach ($colunas as $coluna) : ?>
            <div class="col-md-4">
                <ul style="font-size: 120%">
                    <?php foreach ($coluna as $id => $livro) : ?>
                    <li><a href="<?php echo "/$versao/nt/$livro->id_livro"; ?>"><?php echo $livro->nome; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>
    </div><!--panel-body-->
</div><!--panel-->