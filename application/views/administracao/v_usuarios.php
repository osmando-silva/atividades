<?php
if (!defined('BASEPATH')){ exit('Acesso direto ao arquivo não autorizado, log gerado!');}

// montar título da página
echo heading($pagina_titulo, 2, 'id="titulo_pagina"');

?>

<script type="text/javascript" language="javascript" src="<?=PATH_JS.'administracao/j_usuarios.js'?>"></script>

    <br>
    
    <div align="center">
        
        <button type="button" class="ui-state-default ui-corner-all" id="novo_usuario"><i class="fa fa-user"></i> Novo Usuário</button>
                
        <input type="hidden" id="codigo" value="" />
                            
    </div>
    
    <br>

        <table class="cell-border" id="usuarios_hotel" style="width:100%">
        
            <thead class="">

                <tr align="center" class="">
                    
                    <th>CPF</th>
                    <th>NOME</th>
                    <th>CONTATO</th>
                    <th>E-MAIL</th>
                    <th>OPÇÕES</th>
                    
                </tr>
                
            </thead>
            
            <tbody>
                
                <?=$linhas?>

            </tbody>
            
        </table>
    
<div class="modal fade" id="janelaNovoUsuario" tabindex="1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Novo Usuário</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body" id="viewNovoUsuario"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" id="salvarNovoUsuario">Salvar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="janelaPerfisUsuario" tabindex="1" role="dialog" aria-labelledby="PerfisUsuario" aria-hidden="true">
  <div style="width: 35%; height: 35%; max-width: none; top: 20%;" class="modal-dialog" role="document">
    <div style="height: 100%; border-radius: 0;" class="modal-content">
      <div class="modal-header alert alert-primary">
        <h5 class="modal-title" id="PerfisUsuario"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body" id="viewPerfisUsuario"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" id="salvarPerfis">Salvar</button>
      </div>
    </div>
  </div>
</div>
    
<div class="modal fade" id="janelaInativarUsuario" tabindex="1" role="dialog" aria-labelledby="inativarUsuario" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="alert">
    <div class="modal-content alert alert-warning">
      <div class="modal-header">
          <h5 class="modal-title" id="">Inativar Usu&aacute;rio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body" id="viewInativarUsuario"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="inativarUsuario">Inativar</button>
      </div>
    </div>
  </div>
</div>
    
<div class="modal fade" id="janelaAtivarUsuario" tabindex="1" role="dialog" aria-labelledby="inativarUsuario" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="alert">
    <div class="modal-content alert alert-warning">
      <div class="modal-header">
          <h5 class="modal-title" id="">Ativar Usu&aacute;rio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body" id="viewAtivarUsuario"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="ativarUsuario">Ativar</button>
      </div>
    </div>
  </div>
</div>
    
<div class="modal fade" id="janelaResetarSenha" tabindex="1" role="dialog" aria-labelledby="inativarUsuario" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="alert">
    <div class="modal-content alert alert-warning">
      <div class="modal-header">
          <h5 class="modal-title" id="">Resetar Senha do Usu&aacute;rio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body" id="viewResetarSenha"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="resetarSenha">Resetar</button>
      </div>
    </div>
  </div>
</div>
    
<div class="modal fade" id="janelaDataFim" tabindex="1" role="dialog" aria-labelledby="dataFimPerfil" aria-hidden="true">
  <div style="width: 30%; height: 30%; top: 70px; max-width: none;" class="modal-dialog" role="document">
    <div style="height: 100%; border-radius: 0;" class="modal-content">
      <div class="modal-header alert alert-primary">
        <h5 class="modal-title" id="dataFimPerfilUsuario"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body" id="viewDataFim"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="atribuirPerfil">Atribuir</button>
      </div>
    </div>
  </div>
</div>