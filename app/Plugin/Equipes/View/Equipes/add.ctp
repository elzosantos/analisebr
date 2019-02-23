<div class="col-md-12"> 
    <?php echo $this->Form->create('Equipe', array('class' => "form-horizontal")); ?>
    <fieldset>
        <legend>Adicionar Equipe</legend>
        <?php echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id'))); ?>
        <?php echo $this->Form->input('st_registro', array('type' => 'hidden', 'value' => 'S')); ?>
        <?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => isset($id) ? $id : '')); ?>



        <div class="form-group">
            <label class="col-md-3 control-list" for="textinput">Nome da Equipe *</label>
            <div class="col-md-6">
                <?php
                echo $this->Form->input('nome', array(
                    'label' => false,
                    'type' => 'text',
                    'required' => TRUE,
                    'class=' => "form-control input-md"));
                ?>
            </div>
        </div>

        <div class="col-md-12"> 
            <div class="form-group">
                <label class="control-list" for="textinput">Selecionar Participantes da equipe:</label>
                <table class="table table-hover table-striped table-bordered table-condensed">
                    <tr>
                        <th>Adicionar</th>
                        <th>Nome</th>
                        <th>Usuário</th>
                        <th>Perfil</th>
                        <th>Email</th>
                        <th style="display:  none">
                    </tr>
                    <?php if (!empty($result)) { ?>
                        <?php
                        foreach ($result as $key => $value):
                            if (!empty($userequipe)) {
                                foreach ($userequipe as $k) {
                                    if ($k == $value['id']) {
                                        $valid = 'true';
                                    }
                                }
                            }
                            ?>
                            <tr>
                                <td>     
                                    <?php
                                    echo $this->Form->checkbox('User.Td.' . 'id-' . $value['id'], array('checked' => !empty($valid) ? $valid : ''));
                                    $valid = '';
                                    ?>
                                </td>
                                <td>     
                                    <?php
                                    echo $value['name'];
                                    ?>
                                </td>
                                <td>     
                                    <?php
                                    echo $value['username'];
                                    ?>
                                </td>
                                <td>     
                                    <?php
                                    echo \Dominio\Perfil::getPerfilById($value['perfil']);
                                    ?>
                                </td>
                                <td>     
                                    <?php
                                    echo $value['email'];
                                    ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="2">Sem Registros</td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>(*) Campos obrigatório.
    </fieldset>
    <?php echo $this->Form->end('Salvar'); ?>
</div>



