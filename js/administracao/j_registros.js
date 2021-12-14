$(document).ready(function(){
    
    $("#consultar").button({ icons: { primary: "ui-icon-refresh" }});
    $("#imprimir").button({ icons: { primary: "ui-icon-print" }});
    
    $("#usuario").select2().on("change", function() {
        
        codigo = $(this).val();
        
        $("#ocs").select2('data', {id: "", text: "OCS/PSA - Todos"});
        $("#paciente").select2('data', {id: "", text: "Paciente - Todos"});
        
        $.ajax({
            type: "POST",
            url: 'c_registros/filtrarUsuario',
            cache: false,
            data:{codigo:codigo},
            success: function(data){
                
                $('#ocs').html('').html('<option value="" selected>OCS/PSA - Todos</option>').append(data[0]);
                $('#paciente').html('').html('<option value="" selected>Paciente - Todos</option>').append(data[1]);
               
            }
               ,
            error: function(){
                $("#erro").html('Ocorreu um erro no sistema (AJAX).').dialog( "open" );
            }
        });
        
    });
    
    $("#ocs").select2().on("change", function() {
        
        codigo = $(this).val();
        
        $("#paciente").select2('data', {id: "", text: "Paciente - Todos"});
        
        $.ajax({
            type: "POST",
            url: 'c_registros/filtrarOcs',
            cache: false,
            data:{codigo:codigo},
            success: function(data){
                
                $('#paciente').html('').html('<option value="" selected>Paciente - Todos</option>').append(data);
               
            }
               ,
            error: function(){
                $("#erro").html('Ocorreu um erro no sistema (AJAX).').dialog( "open" );
            }
        });
            
    });
    
    $("#paciente").select2();
    
    $("#consultar").click(function(){
        
        usuario = $("#usuario").val();
        ocs = $("#ocs").val();
        paciente = $("#paciente").val();
        data_ini = $("#data_ini").val();
        data_fim = $("#data_fim").val();
        
        $.ajax({
           type: "POST",
           url: 'c_registros/consultarLog',
           data:{usuario:usuario,ocs:ocs,paciente:paciente,data_ini:data_ini,data_fim:data_fim},
           cache: false,
            success: function(data){
                
                $("#logs").html(data);
                   
            }
               ,
            error: function(){
                $("#erro").html('Ocorreu um erro no sistema (AJAX).').dialog( "open" );
            }
        });
        
    });
    
    $("#imprimir").click(function(){
        
        usuario = $("#usuario").val();
        ocs = $("#ocs").val();
        paciente = $("#paciente").val();
        data_ini = $("#data_ini").val();
        data_fim = $("#data_fim").val();
        
        usuarioDesc = $("#usuario option:selected").text();
        ocsPsa = $("#ocs option:selected").text();
        pacDesc = $("#paciente option:selected").text();
                
        $.ajax({
           type: "POST",
           url: 'c_registros/imprimirLog',
           data:{usuario:usuario,ocs:ocs,paciente:paciente,data_ini:data_ini,data_fim:data_fim,usuarioDesc:usuarioDesc,ocsPsa:ocsPsa,pacDesc:pacDesc},
           cache: false,
            success: function(data){
                
                $("#janelaRelatorios").html(data).dialog("open");
                   
            }
               ,
            error: function(){
                $("#erro").html('Ocorreu um erro no sistema (AJAX).').dialog( "open" );
            }
        });
        
    });
    
});