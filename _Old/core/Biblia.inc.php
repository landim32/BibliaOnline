<?php

define('ANTIGO_TESTAMENTO', 1);
define('NOVO_TESTAMENTO', 2);

class Biblia {
    
    public function listarVersao() {
        $versoes = array(
            1 => 'arib',
            2 => 'acrf',
            3 => 'nvi',
            4 => 'sbb',
            5 => 'ara',
            6 => 'ni'
        );
        $query = "
            SELECT
                vrs_id AS 'id',
                vrs_nome AS 'nome'
            FROM versoes
            ORDER BY vrs_id
        ";
        $retorno = array();
        $result = get_result_db($query);
        while ($versao = get_object($result)) {
            if (array_key_exists($versao->id, $versoes))
                $versao->slug = $versoes[$versao->id];
            $retorno[$versao->id] = $versao;
        }
        free_result($result);
        return $retorno;
    }
    
    public function listarTestamento() {
        $query = "
            SELECT
                tes_id AS 'id',
                tes_nome AS 'nome'
            FROM testamentos
            ORDER BY tes_id
        ";
        return get_result_as_list($query, 'id', 'nome');
    }
    
    public function listarLivro($id_testamento = null) {
        $query = "
            SELECT
                liv_id AS 'id_livro',
                liv_nome AS 'nome'
            FROM livros
        ";
        if (!is_null($id_testamento))
            $query .= " WHERE liv_tes_id = '".do_escape($id_testamento)."'";
        $query .= " ORDER BY liv_posicao";
        //return get_result_as_list($query, 'id_livro', 'nome');
        return get_result($query);
    }
    
    public function pegarLivro($id_livro) {
        $query = "
            SELECT
                livros.liv_id AS 'id_livro',
                livros.liv_nome AS 'nome',
                testamentos.tes_nome AS 'testemunho'
            FROM livros
            INNER JOIN testamentos ON testamentos.tes_id = livros.liv_tes_id
            WHERE livros.liv_id = '".do_escape($id_livro)."'
        ";
        return get_first_result($query);
    }
    
    public function listarCapitulo($id_versao, $id_livro) {
        $query = "
            SELECT DISTINCT
                ver_capitulo AS 'capitulo'
            FROM versiculos
            WHERE (1=1)
        ";
        if (!is_null($id_versao))
            $query .= " AND ver_vrs_id = '".do_escape($id_versao)."'";
        if (!is_null($id_livro))
            $query .= " AND ver_liv_id = '".do_escape($id_livro)."'";
        $query .= " ORDER BY ver_capitulo";
        return get_result_as_string($query, 'capitulo');
    }
    
    public function listarVersiculo($id_versao, $id_livro, $id_capitulo) {
        $regraUsuario = new Usuario();
        $usuario = $regraUsuario->pegarAtual();
        if (!is_null($usuario))
            $id_usuario = $usuario->id_usuario;
        $query = "
            SELECT
                versiculos.ver_id AS 'id',
                versiculos.ver_liv_id AS 'id_livro',
                versiculos.ver_capitulo AS 'id_capitulo',
                versiculos.ver_versiculo AS 'num_versiculo',
                versiculos.ver_texto AS 'texto',
                (
                    SELECT COUNT(*)
                    FROM comentario_versiculo
                    WHERE comentario_versiculo.id_livro = versiculos.ver_liv_id
                    AND comentario_versiculo.id_capitulo = versiculos.ver_capitulo
                    AND comentario_versiculo.num_versiculo = versiculos.ver_versiculo
                ) AS 'comentario'
        ";
        if ($id_usuario > 0) {
            $query .= ",(
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
            ";
        }
        $query .= "
            FROM versiculos
            WHERE (1=1)
        ";
        if (!is_null($id_versao))
            $query .= " AND versiculos.ver_vrs_id = '".do_escape($id_versao)."'";
        if (!is_null($id_livro))
            $query .= " AND versiculos.ver_liv_id = '".do_escape($id_livro)."'";
        if (!is_null($id_capitulo))
            $query .= " AND versiculos.ver_capitulo = '".do_escape($id_capitulo)."'";
        $query .= " 
            ORDER BY 
                versiculos.ver_capitulo, 
                versiculos.ver_versiculo
        ";
        //echo $query;
        return get_result($query);
    }
    
