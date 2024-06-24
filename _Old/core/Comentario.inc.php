<?php

/*
create table comentario (
id_comentario int not null auto_increment,
id_pai int,
id_usuario int not null,
data_inclusao datetime not null,
texto varchar(8000) not null,
cod_situacao tinyint not null default 1,
primary key(id_comentario)
);

create table comentario_versiculo(
id_versiculo int not null auto_increment,
id_comentario int not null,
id_livro tinyint not null,
id_capitulo tinyint not null,
num_versiculo tinyint,
primary key(id_versiculo)
);

create table comentario_tag (
id_comentario int not null,
tag varchar(25) not null,
primary key(id_comentario, tag)
);

create table comentario_anexo (
id_imagem int not null auto_increment,
id_comentario int not null,
tipo_anexo tinyint not null,
anexo varchar(50) not null,
primary key(id_imagem)
);


 */

class Comentario {

    private function query() {
        $query = "
            SELECT
                comentario.id_comentario,
                comentario.id_pai,
                comentario.id_usuario,
                usuario.nome,
                usuario.email,
                comentario_versiculo.id_livro,
                comentario_versiculo.id_capitulo,
                comentario_versiculo.num_versiculo,
                comentario.data_inclusao,
                comentario.texto,
                comentario.cod_situacao
            FROM comentario
            INNER JOIN comentario_versiculo ON comentario_versiculo.id_comentario = comentario.id_comentario
            INNER JOIN usuario ON usuario.id_usuario = comentario.id_usuario
        ";
        return $query;
    }
    
    private function listarResposta($id_comentario) {
        $query = "
            SELECT
                comentario.id_comentario,
                comentario.id_pai,
                comentario.id_usuario,
                usuario.nome,
                usuario.email,
                comentario.data_inclusao,
                comentario.texto,
                comentario.cod_situacao
            FROM comentario
            INNER JOIN usuario ON usuario.id_usuario = comentario.id_usuario
            WHERE comentario.id_pai = '".  do_escape($id_comentario)."'
            AND comentario.cod_situacao = 1
            ORDER BY comentario.data_inclusao DESC
        ";
        //echo $query;
        $comentarios = array();
        foreach (get_result($query) as $comentario) {
            $comentario->comentarios = $this->listarResposta($comentario->id_comentario);
            $comentario->versiculos = $this->listarVersiculo($comentario->id_comentario);
            $comentario->data = strftime("%b %d, %Y %Hh%M", strtotime($comentario->data_inclusao));
            $comentarios[] = $comentario;
        }
        //var_dump($comentarios);
        return $comentarios;
    }
    
    public function listar($id_livro, $id_capitulo, $num_versiculo) {
        $query = "
            SELECT
                comentario.id_comentario,
                comentario.id_pai,
                comentario.id_usuario,
                usuario.nome,
                usuario.email,
                comentario.data_inclusao,
                comentario.texto,
                comentario.cod_situacao
            FROM comentario
            INNER JOIN comentario_versiculo ON comentario_versiculo.id_comentario = comentario.id_comentario
            INNER JOIN usuario ON usuario.id_usuario = comentario.id_usuario
            WHERE comentario_versiculo.id_livro = '".do_escape($id_livro)."'
            AND comentario_versiculo.id_capitulo = '".do_escape($id_capitulo)."'
            AND comentario_versiculo.num_versiculo = '".do_escape($num_versiculo)."'
            AND comentario.cod_situacao = 1
            AND comentario.id_pai IS NULL
            ORDER BY comentario.data_inclusao DESC
        ";
        $comentarios = array();
        foreach (get_result($query) as $comentario) {
            $comentario->comentarios = $this->listarResposta($comentario->id_comentario);
            $comentario->versiculos = $this->listarVersiculo($comentario->id_comentario);
            $comentario->data = strftime("%b %d, %Y %Hh%M", strtotime($comentario->data_inclusao));
            $comentarios[] = $comentario;
        }
        return $comentarios;
    }
    
    public function pegar($id_comentario) {
        $query = "
            SELECT
                comentario.id_comentario,
                comentario.id_pai,
                comentario.id_usuario,
                usuario.nome,
                usuario.email,
                comentario.data_inclusao,
                comentario.texto,
                comentario.cod_situacao
            FROM comentario
            INNER JOIN usuario ON usuario.id_usuario = comentario.id_usuario
            WHERE comentario.id_comentario = '".do_escape($id_comentario)."'
        ";
        $comentario = get_first_result($query);
        if (!is_null($comentario)) {
            $comentario->comentarios = $this->listarResposta($comentario->id_comentario);
            $comentario->versiculos = $this->listarVersiculo($comentario->id_comentario);
            $comentario->data = strftime("%b %d, %Y %Hh%M", strtotime($comentario->data_inclusao));
        }
        return $comentario;
    }
    
