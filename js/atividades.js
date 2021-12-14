$(document).ready( function () {
    
    $.ajaxSetup({ cache: false }); 
    
    $( document ).ajaxStart(function() {
        
        $('<img id="loadingGif" style="position: absolute; z-index: 1;" class="centro" src="img/preloader.gif" />').appendTo("#barra_titulo");
        $('#conteudo').addClass("div_carregando");
    
    });
    
    $( document ).ajaxSuccess(function() {
        
        $("#loadingGif").remove();
        $('#conteudo').removeClass("div_carregando");
        
    });
    
    $( document ).ajaxComplete(function() {
        
        $("#loadingGif").remove();
        $('#conteudo').removeClass("div_carregando");
        
    });
    
    $(document).ajaxError(function(event,xhr,options,exc){
        
        erro = xhr.responseText;
        
        pos1 = erro.indexOf("<body>");
        
        pos2 = erro.indexOf("</html>");

        $("#erro").html(erro.substr(parseInt(pos1), parseInt(pos2 - pos1))).dialog("open");
        
    });
    
    $(function() {
        
        if ($('input[name="logout"]').val() == '1'){
            
            $('#area_usuario_logado').removeClass('ui-state-active ui-corner-all');
            $('#usuario_logado_icone').removeClass('ui-icon ui-icon-person');
            $('#usuario_logado_nome').html('');
            
        }
        
        $('input[name="novaSenha"]').keyup(function() {
            valor = $(this).val().replace(/[^!@#$%&*.a-zA-Z0-9]+/g,'');
            $(this).val(valor);
        });

        $('input[name="confirmaSenha"]').keyup(function() {
            valor = $(this).val().replace(/[^!@#$%&*.a-zA-Z0-9]+/g,'');
            $(this).val(valor);
        });

        switch($('input[name="erroSenha"]').val()) {

        case '1': {

            $("#erroSenha").html('Senhas não conferem.');
            $("#erroSenha").addClass('alert alert-danger');
            break;  

        }

        case '2': {

            $("#erroSenha").html('As senhas não podem estar em branco.');
            $("#erroSenha").addClass('alert alert-danger');
            break;  

        }

        case '3': {

            $("#erroSenha").html('A senha não pode ser o login.');
            $("#erroSenha").addClass('alert alert-danger');
            break;  

        }

        case '4': {

            $("#erroSenha").html('Primeiro acesso ou senha resetada.<br>A senha deve ter, no mínimo, 8 caracteres; uma letra maiúscula, uma minúscula e um número.');
            $("#erroSenha").addClass('alert alert-danger');
            break;  

        }

        case '5': {

            $("#erroSenha").html('Erro ao alterar a senha.');
            $("#erroSenha").addClass('alert alert-danger');
            break;  

        }

        case '6': {

            $("#erroSenha").html('A senha deve conter 8 caracteres, no mínimo.');
            $("#erroSenha").addClass('alert alert-danger');
            break;  

        }

        case '7': {

            $("#erroSenha").html('A senha deve conter uma letra maiúscula, sem acentos.');
            $("#erroSenha").addClass('alert alert-danger');
            break;  

        }

        case '8': {

            $("#erroSenha").html('A senha deve conter uma letra minúscula, sem acentos.');
            $("#erroSenha").addClass('alert alert-danger');
            break;  

        }

        case '9': {

            $("#erroSenha").html('A senha deve conter um número.');
            $("#erroSenha").addClass('alert alert-danger');
            break;  

        }

        case '10': {

            $("#erroSenha").html('A senha não deve conter espaço ou tab.');
            $("#erroSenha").addClass('alert alert-danger');
            break;  

        }

    }
            
        switch($('input[name="erroLogin"]').val()) {

            case '1': {
                    
                $("#erroLogin").html('Login e/ou senha inv&aacute;lidos.');
                $("#erroLogin").addClass('alert alert-danger');
                break;  
                
            }
            
            case '2': {
                    
                $("#erroLogin").html('Senha alterada com sucesso.');
                $("#erroLogin").addClass('ui-state-highlight');
                break;  
                
            }
            
            case '3': {
                    
                $("#erroLogin").html('Usu&aacute;rio desativado.');
                $("#erroLogin").addClass('alert alert-danger');
                break;  
                
            }
            
            case '4': {
                    
                $("#erroLogin").html('Login e/ou senha inv&aacute;lidos.');
                $("#erroLogin").addClass('alert alert-danger');
                break;  
                
            }
            
            case '5': {
                    
                $("#erroLogin").html('C&oacute;digo de segura&ccedil;a inv&aacute;lido.');
                $("#erroLogin").addClass('alert alert-danger');
                break;  
                
            }
            
        }
    
    });
    
    $('input[name="newlogin"]').click(function() {
        
        novaSenha = $('input[name="novaSenha"]').val();
        confirmaSenha = $('input[name="confirmaSenha"]').val();
        seq =  $('input[name="seq"]').val();
        
        encryption = new Encryption();
        hashSenha = encryption.encrypt(novaSenha, seq);
        hashConfirma = encryption.encrypt(confirmaSenha, seq);

        $('input[name="newpassw"]').val(hashSenha);
        $('input[name="confirmnewpassw"]').val(hashConfirma);
        $('input[name="novaSenha"]').val('**********');
        $('input[name="confirmaSenha"]').val('**********');
        $('input[name="seq"]').val('**********');

    });
    
    $('input[name="login"]').inputmask({"placeholder": "", mask: ['99999999999'], keepStatic: true });
    
    $('input[name="entrar"]').click(function() {
        
        login =  $('input[name="login"]').val();
        senha = $('input[name="senha"]').val();
        seq =  $('input[name="seq"]').val();
                
        encryption = new Encryption();
        hash = encryption.encrypt(senha, seq);
        hashLogin = encryption.encrypt(login, seq);
               
        $('input[name="hash"]').val(hash);
        $('input[name="hashLogin"]').val(hashLogin);
        $('input[name="seq"]').val('**********');
        $('input[name="login"]').val('**********');
        $('input[name="senha"]').val('**********');
           
    });
    
});

function testaVazio(campo, objeto){
    
    if (campo == ''){
        
        objeto.addClass('requerido');
        objeto.attr('placeholder','Requerido');
        return false;

    }else{
        
        objeto.removeClass('requerido');
        return true;
        
    }
    
}