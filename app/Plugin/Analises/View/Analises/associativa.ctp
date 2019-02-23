

<div class="col-md-12"> 
    <fieldset>
        <legend>Associar Funcionalidades </legend>

        Funcionalidade: <strong>   <?php echo $nomeFunc; ?>  </strong>
        <hr>
        <div  class="form-group" id='functionPesq' >
            <label class="col-md-6 control-label" for="textinput">Procurar funcionalidades ALI | AIE :</label>
            <?php echo $this->Form->create('Funcionalidade', array('class' => 'form-horizontal')); ?>
            <?php echo $this->Form->input('analise_id', array('type' => 'hidden', 'value' => $analise['Analise']['id'])); ?>
            <?php echo $this->Form->input('sistema_id', array('type' => 'hidden', 'value' => $analise['Analise']['sistema_id'])); ?>
            <div class="col-md-6">
                <?php
                echo $this->Form->input('q', array(
                    'label' => false,
                    'id' => 'autocompleteAR'));
                ?>
            </div>
        </div>
    </fieldset>
    <div class="col-md-5">
        <?php echo $this->Form->end('Buscar'); ?>
    </div>
    <div class="col-md-5">
        <?php echo $this->Html->link($this->Form->button('Voltar para Funcionalidade'), array('action' => 'funcionalidades', 2, $analise['Analise']['id'], $funcionalidade), array('escape' => false, 'title' => "Voltar para a funcionalidade.")); ?>
    </div>

</div>
<div class="col-md-12"> 
    <hr>
    <div  class="form-group">
        <?php if (!empty($resultArsAssoc)) { ?>
            <?php echo $this->Form->create('Associativa', array('class' => 'form-horizontal')); ?>
            <?php echo $this->Form->input('funcionalidade_nova', array('type' => 'hidden', 'value' => $funcionalidade)); ?>
            <?php echo $this->Form->input('funcionalidade_antiga', array('type' => 'hidden', 'value' => $dataFuncionalidade['funcionalidade_id'])); ?>
            <?php echo $this->Form->input('analise_id', array('type' => 'hidden', 'value' => $analise['Analise']['id'])); ?>
            <?php echo $this->Form->input('st_registro', array('type' => 'hidden', 'value' => 'S')); ?>
            <?php echo $this->Form->input('sistema_id', array('type' => 'hidden', 'value' => $analise['Analise']['sistema_id'])); ?>
            <?php echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id'))); ?>
            <table class="table table-hover table-striped table-bordered table-condensed">
                <tr>
                    <th style="text-align: center">Sistema</th>
                    <td style="text-align: center"><?php echo $dataFuncionalidade['nome_sistema']; ?></td>

                </tr>
                <tr>
                    <th style="text-align: center">Funcionalidade</th>
                    <td style="text-align: center"><?php echo $dataFuncionalidade['nome_funcionalidade']; ?></td>
                </tr>
                <tr>
                    <th style="text-align: center">Tipo</th>
                    <td style="text-align: center"><?php echo \Dominio\TipoFuncionalidade::getTipoById($dataFuncionalidade['tipo']); ?></td>
                </tr>
                <tr>
                </tr>
                <tr>
                    <th style="text-align: center; background: #D6E9C6">Adicionar TDs</th>
                    <th style="text-align: center; background: #D6E9C6">Nome TDs</th>
                </tr>
    <?php if (!empty($resultArsAssoc)) { ?>
        <?php foreach ($resultArsAssoc as $key => $value):
            ?>
                        <tr>
                            <td style="text-align: center">     
                        <?php
                        echo $this->Form->checkbox('Associativa.Td.' . 'id-' . $value['Tdstrsar']['id']);
                        ?>
                            </td>
                            <td style="text-align: center">     
                                <?php
                                echo $value['Tdstrsar']['nome'];
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
                <?php echo $this->Form->end('Adicionar'); ?>
<?php } ?>
    </div> 
</div> 
<div class="col-md-12">
    <legend style="text-align: center">Resumo parcial da análise</legend>
        <?php
        echo $this->element('resumo', array(
            "analise" => $analise
        ));
        ?>
    <div style="text-align: center" class="hidden-print">
        <a href="/painel" class="btn btn-success">VOLTAR</a>
        <a href="<?php echo '/analises/analises/dataLock/' . $analise['Analise']['id'] . '/true'; ?>" class="btn btn-info">Concluir Análise</a>
    </div>
</div> 
<div class="col-md-12"> 
    <hr>
    <div class="well" style="background: #E0E2FF; opacity: 70%"><strong>Importante!</strong> É necessário Concluir a Análise para desbloqueá-la.</div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).ajaxStart(function () {
            $(".carregando").fadeIn();
            $('input[type="button"], input[type="submit"]').attr('disabled', 'disabled');
        });
        $(document).ajaxStop(function () {
            $(".carregando").fadeOut();
            $('input[type="button"], input[type="submit"]').removeAttr('disabled');
        });

        $("#autocompleteAR").autocomplete({
            source: function (req, add) {
                $.getJSON("/analises/analises/autocompleteAR/<?php echo $analise['Analise']['sistema_id'] ?>?callback=?", req, function (data) {
                    var busca = [];
                    if (data) {
                        $.each(data, function (i, val) {
                            busca.push(val.nome + ' - ' + val.sistema_id);
                        });
                        add(busca);
                    } else
                    {
                        return;
                    }
                });
            }
        });
    });

</script>