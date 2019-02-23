<?php
echo $this->element('header_analises', array(
    "analise" => $analise
));
?>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).ready(function() {
            $("#autocomplete").autocomplete({
                source: function(req, add) {
                    $.getJSON("/analises/analises/autocomplete/<?php echo $analise['Analise']['sistema_id'] ?>/<?php echo $analise['Analise']['id'] ?>/2?callback=?", req, function(data) {
                        var busca = [];
                        $.each(data, function(i, val) {
                            busca.push(val.nome);
                        });
                        add(busca);
                    });
                }
            });
        });
    });
</script>

<div class="row-fluid ">
    <?php echo $this->Form->create('Funcionalidade'); ?>
    <legend>Funções de Transação</legend>
    <?php echo $this->Form->input('analise_id', array('type' => 'hidden', 'value' => $analise['Analise']['id'])); ?>
    <div>
        <label for="prependedtext">Buscar função de transação existente no sistema: </label>
        <div class="input-prepend">
            <?php
            echo $this->Form->input('q', array(
                'label' => false,
                'id' => 'autocomplete'));
            ?>
        </div>
    </div> 
    <?php echo $this->Form->end('Buscar'); ?>
    <?php echo $this->Form->create('Funcionalidade'); ?>
    <?php echo $this->Form->input('analise_id', array('type' => 'hidden', 'value' => $analise['Analise']['id'])); ?>
    <?php echo $this->Form->input('sistema_id', array('type' => 'hidden', 'value' => $analise['Analise']['sistema_id'])); ?>
    <?php echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id'))); ?>
    <?php echo $this->Form->input('st_ultimo_registro', array('type' => 'hidden', 'value' => 'S')); ?>
    <?php echo $this->Form->input('tipo', array('type' => 'hidden', 'value' => '2')); ?>
    <?php echo $this->Form->input('metodo_contagem', array('id' => 'metodo_contagem', 'type' => 'hidden', 'value' => $analise['Analise']['metodo_contagem'])); ?>
    <?php echo $this->Form->input('st_registro', array('type' => 'hidden', 'value' => 'S')); ?>
    <div class="span12">
        <div class="span4">
            <div>
                <label for="prependedtext">Nome</label>
                <div class="input-prepend">
                    <?php
                    echo $this->Form->input('nome', array(
                        'label' => false,
                        'required' => TRUE,
                        'value' => isset($resultado['Funcionalidade']['nome']) ? $resultado['Funcionalidade']['nome'] : ''));
                    ?>
                </div>
            </div> 
        </div>


        <div class="span4">
            <div>
                <label for="prependedtext">Tipo</label>
                <div>
                    <?php
                    echo $this->Form->radio('tipo_funcionalidade', array(
                        '3' => 'SE',
                        '4' => 'CE',
                        '5' => 'EE',), array('legend' => false, 'value' => isset($resultado['Funcionalidade']['tipo_funcionalidade']) ? $resultado['Funcionalidade']['tipo_funcionalidade'] : ''));
                    ?>
                </div>
            </div>
        </div>
        <div class="span4">
            <div>
                <label for="prependedtext">Tipo de Impacto: </label>
                <div>
                    <?php
                    echo $this->Form->radio('impacto', \Dominio\TipoImpacto::getTodosImpactos(), array('legend' => false, 'value' => isset($resultado['Funcionalidade']['impacto']) ? $resultado['Funcionalidade']['impacto'] : ''));
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="span12">
        <div class="span4">
            <label for="prependedtext">AR</label>
            <?php if (isset($resultado['Funcionalidade']['Ar'])) { ?>
                <?php foreach ($resultado['Funcionalidade']['Ar'] as $key): ?>
                    <?php $str = $key; ?> 
                <?php endforeach; ?>
            <?php } ?>
            <?php
            echo $this->Form->textarea('ar', array(
                'label' => false,
                'value' => !empty($str) ? $str : '',
            ));
            ?>

        </div>
        <div class="span4">
            <label for="prependedtext">TD</label>
            <?php if (isset($resultado['Funcionalidade']['Td'])) { ?>
                <?php foreach ($resultado['Funcionalidade']['Td'] as $k => $v): ?>
                    <?php $std = $v; ?> 
                <?php endforeach; ?>
            <?php } ?>
            <?php
            echo $this->Form->textarea('td', array(
                'label' => false,
                'value' => !empty($std) ? $std : '',
            ));
            ?>

        </div>
        <div class="span4">
            <label for="prependedtext">Observações</label>
            <?php
            echo $this->Form->textarea('observacao', array(
                'label' => false,
            ));
            ?>

        </div>
    </div>
    <div class="span12">
        <div>
            <label for="prependedtext">Visualizar itens não mensuráveis?</label>
            <div class="input-prepend">
                <?php
                echo $this->Form->checkbox('item', array(
                    'label' => false,
                    'id' => 'checkItem',
                ));
                ?>
            </div>
        </div> 
    </div>
    <div id="itens" class="span12" style="display: none">
        <table class="table table-hover table-striped table-bordered table-condensed">
            <tr>
                <th>Adicionar</th>
                <th>Nome</th>
                <th>Quantidade</th>
                <th>Justificativa</th>
            </tr>
            <?php
            if ($items) {
                $cont = 0;
                ?>
                <?php foreach ($items as $key => $value):
                    ?>
                    <tr>
                        <td>     
                            <?php
                            echo $this->Form->checkbox('Funcionalidade.Item.' . $cont . '.item_id', array(
                                'value' => $value['Item']['id'],
                            ));
                            ?>
                        </td>
                        <td>     
                            <?php
                            echo $value['Item']['nome'];
                            ?>
                        </td>
                        <td>  <?php
                            echo $this->Form->input('Funcionalidade.Item.' . $cont . '.qtd', array(
                                'label' => false,
                                'type' => 'number'
                            ));
                            ?></td>
                        <td> 
                            <?php
                            echo $this->Form->textarea('Funcionalidade.Item.' . $cont . '.justificativa', array(
                                'label' => false,
                            ));
                            ?></td>
                    </tr>
                    <?php $cont++;
                endforeach;
                ?>
                <?php unset($dados); ?>
<?php }else { ?>
                <div class="alert-info">
                    Sem Registros.
                </div>
<?php } ?>
        </table>
    </div>

