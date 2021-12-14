$(document).ready(function(){
    
    $(".selecao").select2();
    
    $(".calendar").datepicker({
        firstDay: 1,
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 3,
        showOn: "button",
        buttonImage: "img/calendario.gif",
        buttonImageOnly: true,
        buttonText: "Selecione a data",
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Ter&ccedil;a','Quarta','Quinta','Sexta','S&aacute;bado'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','S&aacute;b','Dom'],
        monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        nextText: 'Pr&oacute;ximo',
        prevText: 'Anterior'

    }).inputmask("99/99/9999");
    
    $('#anos').select2().on("change", function(){
        
        ano = $(this).val();
        
        $("#usuario").select2('data', {id: "", text: "Responsável - Todos"});
                
        $.ajax({
            type: "POST",
            url: 'c_registros/preencheCombos',
            cache: false,
            data:{ano:ano},
            success: function(data){
                
                $('#usuario').html('').html('<option value="" selected>Responsável - Todos</option>').append(data[0]);
                                
            }
            
        });
           
    });
    
    $("#consultar").button().click(function(){
        
        ano = $("#anos").val();
        usuario = $("#usuario").val();
        data_ini = $("#data_ini").val();
        data_fim = $("#data_fim").val();
        
        $.ajax({
            type: "POST",
            url: 'c_registros/consultarLog',
            data:{ano:ano,usuario:usuario,data_ini:data_ini,data_fim:data_fim},
            cache: false,
            success: function(data){
                
                $("#logs").html(data);
                   
            }
            
        });
        
    });
    
    $("#imprimir").button().click(function(){
        
        ano = $("#anos").val();
        usuario = $("#usuario").val();
        data_ini = $("#data_ini").val();
        data_fim = $("#data_fim").val();
        usuarioDesc = $("#usuario option:selected").text();
                        
        $.ajax({
           type: "POST",
           url: 'c_registros/imprimirLog',
           data:{ano:ano,usuario:usuario,data_ini:data_ini,data_fim:data_fim,usuarioDesc:usuarioDesc},
           cache: false,
            success: function(data){
                
                $("#relatorios").html(data);
                $("#janelaRelatorios").appendTo("body").modal('show');
                   
            }
            
        });
        
    });
    
});