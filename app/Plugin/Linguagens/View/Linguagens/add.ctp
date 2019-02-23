
<div class="col-md-12"> 
    <?php echo $this->Form->create('', array('class' => "form-horizontal")); ?>
    <fieldset>
        <legend>Adicionar Linguagem</legend>
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
            <label class="col-md-4 control-label" for="textinput">Produtividade (horas/PF) - Desenvolvimento *</label>
            <div class="col-md-4">
                <?php
                echo $this->Form->input('produtividade_desen', array(
                    'label' => false,
                    'required' => TRUE,
                    'class=' => "form-control input-md"));
                ?>

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Produtividade (horas/PF) - Melhoria *</label>
            <div class="col-md-4">
                <?php
                echo $this->Form->input('produtividade_mel', array(
                    'label' => false,
                    'required' => TRUE,
                    'class=' => "form-control input-md"));
                ?>

            </div>
        </div>(*) Campos obrigatórios.
    </fieldset>
    
    <?php echo $this->Form->end('Salvar'); ?>
</div>

