<?php 
require('common.inc.php'); 

$regraBiblia = new Biblia();

//$livro = $regraBiblia->pegarLivro(ID_LIVRO);
//$capitulos = $regraBiblia->listarCapitulo(ID_VERSAO, ID_LIVRO);
$versiculos = $regraBiblia->buscar($_GET['p']);

?>
<?php require('header.inc.php'); ?>
<?php require('menu-principal.inc.php'); ?>
<div class="container" style="margin-top: 80px">
    <div class="row">
        <div class="col-md-9">
            <h3>Resultado da busca "<?php echo $_GET['p']; ?>"</h3>
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
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- BibliaEmDestaque -->
            <ins class="adsbygoogle"
                style="display:block"
                data-ad-client="ca-pub-5769680090282398"
                data-ad-slot="1990484248"
                data-ad-format="auto"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>
</div>
<?php require('footer.inc.php'); ?>