    public function pegarDoPost($comentario = null) {
        if (is_null($comentario))
            $comentario = new stdClass();
        if (array_key_exists('id_pai', $_POST)) {
            $comentario->id_pai = intval($_POST['id_pai']);
            if (!($comentario->id_pai > 0))
                $comentario->id_pai = null;
        }
        if (array_key_exists('versiculos', $_POST))
            $comentario->versiculos_str = $_POST['versiculos'];
        if (array_key_exists('tags', $_POST))
            $comentario->tags_str = $_POST['tags'];
        if (array_key_exists('texto', $_POST))
            $comentario->texto = $_POST['texto'];
        return $comentario;
    }

    private function pegarIdLivro($nome) {
        $query = "
            SELECT liv_id
            FROM livros
            WHERE LOWER(liv_nome) = '".do_escape($nome)."'
        ";
        return get_value($query, 'liv_id');
    }
    
    public function validar($comentario = null) {
        if (!is_object($comentario))
            throw new Exception('Objeto inválido!');
        $regraUsuario = new Usuario();
        $usuario = $regraUsuario->pegarAtual();
        //var_dump($usuario);
        if (is_null($usuario))
            throw new Exception('Usuário não encontrado!');
        $comentario->id_usuario = $usuario->id_usuario;
        $versiculos = explode(',', $comentario->versiculos_str);
        $comentario->versiculos = array();
        foreach ($versiculos as $versiculo) {
            $out = array();
            preg_match_all("/([a-z,\ ]+)\ ([0-9]+)\:([0-9]+)/", strtolower($versiculo), $out);
            //echo '<pre>';
            //var_dump($comentario->versiculos_str, $versiculo, $out);
            //echo '</pre>';
            $livro = $out[1][0];
            $id_livro = $this->pegarIdLivro($livro);
            $id_capitulo = $out[2][0];
            $num_versiculo = $out[3][0];
            if ($id_livro > 0 && $id_capitulo > 0 && $num_versiculo > 0) {
                $ver = new stdClass();
                $ver->id_livro = $id_livro;
                $ver->id_capitulo = $id_capitulo;
                $ver->num_versiculo = $num_versiculo;
                $comentario->versiculos[] = $ver;
            }
            //var_dump($out);
        }
        $comentario->tags = explode(',', $comentario->tags_str);
        return $comentario;
    }
    
    public function inserir($comentario = null) {
        if (is_null($comentario))
            $comentario = $this->pegarDoPost();
        $comentario = $this->validar($comentario);
        //var_dump($comentario);
        //exit();
        $query = "
            INSERT INTO comentario (
                id_pai,
                id_usuario,
                data_inclusao,
                texto,
                cod_situacao
            ) VALUES (
                ".do_escape_full($comentario->id_pai).",
                '".do_escape($comentario->id_usuario)."',
                NOW(),
                '".do_escape($comentario->texto)."',
                1
            )
        ";
        $id_comentario = do_insert($query);
        foreach ($comentario->versiculos as $versiculo) {
            $versiculo->id_comentario = $id_comentario;
            $this->inserirVersiculo($versiculo);
        }
        foreach ($comentario->tags as $tag)
            $this->inserirTag($id_comentario, $tag);
        return $id_comentario;
    }
    
    private function inserirVersiculo($versiculo) {
        $query = "
            INSERT INTO comentario_versiculo (
                id_comentario,
                id_livro,
                id_capitulo,
                num_versiculo
            ) VALUES (
                '".do_escape($versiculo->id_comentario)."',
                '".do_escape($versiculo->id_livro)."',
                '".do_escape($versiculo->id_capitulo)."',
                ".do_escape_full($versiculo->num_versiculo)."
            )
        ";
        return do_insert($query);
    }
    
    private function inserirTag($id_comentario, $tag) {
        $query = "
            INSERT INTO comentario_tag (
                id_comentario,
                tag
            ) VALUES (
                '".do_escape($id_comentario)."',
                '".do_escape($tag)."'
            )
        ";
        do_insert($query);
    }


    public function alterar($comentario) {
        
    }
    
    public function excluir($id_comentario) {
        $query = "
            UPDATE comentario SET
                cod_situacao = 0
            WHERE id_comentario = '".do_escape($id_comentario)."'
        ";
        //echo $query;
        //exit();
        do_update($query);
    }
    
    private function listarVersiculo($id_comentario) {
        $query = "
            SELECT DISTINCT
                versiculos.ver_liv_id AS 'id_livro',
                versiculos.ver_capitulo AS 'id_capitulo',
                versiculos.ver_versiculo AS 'num_versiculo',
                CONCAT(livros.liv_nome, ' ', versiculos.ver_capitulo, ':', versiculos.ver_versiculo) AS 'versiculo',
                versiculos.ver_texto AS 'texto'
            FROM comentario_versiculo
            INNER JOIN versiculos ON (
                comentario_versiculo.id_livro = versiculos.ver_liv_id
                AND comentario_versiculo.id_capitulo = versiculos.ver_capitulo
                AND comentario_versiculo.num_versiculo = versiculos.ver_versiculo
                AND versiculos.ver_vrs_id = '".do_escape(ID_VERSAO)."'
            )
            INNER JOIN livros ON livros.liv_id = comentario_versiculo.id_livro
            WHERE comentario_versiculo.id_comentario = '".do_escape($id_comentario)."'
        ";
        return get_result($query);
    }
    
