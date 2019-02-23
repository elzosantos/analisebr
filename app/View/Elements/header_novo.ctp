
<div id="top-nav" class="navbar navbar-inverse navbar-static-top hidden-print">
    <div class="container">
        <div class="navbar-header">
           
            <a class="navbar-brand" href="/painel">APFBr</a>
        
            <ul class="nav navbar-left">
                
                <li class="dropdown">
                    <button style="color:#333;background-color:#333;border-color:#333" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <b style="color: white">Administração</b><span style="color: white" class="caret"></span>
                    </button>
                    
                    
                     
                    <ul id="g-account-menu" class="dropdown-menu"  >
                        <?php $equipe = $this->Session->read('Equipe');
                        if (!empty($equipe) || $this->Session->read('Auth.User.role_id') == '1') {
                            ?>
                                <li><?php echo $this->Html->link('Usuários', array('plugin' => 'users', 'controller' => 'users', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                                <li><?php echo $this->Html->link('Contratos', array('plugin' => 'contratos', 'controller' => 'contratos', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                                <li><?php echo $this->Html->link('Linguagens', array('plugin' => 'linguagens', 'controller' => 'linguagens', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                                <li><?php echo $this->Html->link('Fases', array('plugin' => 'fases', 'controller' => 'fases', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                                 <li><?php echo $this->Html->link('Fronteiras', array('plugin' => 'fronteiras', 'controller' => 'fronteiras', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                                <li><?php echo $this->Html->link('Itens não mensuráveis', array('plugin' => 'itens', 'controller' => 'itens', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                                <li><?php echo $this->Html->link('UST', array('plugin' => 'usts', 'controller' => 'usts', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                                <li><?php echo $this->Html->link('Equipes', array('plugin' => 'equipes', 'controller' => 'equipes', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                                <li><?php echo $this->Html->link('Visualizar por Equipe', array('plugin' => 'users', 'controller' => 'users', 'action' => 'control', 'admin'), array('tabindex' => "-1")); ?></li>
                
                        <?php } ?>
                    </ul>
                </li>
                
             
            </ul>
             <ul class="nav navbar-left">
                
                <li class="dropdown">
                    <button style="color:#333;background-color:#333;border-color:#333" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <b style="color: white">Análise</b><span style="color: white" class="caret"></span>
                    </button>
                     <ul class="dropdown-menu">
                       
                           <li><?php echo $this->Html->link('Analises (PF)', array('plugin' => 'analises', 'controller' => 'analises', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                           <li><?php echo $this->Html->link('Analises (UST)', array('plugin' => 'analiusts', 'controller' => 'analiusts', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                           <li><?php echo $this->Html->link('Comparar Análises', array('plugin' => 'analises', 'controller' => 'analises', 'action' => 'compara'), array('tabindex' => "-1")); ?></li>
                           <li><?php echo $this->Html->link('Buscar Análises', array('plugin' => 'analises', 'controller' => 'analises', 'action' => 'buscar'), array('tabindex' => "-1")); ?></li>
                 
                    </ul>
                </li>
                
             
            </ul>
            <ul class="nav navbar-left">
                
                <li class="dropdown">
                    <button style="color:#333;background-color:#333;border-color:#333" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <b style="color: white">Sistema</b><span style="color: white" class="caret"></span>
                    </button>
                    <ul id="g-account-menu" class="dropdown-menu" role="menu">
                       
                            <li><?php echo $this->Html->link('Sistemas', array('plugin' => 'sistemas', 'controller' => 'sistemas', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                            <li><?php echo $this->Html->link('Baselines (APF)', array('plugin' => 'sistemas', 'controller' => 'sistemas', 'action' => 'baselines'), array('tabindex' => "-1")); ?></li>
                            <li><?php echo $this->Html->link('Baselines (UST)', array('plugin' => 'sistemas', 'controller' => 'sistemas', 'action' => 'baselineusts'), array('tabindex' => "-1")); ?></li>
                            <li><?php echo $this->Html->link('Histórico', array('plugin' => 'sistemas', 'controller' => 'sistemas', 'action' => 'history'), array('tabindex' => "-1")); ?></li>
                     
                    </ul>
                </li>
                
             
            </ul>
             <ul class="nav navbar-left">
                
                <li class="dropdown">
                    <button style="color:#333;background-color:#333;border-color:#333" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <b style="color: white">Relatórios</b><span style="color: white" class="caret"></span>
                    </button>
                    <ul id="g-account-menu" class="dropdown-menu" role="menu">
                        <?php $equipe = $this->Session->read('Equipe');
                        if (!empty($equipe) || $this->Session->read('Auth.User.role_id') == '1') {
                            ?>
                            <li>  <?php echo $this->Html->link('Sistemas por equipe', array('plugin' => 'painel', 'controller' => 'painel', 'action' => 'relatorios', 'a'), array('tabindex' => "-1")); ?></li>
                    <li>  <?php echo $this->Html->link('Sistemas detalhado', array('plugin' => 'painel', 'controller' => 'painel', 'action' => 'relatorios', 'b'), array('tabindex' => "-1")); ?></li>
                    <li>  <?php echo $this->Html->link('Desempenho individual', array('plugin' => 'painel', 'controller' => 'painel', 'action' => 'relatorios', 'c'), array('tabindex' => "-1")); ?></li>
                    <li>  <?php echo $this->Html->link('Análises por sistema e equipe', array('plugin' => 'painel', 'controller' => 'painel', 'action' => 'relatorios', 'd'), array('tabindex' => "-1")); ?></li>
                  <?php } ?>
                    </ul>
                </li>
                
             
            </ul>
        </div>

     
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><p style="font-size: 12px; color: white; padding: 10px"><?php echo  date("d/m/Y H:m "); ?></p></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-user"></i>  <?php echo $this->Session->read('Auth.User.name'); ?> <span class="caret"></span></a>
                    <ul id="g-account-menu" class="dropdown-menu" role="menu">
                        <?php $equipe = $this->Session->read('Equipe');
                        if (!empty($equipe) || $this->Session->read('Auth.User.role_id') == '1') {
                            ?>
                            <li><a href="/users/users/add/user">Minha Conta</a></li>
                            <li><a href="/painel/painel/index/1">Ajuda</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li>
                    <a href="/users/users/logout"><i class="glyphicon glyphicon-lock"></i> Sair</a></li>
            </ul>
        </div>
    </div>
</div>
