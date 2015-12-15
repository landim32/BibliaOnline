<?php 
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
                    url: "/ajax-versiculo.php",
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
    });
    $('.tags').tokenfield({
        autocomplete: {
            source: ['red','blue','green','yellow','violet','brown','purple','black','white'],
            delay: 100
        },
        showAutocompleteOnFocus: true
    })
});
</script>
<?php }
endif;

?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-comment"></i> Novo Comentário</h3>
    </div>
    <div class="panel-body">
        <form method="POST" class="form-vertical">
            <div class="form-group">
                <input type="text" class="form-control versiculo" name="versiculos" value="<?php echo NOME_VERSICULO; ?>" placeholder="Preencha os versículos relacionados aqui" />
            </div>
            <div class="form-group">
                <input type="text" class="form-control tags" name="tags" value="" placeholder="Preencha as tags que deseja..." />
            </div>
            <div class="form-group">
                <textarea name="texto" rows="3" class="form-control" placeholder="Preencha seu comentário aqui..."></textarea>
            </div>
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="icon icon-comment"></i> Comentar
                </button>
            </div>
        </form>
    </div><!--panel-body-->
</div><!--panel-->