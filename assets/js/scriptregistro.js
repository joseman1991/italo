$(document).ready(function () {
    var provincias = $('#provincia');


    provincias.change(function () {
        var idprovincia = $(this).val();
          $.ajax({
                type:'POST',
                url:'phpCantones.php',
                data:'idprovincia='+idprovincia,
                success:function(html){
                    $('#canton').html(html);
                  
                }
            }); 
    });
});