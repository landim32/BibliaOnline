<?php 
    $regraUsuario = new Usuario();
    $usuario = $regraUsuario->pegarAtual();
    $regraComentario = new Comentario();
    $id_livro = ID_LIVRO;
    $id_capitulo = ID_CAPITULO;
    if (defined('NUM_VERSICULO'))
        $num_versiculo = NUM_VERSICULO;
    else
        $num_versiculo = null;
    if (array_key_exists('_comentarios', $GLOBALS))
        $comentarios = $GLOBALS['_comentarios'];
    else
        $comentarios = $regraComentario->listar($id_livro, $id_capitulo, $num_versiculo);
?>
<?php if (!function_exists('listar_comentario')) : ?>
<?php function listar_comentario($comentario) { ?>
<li class="clearfix">
    <img src="<?php echo get_gravatar($comentario->email, 65) ?>" class="avatar" alt="<?php echo $comentario->nome; ?>" />
    <div class="post-comments">
        <p class="meta"><?php echo $comentario->data; ?> <a href="#"><?php echo $comentario->nome; ?></a> disse : 
            <i class="pull-right"><a href="#" class="responder" data-comentario="<?php echo $comentario->id_comentario; ?>"><small>Responder</small></a></i>
        </p>
        <p><?php echo $comentario->texto; ?></p>
    </div>
    <?php if (count($comentario->comentarios) > 0) : ?>
    <ul class="comments">
        <?php foreach ($comentario->comentarios as $comentario2) : ?>
        <?php listar_comentario($comentario2); ?>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</li>
<?php } ?>
<?php endif;?>
<style type="text/css">
.blog-comment::before,
.blog-comment::after,
.blog-comment-form::before,
.blog-comment-form::after{
    content: "";
    display: table;
    clear: both;
}
.blog-comment ul{
    list-style-type: none;
    padding: 0;
}

.blog-comment img{
    opacity: 1;
    filter: Alpha(opacity=100);
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    -o-border-radius: 4px;
    border-radius: 4px;
}

.blog-comment img.avatar {
    position: relative;
    float: left;
    margin-left: 0;
    margin-top: 0;
    width: 65px;
    height: 65px;
}

.blog-comment .post-comments{
    border: 1px solid #eee;
    margin-bottom: 20px;
    margin-left: 85px;
    margin-right: 0px;
    padding: 10px 20px;
    position: relative;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    -o-border-radius: 4px;
    border-radius: 4px;
    background: #fff;
    color: #6b6e80;
    position: relative;
}

.blog-comment .meta {
    font-size: 13px;
    color: #aaaaaa;
    padding-bottom: 8px;
    margin-bottom: 10px !important;
    border-bottom: 1px solid #eee;
}

.blog-comment ul.comments ul{
    list-style-type: none;
    padding: 0;
    margin-left: 85px;
}

.blog-comment-form{
    padding-left: 15%;
    padding-right: 15%;
    padding-top: 40px;
}

.blog-comment h3,
.blog-comment-form h3{
    margin-bottom: 40px;
    font-size: 26px;
    line-height: 30px;
    font-weight: 800;
}
</style>
<div class="row">
    <div class="col-md-12">
        <?php 
        //echo '<pre>';
        //var_dump($comentarios);
        //echo '</pre>';
        ?>
        <div class="blog-comment">
            <h3>
                <?php if (!is_null($usuario)) : ?>
                <a href="#comentarioModal" class="comentario-novo btn btn-success pull-right"><i class="icon icon-plus"></i> Comentar</a>
                <?php endif; ?>
                Comentários
            </h3>
            <hr/>
            <ul class="comments">
                <?php foreach ($comentarios as $comentario) : ?>
                <?php listar_comentario($comentario); ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>