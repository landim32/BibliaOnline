$(document).ready(function(){
    $('a.favorito').click(function (e) {
        var btn = this;
        var versiculo = $(this).attr('data-versiculo');
        $.ajax({
            url: "/ajax-marca.php",
            type: 'POST',
            data: {
                versiculo: versiculo,
                tipo: 1
            },
            success: function( data ) {
                //alert(data);
                if (data == '1') {
                    $(btn).find('i').attr('class', 'icon icon-star');
                }
                else if (data == '0')  {
                    $(btn).find('i').attr('class', 'icon icon-star-o');
                }
                else
                    alert(data);
            }
        });
        return false;
    });
    $('a.gostei').click(function (e) {
        var btn = this;
        var versiculo = $(this).attr('data-versiculo');
        $.ajax({
            url: "/ajax-marca.php",
            type: 'POST',
            data: {
                versiculo: versiculo,
                tipo: 2
            },
            success: function( data ) {
                //alert(data);
                var gostei = parseInt($(btn).find('span').html());
                if (data == '1') {
                    gostei = gostei + 1;
                    $(btn).find('span').html(gostei);
                }
                else if (data == '0')  {
                    gostei = gostei - 1;
                    $(btn).find('span').html(gostei);
                }
                else
                    alert(data);
            }
        });
        return false;
    });
    $('a.desgostei').click(function (e) {
        var btn = this;
        var versiculo = $(this).attr('data-versiculo');
        $.ajax({
            url: "/ajax-marca.php",
            type: 'POST',
            data: {
                versiculo: versiculo,
                tipo: 3
            },
            success: function( data ) {
                //alert(data);
                var gostei = parseInt($(btn).find('span').html());
                if (data == '1') {
                    gostei = gostei + 1;
                    $(btn).find('span').html(gostei);
                }
                else if (data == '0')  {
                    gostei = gostei - 1;
                    $(btn).find('span').html(gostei);
                }
                else
                    alert(data);
            }
        });
        return false;
    });
});