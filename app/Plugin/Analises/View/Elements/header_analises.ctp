<div class="col-md-12">
   <div class="col-md-8">
    <input type="hidden" id='action' value="<?php echo!empty($action) ? $action : ''; ?>" >
    <input type="hidden" id='tipo' value="<?php echo isset($tipo) ? $tipo : ''; ?>">
    <ul class="nav nav-pills pull-center">
        <li id='geralmenuanalises'><?php echo $this->Html->link('Informações Gerais', array('plugin' => 'analises', 'controller' => 'analises', 'action' => 'analises', $analise['Analise']['id']), array('class' => 'bloqueio')); ?></li>
        <?php if (!empty($analise['Analise']['metodo_contagem'])) { ?>
            <li  id='dadosmenuanalises'><?php echo $this->Html->link('Função de dados', array('plugin' => 'analises', 'controller' => 'analises', 'action' => 'funcionalidades', '1', $analise['Analise']['id']), array('class' => 'bloqueio')); ?></li>
            <?php if ($analise['Analise']['metodo_contagem'] != \Dominio\MetodoContagem::$indicativa) { ?>
                <li id="transacaomenuanalises"> <?php echo $this->Html->link('Função de transação', array('plugin' => 'analises', 'controller' => 'analises', 'action' => 'funcionalidades', '2', $analise['Analise']['id']), array('class' => 'bloqueio')); ?></li>
            
            <?php } ?>
             <li id='itensmenuanalises'> <?php echo $this->Html->link('Itens não mensuráveis', array('plugin' => 'analises', 'controller' => 'analises', 'action' => 'itens', $analise['Analise']['id'])); ?>
            </li>
        <?php } ?>
           
            <li id='documentos'> <?php echo $this->Html->link('Documentação', array('plugin' => 'analises', 'controller' => 'analises', 'action' => 'documentos', $analise['Analise']['id'])); ?>
            </li>
              
            
    </ul>
     
    </div>
    <div class="col-md-4 hidden-print"   style="text-align: right; font-size: 10px; ">
        <a href="<?php echo '/analises/analises/relatorio/' . $analise['Analise']['id']; ?>" class="btn btn-default btn-small" style="padding: 4px 10px">Relatório</a>
        <a href="<?php echo '/analises/analises/dataLock/' . $analise['Analise']['id'] . '/desbloquear'; ?>" class="btn btn-success btn-small" style="padding: 4px 10px">Finalizar e Sair</a> 
    </div>
</div>