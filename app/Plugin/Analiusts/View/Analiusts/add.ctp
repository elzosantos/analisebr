<div class="col-md-12"> 
    <?php echo $this->Form->create('Analise', array('class' => 'form-horizontal')); ?>
    <fieldset>
        <legend>Adicionar Análise (UST)</legend>
        <?php echo $this->Form->input('st_registro', array('type' => 'hidden', 'value' => 'S')); ?>
        <?php echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id'))); ?>


        <?php
        $perfil = $this->Session->read('Auth.User.role_id');

        if ($perfil == '1') {
            ?>
            <div class="col-md-12"> 

                <div class="well" style="background: #E0E2FF; opacity: 70%"><strong>Importante!</strong> Administrador antes de cadastrar uma análise escolha "Visualizar demandas por Equipe" para o devido cadastro!</div>
            </div>
        <?php }
        ?>
        <div class="col-md-8"> 
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Escolha um Sistema *</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('sistema_id', array(
                        'label' => false,
                        'required' => TRUE,
                        'empty' => '-- Selecione --',
                        'class=' => "form-control input-md"));
                    ?>
                </div>
            </div>

        </div>(*) Campo obrigatório.

    </fieldset>
    <?php echo $this->Form->end('Continuar'); ?>
</div>

