<div class="masthead">
    <ul class="nav nav-pills pull-right">
        <li><p style="font-size: 12px; margin: 0px 20px 10px;"><?php echo "Data: " . date("d/m/Y H:m "); ?></p></li>
        <li><?php echo $this->Html->image('user.jpg'); ?> <i> <?php echo $this->Session->read('Auth.User.name'); ?> &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;</i>
            <br><p style="font-size: 10px"><?php echo \Dominio\Perfil::getPerfilById($this->Session->read('Auth.User.role_id')) ?></p></li>
        <li> 
            <div class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <?php echo $this->Html->image('conf.png', array('alt' => 'Configurações', 'width' => '30')); ?>
                </a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                    <li><?php echo $this->Html->link('Configurações da conta', array('plugin' => 'users', 'controller' => 'users', 'action' => 'add', $this->Session->read('Auth.User.id'))); ?></li>
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
</div>
