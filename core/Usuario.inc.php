<?php

/*
create table usuario (
id_usuario int not null,
data_inclusao datetime not null,
ultima_alteracao datetime not null,
email varchar(250) not null,
nome varchar(60) not null,
senha varchar(30) not null,
cod_situacao int not null,
primary key(id_usuario)
);
 */

define('MARCA_FAVORITO', 1);
define('MARCA_GOSTEI', 2);
define('MARCA_DESGOSTEI', 3);

class Usuario {
    
    private function query() {
        $query = "
            SELECT 
                usuario.id_usuario,
                usuario.data_inclusao,
                usuario.ultima_alteracao,
                usuario.email,
                usuario.nome,
                usuario.senha,
                usuario.cod_situacao,
                (
                    SELECT count(*)
                    FROM usuario_versiculo
                    WHERE usuario_versiculo.id_usuario = usuario.id_usuario
                    AND usuario_versiculo.tipo = '".do_escape(MARCA_FAVORITO)."'
                ) AS 'favorito',
                (
                    SELECT count(*)
                    FROM usuario_versiculo
                    WHERE usuario_versiculo.id_usuario = usuario.id_usuario
                    AND usuario_versiculo.tipo = '".do_escape(MARCA_GOSTEI)."'
                ) AS 'gostei',
                (
                    SELECT count(*)
                    FROM usuario_versiculo
                    WHERE usuario_versiculo.id_usuario = usuario.id_usuario
                    AND usuario_versiculo.tipo = '".do_escape(MARCA_DESGOSTEI)."'
                ) AS 'desgostei',
                (
                    SELECT count(*)
                    FROM comentario
                    WHERE comentario.id_usuario = usuario.id_usuario
                    AND comentario.cod_situacao = 1
                ) AS 'comentario'
            FROM usuario
        ";
        return $query;
    }
    
    public function listar() {
        
    }
    
    public function pegar($id_usuario) {
        $query = $this->query()."
            WHERE usuario.id_usuario = '".  do_escape($id_usuario)."'
        ";
        return get_first_result($query);
    }
    
    public function pegarDoPost($usuario = null){
        if (is_null($usuario))
            $usuario = new stdClass();
        if (array_key_exists('email', $_POST))
            $usuario->email = $_POST['email'];
        if (array_key_exists('nome', $_POST))
            $usuario->nome = $_POST['nome'];
        if (array_key_exists('senha', $_POST))
            $usuario->senha = $_POST['senha'];
        return $usuario;
    }
    
    private function validar($usuario) {
        if (!is_object($usuario))
            throw new Exception('Objeto não pode ser nulo.');
        if (isNullOrEmpty($usuario->email))
            throw new Exception('Email não pode ser vazio.');
        if (isNullOrEmpty($usuario->nome))
            throw new Exception('Nome não pode ser vazio.');
        if (isNullOrEmpty($usuario->senha))
            throw new Exception('Senha não pode ser vazia.');
        return $usuario;
    }
    
    public function inserir($usuario) {
        $usuario = $this->validar($usuario);
        $query = "
            INSERT INTO usuario (
                data_inclusao,
                ultima_alteracao,
                email,
                nome,
                senha,
                cod_situacao
            ) VALUES (
                NOW(),
                NOW(),
                '".do_escape($usuario->email)."',
                '".do_escape($usuario->nome)."',
                '".do_escape($usuario->senha)."',
                1
            )
        ";
        return do_insert($query);
    }
    
    public function alterar($usuario) {
        $usuario = $this->validar($usuario);
        $query = "
            UPDATE usuario SET
                ultima_alteracao = NOW(),
                email = '".do_escape($usuario->email)."',
                nome = '".do_escape($usuario->nome)."',
                senha = '".do_escape($usuario->senha)."',
            WHERE id_usuario = '".do_escape($usuario->id_usuario)."',
        ";
        do_update($query);
    }
    
    public function logar($email, $senha) {
        $query = $this->query()."
            WHERE usuario.email = '".do_escape($email)."'
            AND usuario.senha = '".do_escape($senha)."'
        ";
        $usuario = get_first_result($query);
        if (!is_null($usuario)) {
            $_SESSION['usuario_atual'] = $usuario;
            return true;
        }
        else
            return false;
    }
    
    public function gravarSessao($usuario) {
        if (session_status() == PHP_SESSION_ACTIVE)
           $_SESSION['usuario_atual'] = $usuario; 
    }
    
    public function pegarAtual() {
        if (session_status() == PHP_SESSION_ACTIVE && array_key_exists('usuario_atual', $_SESSION)) {
           return $_SESSION['usuario_atual']; 
        }
        else 
            return null;
    }
    
    public function marcar($id_livro, $id_capitulo, $num_versiculo, $tipo = 1) {
        $usuario = $this->pegarAtual();
        if (!is_null($usuario)) {
            $query = "
                SELECT tipo
                FROM usuario_versiculo
                WHERE id_usuario = '".do_escape($usuario->id_usuario)."'
                AND id_livro = '".do_escape($id_livro)."'
                AND id_capitulo = '".do_escape($id_capitulo)."'
                AND num_versiculo = '".do_escape($num_versiculo)."'
                AND tipo = '".do_escape($tipo)."'
            ";
            $tipoAtual = intval(get_value($query, 'tipo'));
            if ($tipoAtual > 0) {
                $query = "
                    DELETE FROM usuario_versiculo
                    WHERE id_usuario = '".do_escape($usuario->id_usuario)."'
                    AND id_livro = '".do_escape($id_livro)."'
                    AND id_capitulo = '".do_escape($id_capitulo)."'
                    AND num_versiculo = '".do_escape($num_versiculo)."'
                    AND tipo = '".do_escape($tipo)."'
                ";
                do_delete($query);
                return false;
            }
            else {
                $query = "
                    INSERT INTO usuario_versiculo (
                        id_usuario,
                        id_livro,
                        id_capitulo,
                        num_versiculo,
                        tipo
                    ) VALUES (
                        '".do_escape($usuario->id_usuario)."',
                        '".do_escape($id_livro)."',
                        '".do_escape($id_capitulo)."',
                        '".do_escape($num_versiculo)."',
                        '".do_escape($tipo)."'
                    )
                ";
                do_insert($query);
                return true;
            }
        }
        return false;
    }
    
}
