<?php
echo $this->element('header_analises', array(
    "analise" => $analise,
    "action" => $this->params['action']
));
$equipeId = $this->Session->read('Equipe_id');
$roleId = $this->Session->read('Auth.User.role_id');
?>  
<div class="col-md-12">
    <fieldset>
        <legend>Informações gerais da análise </legend> 


        <?php echo $this->Form->create('Analiust', array('class' => "form-horizontal")); ?>
        <?php echo $this->Form->input('analise_id', array('type' => 'hidden', 'value' => $analise['Analiust']['id'])); ?>
        <?php echo $this->Form->input('sistema_id', array('type' => 'hidden', 'value' => !empty($analise['Analiust']['sistema_id']) ? $analise['Analiust']['sistema_id'] : '')); ?>
        <?php echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id'))); ?>
        <?php echo $this->Form->input('equipe_id', array('type' => 'hidden', 'value' => $equipeId)); ?>
        <?php echo $this->Form->input('baseControl', array('type' => 'hidden', 'value' => $analise['Analiust']['baseline'])); ?>
        <?php echo $this->Form->input('st_registro', array('type' => 'hidden', 'value' => 'S')); ?>
        <div class="col-md-10"> 
             <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Contrato Vinculado *</label>
                <div class="col-md-4">
                  
                     <?php
                    echo $this->Form->input('id_contrato', array(
                        'label' => false,
                        'id' => 'IdContrato',
                        'options' => $contratos,
                        'required' => TRUE,
                        'empty' => '-- Selecione --'
                    ));
                    ?>
                </div>
            </div>
             <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Método de Contagem *</label>
                <div class="col-md-4">
               
                <?php
                    echo $this->Form->input('metodo_contagem', array(
                    'label' => false,
                    'id' => 'MetodoContagem',
                    'options' => $metodos, 
                    'empty' => '-- Selecione --',
                    'required' => true ));
                ?>
                </div>
            </div>
            

            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Fase *</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('fase_id', array(
                        'label' => false,
                        'options' => $fases,
                        'empty' => '-- Selecione --'
                    ));
                    ?>
                </div>
            </div>

        </div>
        <div class="col-md-10"> 
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Código Demanda *</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('nu_demanda', array(
                        'label' => false, 'required' => TRUE));
                    ?>
                </div>
            </div>
           

        </div>


        <div class="col-md-10"> 

            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Observações</label>
                <div class="col-md-4">
<?php
echo $this->Form->textarea('observacao', array('label' => false, 'rows' => '4', 'cols' => '60', 'maxlength' => 2000));
?>
                </div>
            </div>
        </div>

        <div class="col-md-10"> 
            <?php if ($roleId == '1'): ?>
                <div class="form-group" id="formBase">
                    <label class="col-md-4 control-label" for="textinput">Deseja incluir esta análise ao Baseline?</label>
                    <div class="col-md-4">
                        <?php
                     echo $this->Form->checkbox('baseline', array(
                    'label' => false,
                    'id' => 'baseCheck'
                ));
                ?>
                                </div>
                            </div>

            <?php endif; ?>(*) Campos obrigatórios.
</fieldset>
            <?php echo $this->Form->end('Salvar'); ?>
        </div>
</div> 

<div class="col-md-12">
    <legend style="text-align: center">Resumo parcial da análise</legend>
<?php
echo $this->element('resumo', array(
    "analise" => $resumo
));
?>
    <!-- div style="text-align: center" class="hidden-print">
        <a href="/analiusts" class="btn btn-success">Voltar</a>
        <a href="< ?php echo '/analiusts/analiusts/dataLock/' . $analise['Analiust']['id'] . '/desbloquear'; ?>" class="btn btn-info">Desbloquear Análise</a>
        <a href="< ?php echo '/analiusts/analiusts/relatorio/' . $analise['Analiust']['id']; ?>" class="btn btn-default">Relatório Análise</a>
    </div>
</div> 
<div class="col-md-12"> 
    <hr>
    <div class="well" style="background: #E0E2FF; opacity: 70%"><strong>Importante!</strong> É necessário desbloquear a análise para torná-la disponível para outros usuários.</div>
</div -->

<script type="text/javascript">
    $(document).ready(function () {
        
         $('#IdContrato').change(function(e){
              
            var IdContrato = $('#IdContrato').val(); 
            if(IdContrato != '0'){
                $.getJSON('/analiusts/analiusts/carregaMetodo/'+IdContrato, function (dados){ 

                   if (Object.keys(dados).length > 0){  

                      var option = '<option value= ""> - Selecione - </option>';
                      $.each(dados, function(i, obj){
                          if(obj === '1'){
                              obj = 'Detalhada (IFPUG)'
                          }else if (obj === '2'){
                              obj = 'Estimada (NESMA)'
                          }else{
                              obj = 'Indicativa (NESMA)'
                          }
                          option += '<option value="'+i+'">'+obj+'</option>';
                      })

                   }else{
                       var option = '<option value= ""> - Selecione - </option>';
                       bootbox.alert("Não há métodos associados ao contrato.");
                   }
                   $('#MetodoContagem').html(option).show(); 
                })
            }
        })
        
        
        $("#AnaliseMetodoContagem").click(function () {
            if ($("#AnaliseMetodoContagem").val() == '2' || $("#AnaliseMetodoContagem").val() == '3') {
                $("#baseCheck").val(1);
                $("#formBase").hide();

            } else {

                $("#formBase").show();
            }


        });


        if ($("#AnaliseMetodoContagem").val() == '2') {
            $("#baseCheck").val(1);
            $("#formBase").hide();

        } else {

            $("#formBase").show();
        }




        if ($("#AnaliustBaseControl").val() == '1') {
            $("#baseCheck").attr('checked', false);
        }else
        if ($("#AnaliustBaseControl").val() == '0') {
            $("#baseCheck").attr('checked', true);
        }

    });
</script>