<div class="masthead">
    <ul class="nav nav-pills pull-right">
        <li><p style="font-size: 12px; margin: 0px 20px 10px;">
                <?php echo $this->Html->image('icons/eye.png', array('title' => 'Você está visualizando o sistema por equipe.')); ?> <strong><?php
                    $equipe = $this->Session->read('Equipe');
                    echo!empty($equipe) ? $equipe : 'Administração';
                    ?></strong></p></li>
        <li><p style="font-size: 12px; margin: 0px 20px 10px;"><?php echo "Data: " . date("d/m/Y H:m "); ?></p></li>
        <li><?php echo $this->Html->image('user.jpg'); ?> <i> <?php echo $this->Session->read('Auth.User.name'); ?> &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;</i>
            <br><p style="font-size: 10px"><?php echo \Dominio\Perfil::getPerfilById($this->Session->read('Auth.User.role_id')); ?></p></li>
        <li> 
            <div class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <?php echo $this->Html->image('conf.png', array('alt' => 'Configurações', 'width' => '30')); ?>
                </a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                    <li><?php echo $this->Html->link('Configurações da conta', array('plugin' => 'users', 'controller' => 'users', 'action' => 'add', 'user')); ?></li>
                    <li class="divider"></li>
                    <li> <?php echo $this->Html->link('Ajuda', array('plugin' => 'users', 'controller' => 'users', 'action' => 'logout')); ?></li>
                    <li> <?php echo $this->Html->link('Sobre', array('plugin' => 'users', 'controller' => 'users', 'action' => 'logout')); ?></li>
                    <li class="divider"></li>
                    <li> <?php echo $this->Html->link('Sair', array('plugin' => 'users', 'controller' => 'users', 'action' => 'logout')); ?></li>
                </ul>
            </div>
        </li>

    </ul>
    <?php echo $this->Html->image('analisebr.png'); ?> 
    <hr>
    <div class="dropdown hidden-print">
        <ul class="nav nav-pills">
            <li class="active"> <?php echo $this->Html->link('Início', array('plugin' => 'painel', 'controller' => 'painel', 'action' => 'index'), array('class' => 'dropdown-toggle')); ?></li>
            <?php if ($this->Session->read('Auth.User.role_id') == '1') { ?> 
                <li class="dropdown">
                    <a class="dropdown-toggle" id="drop4" role="button" data-toggle="dropdown" href="#">Administração <b class="caret"></b></a>
                    <ul id="menu1" class="dropdown-menu" role="menu" aria-labelledby="drop4">
                        <li id='menu'> <?php echo $this->Html->link('Adicionar Usuários', array('plugin' => 'users', 'controller' => 'users', 'action' => 'add'), array('tabindex' => "-1")); ?></li>
                        <li> <?php echo $this->Html->link('Listar Usuários', array('plugin' => 'users', 'controller' => 'users', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                        <li class="divider"></li>
                        <li> <?php echo $this->Html->link('Deflatores', array('plugin' => 'deflatores', 'controller' => 'deflatores', 'action' => 'add'), array('tabindex' => "-1")); ?></li>
                        <li class="divider"></li>
                        <li> <?php echo $this->Html->link('Adicionar Linguagem', array('plugin' => 'linguagens', 'controller' => 'linguagens', 'action' => 'add'), array('tabindex' => "-1")); ?></li>
                        <li> <?php echo $this->Html->link('Listar Linguagens', array('plugin' => 'linguagens', 'controller' => 'linguagens', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                        <li class="divider"></li>
                        <li> <?php echo $this->Html->link('Adicionar Fase', array('plugin' => 'fases', 'controller' => 'fases', 'action' => 'add'), array('tabindex' => "-1")); ?></li>
                        <li> <?php echo $this->Html->link('Listar Fases', array('plugin' => 'fases', 'controller' => 'fases', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                        <li class="divider"></li>
                        <li> <?php echo $this->Html->link('Adicionar Itens não mensuráveis', array('plugin' => 'itens', 'controller' => 'itens', 'action' => 'add'), array('tabindex' => "-1")); ?></li>
                        <li> <?php echo $this->Html->link('Listar Itens não mensuráveis', array('plugin' => 'itens', 'controller' => 'itens', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                        <li class="divider"></li>
                        <li> <?php echo $this->Html->link('Adicionar Equipe', array('plugin' => 'equipes', 'controller' => 'equipes', 'action' => 'add'), array('tabindex' => "-1")); ?></li>
                        <li> <?php echo $this->Html->link('Listar Equipes', array('plugin' => 'equipes', 'controller' => 'equipes', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                        <li class="divider"></li>
                        <li> <?php echo $this->Html->link('Visualizar por Equipe', array('plugin' => 'users', 'controller' => 'users', 'action' => 'control', 'admin'), array('tabindex' => "-1")); ?></li>
                    </ul>
                </li>
            <?php } ?> 
            <li class="dropdown">
                <a class="dropdown-toggle" id="drop4" role="button" data-toggle="dropdown" href="#">Análises <b class="caret"></b></a>
                <ul id="menu1" class="dropdown-menu" role="menu" aria-labelledby="drop4">
                    <li> <?php echo $this->Html->link('Adicionar Análise', array('plugin' => 'analises', 'controller' => 'analises', 'action' => 'add'), array('tabindex' => "-1")); ?></li>
                    <li> <?php echo $this->Html->link('Listar Análises', array('plugin' => 'analises', 'controller' => 'analises', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                    <li> <?php echo $this->Html->link('Comparar Análises', array('plugin' => 'analises', 'controller' => 'analises', 'action' => 'compara'), array('tabindex' => "-1")); ?></li>
                    <li> <?php echo $this->Html->link('Buscar Análises', array('plugin' => 'analises', 'controller' => 'analises', 'action' => 'buscar'), array('tabindex' => "-1")); ?></li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" id="drop4" role="button" data-toggle="dropdown" href="#">Sistemas <b class="caret"></b></a>
                <ul id="menu2" class="dropdown-menu" role="menu" aria-labelledby="drop5">
                    <li> <?php echo $this->Html->link('Adicionar Sistema', array('plugin' => 'sistemas', 'controller' => 'sistemas', 'action' => 'add'), array('tabindex' => "-1")); ?></li>
                    <li> <?php echo $this->Html->link('Listar Sistemas', array('plugin' => 'sistemas', 'controller' => 'sistemas', 'action' => 'index'), array('tabindex' => "-1")); ?></li>
                    <li class="divider"></li>
                    <li> <?php echo $this->Html->link('Baselines', array('plugin' => 'sistemas', 'controller' => 'sistemas', 'action' => 'baselines'), array('tabindex' => "-1")); ?></li>
                    <li> <?php echo $this->Html->link('Histórico', array('plugin' => 'sistemas', 'controller' => 'sistemas', 'action' => 'history'), array('tabindex' => "-1")); ?></li>
                </ul>
            </li>

        </ul>
    </div>
    <hr>
</div>
