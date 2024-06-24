<?php $versiculo = $GLOBALS['_versiculo']; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Rodrigo Landim" />
    <link rel="icon" href="/favicon.ico" />
    <?php if (!is_null($versiculo)) : ?>
    <?php //var_dump($versiculo); ?>
    <meta name="description" content="<?php echo htmlentities($versiculo->texto); ?>">
    <meta property="og:title" content="<?php echo $versiculo->nome_versiculo; ?>" />
    <meta property="og:site_name" content="Bíblia em Debate" />
    <meta property="og:url" content="<?php echo 'http://www.bibliaemdebate.com.br/'.VERSAO.'/'.TESTAMENTO.'/'.ID_LIVRO.'/'.ID_CAPITULO.'/'.NUM_VERSICULO; ?>" />
    <meta property="og:description" content="<?php echo htmlentities($versiculo->texto); ?>" />
    <meta property="og:image" content="<?php echo 'http://www.bibliaemdebate.com.br/'.VERSAO.'/'.TESTAMENTO.'/'.ID_LIVRO.'/'.ID_CAPITULO.'/'.NUM_VERSICULO; ?>/versiculo.jpg" />
    <title><?php echo $versiculo->nome_versiculo; ?> | Bíblia em Debate</title>    
    <?php else : ?>
    <title>Bíblia em Debate</title>
    <?php endif; ?>
    <!-- Bootstrap core CSS -->
    <link href="/css/biblia-ateia.min.css" rel="stylesheet" />
    <link href="/css/tokenfield-typeahead.min.css" rel="stylesheet" />
    <link href="/css/bootstrap-tokenfield.min.css" rel="stylesheet" />
    <link href="/css/jquery-ui.min.css" rel="stylesheet" />
    <style type="text/css">
        .ui-autocomplete { z-index:2147483647; }
    </style>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-70777202-1', 'auto');
  ga('send', 'pageview');

</script>