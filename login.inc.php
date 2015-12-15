<?php 
$regraUsuario = new Usuario();
$usuario = $regraUsuario->pegarAtual();
?>
<?php if (!is_null($usuario)) : ?>
<div class="panel panel-default">
    <div class="panel-body">
        <img src="<?php echo get_gravatar($usuario->email, 60); ?>" class="img-circle pull-left" style="margin: 0px 5px 15px 0px" />
        <h5 style="margin: 12px 0px 3px 0px; font-weight: bold"><?php echo $usuario->nome; ?></h5>
        <a href="#"><i class="icon icon-pencil"></i> Alterar</a> | 
        <a href="/logout.php"><i class="icon icon-remove"></i> Sair</a>
        <div class="clearfix"></div>
        <div class="list-group">
            <a href="/meus/favoritos" class="<?php echo ($_GET['tipo'] == 'favoritos') ? 'list-group-item active' : 'list-group-item'; ?>">
                <span class="badge"><?php echo $usuario->favorito; ?></span>
                <i class="icon icon-star"></i> Favoritos
            </a>
            <a href="/meus/gostei" class="<?php echo ($_GET['tipo'] == 'gostei') ? 'list-group-item active' : 'list-group-item'; ?>">
                <span class="badge"><?php echo $usuario->gostei; ?></span>
                <i class="icon icon-thumbs-up"></i> Gostei
            </a>
            <a href="/meus/desgostei" class="<?php echo ($_GET['tipo'] == 'desgostei') ? 'list-group-item active' : 'list-group-item'; ?>">
                <span class="badge"><?php echo $usuario->desgostei; ?></span>
                <i class="icon icon-thumbs-down"></i> Desgostei
            </a>
            <a href="/meus/comentarios" class="<?php echo ($_GET['tipo'] == 'comentarios') ? 'list-group-item active' : 'list-group-item'; ?>">
                <span class="badge"><?php echo $usuario->comentario; ?></span>
                <i class="icon icon-comment"></i> Comentários
            </a>
        </div>
    </div>
</div>
<?php else : ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-user"></i> Entre com Usuário</h3>
    </div>
    <div class="panel-body">
        <form method="POST" class="form-vertical">
            <input type="hidden" name="acao" value="logar">
            <div class="form-group">
                <input type="text" class="form-control" name="email" placeholder="Seu email" value="<?php echo $_POST['email']; ?>" />
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="senha" placeholder="Sua senha" value="<?php echo $_POST['senha']; ?>" />
            </div>
            <?php if (array_key_exists('msgerro', $GLOBALS)) : ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="icon icon-warning"> <?php echo $GLOBALS['msgerro']; ?>
            </div>
            <?php endif; ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <a href="/criar-conta.php">Crie sua conta</a>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>