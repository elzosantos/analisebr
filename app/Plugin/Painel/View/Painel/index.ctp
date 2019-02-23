<div class="well">Últimas análises (PF) cadastradas </div>

<?php echo $this->Form->create('Analise', array('class' => 'form-horizontal')); ?>

<div class="col-md-12"> 

    <div class="col-md-3">
        <label class="control-list">Demanda</label>

        <?php
        echo $this->Form->input('demanda', array(
            'label' => false,
            'id' => 'demanda',
            'required' => TRUE,
            'placeholder' => '9999999999999'
        ));
        ?>
    </div> 
    <div class="col-md-3">
        <label class="control-list"><strong>*</strong>Período inicial</label>

        <?php
        echo $this->Form->input('data_ini', array(
            'label' => false,
            'class' => 'datepicker',
            'placeholder' => '99/99/9999'));
        ?>
    </div> 
    <div class="col-md-3">
        <label class="control-list"><strong>*</strong>Período final</label>

        <?php
        echo $this->Form->input('data_fim', array(
            'label' => false,
            'class' => 'datepicker',
            'placeholder' => '99/99/9999'));
        ?>
    </div> 

    <div class="col-md-3">
        <label class="control-list">Equipe</label>
        <?php
        echo $this->Form->input('equipes', array(
            'label' => false,
            'class' => 'control-label',
            'required' => true,
            'class=' => "form-control input-md"));
        ?>
    </div> 

    <div class="col-md-3">
        <label class="control-list"></label>
        <?php echo $this->Form->end(array('type' => 'button', 'label' => 'Pesquisar', 'id' => 'filter', 'style' => 'padding: 4px;')); ?>
    </div>


</div>


<div class="col-md-12" >

    <hr />

</div>
<div>
    <!-- a href="javascript:void(0)" id="filter">Pesquisar</a -->


    <table id="datatable" class="responsive nowrap">
        <thead>
            <?php
            echo $this->Html->tableHeaders(array(
                'ID#',
                'Status',
                'Sistema',
                'Demanda',
                'Resposável',
                'Equipe',
                'Tp de Contagem',
                'Met. de Contagem',
                'Total PF',
                'Total PF Ajust + INM',
                'Data',
                'Ações'
            ));
            ?>
        </thead>

        <tbody>
            <tr>
                <th colspan="4" class="dataTables_empty"></th>
            </tr>
        </tbody>
    </table>
</div>




<script type="text/javascript">
    jQuery(document).ready(function () {
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
            "aLengthMenu": [[10, 15, 30, 50], [10, 15, 30, 50]],
            "iDisplayLength": 15,
            "sAjaxSource": "/analises/analises/response",
            "aoColumns": [
                {"bSearchable": false,
                    "bVisible": true},
                {"bSortable": false,
                    "bSearchable": false
                },
                {"bSearchable": false},
                null,
                {"bSearchable": false},
                null,
                {"bSearchable": false},
                {"bSearchable": false},
                {"bSearchable": false},
                {"bSearchable": false},
                null,
                {"fnRender": function (oObj) {
                        return '<a href=/analises/analises/analises/' + oObj.aData[0] + '>' + '<img title=\'Editar\' src=\'/img/icons/edit.jpg\'>' + '</a> \n\
                                <a onClick="excluir(\'/analises/analises/delete/' + oObj.aData[0] + '\')" href=#><img title=\'Excluir\' src=\'/img/icons/delete.png\'></a> \n\
                                <a href=/analises/analises/relatorio/' + oObj.aData[0] + '><img title=\'Relatório\' src=\'/img/icons/relatorio.jpg\'></a> \n\
                                <a href=/analises/analises/history/' + oObj.aData[0] + '>' + '<img title=\'Histórico\' src=\'/img/icons/edit.png\'>' + '</a>  ';
                    },
                    "bSearchable": false,
                    "sWidth": "20px",
                    "bSortable": false
                }
            ]
        });

  $("#datatable_filter").attr('style', 'display: none');
        var oTable = $('#datatable').dataTable();
//
        $("#demanda").unbind();

        $('#filter').click(function (e) {
            var endDate = $('#AnaliseDataFim').val();
            var startDate = $('#AnaliseDataIni').val();
            var demanda = $("#demanda").val();
            var equipe = $("#AnaliseEquipes").val();

            if (demanda !== "") {
                oTable.fnFilter(demanda, 3, true, false);
            }else{
                oTable.fnFilter(null, 3, true, false);
            }
            if (equipe !== "") {
                oTable.fnFilter(equipe, 5, true, false);
            }else{
                oTable.fnFilter(null, 5, true, false);
            }
            
            if (startDate !== "" && endDate !== "") {
                var datafim = endDate.split("/");
                var start = startDate.split("/");

                datafim = datafim[2] + '-' + datafim[1] + '-' + datafim[0] + ' ' + '23:59:59';
                start = start[2] + '-' + start[1] + '-' + start[0] + ' ' + '00:00:00';
                var concatdt = start + 'a' + datafim;

                oTable.fnFilter(concatdt, 10, true, false);
            } else if (startDate == "" && endDate !== "") {
                bootbox.alert('Informe o período inicial para a pesquisa.');
                return;
            } else if (endDate == "" && startDate !== "") {
                bootbox.alert('Informe o período final para a pesquisa.');
                return;
            }else{
                 oTable.fnFilter(null, 10, true, false);
            }
            //  oTable.dataTable().fnDraw();

        });



    });


</script>