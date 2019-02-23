<div class="well">Listagem de Sistemas </div>
<div>
    <p> <a href="/sistemas/sistemas/add" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Novo Sistema</a>
    </p>
    
</div>
<table id="datatable">
    <thead>
        <?php
        echo $this->Html->tableHeaders(array(
            'Id',
            'Nome',
            'Sigla',
            'Linguagem',
            'Ações',
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
            "aLengthMenu": [[15, 25, 50, 100], [15, 25, 50, 100]],
            "iDisplayLength": 15,
            "bPaginate": true,
            "sAjaxSource": "/sistemas/sistemas/response",
            "aoColumns": [
                {"bSearchable": false,
                    "bVisible": false},
                null, null, null, 
                {"fnRender": function(oObj) {
                        return '<a href=/sistemas/sistemas/add/' + oObj.aData[0] + '>' + '<img title=\'Editar\' src=\'/img/icons/edit.jpg\'>' + '</a> \n\
                                <a onClick="excluir(\'/sistemas/sistemas/delete/' + oObj.aData[0] + '\')" href=#><img title=\'Excluir\' src=\'/img/icons/delete.png\'></a>';
                    },
                    "bSearchable": false,
                    "sWidth": "20px",
                    "bSortable": false
                }
            ]

        });
    });


</script>