<div class="col-md-12 hidden-print"> 
    <?php echo $this->Form->create('Analise', array('class' => 'form-horizontal')); ?>
    <fieldset>
        <legend>Buscar Análises</legend>


        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Sistema * </label>
            <div class="col-md-4">
                <?php
                echo $this->Form->input('sistema_id', array(
                    'label' => false,
                    'required' => TRUE,
                    'empty' => '-- Selecione --'));
                ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Demanda</label>
            <div class="col-md-4">
                <?php
                echo $this->Form->input('demanda', array(
                    'label' => false));
                ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Tipo Contagem</label>
            <div class="col-md-4">
                <?php
                echo $this->Form->input('tipo', array(
                    'label' => false,
                    'type' => 'select',
                    'options' => \Dominio\TipoContagem::getTodosTipos(),
                    'empty' => '-- Selecione --'));
                ?>
            </div>
        </div>
    </fieldset>
    <?php echo $this->Form->end('Buscar'); ?>
</div>



<?php if (!empty($result)) { ?>
    <div class="col-md-12"> 
        <hr>
        <h4>Resultado da busca</h4>
        <hr>

        <?php foreach ($result as $key => $value) { ?>
            <legend>Análise : <?php echo!empty($value['Analise']['created']) ? date("d/m/Y ", strtotime($value['Analise']['created'])) : ''; ?></legend>
            <table class="table table-bordered">
                <tr>
                    <td>
                        <strong>Análise ID: </strong> <?php echo!empty($value['Analise']['id']) ? $value['Analise']['id'] : ''; ?>
                    </td>
                    <td colspan="4">
                        <strong>Sistema: </strong> <?php echo!empty($value['Analise']['sistema']) ? $value['Analise']['sistema'] : ''; ?>
                    </td>    
                    <td>
                        <a  href="/analises/analises/analises/<?php echo!empty($value['Analise']['id']) ? $value['Analise']['id'] : ''; ?>" class="btn btn-info">Editar Análise</a> 
                        <a  href="/analises/analises/relatorio/<?php echo!empty($value['Analise']['id']) ? $value['Analise']['id'] : ''; ?>" class="btn btn-success">Ver Relatório</a> 
                    </td>



                </tr>
                <tr>
                    <td colspan="2">
                        <strong>Nº Demanda: </strong> <?php echo!empty($value['Analise']['nu_demanda']) ? $value['Analise']['nu_demanda'] : ''; ?>
                    </td>
                    <td colspan="2">
                        <strong>Fase: </strong>  <?php echo!empty($value['Analise']['fase_id']) ? $value['Analise']['fase_id'] : ''; ?>
                    </td>
                    <td colspan="2">
                        <strong>Metodo Contagem: </strong>  <?php echo!empty($value['Analise']['metodo_contagem']) ? \Dominio\MetodoContagem::getMetodoById($value['Analise']['metodo_contagem']) : ''; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <strong>Qtde PF: </strong> <?php echo!empty($value['Analise']['total_pf']) ? $value['Analise']['total_pf'] : ''; ?>
                    </td>
                    <td colspan="2">
                        <strong>Qtde PF ajustado + INM:</strong>  <?php echo $value['Analise']['total_pf_ajustado'] + $value['Analise']['total_pf_itens']  ; ?>
                    </td>
                    <td colspan="2">
                        <strong>Tipo Contagem: </strong>  <?php echo!empty($value['Analise']['tipo_contagem']) ? \Dominio\TipoContagem::getTipoById($value['Analise']['tipo_contagem']) : ''; ?>
                    </td>
                </tr>
                <tr>
                    <th colspan="6" style="text-align: center">Funcionalidades</th>
                </tr>


                <?php if (!empty($value['Funcionalidade'])) { ?>
                    <?php foreach ($value['Funcionalidade'] as $dado): ?>
                        <tr>
                            <th style="background: #A8BDCF" colspan="2">Nome</th>
                            <th style="background: #A8BDCF">Tipo</th>
                            <th style="background: #A8BDCF">Impacto</th>
                            <th style="background: #A8BDCF">Complexidade</th>
                            <th style="background: #A8BDCF">Total PF</th>

                        </tr>
                        <tr>
                            <td colspan="2"><?php echo $dado['Funcionalidade']['nome']; ?></td>
                            <td><?php echo \Dominio\TipoFuncionalidade::getTipoById($dado['Funcionalidade']['tipo_funcionalidade']); ?></td>
                            <td><?php echo \Dominio\TipoImpacto::getImpactoById($dado['Funcionalidade']['impacto']); ?></td>
                            <td><?php echo \Dominio\TipoComplexidade::getComplexidadeById($dado['Funcionalidade']['complexidade']); ?></td>
                            <td><?php echo $dado['Funcionalidade']['qtd_pf']; ?></td>
                        </tr>  
                        <tr>
                            <td colspan="6" style="text-align: center"><strong>Observações</strong></td>

                        </tr>
                        <tr>
                            <td colspan="6"><?php echo $dado['Funcionalidade']['observacao']; ?></td>

                        </tr>
                        <?php if ($dado['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$ALI || $dado['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$AIE) { ?>
                            <?php if (!empty($dado['Funcionalidade']['trs'])) { ?>
                                <tr>
                                    <td colspan="3" style="text-align: center"><strong>TRs</strong></td>
                                    <td colspan="3" style="text-align: center"><strong>TDs</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <?php
                                        foreach ($dado['Funcionalidade']['trs'] as $valorTr) {
                                            echo $valorTr['Tdstrsar']['nome'] . ' ; ';
                                        }
                                        ?>
                                    </td>
                                    <td colspan="3">
                                        <?php
                                        foreach ($dado['Funcionalidade']['tds'] as $valorTd) {
                                            echo $valorTd['Tdstrsar']['nome'] . ' ; ';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php }
                            ?>

                        <?php } else { ?>
                            <?php if (!empty($dado['Funcionalidade']['ars'])) { ?>
                                <tr>
                                    <td colspan="3" style="text-align: center"><strong>ARs</strong></td>
                                    <td colspan="3" style="text-align: center"><strong>TDs</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <?php
                                        foreach ($dado['Funcionalidade']['ars'] as $valorAr) {
                                            echo $valorAr['Tdstrsar']['nome'] . ' ; ';
                                        }
                                        ?>
                                    </td>
                                    <td colspan="3">
                                        <?php
                                        foreach ($dado['Funcionalidade']['tds'] as $valorTds) {
                                            echo $valorTds['Tdstrsar']['nome'] . ' ; ';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php }
                            ?>
                        <?php } ?>

                    <?php endforeach; ?>

                    <?php unset($dados); ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="6"> Sem Registros.</td>
                    </tr>  
                <?php } ?>
            </table>
            <hr>
        <?php } ?>
    </div>
<?php } ?>
<div style="text-align: center" class="hidden-print col-md-12">
    <input type="button" class="btn btn-danger" value="Imprimir" onclick="self.print();">
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

        $(".checkTipo").click(function () {
            var aux = $(this).attr('id');
            var cont = aux.split('-');
            $.ajax({
                type: "POST",
                url: '/analises/analises/gettipos',
                data: {id: cont[1]},
                dataType: 'html'
            }).done(function (e) {
                bootbox.alert(e);
            });
        });
    });

</script>