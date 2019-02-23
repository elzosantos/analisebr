<div class="col-md-12"> 
    <?php echo $this->Form->create('Sistema', array('class' => 'form-horizontal')); ?>
    <fieldset>
        <legend>Buscar histórico por período</legend>
        <?php echo $this->Form->input('st_registro', array('type' => 'hidden', 'value' => 'S')); ?>
        <?php echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id'))); ?>




        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Sistema</label>
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
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Data inicial</label>
            <div class="col-md-4">
                <?php
                echo $this->Form->input('data_ini', array(
                    'label' => false,
                    'class' => 'datepicker',
                    'required' => TRUE));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Data final</label>
            <div class="col-md-4">
                <?php
                echo $this->Form->input('data_fim', array(
                    'label' => false,
                    'class' => 'datepicker',
                    'required' => TRUE));
                ?>
            </div>
        </div>
    </fieldset>
    <?php echo $this->Form->end('Buscar'); ?>

</div>
<div class="col-md-12"> 
    <?php if (!empty($result)) { ?>

        <legend style="text-align: center">Resultado da busca</legend>
        <table class="table table-bordered">
            <caption>Resumo do Histórico</caption>
            <tr>
                <td>
                    <strong>Sistema: </strong><?php echo!empty($result['sistema']['Sistema']['nome']) ? $result['sistema']['Sistema']['nome'] : ''; ?>
                </td>
                <td>

                    <strong>Nº Demandas: </strong> <?php echo $result['total_demanda']; ?>
                </td>
                <td>
                    <strong>Qtde PF inclusão: </strong> <?php echo!empty($result['total_incluido']) ? $result['total_incluido'] : ''; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Qtde PF alteração: </strong><?php echo!empty($result['total_alterado']) ? $result['total_alterado'] : ''; ?>
                </td>
                <td colspan="2">
                    <strong>Qtde PF exclusão:</strong> <?php echo!empty($result['total_excluido']) ? $result['total_excluido'] : ''; ?>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <strong>Qtde Total PF: </strong> <?php echo $result['total_pf']; ?>
                </td>
            </tr>
        </table>
        <legend>Funcionalidades</legend>
        <table class="table table-hover table-striped table-bordered table-condensed">
            <tr>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Impacto</th>
                <th>Complexidade</th>
                <th>Total PF</th>
                <th>TDs TRs ARs</th>
            </tr>
            <?php if ($funcionalidades) { ?>
                <?php foreach ($funcionalidades as $dado): ?>
                    <tr>
                        <td><?php echo $dado['Funcionalidade']['nome']; ?></td>
                        <td><?php echo \Dominio\TipoFuncionalidade::getTipoById($dado['Funcionalidade']['tipo_funcionalidade']); ?></td>
                        <td><?php echo \Dominio\TipoImpacto::getImpactoById($dado['Funcionalidade']['impacto']); ?></td>
                        <td><?php echo \Dominio\TipoComplexidade::getComplexidadeById($dado['Funcionalidade']['complexidade']); ?></td>
                        <td><?php echo $dado['Funcionalidade']['qtd_pf']; ?></td>
                        <td><input type="button" id='checkTipo-<?php echo $dado['Funcionalidade']['id']; ?>' class='checkTipo' value="Ver Detalhes" title="Ver Detalhes"></td>
                    </tr>

                <?php endforeach; ?>
                <?php unset($dado); ?>
            <?php }else { ?>
                <td colspan="6">Sem registros</td>
            <?php } ?>
        </table>
    <?php } ?>
</div>
<script type="text/javascript">
    jQuery(document).ready(function () {
        $(document).ajaxStart(function () {
            $(".carregando").fadeIn();
            $('input[type="button"], input[type="submit"]').attr('disabled', 'disabled');
        });
        $(document).ajaxStop(function () {
            $(".carregando").fadeOut();
            $('input[type="button"], input[type="submit"]').removeAttr('disabled');
        });
        $(".checkTipo").click(function () {
            var aux = $(this).attr('id');
            var cont = aux.split('-');
            $.ajax({type: "POST",
                url: '/analises/analises/gettipos',
                data: {id: cont[1]},
                dataType: 'html'
            }).done(function (e) {
                bootbox.alert(e);
            });
        });
        $(".datepicker").datepicker({
            dateFormat: 'dd/mm/yy',
            dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
            dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
            dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            nextText: 'Próximo',
            prevText: 'Anterior'
        });
        $("#SistemaDataIni").mask("99/99/9999");
        $("#SistemaDataFim").mask("99/99/9999");
    });

</script>
