<div class="col-md-12">
    <?php echo $this->Form->create('', array('class' => "form-horizontal")); ?>
    <fieldset>
        <legend>Adicionar Sistema</legend>
        <?php echo $this->Form->input('st_registro', array('type' => 'hidden', 'value' => 'S')); ?>
        <?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
        <?php echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id'))); ?>
        <div class="col-md-8"> 
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
                <label class="col-md-4 control-label" for="textinput">Sigla *</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('sigla', array(
                        'label' => false,
                        'required' => TRUE,
                        'maxlength' => 3,
                        'class=' => "form-control input-md"));
                    ?>

                </div>
            </div>

        </div>
        <div class="col-md-8"> 
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Linguagem *</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('linguagem_id', array(
                        'label' => false,
                        'required' => TRUE,
                        'empty' => '-- Selecione --',
                        'class=' => "form-control input-md"));
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-8"> 

            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Descrição</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->textarea('descricao', array('label' => false, 'rows' => '5', 'cols' => '60'));
                    ?>

                </div>
            </div>(*) Campos obrigatórios.
        </div>
    </fieldset>
    <?php echo $this->Form->end('Salvar'); ?>
</div>




