
<script type="text/javascript" language="javascript" src="<?=PATH_JS.'log/j_registros_filtrado.js'?>"></script>

<style>
    
    .registros {font-family: verdana; font-size: 10pt; color:#000; background-repeat: repeat-x; background-color: #FFFFFF;}
    
    .bordas-registros{
        border: 1px solid black;
    }
    
    .texto{
        padding: 5px;
        vertical-align: middle;
    }
    
</style>

<table id="tabela_registros" class="cell-border" border="0">
        
    <thead>

        <tr align="center" class="ui-widget-header" style="line-height: 25px;">
            
            <th>DATA - HORA<br>IP ORIGEM</th>
            <th>AÇÃO</th>
            <th>RESPONSÁVEL</th>
            
        </tr>

    </thead>

    <tbody>

        <?=$linhas?>
               
    </tbody>

</table>