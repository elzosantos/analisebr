<?php
   
echo $this->element('header_analises', array(
    "analise" => $analise,
    "tipo" => $tipo,
    "action" => $this->params['action']
));
?>
<div class="col-md-12">
    <fieldset>
        <legend>Adicionar funções </legend> 
        <?php echo $this->Form->create('Funcionalidade', array('class' => 'form-horizontal', 'id' => 'formFuncao')); ?>
        <?php echo $this->Form->input('analise_id', array('id' => 'analise', 'type' => 'hidden', 'value' => $analise['Analise']['id'])); ?>
        <?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => !empty($id_busca) ? $id_busca : '')); ?>
        <?php echo $this->Form->input('id_busca', array('type' => 'hidden', 'value' => !empty($id) ? $id : '')); ?>
        <?php echo $this->Form->input('buscado', array('type' => 'hidden', 'value' => !empty($id_busca) ? $id_busca : '')); ?>
        <?php echo $this->Form->input('validaBaseline', array('type' => 'hidden', 'value' => !empty($validaBaseline) ? $validaBaseline : '')); ?>
        <?php echo $this->Form->input('baseline', array('type' => 'hidden', 'value' => isset($analise['Analise']['baseline']) ? $analise['Analise']['baseline'] : '')); ?>
        <?php echo $this->Form->input('id_antigo', array('type' => 'hidden', 'value' => isset($resultado['Funcionalidade']['id_antigo']) ? $resultado['Funcionalidade']['id_antigo'] : '')); ?>
        <?php echo $this->Form->input('rastreio', array('id' => 'changeBusca', 'type' => 'hidden', 'value' => isset($resultado['Funcionalidade']['id']) ? $resultado['Funcionalidade']['id'] : '')); ?>
        <?php echo $this->Form->input('sistema_id', array('type' => 'hidden', 'value' => $analise['Analise']['sistema_id'])); ?>
        <?php echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id'))); ?>
        <?php echo $this->Form->input('tipo', array('id' => 'tipoFuncao', 'type' => 'hidden', 'value' => $tipo)); ?>
        <?php echo $this->Form->input('metodo_contagem', array('id' => 'metodo_contagem', 'type' => 'hidden', 'value' => $analise['Analise']['metodo_contagem'])); ?>
        <?php echo $this->Form->input('st_registro', array('type' => 'hidden', 'value' => 'S')); ?>
        <?php echo $this->Form->input('autocomplete', array('type' => 'hidden', 'value' => 'S')); ?>
        <?php echo $this->Form->input('st_ultimo_registro', array('type' => 'hidden', 'value' => 'S')); ?>
        <?php echo $this->Form->input('associacao', array('type' => 'hidden', 'id' => 'associacao', 'value' => '')); ?>
        <div class="col-md-12"> 
            <div class="form-group">
                <div class="col-md-10"> 
                    <label class="control-list">Nome *</label>
                </div>
                <div class="col-md-10"> 
                    <div>
                        <?php
                        echo $this->Form->input('Funcionalidade.nome', array(
                            'id' => 'nomeFunc',
                            'label' => false,
                            'style' => 'width:670px; height:23px;',
                            'required' => TRUE,
                            'maxlength' => '250',
                            'value' => isset($resultado['Funcionalidade']['nome']) ? $resultado['Funcionalidade']['nome'] : ''));
                        ?>
                    </div>
                </div>
                <div class="col-md-2" style="text-align: right"> 
                    <?php echo $this->Html->image('help.png', array('id' => 'assistente')); ?> 
                </div>
            </div>
        </div>
        <div class="col-md-12"> 
            <div class="form-group">


                <div class="col-md-3"> 
                    <label class="control-list" for="textinput">Tipo *</label>
                    <?php
                    if ($tipo == '1') {
                        echo $this->Form->input('Funcionalidade.tipo_funcionalidade', array(
                            'label' => false,
                            'required' => TRUE,
                            'options' => array(
                                '1' => 'ALI',
                                '2' => 'AIE')
                            ,
                            'empty' => '-- Selecione --',
                            'value' => isset($resultado['Funcionalidade']['tipo_funcionalidade']) ? $resultado['Funcionalidade']['tipo_funcionalidade'] : ''
                        ));
                    } elseif ($tipo == '2') {
                        echo $this->Form->input('tipo_funcionalidade', array(
                            'label' => false,
                            'required' => TRUE,
                            'options' => array(
                                '3' => 'SE',
                                '4' => 'CE',
                                '5' => 'EE',)
                            ,
                            'empty' => '-- Selecione --',
                            'value' => isset($resultado['Funcionalidade']['tipo_funcionalidade']) ? $resultado['Funcionalidade']['tipo_funcionalidade'] : ''));
                    }
                    ?>
                </div>
                <div class="col-md-3"> 
                    <label class="control-list" for="textinput">Tipo Impacto *</label>
                    <?php
                    echo $this->Form->input('Funcionalidade.impacto', array(
                        'label' => false,
                        'required' => TRUE,
                        'options' => $impactos,
                        'empty' => '-- Selecione --',
                        'value' => isset($resultado['Funcionalidade']['impacto']) ? $resultado['Funcionalidade']['impacto'] : '')
                    );
                    ?>
                </div>

                <?php if (!empty($analise['Analise']['metodo_contagem']) && $analise['Analise']['metodo_contagem'] == \Dominio\MetodoContagem::$detalhada) { ?>

                    <?php if ($tipo == '2') { ?>
                        <div class="col-md-3"> 
                            <a  style="font-size: 12px" href="#"   id='checkTipo-<?php echo 0; ?>' class="btn btn-info checkAssociativa">Adicionar ALIs ou AIEs?</a>
                        </div>
                    <?php } ?>

                <?php } ?>

            </div>

        </div>



        <?php if (!empty($analise['Analise']['metodo_contagem']) && $analise['Analise']['metodo_contagem'] == \Dominio\MetodoContagem::$detalhada) { ?>
            <div class="col-md-12"> 
                <div class="form-group">
                    <?php if ($tipo == '1') { ?>
                        <div class="col-md-5">
                            <div>
                                <label class="control-list" for="textinput">TR</label>
                            </div>

                            <?php
                            echo $this->Form->textarea('Funcionalidade.tr', array(
                                'label' => false,
                                'value' => !empty($tr) ? $tr : '',
                                'cols' => '50',
                                'rows' => '12'
                            ));
                            ?>
                            <div>
                                <strong>TOTAL TRs: </strong><span id="result__trs">0</span>
                            </div>
                            <div>
                                <input id="removeTRDuplicada" type="button" value="Remover TRs duplicados">   
                            </div>


                            <script type="text/javascript">
                                var area = document.getElementById('FuncionalidadeTr')
                                        , results = {
                                            paragraphs: document.getElementById('result__trs')
                                        };

                                new Countable(area, function (counter) {
                                    if ('textContent' in document.body) {
                                        results.paragraphs.textContent = counter.paragraphs;
                                    } else {
                                        results.paragraphs.innerText = counter.paragraphs;
                                    }
                                });

                            </script>

                        </div>

                    <?php } elseif ($tipo == '2') { ?>
                        <div class="col-md-5">
                            <div>
                                <label class="control-label" for="textinput">AR</label>
                            </div>

                            <?php
                            echo $this->Form->textarea('Funcionalidade.ar', array(
                                'label' => false,
                                'value' => !empty($ar) ? $ar : '',
                                'id' => 'arSistem',
                                'cols' => '50',
                                'rows' => '12'
                            ));
                            ?>
                            <div>
                                <strong>TOTAL ARs: </strong><span id="result__ars">0</span>
                            </div>
                            <div>
                                <input id="removeARDuplicada" type="button" value="Remover ARs duplicados">   
                            </div>

                            <script type="text/javascript">
                                var areaar = document.getElementById('arSistem')
                                        , resultsar = {
                                            paragraphs: document.getElementById('result__ars')
                                        };

                                new Countable(areaar, function (counter) {
                                    if ('textContent' in document.body) {
                                        resultsar.paragraphs.textContent = counter.paragraphs;
                                    } else {
                                        resultsar.paragraphs.innerText = counter.paragraphs;
                                    }
                                });

                            </script>
                        </div>
                    <?php } ?>
                    <div class="col-md-5">
                        <div>
                            <label class="control-list" for="textinput">TD</label>
                        </div>
                        <?php
                        echo $this->Form->textarea('Funcionalidade.td', array(
                            'label' => false,
                            'value' => !empty($td) ? $td : '',
                            'cols' => '50',
                            'rows' => '12'
                        ));
                        ?> 
                        <div>
                            <strong>TOTAL TDs: </strong><span id="result__tds">0</span>
                        </div>
                        <div>
                                <input id="removeTDDuplicada" type="button" value="Remover TDs duplicados">   
                        </div>

                        <script type="text/javascript">
                            var areatd = document.getElementById('FuncionalidadeTd')
                                    , resultstd = {
                                        paragraphs: document.getElementById('result__tds')
                                    };

                            new Countable(areatd, function (counter) {
                                if ('textContent' in document.body) {
                                    resultstd.paragraphs.textContent = counter.paragraphs;
                                } else {
                                    resultstd.paragraphs.innerText = counter.paragraphs;
                                }
                            });

                        </script>
                    </div>

                </div>
            </div>

        <?php } ?>



        <div class="col-md-12"> 
            <div>

                <label class="control-list" for="textinput">Observações</label>
            </div>
            <div>
                <?php
                echo $this->Form->textarea('observacao', array(
                    'label' => false,
                    'value' => isset($resultado['Funcionalidade']['observacao']) ? $resultado['Funcionalidade']['observacao'] : '',
                    'cols' => '111',
                    'rows' => '4',
                    'maxlength' => '1999',
                ));
                ?>
            </div>

        </div>
        <div class="col-md-12"> 

            <label class="control-label"> <?php
                echo $this->Form->checkbox('Funcionalidade.item', array(
                    'label' => false,
                    'id' => 'checkItem',
                ));
                ?> Deseja adicionar itens não mensuráveis?<br><br></label>

        </div>


        <div class="col-md-12"> 
            <div id="itens" class="span12" style="display: none">
                <table class="table table-hover table-striped table-bordered table-condensed">
                    <tr>
                        <th style="text-align: center">#</th>

                        <th style="text-align: center">Nome</th>
                        <th style="text-align: center">Peso</th>
                        <th style="text-align: center">QTDE</th>
                        <th style="text-align: center">Justificativa</th>
                    </tr>
                    <?php
                  
                    if (!empty($items)) {
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
                                <td style="display:none;">     
                                    <?php echo $this->Form->input('Item.' . $cont . '.item_id', array('type' => 'hidden', 'value' => $value['Item']['id'], 'size' => '1')); ?>

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
                                    echo $this->Form->input('Item.' . $cont . '.qtd', array(
                                        'label' => false, 'size' => '1',
                                        'class' => 'qtditem'
                                        ,'style' => 'width:40px'
                                    ));
                                    ?></td>
                                <td style="text-align: center"> 
                                    <?php
                                    echo $this->Form->textarea('Item.' . $cont . '.justificativa', array(
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
                        <td colspan="5">Sem registros</td>
                    <?php } ?>
                </table>
            </div>
        </div>
    </fieldset>
    <div class="col-md-12"> 
        <?php echo $this->Form->end(array('type' => 'button', 'label' => 'Adicionar', 'id' => 'submitForm')); ?>
    </div>
</div>
<div class="col-md-12"> 
    <hr>
    <div class="form-group">
        <?php echo $this->Form->create('Funcionalidade'); ?>
        <?php echo $this->Form->input('analise_id', array('type' => 'hidden', 'value' => $analise['Analise']['id'])); ?>
        <?php echo $this->Form->input('sistema_id', array('type' => 'hidden', 'value' => $analise['Analise']['sistema_id'])); ?>
        <div>
            <label class="control-list " for="textinput">Buscar função de <?php echo ($tipo == '1') ? 'dados' : 'transação'; ?>?</label>


        </div>
        <div>
            <?php
            echo $this->Form->input('q', array(
                'label' => false,
                'id' => 'autocomplete',
                'style' => 'width:690px; height:23px;',));
            ?><br>
            <?php echo $this->Form->end('Buscar'); ?>
            <p>*Apenas funcões que compõem o baseline do sistema serão buscadas.</p>
        </div>
    </div>

</div>





<div class="col-md-12"> 
    <hr>



    <legend>Listagem de funções </legend>

    <p>
        <strong>Funções de Dados</strong> 
    </p>
    <?php
      if($analise['Analise']['metodo_contagem'] == \Dominio\MetodoContagem::$estimada){   ?>
        <table id="dadosEstimada">

        <thead>
            <?php

                 echo $this->Html->tableHeaders(  array(
                'ID#',
                'Nome',
                'Tipo',
                'Impacto',
                'Complexidade',
                'PF',
                'PF c/ Deflator',
            
                'Ações'
            ));
            ?>
        </thead>
        </table>
    <?php }else {?>
            <table id="dados">

        <thead>
            <?php

                 echo $this->Html->tableHeaders(  array(
                'ID#',
                'Nome',
                'Tipo',
                'Impacto',
                'Complexidade',
                'PF',
                'PF c/ Deflator',
                'TR|AR|TD',
                'Ações'
            ));
       
            
            
            ?>
        </thead>


    </table>
            
    <?php }?>
    <hr>
    <p>
        <strong>Funções de Transação</strong>
    </p>
     <?php
      if($analise['Analise']['metodo_contagem'] == \Dominio\MetodoContagem::$estimada){   ?>
    <table id="transacaoEstimada">

        <thead>
           <?php
            echo $this->Html->tableHeaders(array(
                'ID#',
                'Nome',
                'Tipo',
                'Impacto',
                'Complexidade',
                'PF',
                'PF c/ Deflator',
              
                'Ações'
            ));
            
            ?>
        </thead>

    </table>
     <?php }else {?>
    <table id="transacao">

        <thead>
           <?php
            echo $this->Html->tableHeaders(array(
                'ID#',
                'Nome',
                'Tipo',
                'Impacto',
                'Complexidade',
                'PF',
                'PF c/ Deflator',
                'TR|AR|TD',
                'Ações'
            ));
            
            ?>
        </thead>

    </table>
       <?php }?>
    <hr>

</div>




<div class="col-md-12"> 

    <legend>Listagem de itens não mensuráveis das funções</legend>
    <table class="table table-hover table-striped table-bordered table-condensed">
        <tr>

            <th>Funcionalidade</th>
            <th>Nome Item</th>
            <th>Peso</th>
            <th>Quantidade</th>
            <th>Justificativa</th>
            <th>Ações</th>
        </tr>
        <?php if (!empty($naomensuravel)) { ?>
            <?php foreach ($naomensuravel as $dado) {
                ?>
                <tr>
                    <td><?php echo $dado['funcionalidade']; ?></td>
                    <td><?php echo $dado['nome']; ?></td>
                    <td><?php echo $dado['peso']; ?></td>
                    <td><?php echo $dado['quantidade'] ?></td>
                    <td><?php echo $dado['justificativa']; ?></td>
                    <td>
                        <?php
                        echo $this->Html->image("icons/delete.png", array(
                            "alt" => "Excluir",
                            'url' => array(),
                            'onclick' => "excluir('/analises/analises/deleteItensFuncionalidade/" . $dado['rl_id'] . '/' . $dado['item_id'] . '/' . $dado['funcionalidade_id'] . '/' . $analise['Analise']['id'] . '/' . $tipo . "')"
                        ));
                        ?>
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="6">Sem registros</td>

            </tr>      
        <?php } ?>
        <?php unset($dados); ?>
    </table>
</div>





<div class="col-md-12">
    <legend style="text-align: center">Resumo parcial da análise</legend>
    <?php
    echo $this->element('resumo', array(
        "analise" => $analise
    ));
    ?>
    <!-- div style="text-align: center" class="hidden-print">
        <a href="/analises/analises" class="btn btn-success">Voltar</a>
        <a href="< ?php echo '/analises/analises/dataLock/' . $analise['Analise']['id'] . '/desbloquear'; ?>" class="btn btn-info">Desbloquear Análise</a>
        <a href="< ?php echo '/analises/analises/relatorio/' . $analise['Analise']['id']; ?>" class="btn btn-default">Relatório Análise</a>
    </div -->
</div> 
 
<script type="text/javascript">


    $(document).ready(function () {
        
        $('#removeTRDuplicada').click(function(){
            
            bootbox.dialog({
                message: "Deseja apagar as TRs duplicadas?",
                title: "Atenção!",
                buttons: {
                    success: {
                        label: "Cancelar",
                        className: "btn-info",
                        callback: function() {

                        }
                    },
                    danger: {
                        label: "Continuar",
                        className: "btn-success",

                        callback: function() {
                            var data = $('#FuncionalidadeTr').val();
                            var result = data.toUpperCase().split(/\s/g).filter((word, i, arr) => arr.indexOf(word) === i);
                            $('#FuncionalidadeTr').val(result.join('\n'));
                        }
                    }
                }
            });
           
        });
        $('#removeTDDuplicada').click(function(){
            
            bootbox.dialog({
                message: "Deseja apagar as TDs duplicadas?",
                title: "Atenção!",
                buttons: {
                    success: {
                        label: "Cancelar",
                        className: "btn-info",
                        callback: function() {

                        }
                    },
                    danger: {
                        label: "Continuar",
                        className: "btn-success",

                        callback: function() {
                            var data = $('#FuncionalidadeTd').val();
                            
                            var result = data.toUpperCase().split(/\s/g).filter((word, i, arr) => arr.indexOf(word) === i);
                            $('#FuncionalidadeTd').val(result.join('\n'));
                        }
                    }
                }
            });
           
        });
        $('#removeARDuplicada').click(function(){
            
            bootbox.dialog({
                message: "Deseja apagar as ARs duplicadas?",
                title: "Atenção!",
                buttons: {
                    success: {
                        label: "Cancelar",
                        className: "btn-info",
                        callback: function() {

                        }
                    },
                    danger: {
                        label: "Continuar",
                        className: "btn-success",

                        callback: function() {
                            var data = $('#arSistem').val();
                            var result = data.toUpperCase().split(/\s/g).filter((word, i, arr) => arr.indexOf(word) === i);
                            $('#arSistem').val(result.join('\n'));
                        }
                    }
                }
            });
           
        });

        if ($("#FuncionalidadeValidaBaseline").val() != '' ){

            bootbox.dialog({
                message: "Essa funcionalidade já existe no baseline do sistema. Deseja retirar a funcionalidade do baseline na outra análise?",
                title: "Atenção!",
                buttons: {
                    success: {
                        label: "Cancelar",
                        className: "btn-info",
                        callback: function() {

                        }
                    },
                    danger: {
                        label: "Ir para análise",
                        className: "btn-success",

                        callback: function() {
                            var url = '/analises/analises/analises/' + $("#FuncionalidadeValidaBaseline").val()
                            location.href = url
                        }
                    }
                }
            });
        }
        
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
        var id_analise = $("#analise").val();
        $('#dados').dataTable({
            "bJQueryUI": true,
            "aaSorting": [[0, 'desc']],
            "bFilter": false,
            "sPaginationType": "full_numbers",
            "sDom": '<"H"Tlfr>t<"F"ip>',
            "bProcessing": false,
            "bServerSide": true,
            "bPaginate": true,
            "aLengthMenu": [[10, 25, 50, 200], [10, 25, 50, 200]],
            "iDisplayLength": 10,
            "sAjaxSource": "/analises/analises/responseDados/" + id_analise,
            "aoColumns": [
                {"bVisible": false},
                {"bSearchable": true,
                "bVisible": true},
                null,
                null,
                {"bSearchable": true,
                     "bVisible": true},
                null,
                null,
                {"fnRender": function (oObj) {
                        return     '<a href="#">' + '  <img title=\'Visualizar TD | TR | AR\' src=\'/img/icons/view.png\' onclick="verDetalhes(' + oObj.aData[0] + ')" >' + '</a>';
                    },
                    "bSearchable": false,
                    "sWidth": "10px",
                    "bSortable": false
                },
                {"fnRender": function (oObj) {
                        return '<a href="/analises/analises/funcionalidades/1/' + id_analise + '/' + oObj.aData[0] + '" >' + '<img title=\'Editar\' src=\'/img/icons/edit.jpg\'>' + '</a> \n\
                                <a onClick="duplicar(\'/analises/analises/duplicarFuncionalidade/' + oObj.aData[0] + '/1' + '\')" href=#><img width=\'16px\' height=\'16px\' title=\'Duplicar função\' src=\'/img/icons/duplicar.jpg\'></a> \n\
                                <a href="#">' + '<img title=\'Excluir\' src=\'/img/icons/delete.png\' onclick=excluirFuncionalidade(' + oObj.aData[0] + ',' + id_analise + ')>' + '</a>';
                    },
                    "bSearchable": false,
                    "sWidth": "20px",
                    "bSortable": false
                }
            ]

        });
        
         $('#dadosEstimada').dataTable({
            "bJQueryUI": true,
            "aaSorting": [[0, 'desc']],
            "bFilter": false,
            "sPaginationType": "full_numbers",
            "sDom": '<"H"Tlfr>t<"F"ip>',
            "bProcessing": false,
            "bServerSide": true,
            "bPaginate": true,
            "aLengthMenu": [[10, 25, 50, 200], [10, 25, 50, 200]],
            "iDisplayLength": 10,
            "sAjaxSource": "/analises/analises/responseDados/" + id_analise,
            "aoColumns": [
                {"bVisible": false},
                {"bSearchable": true,
                "bVisible": true},
                null,
                null,
                {"bSearchable": true,
                     "bVisible": true},
                null,
                null,
                {"fnRender": function (oObj) {
                        return '<a href="/analises/analises/funcionalidades/1/' + id_analise + '/' + oObj.aData[0] + '" >' + '<img title=\'Editar\' src=\'/img/icons/edit.jpg\'>' + '</a> \n\
                                <a onClick="duplicar(\'/analises/analises/duplicarFuncao/' + oObj.aData[0] +'/2' + '\')" href=#><img width=\'16px\' height=\'16px\' title=\'Duplicar função\' src=\'/img/icons/duplicar.jpg\'></a> \n\
                                <a href="#">' + '<img title=\'Excluir\' src=\'/img/icons/delete.png\' onclick=excluirFuncionalidade(' + oObj.aData[0] + ',' + id_analise + ')>' + '</a>';
                    },
                    "bSearchable": false,
                    "sWidth": "20px",
                    "bSortable": false
                }
            ]

        });

        $('#transacao').dataTable({
            "bJQueryUI": true,
            "aaSorting": [[0, 'desc']],
            "bFilter": false,
            "sPaginationType": "full_numbers",
            "sDom": '<"H"Tlfr>t<"F"ip>',
            "bProcessing": false,
            "bServerSide": true,
            "bPaginate": true,
            "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
            "iDisplayLength": 10,
            "sAjaxSource": "/analises/analises/responseTransacao/" + id_analise,
            "aoColumns": [
                {"bVisible": false},
                {"bSearchable": true,
                    "bVisible": true},
                null,
                null,
                {"bSearchable": true,
                    "bVisible": true},
                null,
                null,
                {"fnRender": function (oObj) {
                        return     '<a href="#">' + '  <img title=\'Visualizar TD | TR | AR\' src=\'/img/icons/view.png\' onclick="verDetalhes(' + oObj.aData[0] + ')" >' + '</a>';

                    },
                    "bSearchable": false,
                    "sWidth": "10px",
                    "bSortable": false
                },
                {"fnRender": function (oObj) {
                        return '<a href="/analises/analises/funcionalidades/2/' + id_analise + '/' + oObj.aData[0] + '">' + '<img title=\'Editar\' src=\'/img/icons/edit.jpg\'>' + '</a> \n\
                                <a href="#">' + '  <img title=\'Excluir\' src=\'/img/icons/delete.png\' onclick="excluir(\'/analises/analises/deleteDados/' + oObj.aData[0] + '/' + id_analise + '\')" >' + '</a>';
                    },
                    "bSearchable": false,
                    "sWidth": "20px",
                    "bSortable": false
                }
            ]

        });
        $('#transacaoEstimada').dataTable({
            "bJQueryUI": true,
            "aaSorting": [[0, 'desc']],
            "bFilter": false,
            "sPaginationType": "full_numbers",
            "sDom": '<"H"Tlfr>t<"F"ip>',
            "bProcessing": false,
            "bServerSide": true,
            "bPaginate": true,
            "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
            "iDisplayLength": 10,
            "sAjaxSource": "/analises/analises/responseTransacao/" + id_analise,
            "aoColumns": [
                {"bVisible": false},
                {"bSearchable": true,
                    "bVisible": true},
                null,
                null,
                {"bSearchable": true,
                    "bVisible": true},
                null,
                null,
                
                {"fnRender": function (oObj) {
                        return '<a href="/analises/analises/funcionalidades/2/' + id_analise + '/' + oObj.aData[0] + '">' + '<img title=\'Editar\' src=\'/img/icons/edit.jpg\'>' + '</a> \n\
                                <a href="#">' + '  <img title=\'Excluir\' src=\'/img/icons/delete.png\' onclick="excluir(\'/analises/analises/deleteDados/' + oObj.aData[0] + '/' + id_analise + '\')" >' + '</a>';
                    },
                    "bSearchable": false,
                    "sWidth": "20px",
                    "bSortable": false
                }
            ]

        });
        $(".checkAssociativa").click(function () {
            if ($("#FuncionalidadeNome").val() === "" || $("#FuncionalidadeTipoFuncionalidade").val() === ""
                    || $("#FuncionalidadeImpacto").val() === ""

                    ) {
                bootbox.alert('Existem campos que não foram preenchidos!');

            } else {

                $('#associacao').val('1');

                $('#formFuncao').submit();
            }
        });


        if ($("#metodo_contagem").val() === '2') {
            $('.verDetalhesContagem').hide();
            $('.verTdsContagem').hide();
        }

        if ($("#FuncionalidadeBuscado").val()) {
            $('#nomeFunc').attr('readonly', true);
        } else {
            $('#nomeFunc').attr('readonly', false);
        }



        if ($("#tipoFuncao").val() === '1' && $("#changeBusca").val() !== "") {

            $('#submitForm').attr('onclick', "alterarFuncionalidade(" + $("#changeBusca").val() + ", " + $("#tipoFuncao").val() + ")");
        } else {
            $('#submitForm').attr('onclick', "submeterFomulario(" + $("#tipoFuncao").val() + ")");
        }

        $("#checkItem").click(function () {
            if ($("#checkItem").is(':checked')) {

                $('#checkItens').attr('required', true);
                $('#qtdItens').attr('required', true);
                $('#itens').fadeIn();
            } else {
                $('#itens').fadeOut();
                $('#checkItens').removeAttr('required', true);
                $('#qtdItens').removeAttr('required', true);
            }

        });




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


        $("#assistente").click(function () {
            var tipo = $("#tipo").val();

            $.ajax({
                type: "POST",
                url: '/analises/analises/assistente/' + tipo,
                dataType: 'html'
            }).done(function (e) {

                bootbox.confirm({
                    title: 'Assistente de identificação',
                    message: e,
                    buttons: {
                        'cancel': {
                            label: 'Cancelar',
                            className: 'btn-default pull-left'
                        },
                        'confirm': {
                            label: 'Enviar',
                            className: 'btn-success pull-right'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            $.post('/analises/analises/assistente/' + tipo + '/dados', $('#AnaliseAssistenteForm').serialize()).done(function (e) {
                                bootbox.alert(e);
                            });
                        }
                    }
                });

            });
        });

        $("#autocomplete").autocomplete({
            source: function (req, add) {
                $.getJSON("/analises/analises/autocomplete/<?php echo $analise['Analise']['sistema_id'] ?>/<?php echo $analise['Analise']['id'] . '/' . $tipo ?>/<?php echo $analise['Analise']['metodo_contagem'] ?>?callback=?", req, function (data) {
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
//     
    });

    function excluirFuncionalidade(id, analise) {
        $.ajax({
            type: "POST",
            url: '/analises/analises/rastreabilidade',
            data: {id: id},
            dataType: 'html'
        }).done(function (e) {

            if (e) {
                bootbox.confirm({
                    title: 'Atenção! Existem funcionalidades associadas a esta.',
                    message: e,
                    buttons: {
                        'cancel': {
                            label: 'Cancelar',
                            className: 'btn-default pull-left'
                        },
                        'confirm': {
                            label: 'Deseja Realmente Excluir?',
                            className: 'btn-danger pull-right'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            window.location = '/analises/analises/deleteDados/' + id + '/' + analise;
                        }
                    }
                });
            } else {
                var url = '/analises/analises/deleteDados/' + id + '/' + analise;
                excluir(url);
            }
        });
    }

    function verDetalhes(id) {

        $.ajax({
            type: "POST",
            url: '/analises/analises/gettipos',
            data: {id: id},
            dataType: 'html'

        }).done(function (e) {

            bootbox.alert(e);
        });
    }
    function alterarFuncionalidade(id, tipoFunc) {

        $.ajax({
            type: "POST",
            url: '/analises/analises/rastreabilidade',
            data: {id: id},
            dataType: 'html'

        }).done(function (e) {

            if (e) {
                bootbox.confirm({
                    title: 'Atenção! Existem funcionalidades associadas que podem ser impactadas.',
                    message: e,
                    buttons: {
                        'cancel': {
                            label: 'Cancelar',
                            className: 'btn-default pull-left'
                        },
                        'confirm': {
                            label: 'Deseja Realmente Alterar?',
                            className: 'btn-danger pull-right'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            submeterFomulario(tipoFunc)
                        }
                    }
                });
            } else {
                submeterFomulario(tipoFunc)
            }
        });
    }


    function submeterFomulario(tipoFunc) {

        var nome = $("#nomeFunc").val();
        var tipo = $("#FuncionalidadeTipoFuncionalidade").val();
        var impacto = $("#FuncionalidadeImpacto").val();

        if (nome === '') {
            bootbox.alert("Preencha o campo NOME!");
            return;
        }
        if (tipo === '') {
            bootbox.alert("Preencha o campo TIPO!");
            return;
        }
        if (impacto === '') {
            bootbox.alert("Preencha o campo IMPACTO!");
            return;
        }

        var valida_duplicidade = 0;

        if (tipoFunc === 1) {
            if ($("#metodo_contagem").val() !== '2') {
                var trr = $("#FuncionalidadeTr").val().split("\n");
                var counts = {}, max = 0, res;
                for (var v in trr) {
                    trr[v] = $.trim(trr[v]).toLowerCase();

                    if (trr[v] !== '') {
                        counts[trr[v]] = (counts[trr[v]] || 0) + 1;
                        if (counts[trr[v]] > max) {
                            max = counts[trr[v]];
                            res = trr[v];
                        }
                    }
                }
                if (counts[res] > 1) {
                    bootbox.alert("A TR [ " + res + " ] ocorre " + counts[res] + " vezes. Para continuar é preciso retirar as duplicidades.");
                    return;
                    valida_duplicidade = 1;
                }

            } else {
                valida_duplicidade = 0;
            }
        }
        if (tipoFunc === 2) {
            if ($("#metodo_contagem").val() !== '2') {
                var arr = $("#arSistem").val().split("\n");
                var counts = {}, max = 0, res;
                for (var v in arr) {
                    arr[v] = $.trim(arr[v]).toLowerCase();

                    if (arr[v] !== '') {
                        counts[arr[v]] = (counts[arr[v]] || 0) + 1;
                        if (counts[arr[v]] > max) {
                            max = counts[arr[v]];
                            res = arr[v];
                        }
                    }
                }
                if (counts[res] > 1) {
                    bootbox.alert("A AR [ " + res + " ] ocorre " + counts[res] + " vezes. Para continuar é preciso retirar as duplicidades.");
                    return;
                    valida_duplicidade = 1;
                }





                var tdr = $("#FuncionalidadeTd").val().split("\n");
                var counts = {}, max = 0, res;
                for (var v in tdr) {
                    tdr[v] = $.trim(tdr[v]).toLowerCase();

                    if (tdr[v] !== '') {
                        counts[tdr[v]] = (counts[tdr[v]] || 0) + 1;
                        if (counts[tdr[v]] > max) {
                            max = counts[tdr[v]];
                            res = tdr[v];
                        }
                    }
                }
                if (counts[res] > 1) {
                    bootbox.alert("A TD [" + res + "] ocorre " + counts[res] + " vezes. Para continuar é preciso retirar as duplicidades.");
                    return;
                    valida_duplicidade = 1;
                }
            } else {
                valida_duplicidade = 0;
            }
        }
        if (valida_duplicidade === 0) {
            $('#formFuncao').submit();
        }
    }





</script>
