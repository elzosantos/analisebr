<div class="well">Listagem de Baselines (Análises UST) </div>
    <table id="datatable">
        <thead>
            <?php
            echo $this->Html->tableHeaders(array(
                'Id',
                'Nome Sistema',
                'Sigla Sistema',
                'Última Atualização',
                'Qtde. PF',
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


<script type="text/javascript">
    jQuery(document).ready(function() {
        $('#datatable').dataTable({
            "bJQueryUI": true,
            "aaSorting": [[0, 'desc']],
            "bFilter": false,
            "sPaginationType": "full_numbers",
            "sDom": '<"H"Tlfr>t<"F"ip>',
            "bProcessing": true,
            "bServerSide": true,
            "bPaginate": true,
            "sAjaxSource": "/sistemas/sistemas/baseresponseusts",
            "aoColumns": [
                {"bSearchable": false,
                    "bVisible": false},
                null,  
                null, 
                {"bSortable": false}, 
                {"bSortable": false}, 
                 {"fnRender": function(oObj) {
                        return '<a href=/sistemas/sistemas/baseviewusts/' + oObj.aData[0] + '>' + '<img title=\'View\' src=\'/img/icons/view.png\'>' + '</a>';
                    },
                    "bSearchable": false,
                    "sWidth": "20px",
                    "bSortable": false
                }
            ]

        });
    });


</script>