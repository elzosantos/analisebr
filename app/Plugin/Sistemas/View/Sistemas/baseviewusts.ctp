
<div class="well" style="text-align: center; padding: 1px 1px 1px">Relatório do Baseline</div>
<br>
<div class="col-md-12" style="font-size: 15px">
    <strong><?php echo $sigla; ?> - <?php echo $sistema; ?> </strong> <br><br>
</div>
<?php


echo $this->element('resumo_ust');
?>



<?php if (!empty($usts)) { ?>
    <div class="col-md-12"> 
        <legend>Listagem de itens (UST) existentes no baseline</legend>
        <table class="table table-hover table-striped table-bordered table-condensed">
            <tr>
                <th>Nome</th>
                <th>Peso</th>
                <th>Quantidade</th>
                <th>Justificativa</th>
            </tr>
            <!-- Here is where we loop through our $posts array, printing out post info -->

            <?php foreach ($usts as $dado): ?>
                <tr>
                    <td ><?php echo $nomeItens[$dado['Rlustsanalise']['ust_id']]; ?></td>
                    <td><?php echo $pesoItens[$dado['Rlustsanalise']['ust_id']]; ?></td>
                    <td><?php echo $dado['Rlustsanalise']['qtde'] ?></td>
                    <td><?php echo $dado['Rlustsanalise']['justificativa']; ?></td>
                </tr>
            <?php endforeach; ?>
            <?php unset($dados); ?>
        </table>
    </div>
<?php } ?>


<div style="text-align: center" class="hidden-print col-md-12">

    <?php if ($imprimir == '1') { ?>
        <input type="button" class="btn btn-danger" value="Imprimir" onclick="self.print();">
    <?php } else { ?>
        <a href="/sistemas/sistemas/baselineusts" class="btn btn-info">VOLTAR</a>
        <input type="button" class="btn btn-danger" value="Gerar Impressão" onclick="imprimir();">
    <?php } ?>
</div>




<script type="text/javascript">
    $(document).ready(function () {



        $(document).ajaxStart(function () {
            $(".carregando").fadeIn();
            $('input[type="button"], input[type="submit"]').attr('disabled', 'disabled');
        });
        $(document).ajaxStop(function () {
            $(".carregando").fadeOut();
            $('input[type="button"], input[type="submit"]').removeAttr('disabled');
        });

        $(".check").click(function () {
            var aux = $(this).attr('valor');
            var cont = aux.split('-');
            window.location.href = '/analises/analises/relatorio/' + cont[1];
        });
    });

function imprimir() {
        var url = '/sistemas/sistemas/baseviewusts/' + $('#sistema_id').val() + '/1';
        window.open(url, '_blank', "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=800, height=800");

    }
</script>