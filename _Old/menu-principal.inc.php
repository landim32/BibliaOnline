<?php 
$regraUsuario = new Usuario();
$usuario = $regraUsuario->pegarAtual();

$regraBiblia = new Biblia(); 
$versoes = $regraBiblia->listarVersao();
$url = '/%s/'.TESTAMENTO;
if (defined('ID_LIVRO')) {
    $url .= '/'.ID_LIVRO;
    if (defined('ID_CAPITULO')) {
        $url .= '/'.ID_CAPITULO;
        if (defined('NUM_VERSICULO'))
            $url .= '/'.NUM_VERSICULO;
    }
}
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo '/'.VERSAO; ?>">Bíblia em Debate</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Testamentos <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo '/'.VERSAO.'/at'; ?>">Antigo Testamento</a></li>
                        <li><a href="<?php echo '/'.VERSAO.'/nt'; ?>">Novo Testamento</a></li>
                        <!--li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">One more separated link</a></li-->
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Versão <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php foreach ($versoes as $versao) : ?>
                        <li><a href="<?php echo sprintf($url, $versao->slug); ?>"><?php echo $versao->nome; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if (!is_null($usuario)) : ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo get_gravatar($usuario->email, 20); ?>" class="img-circle" />
                        <?php echo $usuario->nome; ?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="icon icon-pencil"></i> Alterar</a></li>
                        <li><a href="/logout.php"><i class="icon icon-remove"></i> Sair</a></li>
                        <li class="divider"></li>
                        <li class="<?php echo ($_GET['tipo'] == 'favoritos') ? 'active' : ''; ?>"><a href="/meus/favoritos">
                            <i class="icon icon-star"></i> Favoritos
                            <span class="badge pull-right"><?php echo $usuario->favorito; ?></span>
                        </a></li>
                        <li class="<?php echo ($_GET['tipo'] == 'gostei') ? 'active' : ''; ?>"><a href="/meus/gostei">
                            <i class="icon icon-thumbs-up"></i> Gostei
                            <span class="badge pull-right"><?php echo $usuario->gostei; ?></span>
                        </a></li>
                        <li class="<?php echo ($_GET['tipo'] == 'desgostei') ? 'active' : ''; ?>"><a href="/meus/desgostei">
                            <i class="icon icon-thumbs-down"></i> Desgostei
                            <span class="badge pull-right"><?php echo $usuario->desgostei; ?></span>
                        </a></li>
                        <li class="<?php echo ($_GET['tipo'] == 'comentarios') ? 'active' : ''; ?>"><a href="/comentario">
                            <i class="icon icon-comment"></i> Comentários
                            <span class="badge pull-right"><?php echo $usuario->comentario; ?></span>
                        </a></li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
            <form method="GET" action="/resultado.php" class="navbar-form navbar-right" role="search">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" name="p" value="<?php echo $_GET['p']; ?>" style="max-width: 150px" placeholder="Buscar...">
                        <div class="input-group-addon"><i class="icon icon-search"></i></div>
                    </div>
                </div>
            </form>
        </div><!--/.nav-collapse -->
    </div>
</nav>