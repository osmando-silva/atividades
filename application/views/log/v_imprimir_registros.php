<?php
    if (!defined('BASEPATH')){ exit('Acesso direto ao arquivo n�o autorizado, log gerado!');}
?>



<div align="center"><strong><?=$this->session->userdata('nomeOm') ?><br><br><?=NOMESISTEMA?></strong></div><br>

<div align="center"><strong><u>RELAT�RIO DE REGISTROS</u></strong></div><br><br>

<div align="left"><strong>USU�RIO: </strong><?=utf8_decode($usuario) ?></div>

<div align="left"><strong>PER�ODO: </strong><?=$periodo ?></div><br>

<table>
        
    <thead>

        <tr align="center" style="line-height: 25px;">
            
            <th>DATA - HORA<br>IP ORIGEM</th>
            <th>A��O</th>
            <th>RESPONS�VEL</th>
            
        </tr>

    </thead>

    <tbody>

        <?=$linhas?>
        
    </tbody>

</table>