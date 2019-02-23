<?php echo $this->Form->create('User', array('class' => "form-horizontal")); ?>
<?php echo $this->Form->input('st_registro', array('type' => 'hidden', 'value' => 'S')); ?>
<?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id'))); ?>
<?php echo $this->Form->input('complete', array('type' => 'hidden', 'value' => 'S')); ?>
<?php echo $this->Form->input('role_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.role_id'))); ?>
<div class="well">Completar Cadastro - Alterar Senha</div>
<div class="col-md-8"> 
    <div class="form-group">
        <label class="col-md-4 control-label" for="textinput">Nova Senha *</label>
        <div class="col-md-4">
            <?php
            echo $this->Form->input('password', array(
                'label' => false,
                'required' => TRUE,
                'max-length' => 8,
                'min-length' => 8,
                'class=' => "form-control input-md"));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label" for="textinput">Confirmar Senha *</label>
        <div class="col-md-4">
            <?php
            echo $this->Form->input('password_confirm', array(
                'label' => false,
                'type' => 'password',
                'required' => TRUE,
                'max-length' => 8,
                'min-length' => 8,
                'class=' => "form-control input-md"));
            ?>
        </div>
    </div>
<?php echo $this->Form->end('Completar Cadastro'); ?>
</div>

</div>
