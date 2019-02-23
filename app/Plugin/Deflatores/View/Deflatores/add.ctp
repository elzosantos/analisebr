
<div class="col-md-12"> 
    <?php echo $this->Form->create('', array('class' => "form-horizontal")); ?>
    <fieldset>
        <legend>Deflatores - % Porcentagem</legend>
        <?php echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id'))); ?>
        <?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => '1')); ?>

        <div class="col-md-8"> 
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Funcionalidades Incluídas</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('deflator_inc', array(
                        'label' => false,
                        'required' => TRUE,
                        'class=' => "form-control input-md"));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Funcionalidades Alteradas</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('deflator_alt', array(
                        'label' => false,
                        'required' => TRUE,
                        'class=' => "form-control input-md"));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Funcionalidades Excluídas</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('deflator_exc', array(
                        'label' => false,
                        'required' => TRUE,
                        'class=' => "form-control input-md"));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Fator de Ajuste PADRAO (VAF)</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('fator', array(
                        'label' => false,
                        'required' => TRUE,
                        'class=' => "form-control input-md"));
                    ?>
                </div>
            </div>
        </div>
    </fieldset>
    <?php echo $this->Form->end('Salvar'); ?>
</div>




