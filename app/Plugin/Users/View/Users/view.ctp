<h1>Visualizando Usuario</h1>
<br />
<?php echo $this->Html->link('Listar Usuarios', '/users/', array('class' => 'button')); ?>
<br />
<br />
<h2><?php echo $users['User']['name'] ?></h2>
<small> Criado em : <?php echo $users['User']['created'] ?></small>
    <p>Email: <?php echo $users['User']['email'] ?> <br /> 
    Senha: <?php echo $users['User']['senha'] ?></p>
<br />