<?php

function array_partition( $list, $p ) {
    $listlen = count( $list );
    $partlen = floor( $listlen / $p );
    $partrem = $listlen % $p;
    $partition = array();
    $mark = 0;
    for ($px = 0; $px < $p; $px++) {
        $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
        $partition[$px] = array_slice( $list, $mark, $incr );
        $mark += $incr;
    }
    return $partition;
}

function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
    $url = 'http://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

function isNullOrEmpty($texto) {
    return (is_null($texto) || trim($texto) == '');
}

function versiculo_opcao($versiculo) {
    $chave = "$versiculo->id_livro:$versiculo->id_capitulo:$versiculo->num_versiculo";
    if (isset($versiculo->gostei)) {
        echo '<a class="text-success gostei" href="#" data-versiculo="'.$chave.'">';
        echo '<i class="icon icon-thumbs-up"></i>';
        echo ' <span>'.$versiculo->gostei.'</span></a> ';
    }
    if (isset($versiculo->desgostei)) {
        echo '<a class="text-danger desgostei" href="#" data-versiculo="'.$chave.'">';
        echo '<i class="icon icon-thumbs-down"></i>';
        echo ' <span>'.$versiculo->desgostei.'</span></a> ';
    }
    if (isset($versiculo->comentario)) {
        echo '<a class="text-info comentario" href="#" data-versiculo="'.$chave.'">';
        echo '<i class="icon icon-comment"></i>';
        echo ' <span>'.$versiculo->comentario.'</span></a> ';
    }
    if (isset($versiculo->favorito)) {
        echo '<a class="text-warning favorito" href="#" data-versiculo="'.$chave.'"><i class="';
        echo ($versiculo->favorito == true) ? 'icon icon-star' : 'icon icon-star-o';
        echo '"></i></a> ';
    }
}