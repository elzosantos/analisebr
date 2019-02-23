
<form>
    <input type="hidden" value="<?php echo!empty($error) ? $error : ''; ?>" id="error">
</form>


<div class="well">Listagem dos usuários </div>
<div>
    <p> <a href="/users/users/add" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Novo Usuário</a>
    </p>
    
</div>
<div>
    <table id="datatable">
        <thead>
            <?php
            echo $this->Html->tableHeaders(array(
                'Id',
                'Nome',
                'Usuário',
                'Categoria',
                'E-mail',
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
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-    labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Atenção!</h3>
    </div>


    <div class="modal-body">
        <p>Deseja realmente excluir?</p>
    </div>

    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <button class="btn btn-primary" id='confirmado' value="">Excluir</button>
    </div>
</div>
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
            "sAjaxSource": "/users/users/response",
            "aoColumns": [
                {"bSearchable": false,
                    "bVisible": false},
                null,
                null,
                null,
                null,
                {"fnRender": function(oObj) {
                         return '<a href=/users/users/add/' + oObj.aData[0] + '>' + '<img title=\'Editar\' src=\'/img/icons/edit.jpg\'>' + '</a> \n\
                                                        <a onClick="excluir(\'/users/users/delete/' + oObj.aData[0] + '\')" href=#><img title=\'Excluir\' src=\'/img/icons/delete.png\'></a> \n\
                                                        <a onClick="enviar(\'/users/users/index/2015/' + oObj.aData[0] + '\')" href=#><img title=\'Reenviar link de senha por e-mail\' src=\'/img/icons/email.png\'></a> ';
                    },
                    "bSearchable": false,
                    "sWidth": "20px",
                    "bSortable": false

                }
            ]
        });

        if ($('#error').val()) {
            bootbox.dialog({
                message: $('#error').val(),
                title: "Atenção!",
                buttons: {
                    success: {
                        label: "OK",
                        className: "btn-info",
                    }
                    
                }
            });
        }
    });



</script>