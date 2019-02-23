<?php


 $timestamp = strtotime($baseline['Baseline']['created']);
$dataformat = date('d/m/Y H:i', $timestamp );

?>
<div class="col-md-12">
    <table  class="table table-bordered  table-hover table-condensed">
        <tr >
        <input id ="sistema_id" type="hidden" value="<?php echo $baseline['Baseline']['sistema_id'];?>">
            <td style="font-size: 12px; padding: 1px 1px 1px" colspan="2">
                <strong>TOTAL DE PF: </strong><?php echo!empty($total_pf) ? $total_pf : ''; ?>
            </td>
            
            
             <td style="font-size: 12px; padding: 1px 1px 1px" colspan="3">
                <strong>DATA DE CRIAÇÃO: </strong><?php echo!empty($dataformat) ? $dataformat : ''; ?>
            </td>
            
            
           
        </tr>
        <tr>
            <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>QTD PF EE: </strong><?php echo!empty($qtd_ee) ? $qtd_ee : '0'; ?>
            </td>
            
            <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>QTD PF SE: </strong> <?php echo!empty($qtd_se) ? $qtd_se : '0'; ?>
            </td>
            
            <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>QTD PF CE: </strong> <?php echo!empty($qtd_ce) ? $qtd_ce : '0'; ?>
            </td>
            
            <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>QTD PF AIE: </strong> <?php echo!empty($qtd_aie) ? $qtd_aie : '0'; ?>
            </td>
           
            <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>Qtde PF ALI: </strong> <?php echo!empty($qtd_ali) ? $qtd_ali : '0'; ?>
            </td>
            
        </tr>
       
        
    </table>
</div>