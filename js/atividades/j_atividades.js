$(document).ready( function () {
    
    $('[id^=login]').inputmask({"placeholder": "", mask: ['999.999.999-99'],keepStatic: true });
    
    $('button').button();
    
    setaDataTable();
    
    $("#nova_atividade").click(function(){
        
        $.ajax({
           type: "POST",
           url: 'c_atividades/novaAtividade',
           cache: false,
            success: function(data){
                
                $("#viewNovaAtividade").html(data);
                $("#janelaNovaAtividade").modal('show');
                    
            }
        });
        
    });
    
    $("#imprimirAtividades").on('click', function(){
        
        $.ajax({
            type: "POST",
            url: 'c_atividades/imprimir',
            cache: false,
            data:{status:$("#statusAtividade").val()},
            success: function(data){

                $("#relatorios").html(data);
                $("#janelaRelatorios").appendTo("body").modal('show');
                
            }
        });
        
    });
    
    $("#statusAtividade").on('change', function(){
        
        $.ajax({
            type: "POST",
            url: 'c_atividades/filtrar',
            cache: false,
            data:{status:$(this).val()},
            success: function(data){

                $("#lista_atividades").html(data);
                setaDataTable();

            }
        });
        
    });
    
    $('#excluirAtividade').on('click', function() {
        
        codigo = $('#codigo').val();
        titulo = $('#titulo'+codigo).val();
        
        $.ajax({
            type: "POST",
            url: 'c_atividades/excluir',
            cache: false,
            data:{codigo:codigo,titulo:titulo},
            success: function(data){
                
                if (data == 'ok'){
                    
                    tabela = $('#table_atividades').DataTable();
                    tabela.row($("#linha"+codigo)).remove().draw(false);
                    $("#sucesso").html('Atividade '+titulo+' apagada com sucesso.');
                    $("#janelaExcluir").appendTo("body").modal('hide');
                    $("#janelaSucesso").appendTo("body").modal('show');
                    
                }else{
                    $("#erro").html(data);
                    $("#janelaErro").appendTo("body").modal('show');
                }

            }
            
        });
                
    });
    
    $('#concluirAtividade').on('click', function() {
        
        codigo = $('#codigo').val();
        titulo = $('#titulo'+codigo).val();
        tipo = $('#tipo'+codigo).val();
        
        if ($('#descricao'+codigo).val().length < 50 && (tipo == $("#tipoMntUrgente").val() || tipo == $("#tipoAtendimento").val())){
            $("#erro").html("Para concluir atividades deste tipo, a descri&ccedil;&atilde;o deve ter, no m&iacute;nimo, 50 caracteres.");
            $("#janelaErro").appendTo("body").modal('show');
        }else{
            $.ajax({
                type: "POST",
                url: 'c_atividades/concluir',
                cache: false,
                data:{codigo:codigo,titulo:titulo},
                success: function(data){

                    if (data == 'ok'){
                        tabela = $('#table_atividades').DataTable();
                        tabela.row($("#linha"+codigo)).remove().draw(false);
                        $("#sucesso").html('Atividade '+titulo+' conclu&iacute;da com sucesso.');
                        $("#janelaConcluir").appendTo("body").modal('hide');
                        $("#janelaSucesso").appendTo("body").modal('show');
                    }else{
                        $("#erro").html(data);
                        $("#janelaErro").appendTo("body").modal('show');
                    }

                }

            });
        }
             
    });
    
    $('#reabrirAtividade').on('click', function() {
        
        codigo = $('#codigo').val();
        titulo = $('#titulo'+codigo).html();
        tipo = $('#tipo'+codigo).val();
        
        $.ajax({
            type: "POST",
            url: 'c_atividades/reabrir',
            cache: false,
            data:{codigo:codigo,titulo:titulo,tipo:tipo},
            success: function(data){
                
                if (data == 'ok'){
                    
                    tabela = $('#table_atividades').DataTable();
                    tabela.row($("#linha"+codigo)).remove().draw(false);
                    $("#sucesso").html('Atividade '+titulo+' reaberta com sucesso.');
                    $("#janelaReabrir").appendTo("body").modal('hide');
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
    
    $('#table_atividades').dataTable({
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
    
    titulo = $('#titulo'+codigo).val();
    descricao = $('#descricao'+codigo).val();
    tipo = $('#tipo'+codigo).val();
    tipoOriginal = $('#tipoOriginal'+codigo).val();
    tipoAtividade = $('#tipo'+codigo+' option:selected').text();
    
    if (testaVazio(titulo, $('#titulo'+codigo)) && testaVazio(descricao, $('#descricao'+codigo))){
        
        $.ajax({
            type: "POST",
            url: 'c_atividades/salvar',
            cache: false,
            data:{codigo:codigo,titulo:titulo,descricao:descricao,tipo:tipo,tipoOriginal:tipoOriginal,tipoAtividade:tipoAtividade},
            success: function(data){
                if (data == 'ok'){
                    if (tipo == $("#tipoMntUrgente").val()){
                        $('#excluir'+codigo).remove();
                    }else{
                        botaoExcluir = '<button id="excluir'+codigo+'" onclick="excluir('+codigo+')" class="ui-state-default ui-corner-all"><i class="fa fa-trash"></i> Excluir</button>';
                        $('#botaoExcluir'+codigo).html(botaoExcluir);
                        $('#excluir'+codigo).button();
                    }
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

function concluir(codigo){
    
    titulo = $('#titulo'+codigo).val();
    $('#codigo').val(codigo);
    $("#viewConcluir").html('Concluir a atividade '+titulo+'?');
    $("#janelaConcluir").appendTo("body").modal('show');
    
}

function reabrir(codigo){
    
    if ($('#titulo'+codigo).val() == ''){
        titulo = $('#titulo'+codigo).html();
    }else{
        titulo = $('#titulo'+codigo).val();
    }
    
    $('#codigo').val(codigo);
    $("#viewReabrir").html('Reabrir a atividade '+titulo+'?');
    $("#janelaReabrir").appendTo("body").modal('show');
    
}

function excluir(codigo){
    
    if ($('#titulo'+codigo).val() == ''){
        titulo = $('#titulo'+codigo).html();
    }else{
        titulo = $('#titulo'+codigo).val();
    }
    
    $('#codigo').val(codigo);
    $("#viewExcluir").html('Excluir a atividade '+titulo+'?');
    $("#janelaExcluir").appendTo("body").modal('show');
    
}