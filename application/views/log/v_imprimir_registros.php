<?php
    if (!defined('BASEPATH')){ exit('Acesso direto ao arquivo não autorizado, log gerado!');}
?>



<div align="center"><strong><?=$this->session->userdata('nomeOm') ?><br><br><?=NOMESISTEMA?></strong></div><br>

<div align="center"><strong><u>RELATÓRIO DE REGISTROS</u></strong></div><br><br>

<div align="left"><strong>USUÁRIO: </strong><?=utf8_decode($usuario) ?></div>

<div align="left"><strong>PERÍODO: </strong><?=$periodo ?></div><br>

<table>
        
    <thead>

        <tr align="center" style="line-height: 25px;">
            
            <th>DATA - HORA<br>IP ORIGEM</th>
            <th>AÇÃO</th>
            <th>RESPONSÁVEL</th>
            
        </tr>

    </thead>

    <tbody>

        <?=$linhas?>
        
    </tbody>

</table>