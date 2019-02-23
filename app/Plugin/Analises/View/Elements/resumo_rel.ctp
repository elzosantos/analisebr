<?php
 $timestamp = strtotime($analise['Analise']['created']);
$dataformat = date('d/m/Y H:i:s', $timestamp );

?>
<div class="col-md-12 excel">
    <table class="table table-bordered table-striped table-hover">
        <tr >
            <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>Sistema: </strong><?php echo!empty($analise['Analise']['sistema']) ? $analise['Analise']['sistema'] : ''; ?>
            </td>
            <td style="font-size: 12px; padding: 1px 1px 1px">

                <strong>Demanda: </strong> <?php echo $analise['Analise']['nu_demanda']; ?>
            </td>
            <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>Tipo de Cont.: </strong> <?php echo!empty($analise['Analise']['tipo_contagem']) ? \Dominio\TipoContagem::getTipoById($analise['Analise']['tipo_contagem']) : ''; ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>Método de Cont.: </strong><?php echo!empty($analise['Analise']['metodo_contagem']) ? \Dominio\MetodoContagem::getMetodoById($analise['Analise']['metodo_contagem']) : ''; ?>
            </td>
            <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>Qtde PF: </strong> <?php echo $analise['Analise']['total_pf']; ?>
            </td>
            <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>Qtde PF Itens: </strong> <?php echo $analise['Analise']['total_pf_itens']; ?>
            </td>
        </tr>
       
        <tr>
            <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>Resposável pela contagem : </strong> <?php echo $analise['Analise']['usuario']; ?>
            </td>
            <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>Qtde PF ajust: </strong> <?php echo $analise['Analise']['total_pf_ajustado']; ?>
            </td>
            <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>Qtde PF (deflator) + INM: </strong> <?php echo 	number_format(($analise['Analise']['total_pf_ajustado'] + $analise['Analise']['total_pf_itens']), 2)   ; ?>
            </td>
        </tr>
         <tr>
            <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>Equipe da contagem: </strong><?php echo $analise['Analise']['equipe']; ?>
            </td>
            <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>Versão CPM: </strong> <?php echo!empty($analise['Analise']['versao_cpm']) ? $analise['Analise']['versao_cpm'] : ''; ?>
            </td>
            <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>Data de criação: </strong> <?php 
                
                          echo!empty($analise['Analise']['created']) ? $dataformat : ''; ?>
            </td>
        </tr>
        <tr>
            <td  style="font-size: 12px; padding: 1px 1px 1px" colspan="3">
                <strong>Propósito da Contagem : </strong> <?php echo $analise['Analise']['proposta']; ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 12px; padding: 1px 1px 1px" colspan="3">
                <strong>Escopo da Contagem: </strong> <?php echo $analise['Analise']['escopo']; ?>
            </td>
        </tr>
        <tr>
            <td  style="font-size: 12px; padding: 1px 1px 1px" colspan="3">
                <strong>Premissas da Contagem : </strong> <?php echo $analise['Analise']['premissa']; ?>
            </td>
        </tr>
        <tr>
            <td  style="font-size: 12px; padding: 1px 1px 1px" colspan="3">
                <strong>Documentação : </strong> <?php echo $analise['Analise']['documentacao']; ?>
            </td>
        </tr>
    </table>
</div>