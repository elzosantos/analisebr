<div class="well">Listagem das análises (UST)</div>

<?php echo $this->Form->create('Analiust', array('class' => 'form-horizontal')); ?>
<fieldset>
<div class="col-md-12">    
    <div class="col-md-3">
        <label class="control-list">Sistema</label>
        <?php
        echo $this->Form->input('sistemas', array(
            'style' => 'width:150px ',
            'id' => 'sistema',
            'label' => false, 
            'required' => true ));
        ?>
    </div> 
    <div class="col-md-4">
        <label class="control-list">Equipe</label>
        <?php
        echo $this->Form->input('equipes', array(
            'label' => false, 
            'style' => 'width: 200px',
            'id'  => 'IdEquipe',
            'required' => true, ));
        ?>
    </div> 
    <div class="col-md-5">
        <label class="control-list">Responsável</label>
        <?php
        echo $this->Form->input('responsaveis', array(
            'label' => false,
            'id' => 'responsavel',
            'style' => 'width: 300px',
            'required' => true ));
        ?>
    </div> 
   
</div>
    <div class="col-md-12"> <br></div>  
<div class="col-md-12">
    <div class="col-md-3">
        <label class="control-list">Demanda</label>

        <?php
        echo $this->Form->input('demanda', array(
            'label' => false,
            'id' => 'demanda',
            'required' => TRUE 
        ));
        ?>
    </div> 
    
    <div class="col-md-3" style="align-content: center">
        <label class="control-list">Método de Contagem</label>
        <?php
        echo $this->Form->input('contagens', array(
            'style' => 'width:150px ',
            'id' => 'contagem',
            'label' => false, 
            'required' => true ));
        ?>
    </div> 
    
    <div class="col-md-3">
        <label class="control-list"><strong>*</strong>Data início</label>

        <?php
        echo $this->Form->input('data_ini', array(
            'label' => false,
            'class' => 'datepicker',
            'style' => 'width:100px ',
            'placeholder' => '99/99/9999'));
        ?>
    </div> 
    <div class="col-md-3">
        <label class="control-list"><strong>*</strong>Data fim</label>

        <?php
        echo $this->Form->input('data_fim', array(
            'label' => false,
            'class' => 'datepicker',
            'style' => 'width:100px',
            'placeholder' => '99/99/9999'));
        ?>
  </div> 
</div> 
</fieldset>
<?php echo $this->Form->end(); ?>

    <div class="col-md-3">
        <label class="control-list"></label>
        <?php echo $this->Form->end(array('type' => 'button', 'label' => 'Pesquisar', 'id' => 'filter', 'style' => 'padding: 4px;')); ?>
    </div>


</div>


<div class="col-md-12" >

    <hr />

</div>

<table id="datatable">
    <thead>
        <?php
        echo $this->Html->tableHeaders(array(
            'ID#',
            'Status',
            'Sistema',
            'Demanda',
            'Resposável',
            'Equipe',
            'Met. de Contagem',
            'Total UST',
            'Data',
            'Ações'
        ));
        ?>
    </thead>
    
    
</table>

