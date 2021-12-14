<?php
if (!defined('BASEPATH')){ exit('Acesso direto ao arquivo não autorizado, log gerado!');}

// montar título da página
echo heading($pagina_titulo, 2, 'id="titulo_pagina"');

?>

<script type="text/javascript" language="javascript" src="<?=PATH_JS.'administracao/j_tipo_atividade.js'?>"></script>

    <br>
    
    <div align="center">
        
        <button type="button" class="ui-state-default ui-corner-all" id="novo_tipo">Novo Tipo de Atividade</button>
                
        <input type="hidden" id="codigo" value="">
                                    
    </div>
    
    <br>

        <table class="cell-border" id="table_tipo" style="width:60%">
        
            <thead class="">

                <tr align="center" class="">
                    
                    <th>DESCRIÇÃO</th>
                    <th>OPÇÕES</th>
                    
                </tr>
                
            </thead>
            
            <tbody>

                <?=$linhas?>       
       
            </tbody>
            
        </table>

    
<div class="modal fade" id="janelaNovo" tabindex="1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Novo Tipo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body" id="viewNovo"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="salvarNovoTipo">Salvar</button>
      </div>
    </div>
  </div>
</div>
    
<div class="modal fade" id="janelaExcluir" tabindex="1" role="dialog" aria-labelledby="janela" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="alert">
    <div class="modal-content alert alert-warning">
      <div class="modal-header">
          <h5 class="modal-title" id="">Excluir</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body" id="viewExcluir"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="excluirTipo">Excluir</button>
      </div>
    </div>
  </div>
</div>

<div style="height: 20%;"></div>    