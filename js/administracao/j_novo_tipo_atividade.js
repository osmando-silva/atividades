$(document).ready( function () {
    
    $('#salvarNovoTipo').on('click', function() {
        
        if(!$("#form_novo_tipo").valid()){
            $("#requerido").html('<strong>(*) Campo Requerido</strong>');
            return false;
        }else{
            $("#requerido").html('');
        }
        
        descricao = $('#n_desc').val();
        
        $.ajax({
            type: "POST",
            url: 'c_tipo_atividade/salvarNovoTipo',
            cache: false,
            data:{descricao:descricao},
            success: function(data){
                
                if (data == 'invalido'){
                    $("#erro").html('Existe(m) caracter(es) inv&aacute;lido(s).');
                    $("#janelaErro").appendTo("body").modal('show');
                }else if (data == 'ok'){
                    window.location.href = "tipos";
                }else{
                    $("#erro").html(data);
                    $("#janelaErro").appendTo("body").modal('show');
                }

            }
        });
        
    });
    
    $("#form_novo_tipo").validate({
	
        rules: {
	    n_desc: { required: true }
	},
	messages: { 
            n_desc: "<strong> (*)</strong>"
        }

    });
    
});    