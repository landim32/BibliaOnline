<?php require('common.inc.php'); ?>
<?php require('header.inc.php'); ?>
<?php require('menu-principal.inc.php'); ?>
<div class="container" style="margin-top: 80px">
    <div class="row">
        <div class="col-md-9">
            <?php if (TESTAMENTO == 'at') : ?>
            <?php require('testamento-antigo.inc.php'); ?>
            <?php else : ?>
            <?php require('testamento-novo.inc.php'); ?>
            <?php endif; ?>
        </div>
        <div class="col-md-3">
            <?php //require('livro.inc.php'); ?>
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- BibliaEmDestaque -->
            <ins class="adsbygoogle"
                style="display:block"
                data-ad-client="ca-pub-5769680090282398"
                data-ad-slot="1990484248"
                data-ad-format="auto"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>
</div>
<?php require('footer.inc.php'); ?>