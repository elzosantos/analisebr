<div class="col-md-12"> 
    <?php echo $this->Form->create('User', array('class' => 'form')); ?>
    <fieldset>
        <legend>Escolha uma equipe para acessar o sistema ( Equipe é definida pelo Administrador )</legend>

        <div class="col-md-8"> 
            <div class="form-group">
                <label class="col-md-3 control-list" for="textinput">Escolher equipe</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('equipe_id', array(
                        'label' => false,
                        'class' => 'control-label',
                        'required' => true,
                        'empty' => '-- Selecione --',
                        'class=' => "form-control input-md"));
                    ?>
                </div>
            </div>
        </div>
    </fieldset>
    <?php echo $this->Form->end('Continuar'); ?>
</div>
