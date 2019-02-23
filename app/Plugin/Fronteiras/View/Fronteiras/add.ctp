<div class="col-md-12"> 
    <?php echo $this->Form->create('Fronteira', array('class' => "form-horizontal")); ?>
    <fieldset>
        <legend>Adicionar Fronteira</legend>
        <?php echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id'))); ?>
        <?php echo $this->Form->input('st_registro', array('type' => 'hidden', 'value' => 'S')); ?>
        <?php echo $this->Form->input('id', array('type' => 'hidden')); ?>


        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Nome *</label>
            <div class="col-md-4">
                <?php
                echo $this->Form->input('nome', array(
                    'label' => false,
                    'required' => TRUE,
                    'class=' => "form-control input-md"));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Descrição</label>
            <div class="col-md-4">
                <?php
                echo $this->Form->textarea('descricao', array(
                    'label' => false, 'rows' => '4', 'cols' => '60', 'maxlength' => 2000));
                ?>
            </div>
        </div>(*) Campo obrigatório.
    </fieldset>
    <?php echo $this->Form->end('Salvar'); ?>
</div>





