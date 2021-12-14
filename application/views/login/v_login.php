<script type="text/javascript" language="javascript" src="<?= PATH_JS.'crypto-js.js'?>"></script>
<script type="text/javascript" language="javascript" src="<?= PATH_JS.'Encryption.js'?>"></script>

<div id="login" align="center">
    
    <?php 
    
        echo form_open('c_login/validate');
        
        echo form_input('login', $login, 'placeholder="CPF" maxlength="14"');
        
    ?>
    
    <br/>
    
    <?php
    
        echo form_password('senha', $senha, 'placeholder="Senha"');
        
        echo form_hidden('hash', '');
        echo form_hidden('hashLogin', '');
        echo form_hidden('seq', $seq);
        echo form_hidden('erroLogin', $this->session->flashdata('erroLogin'));
        echo form_hidden('logout', $this->session->flashdata('logout'));
        
        echo form_input('codseguranca', '', 'placeholder="Digite o C&oacute;digo de Seguran&ccedil;a"');
        
        $autenticacao = rand(1000,9999);
        
        $this->session->set_userdata('autenticacao', $autenticacao);
        
        $string = $autenticacao;
        $cont = 0; 
        $cont1 = 0;
        
        for($cont=0; $cont<4; $cont++){
            
            $aux = substr($string,$cont,1);
            
            for($cont1=0;$cont1<=9;$cont1++){
                
                if($aux == $cont1){
                    
                    print("<img style=\"width: 20px; height: 20px;\" src=\"img/captcha/$cont1.png\">");
                 
                }
                
            } 
            
        }
        
        echo '<br><br>';
        
        echo form_submit('entrar', 'Entrar', 'class="btn-blue"');
 
        echo form_close();

    ?> 
    
    <br>    
    
    <div id="erroLogin" align="center"></div>   
            
</div>