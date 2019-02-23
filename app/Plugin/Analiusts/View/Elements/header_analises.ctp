<div class="col-md-12">
     <input type="hidden" id='action' value="<?php echo!empty($action) ? $action : ''; ?>" >
    <input type="hidden" id='tipo' value="<?php echo isset($tipo) ? $tipo : ''; ?>">
    <div class="col-md-8">
    <ul class="nav nav-pills pull-center">
        <li id='geralmenuanalises'><?php echo $this->Html->link('Informações Gerais', array('plugin' => 'analiusts', 'controller' => 'analiusts', 'action' => 'analises', $analise['Analiust']['id']), array('class' => 'bloqueio')); ?></li>
        <?php if (!empty($analise['Analiust']['metodo_contagem'])) { ?>
           <li id='usts'> <?php echo $this->Html->link('UST', array('plugin' => 'analiusts', 'controller' => 'analiusts', 'action' => 'usts', $analise['Analiust']['id'])); ?>
        </li>
        <?php } ?>
        
    </ul>
        
    </div>
     <div class="col-md-4 hidden-print"   style="text-align: right; font-size: 10px; ">
        <a href="<?php echo '/analiusts/analiusts/relatorio/' . $analise['Analiust']['id']; ?>" class="btn btn-default btn-small" style="padding: 4px 10px">Relatório</a>
       
        <a href="<?php echo '/analiusts/analiusts/dataLock/' . $analise['Analiust']['id'] . '/desbloquear'; ?>" class="btn btn-success btn-small" style="padding: 4px 10px">Finalizar e Sair</a> 
    </div>
</div>