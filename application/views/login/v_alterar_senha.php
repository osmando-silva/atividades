<script type="text/javascript" language="javascript" src="<?= PATH_JS.'crypto-js.js'?>"></script>
<script type="text/javascript" language="javascript" src="<?= PATH_JS.'Encryption.js'?>"></script>

<div id="login">
    
    <?php 
    
        echo form_open('c_alterar_senha/validate');
 
        echo '<div align="center"><strong>Usu&aacute;rio: '.$this->session->userdata('login').'</strong></div>';

        echo '<br>';
        echo form_label('Nova senha', 'novaSenha');
        echo form_password('novaSenha', $novaSenha);
        
        echo form_label('Confirma senha', 'confirmaSenha');
        echo form_password('confirmaSenha', $confirmaSenha);
        
        echo form_hidden('newpassw', '');
        echo form_hidden('confirmnewpassw', '');
        echo form_hidden('seq', $seq);
        echo form_hidden('erroSenha', $this->session->flashdata('erroSenha'));
 
        echo form_submit('newlogin', 'Alterar', 'class="btn-blue"');
        
        echo form_close(); 
        
    ?>

    <br>    
    
    <div id="erroSenha" align="center"></div>   
            
</div>

