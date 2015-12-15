<?php 
require('common.inc.php'); 

$regraBiblia = new Biblia();

/*
$livro = $regraBiblia->pegarLivro(ID_LIVRO);
$capitulos = $regraBiblia->listarCapitulo(ID_VERSAO, ID_LIVRO);
$versiculos = $regraBiblia->listarVersiculo(ID_VERSAO, ID_LIVRO, ID_CAPITULO);

$versiculo = $regraBiblia->pegarVersiculo(ID_VERSAO, ID_LIVRO, ID_CAPITULO, NUM_VERSICULO);

$outrasVersoes = $regraBiblia->listarVersiculoVersao(ID_VERSAO, ID_LIVRO, ID_CAPITULO, NUM_VERSICULO);
 */

if (!function_exists('inicializar_js')) :
function inicializar_js() {
?>
<script type="text/javascript" src="/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/js/bootstrap-tokenfield.min.js"></script>
<script type="text/javascript" src="/js/typeahead.bundle.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('.versiculo').tokenfield({
        autocomplete: {
            minLength: 2,
            source: function( request, response ) {
                $.ajax({
                    url: "ajax-versiculo.php",
                    dataType: "json",
                    data: {
                        palavra: request.term
                    },
                    success: function( data ) {
                        if (data) {
                            var retorno = [];
                            $.each(data, function(index, texto) {
                                retorno.push({
                                    label: texto, 
                                    value: texto
                                });
                            });
                        }
                        response(retorno);
                    }
                });
            }
        },
        showAutocompleteOnFocus: true
    })
});
</script>
<?php }
endif;

?>
<?php require('header.inc.php'); ?>
<?php require('menu-principal.inc.php'); ?>
<div class="container" style="margin-top: 60px">
    <div class="row">
        <div class="col-md-8">
            <h3>Novo comentário</h3>
            <hr />
            <form method="POST" class="form-vertical">
                <div class="form-group">
                    <label class="control-label">Versículos:</label>
                    <input type="text" class="form-control versiculo" name="versiculos" value="" />
                </div>
                <div class="form-group">
                    <label class="control-label">Texto:</label>
                    <textarea name="texto" rows="5" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label class="control-label">Nome:</label>
                    <input type="text" class="form-control" name="nome" value="" placeholder="Seu nome" />
                </div>
                <div class="form-group">
                    <label class="control-label">Email:</label>
                    <input type="text" class="form-control" name="email" value="" placeholder="Seu email" />
                </div>
                <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="icon icon-comment"></i>
                            Novo Comentário
                        </button>
                </div>
            </form>
        </div>
        <div class="col-md-4">
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