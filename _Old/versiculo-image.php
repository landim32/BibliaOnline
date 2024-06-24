<?php 
require('common.inc.php'); 

$regraBiblia = new Biblia();
$versiculo = $GLOBALS['_versiculo'];

//var_dump($versiculo);
$imageWidth = 1200;
$lineHeight = 3;
$shadowSize = 3;

$paddingTop = 50;
$paddingBottom = 50;
$paddingLeft = 30;
$paddingRight = 30;

$fonteSize = 40;
//$fonte = FONTE_DIR."/ufl/ubuntu/Ubuntu-Regular.ttf";
$fonte = __DIR__."/fonts/Ubuntu-Regular.ttf";
$palavras = explode(' ', '"'.utf8_decode($versiculo->texto).'"');
$linhas = array();
$linhaAtual = '';
$altura = 0;
foreach ($palavras as $palavra) {
    $box = imagettfbbox($fonteSize, 0, $fonte, $linhaAtual.$palavra);
    //$largura = $box[2];
    $largura = abs($box[4] - $box[0]);
    $alturaLocal = abs($box[5] - $box[1]);
    if ($alturaLocal > $altura)
        $altura = $alturaLocal;
    if ($largura > ($imageWidth - ($paddingLeft + $paddingRight))) {
        $linhas[] = $linhaAtual;
        $linhaAtual = $palavra.' ';
    }
    else
        $linhaAtual .= $palavra.' ';
    //var_dump($box, $altura);
    //var_dump($linhaAtual, $box[2]);
}
if (strlen(trim($linhaAtual)) > 0)
    $linhas[] = trim($linhaAtual);

$versiculoSize = floor($fonteSize * 0.7);
$box = imagettfbbox($versiculoSize, 0, $fonte, $versiculo->nome_versiculo);
$versiculoLargura = abs($box[4] - $box[0]);
$versiculoAltura = abs($box[5] - $box[1]);

$imageHeight = (count($linhas) * $altura);
$imageHeight += ((count($linhas) - 1) * $lineHeight);
$imageHeight += $paddingTop + $paddingBottom;
$imageHeight += ($lineHeight * 2) + $versiculoAltura;

if ($imageHeight < 630)
    $imageHeight = 630;
$imagem = imagecreatetruecolor($imageWidth, $imageHeight);
$fundo = imagecolorallocate( $imagem, 255, 255, 255 );
$preto = imagecolorallocate( $imagem, 0, 0, 0 );
$sombra = imagecolorallocate( $imagem, 211, 211, 211 );
//$fundo = imagecolorallocate( $imagem, 210, 210, 210 );
imagefilledrectangle( $imagem, 0, 0, $imageWidth, $imageHeight, $fundo);
$top = $paddingTop + floor($altura / 2);
//echo '<pre>';
foreach ($linhas as $linha) {
    $box = imagettfbbox($fonteSize, 0, $fonte, $linha);
    $largura = abs($box[4] - $box[0]);
    $left = $paddingLeft + floor((($imageWidth - ($paddingLeft + $paddingRight)) - $largura) / 2);
    imagefttext($imagem, $fonteSize, 0, $left + $shadowSize, $top + $shadowSize, $sombra, $fonte, $linha);
    imagefttext($imagem, $fonteSize, 0, $left, $top, $preto, $fonte, $linha);
    $top += $altura + $lineHeight;
    //var_dump($linha, $largura, $box);
}
$top += $lineHeight;
$left = ($imageWidth - ($paddingLeft + $paddingRight)) - $versiculoLargura;
imagefttext($imagem, $versiculoSize, 0, $left + $shadowSize, $top + $shadowSize, $sombra, $fonte, $versiculo->nome_versiculo);
imagefttext($imagem, $versiculoSize, 0, $left, $top, $preto, $fonte, $versiculo->nome_versiculo);

$left = $paddingLeft;
$pequenaSize = floor($fonteSize * 0.5);
$cinza = imagecolorallocate( $imagem, 180, 180, 180 );
//imagefttext($imagem, $versiculoSize, 0, $left + $shadowSize, $top + $shadowSize, $sombra, $fonte, 'bibliaemdebate.com.br');
imagefttext($imagem, $pequenaSize, 0, $left, $top, $cinza, $fonte, 'bibliaemdebate.com.br');

//echo '</pre>';
header('Content-type: image/jpeg');
imagejpeg($imagem, NULL, 80);
