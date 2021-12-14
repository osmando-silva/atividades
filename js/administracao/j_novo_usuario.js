$(document).ready( function () {
    
    $('#n_login').inputmask({"placeholder": "-", mask: ['999.999.999-99'],keepStatic: true });

    $('#salvarNovoUsuario').on('click', function() {
        
        if(!$("#form_novo_usuario").valid()){
            $("#requerido").html('<strong>(*) Campo Requerido</strong>');
            return false;
        }else{
            $("#requerido").html('');
        }
        
        login = $('#n_login').val();
        nome = $('#n_nome').val();
        contato = $('#n_contato').val();
        email = $('#n_email').val();
        
        $.ajax({
            type: "POST",
            url: 'c_usuarios/salvarNovoUsuario',
            cache: false,
            data:{login:login,nome:nome,contato:contato,email:email},
            success: function(data){
                
                if (data == 'invalido'){
                    $("#erro").html('Existe(m) caracter(es) inv&aacute;lido(s).');
                    $("#janelaErro").appendTo("body").modal('show');
                }else if (data == 'existe'){
                    $("#erro").html('J&aacute; existe um Usu&aacute;rio com esse CPF.');
                    $("#janelaErro").appendTo("body").modal('show');
                }else if (data == 'ok'){
                    window.location.href = "usuarios";
                }else{
                    $("#erro").html(data);
                    $("#janelaErro").appendTo("body").modal('show');
                }

            }
        });
        
    });
    
    $("#form_novo_usuario").validate({
	 rules: {
	    n_login: { required: true },
            n_nome: { required: true },
            n_contato: { required: true },
            n_email: { required: true }
	},
	messages: { 
            n_login: "<strong> (*)</strong>",
            n_nome: "<strong> (*)</strong>",
            n_contato: "<strong> (*)</strong>",
            n_email: "<strong> (*)</strong>"
        }

    });
    
});    