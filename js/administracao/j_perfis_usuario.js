
$(document).ready( function () {
    
    $('#salvarPerfis').on('click', function() {
        
        codigo = $('#codigo').val();

        id_atribuidos = [];
        
        $("#selecionados li").each(function(){

            id_atribuidos.push($(this).attr('id'));

        });
              
        $.ajax({
           type: "POST",
           url: 'c_usuarios/salvarPerfisAtribuidos',
           cache: false,
           data:{codigo:codigo,id_atribuidos:id_atribuidos},
           success: function(data){
               
               $('#janelaPerfisUsuario').modal('toggle');
               
                if (data != 'erro'){
                    $("#sucesso").html('Perfil(s) atribu&iacute;do(s) com sucesso.');
                    $("#janelaSucesso").appendTo("body").modal('show');
                }else{
                    $("#erro").html(data);
                    $("#janelaErro").appendTo("body").modal('show');
                }

            }
        });
                
    });
    
});


function atribui(id){
    
    conteudo = $('#'+id).html();
   
    largura = '340px';

    $('#selecionados').prepend('<li style="width:'+largura+';" class="alert alert-primary" id="' + id + '" onClick="desatribui('+ id + ')">' + $('#'+id).html() + '</li>');

    $('#disponiveis li[id='+id+']').remove();
    
}

function desatribui(id){
    
    conteudo = $('#'+id).html();
        
    largura = '340px';

    $('#disponiveis').prepend('<li style="width:'+largura+';" class="alert alert-primary" id="' + id + '" onClick="atribui('+ id + ')">' + conteudo + '</li>');
   
    $('#selecionados li[id='+id+']').remove();

}