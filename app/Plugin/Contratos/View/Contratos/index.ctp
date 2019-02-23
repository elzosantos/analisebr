<div class="well">Listagem de Contratos </div>
<div>
    <p> <a href="/contratos/contratos/add" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Novo Contrato</a>
    </p>
    
</div>
<div class="col-md-12"> 

                <div class="well" style="background: #E0E2FF; opacity: 70%"><strong>Importante!</strong> Todas as análises anteriores à 01/01/2019 estão vinculadas ao <b>Contrato Geral do BRB</b>.</div>
            </div>
<table id="datatable">
    <thead>
        <?php
        echo $this->Html->tableHeaders(array(
            'Id',
            'Identificador Contrato',
            'Empresa',
            'Data Início',
            'Data Fim',
            'Valor PF',
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
            "aLengthMenu": [[15, 25, 50, 100], [15, 25, 50, 100]],
            "iDisplayLength": 15,
            "bPaginate": true,
            "sAjaxSource": "/contratos/contratos/response",
            "aoColumns": [
                {"bSearchable": false,
                    "bVisible": false},
                null, null, null, null, null, 
                {"fnRender": function(oObj) {
                        return '<a href=/contratos/contratos/add/' + oObj.aData[0] + '>' + '<img title=\'Editar\' src=\'/img/icons/edit.jpg\'>' + '</a> \n\
                                <a onClick="excluir(\'/contratos/contratos/delete/' + oObj.aData[0] + '\')" href=#><img title=\'Excluir\' src=\'/img/icons/delete.png\'></a>';
                    },
                    "bSearchable": false,
                    "sWidth": "20px",
                    "bSortable": false
                }
            ]

        });
    });


</script>