<div class="col-md-12"> 
    <?php echo $this->Form->create('User', array('class' => "form-horizontal border")); ?>
    <fieldset>
        <legend>Cadastro de Usuários</legend>
        <?php echo $this->Form->input('st_registro', array('type' => 'hidden', 'value' => 'S')); ?>
        <?php echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id'))); ?>
        <?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
        <?php echo $this->Form->input('tipoCadastro', array('type' => 'hidden', 'value' => !empty($cadastro) ? $cadastro : '')); ?>
        
        <div class="col-md-8"> 
            <?php if ($cadastro == 'novo') { ?>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Usuário *</label>
                    <div class="col-md-4">
                        <?php
                        echo $this->Form->input('username', array(
                            'label' => false,
                            'style' => 'width:200px;',
                            'required' => TRUE,
                            'class=' => "form-control input-md"));
                        ?>
                    </div>
                </div>
            
            <?php } else { ?>

            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Usuário *</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('username', array(
                        'label' => false,
                        'style' => 'width:200px;',

                        'readonly' => 'readonly',
                        'class=' => "form-control input-md"));
                    ?>
                </div>
            </div>
            <?php }  ?>
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Nome *</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('name', array(
                        'label' => false,
                        'style' => 'width:400px;',
                        'required' => TRUE,
                        'class=' => "form-control input-md"));
                    ?>
                </div>
            </div>
            <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Senha *</label>
                    <div class="col-md-4">
                        <?php
                        echo $this->Form->input('password', array(
                            'label' => false,
                            'style' => 'width:200px;',
                            'required' => TRUE,
                            'class=' => "form-control input-md"));
                        ?>
                    </div>
            </div>
            
            <?php if ($cadastro != 'alterar_analista_auto') { ?>
                <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Tipo de Usuário *</label>
                <div class="col-md-4">
                    <?php
                    $options = array('Interno' => 'Interno', 'Externo' => 'Externo');
                    $attributes = array('legend' => false);
                    echo $this->Form->radio('tipo_usuario', $options, $attributes);
                    ?>
                </div>
            </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Categoria *</label>
                    <div class="col-md-4">
                        <?php
                        echo $this->Form->input('role_id', array(
                            'label' => false,
                            'required' => TRUE,
                            'options' => array('1' => 'Administrador', '2' => 'Analista de Métricas'),
                            'empty' => '-- Selecione --',
                            'class=' => "form-control"
                        ));
                        ?>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="col-md-8"> 
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">E-mail *</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('email', array(
                        'label' => false,
                        'style' => 'width:400px;',
                        'required' => TRUE,
                        'class=' => "form-control input-md"));
                    ?>
                </div>
            </div>

            (*) Campos obrigatórios.
        </div>
    </fieldset>
    
    <div class="submit"><input type="submit" name="salvar" value="Salvar">
    <?php if ($cadastro != 'novo') { ?>
        <a href="#"  id="reset">Resetar Senha</a>
    <?php } ?>
    
    <!--?php echo $this->Form->end('Salvar'); ?-->
 
</div>

<script type="text/javascript">
    jQuery(document).ready(function() {



        $("#reset").on('click', function resetar(url) {

            var url = '/users/users/reset/' + $("#UserId").val() + '/1';
            bootbox.dialog({
                message: "Deseja realmente resetar a senha?",
                title: "Atenção!",
                buttons: {
                    success: {
                        label: "Cancelar",
                        className: "btn-info",
                        callback: function() {

                        }
                    },
                    danger: {
                        label: "Resetar",
                        className: "btn-danger",
                        callback: function() {
                            location.href = url;
                        }
                    }
                }
            });

        });
    });



</script>