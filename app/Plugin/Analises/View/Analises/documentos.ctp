<?php
echo $this->element('header_analises', array(
    "analise" => $analise,
    "action" => $this->params['action']
));
?>
<div class="col-md-12"> 
    <fieldset>
        <legend>Adicionar documentos</legend>

        <?php echo $this->Form->create('Documentos', array('type' => 'file')); ?>

        <table class="table table-hover table-striped table-bordered table-condensed">
            <caption>Adicione até 5 arquivos por vez | Tamanho máximo: 15mb <br>
             <p>Tipos de arquivos permitidos : 'pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'zip', 'sql', 'ppt', 'pps', 'html', 'htm' e 'svg'.</p>
           </caption>
            <tr style="text-align: center">
                <th style="text-align: center">Descrição</th>
                <th style="text-align: center">Adicionar arquivo</th>
            </tr>
            <tr>
               <td style="text-align: center">
                    <?php
                    echo $this->Form->textarea('documentacao1', array('label' => false, 'rows' => '3', 'cols' => '90', 'maxlength' => 2000));
                    ?>
               </td>
               <td style="text-align: center">
                    <?php echo $this->Form->input('arquivo1', array('type' => 'file','multiple' => false,'label' => false));  ?>
               </td>
            </tr>
             <tr>
               <td style="text-align: center">
                    <?php
                    echo $this->Form->textarea('documentacao2', array('label' => false, 'rows' => '3', 'cols' => '90', 'maxlength' => 2000));
                    ?>
               </td>
               <td style="text-align: center">
                    <?php echo $this->Form->input('arquivo2', array('type' => 'file','multiple' => false,'label' =>false));  ?>
               </td>
            </tr>
             <tr>
               <td style="text-align: center">
                    <?php
                    echo $this->Form->textarea('documentacao3', array('label' => false, 'rows' => '3', 'cols' => '90', 'maxlength' => 2000));
                    ?>
               </td>
               <td style="text-align: center">
                    <?php echo $this->Form->input('arquivo3', array('type' => 'file','multiple' => false,'label' => false));  ?>
               </td>
            </tr>
             <tr>
               <td style="text-align: center">
                    <?php
                    echo $this->Form->textarea('documentacao4', array('label' => false, 'rows' => '3', 'cols' => '90', 'maxlength' => 2000));
                    ?>
               </td>
               <td style="text-align: center">
                    <?php echo $this->Form->input('arquivo4', array('type' => 'file','multiple' => false,'label' => false));  ?>
               </td>
            </tr>
             <tr>
               <td style="text-align: center">
                    <?php
                    echo $this->Form->textarea('documentacao5', array('label' => false, 'rows' => '3', 'cols' => '90', 'maxlength' => 2000));
                    ?>
               </td>
               <td style="align-items:  center">
                    <?php echo $this->Form->input('arquivo5', array('type' => 'file','multiple' => false,'label' => false));  ?>
               </td>
            </tr>
             
        </table>
    </fieldset>
    <?php
    echo $this->Form->end(array('label' => 'Salvar',
        'class' => 'bloqueio'
    ));
    ?>  
</div>
<?php  if(!empty($documentos)){?>
 
    <div class="col-md-12"> 
        <hr>
        <legend>Listagem de documentos</legend>
        <table class="table table-hover table-striped table-bordered table-condensed">
            <tr>
                <th>Arquivo</th>    
                <th>Descrição</th>
                <th>Ações</th>
            </tr> 

            <?php 
            
           
            foreach ($documentos as $dado): 
               
                ?>
                <tr>
                    <td ><?php 
                    
                    
                    echo  !empty($dado['Documento']['nome']) ? $dado['Documento']['nome'] : '' ; ?></td>
                    <td><?php echo  !empty($dado['Documento']['descricao']) ? $dado['Documento']['descricao'] : '' ; ?></td>
                    
                    <td>
                        <?php
                        echo $this->Html->image("icons/delete.png", array(
                            "alt" => "Excluir",
                            'url' => array(),
                            'onclick' => "excluir('/analises/analises/deleteDocumentosAnalise/" . $dado['Documento']['analise_id'] . '/'. $dado['Documento']['nomeFisico'] . "')"
                        ));
                        ?>&nbsp;
                        <a href="/analises/analises/downloadDocumentosAnalise/<?php echo $dado['Documento']['analise_id'] . '/'. $dado['Documento']['nomeFisico']; ?>" ><img src="/img/icons/download.png" alt="Download"></a>
                        
                    </td>
                </tr>
            <?php endforeach; ?>
            
        </table>
    </div>
 
<?php  } ?>



<div class="col-md-12">
    <legend style="text-align: center">Resumo parcial da análise</legend>
    <?php
    echo $this->element('resumo', array(
        "analise" => $analise
    ));
    ?>
    <!-- div style="text-align: center" class="hidden-print">
        <a href="/painel" class="btn btn-success">VOLTAR</a>
        <a href="< ?php echo '/analises/analises/dataLock/' . $analise['Analise']['id'] . '/desbloquear'; ?>" class="btn btn-info">Desbloquear Análise</a>
        <a href="< ?php echo '/analises/analises/relatorio/' . $analise['Analise']['id']; ?>" class="btn btn-default">Relatório Análise</a>
    </div -->
</div> 
 


<script type="text/javascript">


    $(document).ready(function () {

        $('.qtditem').keypress(function (event) {
            var $this = $(this);
            if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
                    ((event.which < 48 || event.which > 57) &&
                            (event.which != 0 && event.which != 8))) {
                event.preventDefault();
            }

            var text = $(this).val();
            if ((event.which == 46) && (text.indexOf('.') == -1)) {
                setTimeout(function () {
                    if ($this.val().substring($this.val().indexOf('.')).length > 3) {
                        $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
                    }
                }, 1);
            }

            if ((text.indexOf('.') != -1) &&
                    (text.substring(text.indexOf('.')).length > 2) &&
                    (event.which != 0 && event.which != 8) &&
                    ($(this)[0].selectionStart >= text.length - 2)) {
                event.preventDefault();
            }
        });
        //  $('.qtditem').mask("99.99", {reverse: true});
        //  $(".qtditem").maskMoney({thousands:'.', decimal:','});
       // $(".qtditem").on("keypress keyup blur", function (event) {
//            //$('.qtditem').mask('9999.99', { reverse: true });
//            this.value = this.value.replace(/[^0-9\.]/g, '');
//            $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
//            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
//                event.preventDefault();
//            }
//            //$(this).val().indexOf('.').parseFloat(this.value).toFixed(2);
            //event.preventDefault();
        //});
        // $(".qtditem").inputmask({'mask':["9{0,5}.9{0,2}", "999"]});
    });




</script>