<?php echo $this->Form->end('Salvar'); ?>
    <fieldset>
        <legend>Funcionalidade de dados</legend>

        <table class="table table-hover table-striped table-bordered table-condensed">
            <tr>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Impacto</th>
                <th>Complexidade</th>
                <th>Total PF</th>
                <th>Ações</th>
            </tr>
            <!-- Here is where we loop through our $posts array, printing out post info -->

            <?php if ($funcionalidades) { ?>
    <?php foreach ($funcionalidades as $dado): ?>
                    <tr>
                        <td><?php echo $dado['Funcionalidade']['nome']; ?></td>
                        <td><?php echo \Dominio\TipoFuncionalidade::getTipoById($dado['Funcionalidade']['tipo_funcionalidade']); ?></td>
                        <td><?php echo \Dominio\TipoImpacto::getImpactoById($dado['Funcionalidade']['impacto']); ?></td>
                        <td><?php echo \Dominio\TipoComplexidade::getComplexidadeById($dado['Funcionalidade']['complexidade']); ?></td>
                        <td><?php echo $dado['Funcionalidade']['qtd_pf']; ?></td>
                        <td>
                            <?php
                            echo $this->Html->link('X ', array('controller' => 'analises', 'action' => 'deleteDados', $dado['Funcionalidade']['id'], $analise['Analise']['id']));
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php unset($dados); ?>
<?php }else { ?>
                <div class="alert-info">
                    Sem Registros.
                </div>
<?php } ?>
        </table>
    </fieldset>
    <?php
    echo $this->element('resumo', array(
        "analise" => $analise
    ));
    ?>
</div> 