    public function buscar($palavraChave) {
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
                ) AS 'comentario'
            FROM versiculos
            INNER JOIN livros ON livros.liv_id = versiculos.ver_liv_id
            WHERE versiculos.ver_vrs_id = '".do_escape(ID_VERSAO)."'
        ";
        $palavras = explode(' ', $palavraChave);
        $queryWhere = array();
        foreach ($palavras as $palavra)
            $queryWhere[] = 'CONCAT(" ", versiculos.ver_texto, " ") LIKE "% '.  do_escape($palavra).' %"';
        $query .= " AND (".implode(' OR ', $queryWhere).")";
        $query .= " 
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
            foreach ($palavras as $palavra)
                $versiculo->texto = str_ireplace($palavra, "<strong>".  mb_strtoupper($palavra)."</strong>", $versiculo->texto);
            $versiculos[] = $versiculo;
        }
        free_result($result);
        return $versiculos;
    }
    
    public function listarMarcado($id_usuario, $tipo = 1) {
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
            INNER JOIN usuario_versiculo ON (
                usuario_versiculo.id_livro = versiculos.ver_liv_id AND 
                usuario_versiculo.id_capitulo = versiculos.ver_capitulo AND 
                usuario_versiculo.num_versiculo = versiculos.ver_versiculo
            )
            WHERE versiculos.ver_vrs_id = '".do_escape(ID_VERSAO)."'
            AND usuario_versiculo.tipo = '".do_escape($tipo)."'
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
    
    public function listarVersiculoVersao($id_versao, $id_livro, $id_capitulo, $num_versiculo) {
        $query = "
            SELECT
                versiculos.ver_id AS 'id',
                versiculos.ver_versiculo AS 'numero',
                versiculos.ver_texto AS 'texto',
                versoes.vrs_nome AS 'versao'
            FROM versiculos
            INNER JOIN versoes ON versoes.vrs_id = versiculos.ver_vrs_id
            WHERE versiculos.ver_vrs_id <> '".do_escape($id_versao)."'
            AND versiculos.ver_liv_id = '".do_escape($id_livro)."'
            AND versiculos.ver_capitulo = '".do_escape($id_capitulo)."'
            AND versiculos.ver_versiculo = '".do_escape($num_versiculo)."'
            ORDER BY 
                versiculos.ver_versiculo
        ";
        return get_result($query);
    }
    
    public function pegarVersiculo($id_versao, $id_livro, $id_capitulo, $num_versiculo) {
        $regraUsuario = new Usuario();
        $usuario = $regraUsuario->pegarAtual();
        if (!is_null($usuario))
            $id_usuario = $usuario->id_usuario;
        $query = "
            SELECT
                versiculos.ver_id AS 'id',
                versiculos.ver_versiculo AS 'numero',
                versiculos.ver_texto AS 'texto',
                versiculos.ver_liv_id AS 'id_livro',
                versiculos.ver_capitulo AS 'id_capitulo',
                versiculos.ver_versiculo AS 'num_versiculo',
                versoes.vrs_nome AS 'versao',
                CONCAT(livros.liv_nome, ' ', versiculos.ver_capitulo, ':', versiculos.ver_versiculo) AS 'nome_versiculo',
                (
                    SELECT COUNT(*)
                    FROM comentario_versiculo
                    WHERE comentario_versiculo.id_livro = versiculos.ver_liv_id
                    AND comentario_versiculo.id_capitulo = versiculos.ver_capitulo
                    AND comentario_versiculo.num_versiculo = versiculos.ver_versiculo
                ) AS 'comentario'
        ";
        if ($id_usuario > 0) {
            $query .= ",(
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
            ";
        }
        $query .= "
            FROM versiculos
            INNER JOIN versoes ON versoes.vrs_id = versiculos.ver_vrs_id
            INNER JOIN livros ON livros.liv_id = versiculos.ver_liv_id
            WHERE (1=1)
        ";
        if (!is_null($id_versao))
            $query .= " AND versiculos.ver_vrs_id = '".do_escape($id_versao)."'";
        if (!is_null($id_livro))
            $query .= " AND versiculos.ver_liv_id = '".do_escape($id_livro)."'";
        if (!is_null($id_capitulo))
            $query .= " AND versiculos.ver_capitulo = '".do_escape($id_capitulo)."'";
        if (!is_null($num_versiculo))
            $query .= " AND versiculos.ver_versiculo = '".do_escape($num_versiculo)."'";
        //$query .= " ORDER BY ver_capitulo, ver_versiculo";
        //echo $query;
        return get_first_result($query);
    }
    
    public function autoCompletarVersiculo($id_versao, $palavraChave) {
        $query = "
            SELECT
                CONCAT(livros.liv_nome, ' ', versiculos.ver_capitulo, ':', versiculos.ver_versiculo) AS 'nome'
            FROM versiculos
            INNER JOIN versoes ON versoes.vrs_id = versiculos.ver_vrs_id
            INNER JOIN livros ON livros.liv_id = versiculos.ver_liv_id
            WHERE versiculos.ver_vrs_id = '".do_escape($id_versao)."'
            AND CONCAT(livros.liv_nome, ' ', versiculos.ver_capitulo, ':', versiculos.ver_versiculo) LIKE '".do_escape($palavraChave)."%'
            ORDER BY
                livros.liv_nome, 
                versiculos.ver_capitulo, 
                versiculos.ver_versiculo
            LIMIT 15
        ";
        return get_result_as_string($query, 'nome');
    }
    
    public function pegarIdTestamento() {
        $testamento = ANTIGO_TESTAMENTO;
        if ($_GET['testamento'] == 'at')
            $testamento = ANTIGO_TESTAMENTO;
        elseif ($_GET['testamento'] == 'nt')
            $testamento = NOVO_TESTAMENTO;
        return $testamento;
        //$id_livro = intval($_GET['livro']);
    }
    
    public function pegarTestamento() {
        if (array_key_exists('testamento', $_GET)) {
            if ($_GET['testamento'] == 'at')
                return 'at';
            else
                return 'nt';
        }
        else
            return 'at';
    }
    
    public function pegarIdLivro() {
        return intval($_GET['livro']);
    }
    
    public function pegarVersao() {
        if (array_key_exists('versao', $_GET))
            return $_GET['versao'];
        else
            return 'nvi';
    }
    
    public function pegarIdVersao() {
        $versoes = array(
            'arib' => 1,
            'acrf' => 2,
            'nvi' => 3,
            'sbb' => 4,
            'ara' => 5,
            'ni' => 6
        );
        if (array_key_exists($_GET['versao'], $versoes))
            return $versoes[$_GET['versao']];
        else
            return 3;
    }
    
    public function pegarIdCapitulo() {
        return intval($_GET['capitulo']);
    }
    
    public function gerarXML() {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->startDocument( '1.0' , 'UTF-8' );
        $xml->startElement("urlset");
        $xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        
        $url = "http://$_SERVER[HTTP_HOST]";

        $xml->startElement("url");
        $xml->writeElement('loc', 'http://bibliaemdebate.com.br');
        //$xml->writeElement('lastmod', date('Y-m-d') );
        $xml->writeElement('changefreq', 'daily');
        $xml->writeElement('priority', '0.5');
        $xml->endElement(); //url
        $query = "
            SELECT DISTINCT
                livros.liv_tes_id AS 'id_testamento',
                versiculos.ver_liv_id AS 'id_livro',
                versiculos.ver_capitulo AS 'id_capitulo'
            FROM versiculos
            INNER JOIN livros ON livros.liv_id = versiculos.ver_liv_id
            AND versiculos.ver_vrs_id = 3
            ORDER BY
                livros.liv_tes_id,
                versiculos.ver_liv_id,
                versiculos.ver_capitulo
        ";
        $result = get_result_db($query);
        while ($versiculo = get_object($result)) {
            $url = 'http://bibliaemdebate.com.br/nvi/';
            if ($versiculo->id_testamento == NOVO_TESTAMENTO)
                $url .= 'nt';
            elseif ($versiculo->id_testamento == ANTIGO_TESTAMENTO)
                $url .= 'at';
            $url .= "/$versiculo->id_livro/$versiculo->id_capitulo";
            $xml->startElement("url");
            $xml->writeElement('loc', $url);
            //$xml->writeElement('lastmod', substr($imovel->ultima_alteracao, 0, 10) );
            $xml->writeElement('changefreq', 'yearly');
            $xml->writeElement('priority', '1.0');
            $xml->endElement(); //url
        }
        free_result($result);
        

        $xml->endElement(); //urlset
        $xml->endDocument();
        //echo $xml->outputMemory(TRUE);
        return $xml;
    }
    
}