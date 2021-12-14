<?php
if (!defined('BASEPATH')){ exit('Acesso direto ao arquivo não autorizado, log gerado!');}

// montar título da página
echo heading($pagina_titulo, 2, 'id="titulo_pagina"');

?>

<script type="text/javascript" language="javascript" src="<?=PATH_JS.'log/j_registros.js'?>"></script>

<br>
    
    <div align="center">
        
        <table border="0" style="width: 75%;">
            
            <tr align="center">
                
                <td colspan="2"><select id="anos" style="width:200px;" class="selecao"><?=$anoCombo ?></select><br><br></td>
                
            </tr>
            
            <tr align="center">
                
                <td><select id="usuario" style="width:600px;" class="selecao"><?=$usuarioCombo ?></select><br><br></td>
                
            </tr>
            
            <tr align="center">
                
                <td colspan="2">
                    
                    <div style="width:650px;">
                        <label for="data_ini">Data inicial: </label>
                        <input type="text" id="data_ini" name="data_ini" class="calendar" style="width:150px;" placeholder="Data final - 20 dias" value="<?=$dataIni ?>" title="Se as datas forem omitidas, serão consultados os últimos 20 dias." />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Até&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label for="data_fim">Data final: </label>
                        <input type="text" id="data_fim" name="data_fim" class="calendar" style="width:150px;" placeholder="Hoje" value="<?=$dataFim ?>" />

                    </div>
                    
                </td>
                
            </tr>
            
        </table>
        <br>
        
        <button id="consultar" class="ui-state-default ui-corner-all"><i class="fa fa-search"></i> Consultar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <button id="imprimir" class="ui-state-default ui-corner-all"><i class="fa fa-print"></i> Imprimir</button>
        
        <input type="hidden" id="codigo" value="" />
                    
    </div>
    
    <br>

    <div align="center" id="logs"></div>
    
<div style="height: 25%;"></div>