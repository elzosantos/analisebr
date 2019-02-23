<div class="well">Listagem de fronteiras </div>
<div>
    <p> <a href="/fronteiras/fronteiras/add" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Nova Fronteira</a>
    </p>
    
</div>
<table id="datatable">
    <thead>
        <?php
        echo $this->Html->tableHeaders(array(
            'Id ',
            'Nome',
            'Descrição',
            'Ações'
        ));
        ?>
    </thead>
    <tbody>
        <tr>
            <th colspan="4" class="dataTa bles_empty"></th>
        </tr>
    </tbody>
</table>



<script type="text/javascript">
    jQuery(document).ready(function() {
        $('#datatable').dataTable({
            "bJQueryUI": true,
            "bProcessing": true,
            "aaSorting": [[0, 'desc']],
            "bFilter": false,
            "sPaginationType": "full_numbers",
            "sDom": '<"H"Tlfr>t<"F"ip>',
            "bServerSide": true,
            "bPaginate": true,
            "sAjaxSource": "/fronteiras/fronteiras/response",
            "aoColumns": [
                {"bSearchable": false,
                    "bVisible": false},
                null,
                null,
                {"fnRender": function(oObj) {
                        return '<a href=/fronteiras/fronteiras/add/' + oObj.aData[0] + '>' + '<img title=\'Editar\' src=\'/img/icons/edit.jpg\'>' + '</a> \n\
                                <a onClick="excluir(\'/fronteiras/fronteiras/delete/' + oObj.aData[0] + '\')" href=#><img title=\'Excluir\' src=\'/img/icons/delete.png\'></a>';
                    },
                    "bSearchable": false,
                    "sWidth": "20px",
                    "bSortable": false
                }
            ]
        });
    });
</script>