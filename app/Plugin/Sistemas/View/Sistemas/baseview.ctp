
<div class="well" style="text-align: center; padding: 1px 1px 1px">Relatório do Baseline</div>
<br>
<div class="col-md-12" style="font-size: 15px">
    <strong><?php echo $sigla; ?> - <?php echo $sistema; ?> </strong> <br><br>
</div>
<?php


echo $this->element('resumo_base');
?>

<div class="col-md-12">
    <legend style="font-size: 15px">Funcionalidades</legend>

    <table class="table table-condensed">


        <?php
        if ($funcionalidades) {
            $aux = 0;
            ?>

            <?php
            $count = 1;
            foreach ($funcionalidades as $dado): $aux ++;
                ?>
                <tr>
                    <th style="background: #A8BDCF; width: 3%; font-size: 11px; padding: 1px 1px 1px; border-color: black; border-width: 2px"></th>
                    <th style="background: #A8BDCF; width: 55%; font-size: 11px; padding: 1px 1px 1px; border-color: black; border-width: 2px">Processo Elementar</th>
                    <th style="background: #A8BDCF; font-size: 11px; width: 4%;  padding: 1px 1px 1px; border-color: black; border-width: 2px">Tipo</th>
                    <th style="background: #A8BDCF; font-size: 11px; width: 4%;  padding: 1px 1px 1px; border-color: black; border-width: 2px">(I/E/A)</th>
                    <th style="background: #A8BDCF; font-size: 11px; width: 4%;  padding: 1px 1px 1px; border-color: black; border-width: 2px">TR/AR</th>
                    <th style="background: #A8BDCF; font-size: 11px; width: 4%;  padding: 1px 1px 1px; border-color: black; border-width: 2px">TD</th>
                    <th style="background: #A8BDCF; font-size: 11px; width: 4%;  padding: 1px 1px 1px; border-color: black; border-width: 2px">Complex.</th>
                    <th style="background: #A8BDCF; width: 4%; font-size: 11px; padding: 1px 1px 1px; border-color: black; border-width: 2px">PF</th>
                    <th style="background: #A8BDCF ; width: 8%; font-size: 11px; padding: 1px 1px 1px; border-color: black; border-width: 2px">PF deflat.</th>
                    <th class="hidden-print" style="background: #A8BDCF ; width: 5%; text-align: center; font-size: 11px; padding: 1px 1px 1px; border-color: black; border-width: 2px">Relatório</th>

                </tr>
                <?php
                $tamanho = count($funcionalidades);
                if ($dado['Funcionalidade']['impacto'] == '1') {
                    $valor_deflator = $valor_base['Contrato']['inclusao'] / 100;
                } else if ($dado['Funcionalidade']['impacto'] == '2') {
                    $valor_deflator = $valor_base['Contrato']['alteracao'] / 100;
                }if ($dado['Funcionalidade']['impacto'] == '3') {
                    $valor_deflator = $valor_base['Contrato']['exclusao'] / 100;
                }
                ?>

                <tr>
                    <td style="text-align: center;background: #A8BDCF; font-size: 11px; padding: 1px 1px 1px"><?php echo '#' . $aux; ?></td>
                    <td style="text-align: center;font-size: 11px; padding: 1px 1px 1px"><?php echo $dado['Funcionalidade']['nome']; ?></td>
                    <td style="text-align: center; font-size: 11px; padding: 1px 1px 1px"><?php echo \Dominio\TipoFuncionalidade::getTipoById($dado['Funcionalidade']['tipo_funcionalidade']); ?></td>
                    <?php if ($dado['Funcionalidade']['impacto'] == 1) { ?>
                        <td style="text-align: center; background: RGB(184,204,228) !important; text-align: center; font-size: 11px; padding: 1px 1px 1px"><?php echo \Dominio\TipoImpacto::getImpactoByIdRelatorio($dado['Funcionalidade']['impacto']); ?></td>
                    <?php } elseif ($dado['Funcionalidade']['impacto'] == 2) { ?>
                        <td style="text-align: center; background: RGB(241,247,169); text-align: center; font-size: 11px; padding: 1px 1px 1px"><?php echo \Dominio\TipoImpacto::getImpactoByIdRelatorio($dado['Funcionalidade']['impacto']); ?></td>
                    <?php } elseif ($dado['Funcionalidade']['impacto'] == 3) { ?>
                        <td style="text-align: center; background: RGB(229,184,183); text-align: center;font-size: 11px; padding: 1px 1px 1px"><?php echo \Dominio\TipoImpacto::getImpactoByIdRelatorio($dado['Funcionalidade']['impacto']); ?></td>
                    <?php } ?>
                    <td style="text-align: center;font-size: 11px; padding: 1px 1px 1px"> <?php if ($dado['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$ALI || $dado['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$AIE) { ?>

                            <?php
                            echo count($dado['Funcionalidade']['trs']);
                            ?>

                        <?php } else { ?>

                            <?php
                            echo count($dado['Funcionalidade']['ars']);
                            ?>

                        <?php } ?></td>
                    <td style="text-align: center;font-size: 11px; padding: 1px 1px 1px"> <?php
                        echo count($dado['Funcionalidade']['tds']);
                        ?></td>
                    <td style="text-align: center;font-size: 11px; padding: 1px 1px 1px"><?php echo \Dominio\TipoComplexidade::getComplexidadeById($dado['Funcionalidade']['complexidade']); ?></td>
                    <td style="text-align: center; font-size: 11px; padding: 1px 1px 1px"><?php echo!empty($dado['Funcionalidade']['qtd_pf']) ? $dado['Funcionalidade']['qtd_pf'] : ''; ?></td>
                    <td style="text-align: center; font-size: 11px; padding: 1px 1px 1px"><?php echo!empty($dado['Funcionalidade']['qtd_pf']) ? $dado['Funcionalidade']['qtd_pf'] * $valor_deflator : ''; ?></td>
                    <td class="hidden-print" title="Detalhar Análise" style="text-align: center; padding: 1px 1px 1px"><a  href="/analises/analises/relatorio/<?php
                        echo $dado['Funcionalidade']['analise_id'];
                        ?>" ><span class="glyphicon glyphicon-plus-sign"></span></td>
                </tr>


                <?php if ($dado['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$ALI || $dado['Funcionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$AIE) { ?>
                    <tr>
                        <td colspan="10" style="font-size: 11px; padding: 1px 1px 1px"><strong>TRs: </strong> <?php
                            foreach ($dado['Funcionalidade']['trs'] as $valorTr) {
                                echo $valorTr['Tdstrsar']['nome'] . ' ; ';
                            }
                            ?></td>

                    </tr>
                    <tr>
                        <td colspan="10" style="font-size: 11px; padding: 1px 1px 1px"><strong>TDs: </strong><?php
                            foreach ($dado['Funcionalidade']['tds'] as $valorTd) {
                                echo $valorTd['Tdstrsar']['nome'] . ' ; ';
                            }
                            ?></td>
                    </tr>
                    <?php if (!empty($dado['Funcionalidade']['observacao'])) { ?>
                        <tr>
                            <td colspan="10" style=" font-size: 11px; padding: 1px 1px 1px"><strong>Observações: </strong><?php echo $dado['Funcionalidade']['observacao']; ?></td>

                        </tr>
                    <?php } ?>
                    <?php
                    if ($count < $tamanho) {
                        ?>
                        <tr style="border-color: white; padding: 1px 1px 1px; border: 0px">
                            <td colspan="10" style="padding: 1px 1px 1px; border: 0px; border-color: white"><br></td>
                        </tr>

                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="10" style="font-size: 11px; padding: 1px 1px 1px"><strong>ARs: </strong> <?php
                            foreach ($dado['Funcionalidade']['ars'] as $valorAr) {
                                echo $valorAr['Tdstrsar']['nome'] . ' ; ';
                            }
                            ?></td>

                    </tr>
                    <tr>
                        <td colspan="10" style="font-size: 11px; padding: 1px 1px 1px"><strong>TDs: </strong> <?php
                            foreach ($dado['Funcionalidade']['tds'] as $valorTds) {
                                echo $valorTds['Tdstrsar']['nome'] . ' ; ';
                            }
                            ?></td>
                    </tr>
                    <?php if (!empty($dado['Funcionalidade']['observacao'])) { ?>
                        <tr>
                            <td colspan="10" style=" font-size: 11px; padding: 1px 1px 1px"><strong>Observações: </strong><?php echo $dado['Funcionalidade']['observacao']; ?></td>

                        </tr>
                    <?php } ?>
                    <?php
                    if ($count < $tamanho) {
                        ?>
                        <tr style="border-color: white; padding: 1px 1px 1px; border: 0px">
                            <td colspan="10" style="padding: 1px 1px 1px; border: 0px; border-color: white"><br></td>
                        </tr>
                    <?php } ?>
                <?php } ?>

  
                <?php
                if ($count < $tamanho) {
                    ?>
                    <tr style="border-color: white; border: 1px;">
                        <td colspan="10" style="border-color: white; border: 1px;"><br></td>
                    </tr>
                <?php }
                ?>
                <?php
                ?>

            <?php endforeach; ?>

            <?php unset($dados); ?>
        <?php } else { ?>
            <td style="font-size: 11px; padding: 1px 1px 1px" colspan="10">
                Sem Registros.
            </td>
<?php } ?>
    </table>
</div> 


<!-- BASELINE -->

<div class="col-md-12">
    <legend style="font-size: 15px; text-align: center">Resumo do Baseline</legend>

    <table class="table table-striped table-hover">
        <tr>
            <th style="text-align: center ; font-size: 11px; padding: 1px 1px 1px">
                <strong>Tipo Função </strong>
            </th>
            <th colspan="3" style="text-align: center ;font-size: 11px; padding: 1px 1px 1px">
                <strong>Complex. Funcional</strong>
            </th>
            <th style="text-align: center ;font-size: 11px; padding: 1px 1px 1px">
                <strong>Total por Complex. </strong>
            </th>
            <th style="font-size: 11px; padding: 1px 1px 1px">
                <strong>%</strong>
            </th>

        </tr>
        <tr>
            <td style="font-size: 11px; padding: 1px 1px 1px">
                <strong>EE </strong>
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"> <?php echo!empty($result['EE']['baixa']) ? $result['EE']['baixa'] : 0; ?>
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px; padding: 1px 1px 1px"><strong>Baixa</strong> 
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
                <strong>x 3 </strong> 
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px">
                <?php echo!empty($result['EE']['comp_baixa']) ? $result['EE']['comp_baixa'] : 0; ?>
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
               
            </td>
        </tr>
        <tr>
            <td style="font-size: 11px; padding: 1px 1px 1px">
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><?php echo!empty($result['EE']['media']) ? $result['EE']['media'] : 0; ?>
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"><strong>Média</strong> 
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
                <strong>x 4 </strong> 
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px">
                <?php echo!empty($result['EE']['comp_media']) ? $result['EE']['comp_media'] : 0; ?>
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
               
            </td>
        </tr>
        <tr>
            <td style="font-size: 11px; padding: 1px 1px 1px">
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><?php echo!empty($result['EE']['alta']) ? $result['EE']['alta'] : 0; ?>
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"><strong>Alta</strong> 
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
                <strong>x 6 </strong> 
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"><?php echo!empty($result['EE']['comp_alta']) ? $result['EE']['comp_alta'] : 0; ?>
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
               
            </td>
        </tr>
        <tr>
            <td style="font-size: 11px; padding: 1px 1px 1px"><strong>Total </strong> 
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><?php echo $result['EE']['baixa'] + $result['EE']['media'] + $result['EE']['alta']; ?>
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><strong>Total </strong> 
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"><?php echo $result['EE']['comp_baixa'] + $result['EE']['comp_media'] + $result['EE']['comp_alta']; ?>
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><?php
                $valor = ($result['total'] == '0') ? '0' : ($result['EE']['baixa'] + $result['EE']['media'] + $result['EE']['alta']) * 100 / $result['total'];
                echo number_format($valor, 2) . '%';
                ?>
            </td>
          
        </tr>
        <tr>
            <td style="font-size: 11px; padding: 1px 1px 1px">
                <strong>SE </strong>
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><?php echo!empty($result['SE']['baixa']) ? $result['SE']['baixa'] : 0; ?>
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"><strong>Baixa</strong> 
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
                <strong>x 4 </strong> 
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px">
                <?php echo!empty($result['SE']['comp_baixa']) ? $result['SE']['comp_baixa'] : 0; ?>
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
               
            </td>
        </tr>
        <tr>
            <td style="font-size: 11px; padding: 1px 1px 1px">
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><?php echo!empty($result['SE']['media']) ? $result['SE']['media'] : 0; ?>
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"><strong>Média</strong> 
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
                <strong>x 5 </strong> 
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px">
                <?php echo!empty($result['SE']['comp_media']) ? $result['SE']['comp_media'] : 0; ?>
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
               
            </td>
        </tr>
        <tr>
            <td style="font-size: 11px; padding: 1px 1px 1px">
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><?php echo!empty($result['SE']['alta']) ? $result['SE']['alta'] : 0; ?>
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"><strong>Alta</strong> 
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
                <strong>x 7 </strong> 
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"><?php echo!empty($result['SE']['comp_alta']) ? $result['SE']['comp_alta'] : 0; ?>
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
               
            </td>
        </tr>
        <tr>
            <td style="font-size: 11px; padding: 1px 1px 1px"><strong>Total </strong> 
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><?php echo $result['SE']['baixa'] + $result['SE']['media'] + $result['SE']['alta']; ?>
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><strong>Total </strong> 
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"><?php echo $result['SE']['comp_baixa'] + $result['SE']['comp_media'] + $result['SE']['comp_alta']; ?>
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><?php
                $valor = ($result['total'] == '0') ? '0' : ($result['SE']['baixa'] + $result['SE']['media'] + $result['SE']['alta']) * 100 / $result['total'];
                echo number_format($valor, 2) . '%';
                ?>
            </td>
            
        </tr>
        <tr>
            <td style="font-size: 11px; padding: 1px 1px 1px">
                <strong>CE </strong>
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><?php echo!empty($result['CE']['baixa']) ? $result['CE']['baixa'] : 0; ?>
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"><strong>Baixa</strong> 
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
                <strong>x 3 </strong> 
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px">
                <?php echo!empty($result['CE']['comp_baixa']) ? $result['CE']['comp_baixa'] : 0; ?>
            </td>
<td style="font-size: 11px; padding: 1px 1px 1px">
               
            </td>
        </tr>
        <tr>
            <td style="font-size: 11px; padding: 1px 1px 1px">
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><?php echo!empty($result['CE']['media']) ? $result['CE']['media'] : 0; ?>
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"><strong>Média</strong> 
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
                <strong>x 4 </strong> 
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px">
                <?php echo!empty($result['CE']['comp_media']) ? $result['CE']['comp_media'] : 0; ?>
            </td>
<td style="font-size: 11px; padding: 1px 1px 1px">
               
            </td>
        </tr>
        <tr>
            <td style="font-size: 11px; padding: 1px 1px 1px">
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><?php echo!empty($result['CE']['alta']) ? $result['CE']['alta'] : 0; ?>
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"><strong>Alta</strong> 
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
                <strong>x 6 </strong> 
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"><?php echo!empty($result['CE']['comp_alta']) ? $result['CE']['comp_alta'] : 0; ?>
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">

            </td>
        </tr>
        <tr>
            <td style="font-size: 11px; padding: 1px 1px 1px"><strong>Total </strong> 
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><?php echo $result['CE']['baixa'] + $result['CE']['media'] + $result['CE']['alta']; ?>
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><strong>Total </strong> 
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"><?php echo $result['CE']['comp_baixa'] + $result['CE']['comp_media'] + $result['CE']['comp_alta']; ?>
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><?php
                $valor = ($result['total'] == '0') ? '0' : ($result['CE']['baixa'] + $result['CE']['media'] + $result['CE']['alta']) * 100 / $result['total'];
                echo number_format($valor, 2) . '%';
                ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 11px; padding: 1px 1px 1px">
                <strong>ALI </strong>
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><?php echo!empty($result['ALI']['baixa']) ? $result['ALI']['baixa'] : 0; ?>
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"><strong>Baixa</strong> 
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
                <strong>x 7 </strong> 
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px">
                <?php echo!empty($result['ALI']['comp_baixa']) ? $result['ALI']['comp_baixa'] : 0; ?>
            </td>
<td style="font-size: 11px; padding: 1px 1px 1px">
               
            </td>
        </tr>
        <tr>
            <td style="font-size: 11px; padding: 1px 1px 1px">
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><?php echo!empty($result['ALI']['media']) ? $result['ALI']['media'] : 0; ?>
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"><strong>Média</strong> 
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
                <strong>x 10 </strong> 
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px">
                <?php echo!empty($result['ALI']['comp_media']) ? $result['ALI']['comp_media'] : 0; ?>
            </td>
<td style="font-size: 11px; padding: 1px 1px 1px">
               
            </td>
        </tr>
        <tr>
            <td style="font-size: 11px; padding: 1px 1px 1px">
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><?php echo!empty($result['ALI']['alta']) ? $result['ALI']['alta'] : 0; ?>
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"><strong>Alta</strong> 
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
                <strong>x 15 </strong> 
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"><?php echo!empty($result['ALI']['comp_alta']) ? $result['ALI']['comp_alta'] : 0; ?>
            </td>
<td style="font-size: 11px; padding: 1px 1px 1px">
               
            </td>
        </tr>
        <tr>
            <td style="font-size: 11px; padding: 1px 1px 1px"><strong>Total </strong> 
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><?php echo $result['ALI']['baixa'] + $result['ALI']['media'] + $result['ALI']['alta']; ?>
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><strong>Total </strong> 
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"><?php echo $result['ALI']['comp_baixa'] + $result['ALI']['comp_media'] + $result['ALI']['comp_alta']; ?>
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><?php
                $valor = ($result['total'] == '0') ? '0' : ($result['ALI']['baixa'] + $result['ALI']['media'] + $result['ALI']['alta']) * 100 / $result['total'];
                echo number_format($valor, 2) . '%';
                ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 11px; padding: 1px 1px 1px">
                <strong>AIE </strong>
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><?php echo!empty($result['AIE']['baixa']) ? $result['AIE']['baixa'] : 0; ?>
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"><strong>Baixa</strong> 
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
                <strong>x 5 </strong> 
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px">
                <?php echo!empty($result['AIE']['comp_baixa']) ? $result['AIE']['comp_baixa'] : 0; ?>
            </td>
<td style="font-size: 11px; padding: 1px 1px 1px">
               
            </td>
        </tr>
        <tr>
            <td style="font-size: 11px; padding: 1px 1px 1px">
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"> <?php echo!empty($result['AIE']['media']) ? $result['AIE']['media'] : 0; ?>
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"><strong>Média</strong> 
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
                <strong>x 7 </strong> 
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px">
                <?php echo!empty($result['AIE']['comp_media']) ? $result['AIE']['comp_media'] : 0; ?>
            </td>
<td style="font-size: 11px; padding: 1px 1px 1px">
               
            </td>
        </tr>
        <tr>
            <td style="font-size: 11px; padding: 1px 1px 1px">
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"> <?php echo!empty($result['AIE']['alta']) ? $result['AIE']['alta'] : 0; ?>
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"><strong>Alta</strong> 
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
                <strong>x 10 </strong> 
            </td>
            <td style="text-align: center ;font-size: 11px; padding: 1px 1px 1px"> <?php echo!empty($result['AIE']['comp_alta']) ? $result['AIE']['comp_alta'] : 0; ?>
            </td>
<td style="font-size: 11px; padding: 1px 1px 1px">
               
            </td>
        </tr>
        <tr>
            <td style="font-size: 11px; padding: 1px 1px 1px"><strong>Total </strong> 
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><?php echo $result['AIE']['baixa'] + $result['AIE']['media'] + $result['AIE']['alta']; ?>
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px">
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><strong>Total </strong> 
            </td>
            <td style="text-align: center ;text-align: center ;font-size: 11px; padding: 1px 1px 1px"><?php echo $result['AIE']['comp_baixa'] + $result['AIE']['comp_media'] + $result['AIE']['comp_alta']; ?>
            </td>
            <td style="font-size: 11px; padding: 1px 1px 1px"><?php
                $valor = ($result['total'] == '0') ? '0' : ($result['AIE']['baixa'] + $result['AIE']['media'] + $result['AIE']['alta']) * 100 / $result['total'];
                echo number_format($valor, 2) . '%';
                ?>
            </td>
        </tr>

    </table>

</div> 

<div style="text-align: center" class="hidden-print col-md-12">

    <?php if ($imprimir == '1') { ?>
        <input type="button" class="btn btn-danger" value="Imprimir" onclick="self.print();">
    <?php } else { ?>
        <a href="/sistemas/sistemas/baselines" class="btn btn-info">VOLTAR</a>
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
        var url = '/sistemas/sistemas/baseview/' + $('#sistema_id').val() + '/1';
        window.open(url, '_blank', "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=800, height=800");

    }
</script>