<?php
if (!defined('BASEPATH')){ exit('Acesso direto ao arquivo não autorizado, log gerado!');}

?>

<script type="text/javascript" language="javascript" src="<?=PATH_JS.'jquery.validate.min.js'?>"></script>

<form id="form_novo_tipo">

    <strong>DESCRIÇÃO </strong><br>
    <input type="text" style="width:95%;" name="n_desc" id="n_desc" value="" /><br><br>

</form>

<div id="requerido" style="color: red;"></div>

<script type="text/javascript" language="javascript" src="<?=PATH_JS.'administracao/j_novo_tipo_atividade.js'?>"></script>
