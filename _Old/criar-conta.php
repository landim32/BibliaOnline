<?php 
require('common.inc.php');

if (count($_POST) > 0) {
    if (array_key_exists('acao', $_POST) && $_POST['acao'] == 'criar-conta') {
        try {
            $regraUsuario = new Usuario();
            $usuario = $regraUsuario->pegarDoPost();
            $id_usuario = $regraUsuario->inserir($usuario);
            $usuario = $regraUsuario->pegar($id_usuario);
            $regraUsuario->gravarSessao($usuario);
            header('Location: /');
            exit();
        }
        catch (Exception $e) {
            $msgerro = $e->getMessage();
        }
    }
}

?>
<?php require('header.inc.php'); ?>
<?php require('menu-principal.inc.php'); ?>
<div class="container" style="margin-top: 100px">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="icon icon-user"></i> Crie sua conta</h3>
                </div>
                <div class="panel-body">
                    <form method="POST" class="form-vertical">
                        <input type="hidden" name="acao" value="criar-conta">
                        <div class="form-group">
                            <input type="text" class="form-control" name="email" placeholder="Seu email" value="<?php echo $_POST['email']; ?>" />
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="nome" placeholder="Seu nome" value="<?php echo $_POST['nome']; ?>" />
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="senha" placeholder="Sua senha" value="<?php echo $_POST['senha']; ?>" />
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="senha_confirma" placeholder="Confirmar senha" value="<?php echo $_POST['senha_confirma']; ?>" />
                        </div>
                        <?php if (isset($msgerro)) : ?>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <i class="icon icon-warning"></i> <?php echo $msgerro; ?>
                        </div>
                        <?php endif; ?>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-lg btn-primary">Entrar</button>
                        </div>
                    </form>
                </div><!--panel-body-->
            </div><!--panel-default-->
        </div>
    </div>
</div>
<?php require('footer.inc.php'); ?>