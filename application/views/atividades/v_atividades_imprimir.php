<?php
if (!defined('BASEPATH')){ exit('Acesso direto ao arquivo n�o autorizado, log gerado!');}
?>

<div align="center"><strong>RELAT�RIO DE ATIVIDADES <?=$status?></strong></div><br>

<table class="cell-border" id="table_atividades" style="width:100%">

        <thead class="">

            <tr align="center" class="">

                <th>T�TULO</th>
                <th>DESCRI��O</th>
                <th>TIPO</th>
                
            </tr>

        </thead>

        <tbody>

            <?=$linhas?>

        </tbody>

    </table>