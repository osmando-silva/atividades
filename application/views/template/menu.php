<?php
if ( ! defined('BASEPATH')) exit('Acesso direto ao arquivo não autorizado, log gerado!');
?>

    <script>

    $(document).ready( function () {

        window.onload = resetTimer();

        $("body").mousemove(function() {
            resetTimer();
        });

        $("body").click(function() {
            resetTimer();
        });

        $("body").keypress(function() {
            resetTimer();
        });

        $("body").scroll(function() {
            resetTimer();
        });

        var tempo;

        function logout() {

            $.ajax({
                type: "POST",
                url: 'c_login/sair',
                cache: false,
    //            data:{codigo:codigo},
                success: function(){

                    window.location.href = "entrar";

                },
                error: function(){
                    $("#erro").html('A sua sess&atilde;o expirou. Refa&ccedil;a o login.').dialog("open");
                }    
            });

        }

        function resetTimer() {

            clearTimeout(tempo);
            tempo = setTimeout(logout, 3600000); // 60 minutos

        }

    });

    </script>

    <nav style="width: 100%;" class="navbar navbar-expand-sm navbar-light btn-blue">
        <div class="">
            <div id="admin">
                <ul class="navbar-nav mr-auto">

                    <li><a href="c_principal" class="nav-link"><span class="fa fa-home"></span> Início</a></li>

                <?php echo $this->session->userdata('menus') ?>

                    <li><a href="<?=base_url().'c_login/logout' ?>" class="nav-link"><span class="fa fa-close"></span> Sair</a></li>

                </ul>
            </div> 
        </div>
    </nav>

    <div class="modal fade" id="janelaErro" tabindex="99" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="alert">
        <div class="modal-content alert alert-danger">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalLabel">Erro</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body" role="alert" id="erro"></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="janelaSucesso" tabindex="99" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="alert">
        <div class="modal-content alert alert-success">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalLabel">Sucesso</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body" role="alert" id="sucesso"></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="janelaRelatorios" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div style="width: 100%; height: 100%; max-width: none; margin: 0; padding: 0;" class="modal-dialog alert alert-primary">
            <div style="height: 100%; border-radius: 0;" class="modal-content alert alert-primary">
            <div class="modal-header">
                <h4 class="modal-title" id="ModalLabel">Visualizar impressão</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body alert alert-primary" id="relatorios"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
    </div>

<!--</div>-->

<br/>

<div id="conteudo">