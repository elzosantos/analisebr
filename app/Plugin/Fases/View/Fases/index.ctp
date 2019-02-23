<div class="well">Listagem de fases </div>
<div>
    <p> <a href="/fases/fases/add" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Nova Fase</a>
    </p>

</div>

<table id="datatable">
        <thead>
            <?php
            echo $this->Html->tableHeaders(array(
                'Id ',
                'Fase',
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
            "sAjaxSource": "/fases/fases/response",
            "aoColumns": [
                {"bSearchable": false,
                    "bVisible": false},
                null,
                {"fnRender": function(oObj) {
                        return '<a href=/fases/fases/add/' + oObj.aData[0] + '>' + '<img title=\'Editar\' src=\'/img/icons/edit.jpg\'>' + '</a> \n\
                                <a onClick="excluir(\'/fases/fases/delete/' + oObj.aData[0] + '\')" href=#><img title=\'Excluir\' src=\'/img/icons/delete.png\'></a>';
                    },
                    "bSearchable": false,
                    "sWidth": "20px",
                    "bSortable": false
                }
            ]
        });
    });
</script>