<div class="well">Listagem de linguagens </div>
<div>
    <p> <a href="/linguagens/linguagens/add" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Nova Linguagem</a>
    </p>

</div>

<table id="datatable">
        <thead>
            <?php

//       echo  $this->DataTable->render('Sistema', array(), array('sAjaxSource' => array()));
            echo $this->Html->tableHeaders(array(
                'Id',
                'Nome',
                'Produtividade Desenvolvimento',
                'Produtividade Melhoria',
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
            "bPaginate": true,
            "sAjaxSource": "/linguagens/linguagens/response",
            "aoColumns": [
                {"bSearchable": false,
                    "bVisible": false},
                null, null, null, 
                {"fnRender": function(oObj) {
                        return '<a href=/linguagens/linguagens/add/' + oObj.aData[0] + '>' + '<img title=\'Editar\' src=\'/img/icons/edit.jpg\'>' + '</a> \n\
                                <a onClick="excluir(\'/linguagens/linguagens/delete/' + oObj.aData[0] + '\')" href=#><img title=\'Excluir\' src=\'/img/icons/delete.png\'></a>';

                    },
                    "bSearchable": false,
                    "sWidth": "20px",
                    "bSortable": false
                }
            ]

        });
    });


</script>