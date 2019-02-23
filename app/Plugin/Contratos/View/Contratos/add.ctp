<div class="col-md-12">
    <?php echo $this->Form->create('Contrato', array('class' => "form-horizontal")); ?>
    <fieldset>
        <legend>Adicionar Contrato</legend>
        <?php echo $this->Form->input('st_registro', array('type' => 'hidden', 'value' => 'S')); ?>
        <?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
        <?php echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id'))); ?>
        <div class="col-md-8"> 
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Identificador Contrato *</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('identificador_contrato', array(
                        'label' => false,
                        'required' => TRUE,
                        'style' => 'width:700px',
                        'class=' => "form-control input-md"));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Nome da Empresa *</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('nome_empresa', array(
                        'label' => false,
                        'style' => 'width:400px',
                        'required' => TRUE,
                        'maxlength' => 1000,
                        'class=' => "form-control input-md"));
                    ?>

                </div>
            </div>

        </div>
        <div class="col-md-8"> 
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Data Inicial Vigência *</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('dt_inicio_contrato', array(
                        'label' => false,
                        'class' => 'datepicker',
                        'style' => 'width:100px',
                        'placeholder' => '99/99/9999',
                        'required' => TRUE,
                        'class=' => "form-control input-md"));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Data Final Vigência *</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('dt_fim_contrato', array(
                        'label' => false,
                        'required' => TRUE,
                        'class' => 'datepicker',
                        'style' => 'width:100px',
                        'placeholder' => '99/99/9999',
                        'class=' => "form-control input-md"));
                    ?>

                </div>
            </div>

        </div>
        <div class="col-md-8"> 
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Número do pregão</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('numero_pregao', array(
                        'label' => false,
                        'required' => TRUE,
                        'style' => 'width:200px',
                        'class=' => "form-control input-md"));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Valor do ponto de função em R$</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('valor_pf', array(
                        'label' => false,
                        'id' => 'valor_pf',
                        'required' => TRUE,
                        'style' => 'width:90px',
                        'class=' => "form-control input-md"));
                    ?>

                </div>
            </div>
        </div>
      
      <div class="col-md-8">  
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">DEFLATORES (%)</label>
                 
            </div>
        </div>
        <div class="col-md-8">  
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Inclusão</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('inclusao', array(
                        'label' => false,
                        'required' => TRUE,
                        'style' => 'width:50px',
                        'class=' => "form-control input-md"));
                    ?>  
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Alteração</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('alteracao', array(
                        'label' => false,
                        'required' => TRUE,
                        'style' => 'width:50px',
                        'class=' => "form-control input-md"));
                    ?>  
                </div>
            </div>
           
            
        </div>
         <div class="col-md-8">   
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Exclusão</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('exclusao', array(
                        'label' => false,
                        'required' => TRUE,
                        'style' => 'width:50px',
                        'class=' => "form-control input-md"));
                    ?> 
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Fator de Ajuste Padrão (VAF)</label>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('fator_ajuste_padrao', array(
                        'label' => false,
                        'required' => TRUE,
                        'style' => 'width:50px',
                        'class=' => "form-control input-md"));
                    ?>
                </div>
            </div>
           
            
        </div>
         
        <div class="col-md-8"> 
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Métodos de contagem permitidos</label>
                <div class="col-md-4">
                    <div>
                    <?php
                    
                    
                                    echo $this->Form->checkbox('Metodo.Tipo-1', array('checked' => !empty($validDetalhada) ? $validDetalhada : ''));
                                    
                                    ?> Detalhada (IFPUG)
                                    </div>
                                    <div>
                     <?php
                                    echo $this->Form->checkbox('Metodo.Tipo-2', array('checked' => !empty($validEstimada) ? $validEstimada : ''));
                                   
                                    ?> Estimada (NESMA)</div>
                    <div>
                     <?php
                                    echo $this->Form->checkbox('Metodo.Tipo-3', array('checked' => !empty($validIndicativa) ? $validIndicativa : ''));
                               
                                    ?> Indicativa (NESMA)</div>
                </div>
            </div>
             
             
        </div>
        <div class="col-md-8"> 
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Equipes habilitadas:</label> 
                <div class="col-md-4">
                    <table class="table">
                      
                        <?php if (!empty($result)) { ?>
                            <?php
                            foreach ($result as $key => $value):
                                if (!empty($equipecontrato)) {
                                    foreach ($equipecontrato as $k => $v) { 
                                        if ($v['Rlcontratoequipe']['id_equipe'] == $value['id']) {
                                            $valid = 'true';
                                        }
                                    }
                                }
                                ?>
                                <tr>
                                    <td>     
                                        <?php
                                        echo $this->Form->checkbox('Equipe.Td.' . 'id-' . $value['id'], array('checked' => !empty($valid) ? $valid : ''));
                                        $valid = '';
                                        ?>
                                    </td>
                                    <td>     
                                        <?php
                                        echo $value['nome'];
                                        ?>
                                    </td>


                                </tr>
                            <?php endforeach; ?>
                        
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>(*) Campo obrigatório.
       
    </fieldset>
    <?php echo $this->Form->end('Salvar'); ?>
</div>

<script type="text/javascript">
    jQuery(document).ready(function () {
        
        
         $('#valor_pf').maskMoney();
        
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


        $(".datepicker").mask("99/99/9999");

        
 
    });

</script>



