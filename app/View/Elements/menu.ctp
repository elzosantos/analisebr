<div class="col-md-3 hidden-print">
    <strong><i class="glyphicon glyphicon-user"></i> Menu</strong>
    <hr>
    <ul class="list-unstyled">
        <?php if ($this->Session->read('Auth.User.role_id') == '1') { ?> 
            <li class="nav-header"> 
                <h5>Administração <i id="adminhide" class="glyphicon glyphicon-chevron-down"></i></h5>

                <ul class="list-unstyled collapse in" id="adminmenu" >
                    <li><span class="glyphicon glyphicon-user"> </span> <?php echo $this->Html->link('Usuários', array('plugin' => 'users', 'controller' => 'users', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-certificate"> </span> <?php echo $this->Html->link('Contratos', array('plugin' => 'contratos', 'controller' => 'contratos', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-plus-sign"></span> <?php echo $this->Html->link('Deflatores', array('plugin' => 'deflatores', 'controller' => 'deflatores', 'action' => 'add'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-list"></span> <?php echo $this->Html->link('Linguagens', array('plugin' => 'linguagens', 'controller' => 'linguagens', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-list"></span> <?php echo $this->Html->link('Fases', array('plugin' => 'fases', 'controller' => 'fases', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                     <li><span class="glyphicon glyphicon-list"></span> <?php echo $this->Html->link('Fronteiras', array('plugin' => 'fronteiras', 'controller' => 'fronteiras', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-list"></span> <?php echo $this->Html->link('Itens não mensuráveis', array('plugin' => 'itens', 'controller' => 'itens', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-list"></span> <?php echo $this->Html->link('UST', array('plugin' => 'usts', 'controller' => 'usts', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-list"></span> <?php echo $this->Html->link('Equipes', array('plugin' => 'equipes', 'controller' => 'equipes', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-eye-open"></span> <?php echo $this->Html->link('Visualizar demandas por Equipe', array('plugin' => 'users', 'controller' => 'users', 'action' => 'control', 'admin'), array('tabindex' => "-1")); ?></li>
                </ul>
            </li>
            <li class="nav-header">
                <h5>Análises <i id="analisehide" class="glyphicon glyphicon-chevron-down"></i></h5>

                <ul class="list-unstyled collapse in" id="analisemenu" >
                    <li><span class="glyphicon glyphicon-list"></span> <?php echo $this->Html->link('Analises (APF)', array('plugin' => 'analises', 'controller' => 'analises', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-list"></span> <?php echo $this->Html->link('Analises (UST)', array('plugin' => 'analiusts', 'controller' => 'analiusts', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-random"></span> <?php echo $this->Html->link('Comparar Análises', array('plugin' => 'analises', 'controller' => 'analises', 'action' => 'compara'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-search"></span> <?php echo $this->Html->link('Buscar Análises', array('plugin' => 'analises', 'controller' => 'analises', 'action' => 'buscar'), array('tabindex' => "-1")); ?></li>
                </ul>
            </li>
            <li class="nav-header">
                <h5>Sistemas <i id="sistemahide" class="glyphicon glyphicon-chevron-down"></i></h5>
                <ul class="list-unstyled collapse in" id="sistemamenu" >
                    <!-- li><span class="glyphicon glyphicon-plus-sign"></span> < ?php echo $this->Html->link('Adicionar Sistema', array('plugin' => 'sistemas', 'controller' => 'sistemas', 'action' => 'add'), array('tabindex' => "-1")); ?></li-->
                    <li><span class="glyphicon glyphicon-list"></span> <?php echo $this->Html->link('Sistemas', array('plugin' => 'sistemas', 'controller' => 'sistemas', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-globe"></span> <?php echo $this->Html->link('Baselines (APF)', array('plugin' => 'sistemas', 'controller' => 'sistemas', 'action' => 'baselines'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-globe"></span> <?php echo $this->Html->link('Baselines (UST)', array('plugin' => 'sistemas', 'controller' => 'sistemas', 'action' => 'baselineusts'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-search"></span> <?php echo $this->Html->link('Histórico', array('plugin' => 'sistemas', 'controller' => 'sistemas', 'action' => 'history'), array('tabindex' => "-1")); ?></li>
                </ul>
            </li>
        <?php } else { ?> 
            <li class="nav-header"> 
                <h5>Administração <i id="adminhide" class="glyphicon glyphicon-chevron-down"></i></h5>
                <ul class="list-unstyled collapse in" id="adminmenu" >
                    <!--li><span class="glyphicon glyphicon-plus-sign"></span> < ?php echo $this->Html->link('Adicionar Fronteira', array('plugin' => 'fronteiras', 'controller' => 'fronteiras', 'action' => 'add'), array('tabindex' => "-1")); ?></li-->
                    <li> <span class="glyphicon glyphicon-list"></span> <?php echo $this->Html->link('Fronteiras', array('plugin' => 'fronteiras', 'controller' => 'fronteiras', 'action' => 'index'), array('tabindex' => "-1")); ?></li>

                    <?php
                    $userId = $this->Session->read('Equipe_unica');
                    if ($userId != '1') {
                        ?>
                        <li><span class="glyphicon glyphicon-eye-open"></span> <?php echo $this->Html->link('Visualizar demandas por Equipe', array('plugin' => 'users', 'controller' => 'users', 'action' => 'control'), array('tabindex' => "-1")); ?></li>
                        <?php
                    }
                    ?>
                </ul>
            </li>
            <li class="nav-header">
                <h5>Análises <i id="analisehide" class="glyphicon glyphicon-chevron-down"></i></h5>

                <ul class="list-unstyled collapse in" id="analisemenu" >
                    <li><span class="glyphicon glyphicon-list"></span> <?php echo $this->Html->link('Analises (APF)', array('plugin' => 'analises', 'controller' => 'analises', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-list"></span> <?php echo $this->Html->link('Analises (UST)', array('plugin' => 'analiusts', 'controller' => 'analiusts', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-random"></span> <?php echo $this->Html->link('Comparar Análises', array('plugin' => 'analises', 'controller' => 'analises', 'action' => 'compara'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-search"></span> <?php echo $this->Html->link('Buscar Análises', array('plugin' => 'analises', 'controller' => 'analises', 'action' => 'buscar'), array('tabindex' => "-1")); ?></li>
                </ul>
            </li>
            <li class="nav-header">
                <h5>Sistemas <i id="sistemahide" class="glyphicon glyphicon-chevron-down"></i></h5>
                <ul class="list-unstyled collapse in"id="sistemamenu" >
                    <!--li><span class="glyphicon glyphicon-plus-sign"></span> < ?php echo $this->Html->link('Adicionar Sistema', array('plugin' => 'sistemas', 'controller' => 'sistemas', 'action' => 'add'), array('tabindex' => "-1")); ?></li-->
                    <li><span class="glyphicon glyphicon-list"></span> <?php echo $this->Html->link('Sistemas', array('plugin' => 'sistemas', 'controller' => 'sistemas', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-globe"></span> <?php echo $this->Html->link('Baselines (APF)', array('plugin' => 'sistemas', 'controller' => 'sistemas', 'action' => 'baselines'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-globe"></span> <?php echo $this->Html->link('Baselines (UST)', array('plugin' => 'sistemas', 'controller' => 'sistemas', 'action' => 'baselineusts'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-search"></span> <?php echo $this->Html->link('Histórico', array('plugin' => 'sistemas', 'controller' => 'sistemas', 'action' => 'history'), array('tabindex' => "-1")); ?></li>
                </ul>
            </li>
        <?php } ?> 
        <?php if ($this->Session->read('Auth.User.role_id') == '1') { ?> 
            <li class="nav-header">
                <h5>Relatórios <i id="relatoriohide" class="glyphicon glyphicon-chevron-down"></i></h5>
                <ul class="list-unstyled collapse in" id="relatoriomenu">
                    <li><span class="glyphicon glyphicon-stats"></span> <?php echo $this->Html->link('Relatório de sistemas por equipe', array('plugin' => 'painel', 'controller' => 'painel', 'action' => 'relatorios', 'a'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-stats"></span> <?php echo $this->Html->link('Relatório de sistema detalhado', array('plugin' => 'painel', 'controller' => 'painel', 'action' => 'relatorios', 'b'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-stats"></span> <?php echo $this->Html->link('Relatório de desempenho individual', array('plugin' => 'painel', 'controller' => 'painel', 'action' => 'relatorios', 'c'), array('tabindex' => "-1")); ?></li>
                    <li><span class="glyphicon glyphicon-stats"></span> <?php echo $this->Html->link('Relátorios de análises por sistema e equipe', array('plugin' => 'painel', 'controller' => 'painel', 'action' => 'relatorios', 'd'), array('tabindex' => "-1")); ?></li>
                </ul>
            </li>

        <?php } ?> 
    </ul>
    <hr>

</div>