    public function listarPorUsuario($id_usuario) {
        $query = "
            SELECT
                comentario.id_comentario,
                comentario.id_pai,
                comentario.id_usuario,
                usuario.nome,
                usuario.email,
                comentario.data_inclusao,
                comentario.texto,
                comentario.cod_situacao
            FROM comentario
            INNER JOIN usuario ON usuario.id_usuario = comentario.id_usuario
            WHERE usuario.id_usuario = '".do_escape($id_usuario)."'
            AND comentario.cod_situacao = 1
            ORDER BY comentario.data_inclusao DESC
        ";
        $comentarios = array();
        foreach (get_result($query) as $comentario) {
            $comentario->comentarios = $this->listarResposta($comentario->id_comentario);
            $comentario->versiculos = $this->listarVersiculo($comentario->id_comentario);
            $comentario->data = strftime("%b %d, %Y %Hh%M", strtotime($comentario->data_inclusao));
            $comentarios[] = $comentario;
        }
        return $comentarios;
    }
        /*
        $query = "
            SELECT
                versiculos.ver_id AS 'id',
                versiculos.ver_liv_id AS 'id_livro',
                versiculos.ver_capitulo AS 'id_capitulo',
                versiculos.ver_versiculo AS 'num_versiculo',
                versiculos.ver_texto AS 'texto',
                CONCAT(livros.liv_nome, ' ', versiculos.ver_capitulo, ':', versiculos.ver_versiculo) AS 'versiculo',
                (
                    SELECT COUNT(*)
                    FROM comentario_versiculo
                    WHERE comentario_versiculo.id_livro = versiculos.ver_liv_id
                    AND comentario_versiculo.id_capitulo = versiculos.ver_capitulo
                    AND comentario_versiculo.num_versiculo = versiculos.ver_versiculo
                ) AS 'comentario',
                (
                    SELECT count(*)
                    FROM usuario_versiculo
                    WHERE usuario_versiculo.id_usuario = '".do_escape($id_usuario)."'
                    AND usuario_versiculo.id_livro = versiculos.ver_liv_id
                    AND usuario_versiculo.id_capitulo = versiculos.ver_capitulo
                    AND usuario_versiculo.num_versiculo = versiculos.ver_versiculo
                    AND usuario_versiculo.tipo = '".do_escape(MARCA_FAVORITO)."'
                ) AS 'favorito',
                (
                    SELECT count(*)
                    FROM usuario_versiculo
                    WHERE usuario_versiculo.id_usuario = '".do_escape($id_usuario)."'
                    AND usuario_versiculo.id_livro = versiculos.ver_liv_id
                    AND usuario_versiculo.id_capitulo = versiculos.ver_capitulo
                    AND usuario_versiculo.num_versiculo = versiculos.ver_versiculo
                    AND usuario_versiculo.tipo = '".do_escape(MARCA_GOSTEI)."'
                ) AS 'gostei',
                (
                    SELECT count(*)
                    FROM usuario_versiculo
                    WHERE usuario_versiculo.id_usuario = '".do_escape($id_usuario)."'
                    AND usuario_versiculo.id_livro = versiculos.ver_liv_id
                    AND usuario_versiculo.id_capitulo = versiculos.ver_capitulo
                    AND usuario_versiculo.num_versiculo = versiculos.ver_versiculo
                    AND usuario_versiculo.tipo = '".do_escape(MARCA_DESGOSTEI)."'
                ) AS 'desgostei'
            FROM versiculos
            INNER JOIN livros ON livros.liv_id = versiculos.ver_liv_id
            INNER JOIN comentario_versiculo ON (
                comentario_versiculo.id_livro = versiculos.ver_liv_id AND 
                comentario_versiculo.id_capitulo = versiculos.ver_capitulo AND 
                comentario_versiculo.num_versiculo = versiculos.ver_versiculo
            )
            INNER JOIN comentario ON comentario.id_comentario = comentario_versiculo.id_comentario
            WHERE versiculos.ver_vrs_id = '".do_escape(ID_VERSAO)."'
            ORDER BY 
                versiculos.ver_liv_id,
                versiculos.ver_capitulo, 
                versiculos.ver_versiculo
        ";
        //echo $query;
        //return get_result($query);
        $versiculos = array();
        $result = get_result_db($query);
        while ($versiculo = get_object($result)) {
            $versiculos[] = $versiculo;
        }
        free_result($result);
        return $versiculos;
    }
    */
}