<div class="col-md-12 hidden-print"> 
    <?php echo $this->Form->create('', array('class' => 'form-horizontal', 'id' => 'formPesq')); ?>
    <fieldset>
        <legend>Relátorios de análises por sistema e equipe</legend>
        <?php echo $this->Form->input('st_registro', array('type' => 'hidden', 'value' => 'S')); ?>
        <?php echo $this->Form->input('relatorio', array('type' => 'hidden', 'value' => 'd')); ?>
        <?php echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id'))); ?>



        <div class="form-group">
            <label class="col-md-3 control-list" for="textinput">Sistema<strong> *</strong></label>
            <div class="col-md-3">
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
            <label class="col-md-3 control-list" for="textinput">Equipe</label>
            <div class="col-md-3">
                <?php
                echo $this->Form->input('equipe_id', array(
                    'label' => false,
                    'empty' => '-- Selecione --',
                    'class=' => "form-control input-md"));
                ?>

            </div>
        </div>
    </fieldset>
    <?php echo $this->Form->end('Gerar Relatório'); ?>
</div>


<?php if (!empty($result)) { ?>
    <div class="col-md-12"> 
        <br><br>
       <legend>Resultado da busca (Relátorios de análises por sistema e equipe)</legend>
          


    <?php foreach ($result as $key => $value) { ?>
        <legend>Análise : <?php echo!empty($value['ana']['created']) ? date("d/m/Y ", strtotime($value['ana']['created'])) : ''; ?></legend>
        <table class="table table-bordered">
            <tr>
                <td colspan="2">
                    <strong>Análise ID: </strong> <?php echo!empty($value['ana']['id']) ? $value['ana']['id'] : ''; ?>
                </td>
                <td colspan="2">
                    <strong>Sistema: </strong> <?php echo!empty($value['sis']['sistema']) ? $value['sis']['sistema'] : ''; ?>
                </td>
                <td colspan="2">
                    <strong>Equipe: </strong> <?php echo!empty($value['eqp']['equipe']) ? $value['eqp']['equipe'] : 'Administração'; ?>
                </td>

            </tr>
            <tr>
                <td colspan="2">
                    <strong>Nº Demanda: </strong> <?php echo!empty($value['ana']['nu_demanda']) ? $value['ana']['nu_demanda'] : ''; ?>
                </td>
                <td colspan="2">
                    <strong>Fase: </strong>  <?php echo!empty($value['ana']['fase_id']) ? $value['ana']['fase_id'] : ''; ?>
                </td>
                <td colspan="2">
                    <strong>Metodo Contagem: </strong>  <?php echo!empty($value['ana']['metodo_contagem']) ? \Dominio\MetodoContagem::getMetodoById($value['ana']['metodo_contagem']) : ''; ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Qtde PF: </strong> <?php echo!empty($value['ana']['total_pf']) ? $value['ana']['total_pf'] : '0'; ?>
                </td>
                <td colspan="2">
                    <strong>Qtde PF ajustado + INM:</strong>  <?php echo number_format((  $value['ana']['total_pf_ajustado'] + $value['ana']['total_pf_itens'] ), 2) ; ?>
                </td>
                <td colspan="2">
                    <strong>Tipo Contagem: </strong>  <?php echo!empty($value['ana']['tipo_contagem']) ? \Dominio\TipoContagem::getTipoById($value['ana']['tipo_contagem']) : ''; ?>
                </td>
            </tr>
        </table>
        <hr>
    <?php } ?>
    </div>
<?php } ?>

<div style="text-align: center" class="hidden-print col-md-12">
    <input type="button" class="btn btn-danger" value="Imprimir" onclick="self.print();">
</div>
<!--div class="col-md-12 hidden-print"> 
    <hr>
    <div class="well" style="background: #E0E2FF; opacity: 70%"><strong>Importante!</strong> Somente análises do baseline formam o relatório.</div>
</div-->