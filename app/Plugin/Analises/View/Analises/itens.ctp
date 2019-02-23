<?php
echo $this->element('header_analises', array(
    "analise" => $analise,
    "action" => $this->params['action']
));
?>
<div class="col-md-12"> 
    <fieldset>
        <legend>Adicionar itens não mensuráveis</legend>

        <?php echo $this->Form->create('Rlustsanalises'); ?>

        <table class="table table-hover table-striped table-bordered table-condensed">
            <tr style="text-align: 
                center">
                <th style="text-align: center">#</th>

                <th style="text-align: center">Nome</th>
                <th style="text-align: center">Peso</th>
                <th style="text-align: center">QTDE</th>
                <th style="text-align: center">Justificativa</th>
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
                            echo $cont + 1;
                            ?>
                        </td>
                        <td style="display: none">     
                            <?php echo $this->Form->input('Rlitensanalise.Item.' . $cont . '.item_id', array('type' => 'hidden', 'value' => $value['Item']['id'])); ?>

                        </td>
                        <td style="text-align: center" title="<?php
                        echo $value['Item']['descricao'];
                        ?>">     

                            <?php
                            echo $value['Item']['nome'];
                            ?>
                        </td>
                        <td style="text-align: center">     
                            <?php
                            echo $value['Item']['valor_pf'];
                            ?>
                        </td>
                        <td style="text-align: center">  <?php
                            echo $this->Form->input('Rlitensanalise.Item.' . $cont . '.qtd', array(
                                'label' => false,
                                'class' => 'input-mini',
                                'class' => 'qtditem'
                                , 'style' => 'width:50px',
                                'size' => '2'
                            ));
                            ?></td>
                        <td style="text-align: center"> 
                            <?php
                            echo $this->Form->textarea('Rlitensanalise.Item.' . $cont . '.justificativa', array(
                                'label' => false,
                                'cols' => '60',
                                'rows' => '3'
                            ));
                            ?></td>
                    </tr>
                    <?php
                    $cont++;
                endforeach;
                ?>
                <?php unset($dados); ?>
            <?php }else { ?>
                <td colspan="7"> Sem Registros.</td>
            <?php } ?>
        </table>
    </fieldset>
    <?php
    echo $this->Form->end(array('label' => 'Salvar',
        'class' => 'bloqueio'
    ));
    ?>  
</div>



<?php if (!empty($naomensuravel)) { ?>
    <div class="col-md-12"> 
        <hr>
        <legend>Listagem de itens não mensuráveis</legend>
        <table class="table table-hover table-striped table-bordered table-condensed">
            <tr>
                <th>Nome</th>
                <th>Peso</th>
                <th>Quantidade</th>
                <th>Justificativa</th>
                <th>Ações</th>
            </tr>
            <!-- Here is where we loop through our $posts array, printing out post info -->

            <?php foreach ($naomensuravel as $dado): ?>
                <tr>
                    <td ><?php echo $nomeItens[$dado['Rlitensanalise']['item_id']]; ?></td>
                    <td><?php echo $pesoItens[$dado['Rlitensanalise']['item_id']]; ?></td>
                    <td><?php echo $dado['Rlitensanalise']['qtde'] ?></td>
                    <td><?php echo $dado['Rlitensanalise']['justificativa']; ?></td>
                    <td>
                        <?php
                        echo $this->Html->image("icons/delete.png", array(
                            "alt" => "Excluir",
                            'url' => array(),
                            'onclick' => "excluir('/analises/analises/deleteItensAnalise/" . $dado['Rlitensanalise']['id'] . '/' . $dado['Rlitensanalise']['item_id'] . '/' . $analise['Analise']['id'] . "')",
                        ));
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php unset($dados); ?>
        </table>
    </div>
<?php } ?>




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
