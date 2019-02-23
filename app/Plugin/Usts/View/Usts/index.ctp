<div class="well">Listagem de usts</div>
<div>
    <p> <a href="/usts/usts/add" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Nova UST</a>
    </p>

</div>

<table id="datatable">
    <thead>
        <?php
        echo $this->Html->tableHeaders(array(
            '#',
            'Id',
            'Nome',
            'Descrição',
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

       
        var t = $('#datatable').dataTable({
            
            "bJQueryUI": true,
            "aaSorting": [[0, 'desc']],
            "bFilter": false,
            "sPaginationType": "full_numbers",
            "sDom": '<"H"Tlfr>t<"F"ip>',
            "bProcessing": true,
            "bServerSide": true,
            "bPaginate": true,
            "sAjaxSource": "/usts/usts/response",
            "aoColumns": [
                 {sWidth: "10%"},
                    {"bSearchable": false,
                            "bVisible": false},
                        
                 
                {sWidth: "40%"},
                {sWidth: "40%"},
                {sWidth: "5%"},
                {"fnRender": function(oObj) {
                        return '<a href=/usts/usts/add/' + oObj.aData[1] + '>' + '<img title=\'Editar\' src=\'/img/icons/edit.jpg\'>' + '</a> \n\
                                <a onClick="excluir(\'/usts/usts/delete/' + oObj.aData[1] + '\')" href=#><img title=\'Excluir\' src=\'/img/icons/delete.png\'></a>';
                    },
                    "bSearchable": false,
                    "sWidth": "5%",
                    "bSortable": false

                }
            ]
        });
        
           
    });
</script>