<script type="text/javascript">
    jQuery(document).ready(function () {
        
        $('#IdEquipe').change(function(e){
            var IdEquipe = $('#IdEquipe').val(); 
            if(IdEquipe != '0'){
                $.getJSON('/analiusts/analiusts/carregaResponsavel/'+IdEquipe, function (dados){ 

                   if (Object.keys(dados).length > 0){  

                      var option = '<option value= "0"> - Todos - </option>';
                      $.each(dados, function(i, obj){

                          option += '<option value="'+i+'">'+obj+'</option>';
                      })

                   }else{
                       var option = '<option value= "0"> - Todos - </option>';
                       bootbox.alert("Não há responsáveis cadastrados na equipe.");
                   }
                   $('#responsavel').html(option).show(); 
                })
            }
        })
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
        
        
        $('#datatable').dataTable({
            "bJQueryUI": true,
            "aaSorting": [[0, 'desc']],
            "bFilter": true,
            "sPaginationType": "full_numbers",
            "sDom": '<"H"Tlfr>t<"F"ip>',
            "bProcessing": true,
            "bServerSide": true,
            "bPaginate": true,
            "aLengthMenu": [[15, 25, 50, 100], [15, 25, 50, 100]],
            "iDisplayLength": 15,
            "sAjaxSource": "/analiusts/analiusts/response",
            "aoColumns": [
                {"bSearchable": true,
                    "bVisible": true},
                {"bSortable": false},
                null,
                {"bSearchable": true,
                    "bVisible": true},
                null,
                null,
                null,
                null,
                null,
                {"fnRender": function (oObj) {
                        return '<a href=/analiusts/analiusts/analises/' + oObj.aData[0] + '>' + '<img title=\'Editar\' src=\'/img/icons/edit.jpg\'>' + '</a> \n\
                                <a onClick="excluir(\'/analiusts/analiusts/delete/' + oObj.aData[0] + '\')" href=#><img title=\'Excluir\' src=\'/img/icons/delete.png\'></a> \n\
                                <a href=/analiusts/analiusts/relatorio/' + oObj.aData[0] + '><img title=\'Relatório\' src=\'/img/icons/relatorio.jpg\'></a> \n\
                                <a onClick="duplicar(\'/analiusts/analiusts/duplicar/' + oObj.aData[0] + '\')" href=#><img width=\'16px\' height=\'16px\' title=\'Duplicar análise\' src=\'/img/icons/duplicar.jpg\'></a> \n\
                                <a href=/analiusts/analiusts/history/' + oObj.aData[0] + '>' + '<img title=\'Histórico\' src=\'/img/icons/edit.png\'>' + '</a>  ';
                    },
                    "bSearchable": false,
                    "sWidth": "10px",
                    "bSortable": false
                }
            ]

        });

        $("#datatable_filter").attr('style', 'display: none');

        var oTable = $('#datatable').dataTable();
//
        $("#demanda").unbind();

        $('#filter').click(function (e) {
        
            var endDate = $('#AnaliustDataFim').val();
            var startDate = $('#AnaliustDataIni').val();
            var demanda = $("#demanda").val();
            var equipe = $("#IdEquipe").val();
            var sistema = $("#sistema").val();
            var contagem = $("#contagem").val();
            var responsavel = $("#responsavel").val(); 
            
            if (sistema !== "") {
                oTable.fnFilter(sistema, 2, true, false);
            }else{
                oTable.fnFilter(null, 2, true, false);
            }
            if (demanda !== "") {
                oTable.fnFilter(demanda, 3, true, false);
            }else{
                oTable.fnFilter(null, 3, true, false);
            }
            
            if (responsavel !== "") {
                oTable.fnFilter(responsavel, 4, true, false);
            }else{
                oTable.fnFilter(null, 4, true, false);
            }
            if (equipe !== "") {
                oTable.fnFilter(equipe, 5, true, false);
            }else{
                oTable.fnFilter(null, 5, true, false);
            }
            
            if (contagem !== "") {
                oTable.fnFilter(contagem, 6, true, false);
            }else{
                oTable.fnFilter(null, 6, true, false);
            }
            if (startDate !== "" && endDate !== "") {
                
                var datafim = endDate.split("/");
                var start = startDate.split("/");

                datafim = datafim[2] + '-' + datafim[1] + '-' + datafim[0] + ' ' + '23:59:59';
                start = start[2] + '-' + start[1] + '-' + start[0] + ' ' + '00:00:00';
                var concatdt = start + 'a' + datafim;

                oTable.fnFilter(concatdt, 8, true, false);

        } else if (startDate == "" && endDate !== "") {
                bootbox.alert('Informe o período inicial para a pesquisa.');
                return;
            } else if (endDate == "" && startDate !== "") {
                bootbox.alert('Informe o período final para a pesquisa.');
                return;
            }else{
                 oTable.fnFilter(null, 8, true, false);
            }
            
            //  oTable.dataTable().fnDraw();

        });


    });

</script>