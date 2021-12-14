<?php
if (!defined('BASEPATH')){ exit('Acesso direto ao arquivo não autorizado, log gerado!');}
?>

<div align="center"><strong>RELATÓRIO DE ATIVIDADES <?=$status?></strong></div><br>

<table class="cell-border" id="table_atividades" style="width:100%">

        <thead class="">

            <tr align="center" class="">

                <th>TÍTULO</th>
                <th>DESCRIÇÃO</th>
                <th>TIPO</th>
                
            </tr>

        </thead>

        <tbody>

            <?=$linhas?>

        </tbody>

    </table>