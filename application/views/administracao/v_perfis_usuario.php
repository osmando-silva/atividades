<?php
if ( ! defined('BASEPATH')) exit('Acesso direto ao arquivo não autorizado, log gerado!');

?>

<br>

<div align="center">

<table class="">
    
    <thead>

        <tr>

            <th style="width:350px; text-align: center;" class="btn-primary">Dispon&iacute;veis</th>
            <th style="width:80px;">&nbsp;</th>
            <th style="width:350px; text-align: center;" class="btn-primary">Atribu&iacute;dos</th>

        </tr>

    </thead>
    
    <tbody>
        
        <tr>
            
            <td style="width:350px; vertical-align: top;">
                
                <div style="max-height: 20em; overflow-y:auto; overflow-x:hidden; width:350px;">
                
                    <ul class="multiselecao" id="disponiveis">

                        <?php echo $perfis_disponiveis; ?>

                    </ul>
                    
                </div>
                    
            </td>
            
            <td style="width:80px;">&nbsp;</td>
            
            <td style="width:350px; vertical-align: top;">
                
                <div style="max-height: 20em; overflow-y:auto; overflow-x:hidden; width:350px;">
                
                    <ul class="multiselecao" id="selecionados">

                        <?php echo $perfis_selecionados; ?>

                    </ul>
                    
                </div>
                    
            </td>
            
        </tr>
                
    </tbody>
    
</table>

</div>
    
<br>

<script type="text/javascript" language="javascript" src="<?=PATH_JS.'administracao/j_perfis_usuario.js'?>"></script>


