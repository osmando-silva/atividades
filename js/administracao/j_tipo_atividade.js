$(document).ready( function () {
    
    $('#table_tipo').dataTable({
        
        "paging": false,
        "sort":false,
        "fixedHeader": true,
        "scrollY": "auto",
        "responsive": true,
        "bJQueryUI": true,
        "columnDefs": [{"className": "dt-center", "targets": "_all"}]
      
    });
    
    $('button').button();
    
    $("#novo_tipo").on('click', function(){
        
        $.ajax({
           type: "POST",
           url: 'c_tipo_atividade/novoTipo',
           cache: false,
            success: function(data){
                
                $("#viewNovo").html(data);
                $("#janelaNovo").modal('show');
                    
            }
        });
        
    });
    
    $('#excluirTipo').on('click', function() {
        
        codigo = $('#codigo').val();
        descricao = $('#descricao'+codigo).val();
        
        $.ajax({
            type: "POST",
            url: 'c_tipo_atividade/excluir',
            cache: false,
            data:{codigo:codigo,descricao:descricao},
            success: function(data){
                
                if (data == 'usado'){

                    $("#erro").html("O item "+descricao+" est&aacute; em uso e n&atilde;o poder&aacute; ser exclu&iacute;do.");
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
    
});

function salvar(codigo){
    
    descricao = $('#descricao'+codigo).val();
    
    if (testaVazio(descricao, $('#descricao'+codigo))){
        
        $.ajax({
            type: "POST",
            url: 'c_tipo_atividade/salvar',
            cache: false,
            data:{codigo:codigo,descricao:descricao},
            success: function(data){
                
                if (data == 'ok'){
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

function excluir(codigo){
    
    descricao = $('#descricao'+codigo).val();
    $('#codigo').val(codigo);
    $("#viewExcluir").html('Excluir o tipo '+descricao+'?');
    $("#janelaExcluir").appendTo("body").modal('show');
    
}