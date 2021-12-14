$(document).ready( function () {
    
    $('[id^=login]').inputmask({"placeholder": "", mask: ['999.999.999-99'],keepStatic: true });
    
    $('button').button();
    
    $("#novo_usuario").click(function(){
        
        $.ajax({
           type: "POST",
           url: 'c_usuarios/novoUsuario',
           cache: false,
            success: function(data){
                
                $("#viewNovoUsuario").html(data);
                $("#janelaNovoUsuario").modal('show');
                    
            }
        });
        
    });
    
    setaDataTable();
    
    $('#inativarUsuario').on('click', function() {
        
        codigo = $('#codigo').val();
        nome = $('#nome'+codigo).val();

        $.ajax({
            type: "POST",
            url: 'c_usuarios/inativar',
            cache: false,
            data:{codigo:codigo},
            success: function(data){
                
                $('#janelaInativarUsuario').modal('toggle');
                
                if (data == 'ok'){

                    desativar = '<button onclick="ativar('+codigo+')" class="btn-primary"><i class="fa fa-power-off"></i>&nbsp;&nbsp;Ativar&nbsp;&nbsp;</button>';                        
                    $('#botoes'+codigo).html(desativar);
                    $('#botoes'+codigo).button();
                    $("#sucesso").html('Usu&aacute;rio '+nome+' Inativado com sucesso.');
                    $("#janelaSucesso").appendTo("body").modal('show');

                }else{
                    $("#erro").html(data);
                    $("#janelaErro").appendTo("body").modal('show');
                }

            }
            
        });
                
    });
    
    $('#ativarUsuario').on('click', function() {
        
        codigo = $('#codigo').val();
        nome = $('#nome'+codigo).val();

        $.ajax({
            type: "POST",
            url: 'c_usuarios/ativar',
            cache: false,
            data:{codigo:codigo},
            success: function(data){
                
                $('#janelaAtivarUsuario').modal('toggle');
                
                if (data == 'ok'){

                    ativar = '<button onclick="inativar('+codigo+')" class="btn-primary"><i class="fa fa-power-off"></i> Inativar</button>';                       
                    $('#botoes'+codigo).html(ativar);
                    $('#botoes'+codigo).button();
                    $("#sucesso").html('Usu&aacute;rio '+nome+' Ativado com sucesso.');
                    $("#janelaSucesso").appendTo("body").modal('show');

                }else{
                    $("#erro").html(data);
                    $("#janelaErro").appendTo("body").modal('show');
                }

            }
            
        });
                
    });
    
    $('#resetarSenha').on('click', function() {
        
        codigo = $('#codigo').val();
        nome = $('#nome'+codigo).val();
        
        $.ajax({
            type: "POST",
            url: 'c_usuarios/resetarSenha',
            cache: false,
            data:{codigo:codigo},
            success: function(data){
                
                $('#janelaResetarSenha').modal('toggle');
                
                if (data == 'ok'){

                    $("#sucesso").html('Senha do Usu&aacute;rio '+nome+' resetada com sucesso.');
                    $("#janelaSucesso").appendTo("body").modal('show');

                }else{
                    $("#erro").html(data);
                    $("#janelaErro").appendTo("body").modal('show');
                }

            }
            
        });
                
    });
    
});

function setaDataTable(){
    
    $('#usuarios_hotel').dataTable({
        "sort":false,
        "scrollY": "400px",
        "scrollCollapse": true,
        "fixedHeader": true,
        "bJQueryUI": true,
        "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
        "responsive": true,
        "sPaginationType": "full_numbers",
        "columnDefs": [
        {"className": "dt-center", "targets": "_all"}
      ]
      
    });

}

function salvar(codigo){
    
    login = $('#login'+codigo).val();
    loginOrig = $('#loginOrig'+codigo).val();
    nome = $('#nome'+codigo).val();
    contato = $('#contato'+codigo).val();
    email = $('#email'+codigo).val();
    
    if (testaVazio(login, $('#login'+codigo)) && testaVazio(nome, $('#nome'+codigo)) && testaVazio(contato, $('#contato'+codigo)) ){
        
        $.ajax({
            type: "POST",
            url: 'c_usuarios/salvar',
            cache: false,
            data:{codigo:codigo,login:login,loginOrig:loginOrig,nome:nome,contato:contato,email:email},
            success: function(data){
                
                if (data == 'invalido'){
                    $("#erro").html('Existe(m) caracter(es) inv&aacute;lido(s).');
                    $("#janelaErro").appendTo("body").modal('show');
                }else if (data == 'existe'){
                    $("#erro").html('J&aacute; existe um Usu&aacute;rio com esse CPF.');
                    $("#janelaErro").appendTo("body").modal('show');
                }else if (data == 'ok'){
                    $("#sucesso").html('Dados alterados com sucesso.');
                    $("#janelaSucesso").appendTo("body").modal('show');
                }else{
                    $("#erro").html(data);
                    $("#janelaErro").appendTo("body").modal('show');
                }
               
            }
            
        });

    }
    
}

function perfisUsuario(codigo){
    
    $('#codigo').val(codigo);
    nome = $('#nome'+codigo).val();
        
    $.ajax({
        type: "POST",
        url: 'c_usuarios/perfisUsuario',
        cache: false,
        data:{codigo:codigo},
        success: function(data){
            
            $("#PerfisUsuario").html("Perfis atrubu&iacute;dos &agrave; "+nome);
            $("#viewPerfisUsuario").html(data);
            $("#janelaPerfisUsuario").modal('show');

        }
    });

}

function inativar(codigo){
    
    nome = $('#nome'+codigo).val();
    $('#codigo').val(codigo);
    $("#viewInativarUsuario").html('Inativar o usu&aacute;rio '+nome+'?');
    $("#janelaInativarUsuario").appendTo("body").modal('show');
    
}

function ativar(codigo){
    
    nome = $('#nome'+codigo).val();
    $('#codigo').val(codigo);
    $("#viewAtivarUsuario").html('Ativar o usu&aacute;rio '+nome+'?');
    $("#janelaAtivarUsuario").appendTo("body").modal('show');
    
}

function resetaSenha(codigo){
    
    nome = $('#nome'+codigo).val();
    
    $('#codigo').val(codigo);
    $("#viewResetarSenha").html('Resetar a senha do(a) '+nome+'? <br>O Login será a nova senha do usuário e,<br>no próximo acesso, será solicitada a sua troca.');
    $("#janelaResetarSenha").appendTo("body").modal('show');
    
}