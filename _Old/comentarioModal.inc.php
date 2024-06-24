<?php 
//$regraBiblia = new Biblia();

if (!function_exists('inicializar_js')) :
function inicializar_js() {
?>
<script type="text/javascript" src="/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/js/bootstrap-tokenfield.js"></script>
<script type="text/javascript" src="/js/typeahead.bundle.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('.comentario-novo').click(function (e) {
        $('#comentarioModal').modal('show');
        return false;
    });
    $('.responder').click(function (e) {
        $('#respostaModal').modal('show');
        $('#id_pai').val($(this).attr('data-comentario'));
        return false;
    });
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
        showAutocompleteOnFocus: true,
        createTokensOnBlur: true
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
<div class="modal fade" id="comentarioModal">
    <div class="modal-dialog modal-lg">
        <form method="POST" class="form-horizontal">
        <div class="modal-content form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon icon-comment"></i> Novo comentário</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" class="form-control versiculo" name="versiculos" value="<?php echo NOME_VERSICULO; ?>" placeholder="Preencha os versiculos relacionados aqui" />
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control tags" name="tags" value="" placeholder="Preencha as tags que deseja..." />
                        </div>
                        <div class="form-group">
                            <textarea name="texto" rows="5" class="form-control" placeholder="Preencha seu comentário aqui..."></textarea>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success"><i class="icon icon-comment"></i> Comentar</button>
            </div>
        </div>
        </form>
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" id="respostaModal">
    <div class="modal-dialog modal-lg">
        <form method="POST" class="form-horizontal">
        <input type="hidden" id="id_pai" name="id_pai" value="0" />
        <div class="modal-content form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon icon-comment"></i> Novo comentário</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <textarea name="texto" rows="5" class="form-control" placeholder="Preencha seu comentário aqui..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success"><i class="icon icon-comment"></i> Comentar</button>
            </div>
        </div>
        </form>
    </div><!-- /.modal-dialog -->
</div>