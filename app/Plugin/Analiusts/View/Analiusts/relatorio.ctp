
<div id='exportar'>

    <div class="well" style="text-align: center; padding: 1px 1px 1px">
        Relatório da Análise
    </div>

    <?php

    echo $this->element('resumo_rel', array(
        "analise" => $analise
    ));
    ?>
   <input type="hidden" value="<?php echo $analise['Analiust']['id']; ?>"  id='idAnalise'>
    <div class="col-md-12"> 
        <hr>
        <legend style="font-size: 15px">USTs dessa análise</legend>
        <table  class="table table-hover table-striped table-bordered table-condensed">
            <tr>
                <th style="font-size: 11px; padding: 1px 1px 1px">Nome</th>
                <th style="font-size: 11px; padding: 1px 1px 1px">Peso</th>
                <th style="font-size: 11px; padding: 1px 1px 1px">Quantidade</th>
                <th style="font-size: 11px; padding: 1px 1px 1px">Justificativa</th>
            </tr>
            <!-- Here is where we loop through our $posts array, printing out post info -->

            <?php foreach ($ustanalise as $dado): ?>
                <tr>
                    <td style="font-size: 11px; padding: 1px 1px 1px"><?php echo $nomeUsts[$dado['Rlustsanalise']['ust_id']]; ?></td>
                    <td style="font-size: 11px; padding: 1px 1px 1px"><?php echo $pesoUsts[$dado['Rlustsanalise']['ust_id']]; ?></td>
                    <td style="font-size: 11px; padding: 1px 1px 1px"><?php echo $dado['Rlustsanalise']['qtde'] ?></td>
                    <td style="font-size: 11px; padding: 1px 1px 1px"><?php echo $dado['Rlustsanalise']['justificativa']; ?></td>
                </tr>
            <?php endforeach; ?>
            <?php unset($dado); ?>
        </table>
    </div>


</div>



<div style="text-align: center" class="hidden-print col-md-12">

    <?php if ($imprimir == '1') { ?>
        <input type="button" class="btn btn-danger" value="Imprimir" onclick="self.print();">
    <?php } else if ($imprimir == '2') { ?>

        <a download="<?php echo 'rel_analise_' . $analise['Analiust']['id'] . '.xls'; ?>" href="#" onclick="return ExcellentExport.excel(this, 'exportar', 'Relatório Análise');">

            <input type="button" class="btn btn-default" value="Donwload XLS" ></a>
    <?php } else { ?>
        <a href="/painel" class="btn btn-info">VOLTAR</a>
        <input type="button" id="analise" class="btn btn-success" value="Editar Análise">
        <input type="button" class="btn btn-danger" value="Gerar Impressão" onclick="imprimir();">
        <input type="button" class="btn btn-default" value="Exportar XLS" onclick="exportar();">

    <?php } ?>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $("#analise").click(function () {
            window.location.href = '/analiusts/analiusts/analises/' + $('#idAnalise').val();
        });
        $(document).ajaxStart(function () {
            $(".carregando").fadeIn();
            $('input[type="button"], input[type="submit"]').attr('disabled', 'disabled');
        });
        $(document).ajaxStop(function () {
            $(".carregando").fadeOut();
            $('input[type="button"], input[type="submit"]').removeAttr('disabled');
        });
        


    });
    function imprimir() {
        var url = '/analiusts/analiusts/relatorio/' + $('#idAnalise').val() + '/1';
        window.open(url, '_blank', "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=800, height=800");

    }
    function exportar() {
        var url = '/analiusts/analiusts/relatorio/' + $('#idAnalise').val() + '/2';
        window.open(url, '_blank', "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=800, height=800");

    }
</script>