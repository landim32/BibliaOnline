<?php 
$regraUsuario = new Usuario();
$usuario = $regraUsuario->pegarAtual();
?>
<?php if (is_null($usuario)) : ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-user"></i> Entre para comentar</h3>
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