$(document).ready( function () {
    
    $('#salvarNovaAtividade').on('click', function() {
        
        if(!$("#form_nova_atividade").valid()){
            $("#requerido").html('<strong>(*) Campo Requerido</strong>');
            return false;
        }else{
            $("#requerido").html('');
        }
        
        titulo = $('#n_titulo').val();
        descricao = $('#n_desc').val();
        tipo = $('#n_tipo').val();
        tipoAtividade = $('#n_tipo option:selected').text();
                
        $.ajax({
            type: "POST",
            url: 'c_atividades/salvarNovaAtividade',
            cache: false,
            data:{titulo:titulo,descricao:descricao,tipo:tipo,tipoAtividade:tipoAtividade},
            success: function(data){
                
                if (data == 'ok'){
                    window.location.href = "atividades";
                }else{
                    $("#erro").html(data);
                    $("#janelaErro").appendTo("body").modal('show');
                }

            }
        });
        
    });
    
    $("#form_nova_atividade").validate({
	 rules: {
	    n_titulo: { required: true },
            n_desc: { required: true }
	},
	messages: { 
            n_titulo: "<strong> (*)</strong>",
            n_desc: "<strong> (*)</strong>"
        }

    });
    
});    