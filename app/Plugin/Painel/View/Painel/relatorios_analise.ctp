<?php
echo $this->Html->script('Chart');
echo $this->Html->script('legend');
$color[0] = "#8B795E";
$color[1] = "#F38630";
$color[2] = "#FFD700";
$color[3] = "#6495ED";
$color[4] = "#5F9EA0";
$color[5] = "#00FF00";
$color[6] = "#FFFF00";
$color[7] = "#8B4513";
$color[8] = "#FA8072";
$color[9] = "#A020F0";
$color[10] = "#008B8B";
$color[11] = "#E0FFFF";
$color[12] = "#C1FFC1";
$color[13] = "#CDCDB4";
$color[14] = "#EE6363";
$color[15] = "#EE0000";
$color[16] = "#FF34B3";
$color[17] = "#EEA2AD";
$color[18] = "#7A378B";
$color[19] = "#AB82FF";
$color[20] = "#FFE1FF";
$color[21] = "#1C1C1C";
$color[22] = "#696969";
$color[23] = "#008B8B";
$color[24] = "#FF00FF";
$color[25] = "#EE3A8C";
$color[26] = "#FFBBFF";
$color[27] = "#FF4500";
$color[28] = "#CD5B45";
$color[29] = "#EE2C2C";
$color[30] = "#8B795E";
$color[31] = "#F38630";
$color[32] = "#FFD700";
$color[33] = "#6495ED";
$color[34] = "#5F9EA0";
$color[35] = "#00FF00";
$color[36] = "#FFFF00";
$color[37] = "#8B4513";
$color[38] = "#FA8072";
$color[39] = "#A020F0";
$color[40] = "#008B8B";
$color[41] = "#E0FFFF";
$color[42] = "#C1FFC1";
$color[43] = "#CDCDB4";
$color[44] = "#EE6363";
$color[45] = "#EE0000";
$color[46] = "#FF34B3";
$color[47] = "#EEA2AD";
$color[48] = "#7A378B";
$color[49] = "#AB82FF";
$color[50] = "#FFE1FF";
$color[51] = "#1C1C1C";
$color[52] = "#696969";
$color[53] = "#008B8B";
$color[54] = "#FF00FF";
$color[55] = "#EE3A8C";
$color[56] = "#FFBBFF";
$color[57] = "#FF4500";
$color[58] = "#CD5B45";
$color[59] = "#EE2C2C";
$color[60] = "#8B795E";
$color[61] = "#F38630";
$color[62] = "#FFD700";
$color[63] = "#6495ED";
$color[64] = "#5F9EA0";
$color[65] = "#00FF00";
$color[66] = "#FFFF00";
$color[67] = "#8B4513";
$color[68] = "#FA8072";
$color[69] = "#A020F0";
$color[70] = "#008B8B";
$color[71] = "#E0FFFF";
$color[72] = "#C1FFC1";
$color[73] = "#CDCDB4";
$color[74] = "#EE6363";
$color[75] = "#EE0000";
$color[76] = "#FF34B3";
$color[77] = "#EEA2AD";
$color[78] = "#7A378B";
$color[79] = "#AB82FF";
$color[80] = "#FFE1FF";
$color[81] = "#1C1C1C";
$color[82] = "#696969";
$color[83] = "#008B8B";
$color[84] = "#FF00FF";
$color[85] = "#EE3A8C";
$color[86] = "#FFBBFF";
$color[87] = "#FF4500";
$color[88] = "#CD5B45";
$color[89] = "#EE2C2C";
$color[90] = "#8B795E";
$color[91] = "#F38630";
$color[92] = "#FFD700";
$color[93] = "#6495ED";
$color[94] = "#5F9EA0";
$color[95] = "#00FF00";
$color[96] = "#FFFF00";
$color[97] = "#8B4513";
$color[98] = "#FA8072";
$color[99] = "#A020F0";
$color[100] = "#008B8B";
$color[101] = "#E0FFFF";
$color[102] = "#C1FFC1";
$color[103] = "#CDCDB4";
$color[104] = "#EE6363";
$color[105] = "#EE0000";
$color[106] = "#FF34B3";
$color[107] = "#EEA2AD";
$color[108] = "#7A378B";
$color[109] = "#AB82FF";
$color[110] = "#FFE1FF";
$color[111] = "#1C1C1C";
$color[112] = "#696969";
$color[113] = "#008B8B";
$color[114] = "#FF00FF";
$color[115] = "#EE3A8C";
$color[116] = "#FFBBFF";
$color[117] = "#FF4500";
$color[118] = "#CD5B45";
$color[119] = "#EE2C2C";
?>   
<div class="col-md-12 hidden-print"> 
    <?php echo $this->Form->create('', array('class' => 'form-horizontal', 'id' => 'formPesq')); ?>
    <fieldset>
        <legend>Relatório de sistema detalhado</legend>
        <?php echo $this->Form->input('st_registro', array('type' => 'hidden', 'value' => 'S')); ?>
        <?php echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id'))); ?>



        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Sistema</label> 
            <div class="col-md-4">
                <?php
                echo $this->Form->input('sistema_id', array(
                    'label' => false,
                    'required' => TRUE,
                    'empty' => '-- Selecione --',
                    'class=' => "form-control input-md"));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Equipe</label>
            <div class="col-md-4">
                <?php
                echo $this->Form->input('equipe_id', array(
                    'label' => false,
                    'empty' => '-- Selecione --',
                    'class=' => "form-control input-md"));
                ?>

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Data inicial</label>
            <div class="col-md-4">
                <?php
                echo $this->Form->input('data_ini', array(
                    'label' => false,
                    'class' => 'data_ini',
                    'id' => 'data_ini'
                ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Data final</label>
            <div class="col-md-4">
                <?php
                echo $this->Form->input('data_fim', array(
                    'label' => false,
                    'class' => 'data_fim',
                    'id' => 'data_fim'
                    ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Tipo de Contagem</label>
            <div class="col-md-4">
                <?php
                echo $this->Form->input('tipo_contagem', array(
                    'label' => false,
                    'options' => array(
                        '1' => 'Projeto de Desenvolvimento',
                        '2' => 'Projeto de Melhoria',
                        '3' => 'Contagem de Aplicação')
                    ,
                    'empty' => '-- Selecione --'
                ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Método de Contagem</label>
            <div class="col-md-4">
                <?php
                echo $this->Form->input('metodo_contagem', array(
                    'label' => false,
                    'options' => array(
                        '1' => 'Detalhada (IFPUG)',
                    )
                    ,
                    'empty' => '-- Selecione --'
                ));
                ?>
            </div>
        </div>
    </fieldset>
    <?php echo $this->Form->end('Gerar Relatório', array('id' => 'subPesq')); ?>

</div>
<div class="col-md-4" id="novaPesq" style="display: none">
    <input   type="button" class="btn-default" >
</div>


<?php if (!empty($result)) { ?>


    <div class="col-md-12">
        <br><br>
            
        <legend>Relatório de busca (Relatório de sistema detalhado)</legend>
        <table class="table table-bordered">
            <tr>
                <td colspan="2">
                    <strong>Sistema: </strong> <?php echo!empty($result[0]['nome']) ? $result[0]['nome'] : ''; ?>
                </td>
                <td colspan="2">
                    <strong>Equipe:</strong>  <?php echo!empty($info['equipe']) ? $info['equipe'] : 'Todas'; ?>
                </td>

            </tr>
            <tr>
                <td>
                    <strong>Data inicial: </strong> <?php echo!empty($info['data_ini']) ? $info['data_ini'] : ''; ?>
                </td>
                <td>
                    <strong>Data final: </strong> <?php echo!empty($info['data_fim']) ? $info['data_fim'] : ''; ?>
                </td>

                <td >
                    <strong>Método Contagem:</strong>  <?php echo!empty($info['metodo_contagem']) ? $info['metodo_contagem'] : 'Todos'; ?>
                </td>
                <td>
                    <strong>Tipo Contagem:</strong>  <?php echo!empty($info['tipo_contagem']) ? $info['tipo_contagem'] : 'Todos'; ?>
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Quantidade Análises: </strong> <?php echo!empty($info['qtd_analise']) ? $info['qtd_analise'] : ''; ?>
                </td>
                <td>
                    <strong>PF total: </strong> <?php echo!empty($info['pf_total']) ? $info['pf_total'] : ''; ?>
                </td>
                <td>
                    <strong>PF total ajustado : </strong>  <?php echo!empty($info['pf_total_ajustado']) ? $info['pf_total_ajustado'] : ''; ?>
                </td>
                <td>
                    <strong>PF (deflator) + INM : </strong>  <?php echo number_format(( $info['valor_fator'] ), 2)   ; ?>
                </td>
            </tr>

        </table>
        <legend>Gráfico do Sistema - Análises, Ponto Função , Ponto Função Ajustado</legend>
        <div class="col-md-12" style="text-align: center">
            <canvas id="canvas" height="450" width="600" style="width: 600px; height: 450px;"></canvas>

        </div>
        <div class="col-md-12" style="text-align: center">
            <div id="pieLegend"></div>
        </div>
        <hr>

    </div>
<?php } ?>

<input id="dados" value='<?php echo!empty($result) ? json_encode($result) : null;
?>' type="hidden">
<input id="cores" value='<?php echo json_encode($color); ?>' type="hidden">
<div style="text-align: center" class="hidden-print col-md-12">
    <input type="button" class="btn btn-danger" value="Imprimir" onclick="self.print();">
</div>
<!--div class="col-md-12 hidden-print"> 
    <hr>
    <div class="well" style="background: #E0E2FF; opacity: 70%"><strong>Importante!</strong> Somente análises do baseline formam o relatório.</div>
</div-->
<script type="text/javascript">
    $(document).ready(function () {
        $("#subPesq").click(function () {
            $("#formPesq").hide();
            $("#novaPesq").show();
        });
        $("#novaPesq").click(function () {
            $("#formPesq").show();
            $("#novaPesq").hide();
        });
         $(".data_ini").mask("99/99/9999");
        $(".data_ini").datepicker({
            dateFormat: 'dd/mm/yy',
            dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
            dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
            dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            nextText: 'Próximo',
            prevText: 'Anterior'
        });
        $(".data_fim").mask("99/99/9999");
        $(".data_fim").datepicker({
            dateFormat: 'dd/mm/yy',
            dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
            dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
            dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            nextText: 'Próximo',
            prevText: 'Anterior'
        });
        if ($('#dados').val() != null) {
            pieChart();
        }
    });
    function pieChart() {
        var json1 = jQuery.parseJSON($('#dados').val());
        var arrDataPfajus = new Array();
        var barChartData = {
            labels: ["Análises", "Ponto Função", "Ponto Função (deflator) + INM", "Ponto de Função Ajustado"],
            datasets: [
                {
                    fillColor: "#5F9EA0",
                    strokeColor: "#FA8072",
                    data: [json1[0].qtd, json1[0].pf_total, json1[0].pf_ajustado_total, json1[0].pf_valor_fator_total]
                }
            ]
        };

        var data1 =
                {
                    title: "Análises",
                    color: "#FA8072",
                    qtd: json1[0].qtd
                };
        arrDataPfajus.push(data1);

        var data2 =
                {
                    title: "Ponto Função",
                    color: "#FA8072",
                    qtd: json1[0].pf_total
                };
        arrDataPfajus.push(data2);

        var data3 =
                {
                    title: "Ponto Função (deflator) + INM",
                    color: "#FA8072",
                    qtd: json1[0].pf_valor_fator_total
                };
        arrDataPfajus.push(data3);
        var data4 =
                {
                    title: "Ponto Função Ajustado",
                    color: "#FA8072",
                    qtd: json1[0].pf_ajustado_total
                };
        arrDataPfajus.push(data4);
        var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Bar(barChartData);
        legend(document.getElementById("pieLegend"), arrDataPfajus);
    }

</script>