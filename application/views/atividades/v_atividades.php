<?php
if (!defined('BASEPATH')){ exit('Acesso direto ao arquivo não autorizado, log gerado!');}

// montar título da página
echo heading($pagina_titulo, 2, 'id="titulo_pagina"');

?>

<script type="text/javascript" language="javascript" src="<?=PATH_JS.'atividades/j_atividades.js'?>"></script>

<br>

<div align="center">

    <button type="button" class="ui-state-default ui-corner-all" id="nova_atividade"><i class="fa fa-check-circle"></i>Nova Atividade</button>

    <input type="hidden" id="codigo" value="" />
    <input type="hidden" id="tipoMntUrgente" value="<?=$tipoMntUrgente?>" />
    <input type="hidden" id="tipoAtendimento" value="<?=$tipoAtendimento?>" />

</div>

<br>
    
<div align="center">
        
    <table border="0" style="width: 75%;">
        
        <tr align="center">
                
            <td>
                <select id="statusAtividade" style="width:200px;" class="">
                    <option value="0" selected>Não concluídas</option>
                    <option value="1">Concluídas</option>
                </select>
            </td>

        </tr>
        
    </table>
        
</div>

<div align="left">

    <span align="left" id="imprimirAtividades">
        &nbsp;&nbsp;&nbsp;<a href="#"><img src="<?=PATH_IMG.'imprimirPdf.png'?>" title="Imprimir Atividades"/></a>

    </span>

</div>

<div id="lista_atividades">
    
    <table class="cell-border" id="table_atividades" style="width:100%">

        <thead class="">

            <tr align="center" class="">

                <th>TÍTULO</th>
                <th>DESCRIÇÃO</th>
                <th>TIPO</th>
                <th>OPÇÕES</th>

            </tr>

        </thead>

        <tbody>

            <?=$linhas?>

        </tbody>

    </table>

</div>
    
<div class="modal fade" id="janelaNovaAtividade" tabindex="1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div style="width: 35%; height: 50%; max-width: none; top: 20%;" class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Nova Atividade</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body" id="viewNovaAtividade"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="salvarNovaAtividade">Salvar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="janelaExcluir" tabindex="1" role="dialog" aria-labelledby="janela" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="alert">
    <div class="modal-content alert alert-warning">
      <div class="modal-header">
          <h5 class="modal-title" id="">Excluir Atividade</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body" id="viewExcluir"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="excluirAtividade">Excluir</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="janelaConcluir" tabindex="1" role="dialog" aria-labelledby="janela" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="alert">
    <div class="modal-content alert alert-warning">
      <div class="modal-header">
          <h5 class="modal-title" id="">Concluir atividade</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body" id="viewConcluir"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="concluirAtividade">Concluir</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="janelaReabrir" tabindex="1" role="dialog" aria-labelledby="janela" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="alert">
    <div class="modal-content alert alert-warning">
      <div class="modal-header">
          <h5 class="modal-title" id="">Reabrir atividade</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body" id="viewReabrir"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="reabrirAtividade">Reabrir</button>
      </div>
    </div>
  </div>
</div>
    
