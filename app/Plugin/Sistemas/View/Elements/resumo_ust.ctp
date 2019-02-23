<?php


 $timestamp = strtotime($baseline['Baseline']['created']);
$dataformat = date('d/m/Y H:i', $timestamp );

?>
<div class="col-md-12">
    <table  class="table table-bordered  table-hover table-condensed">
        <tr >
        <input id ="sistema_id" type="hidden" value="<?php echo $baseline['Baseline']['sistema_id'];?>">
            <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>TOTAL DE UST: </strong><?php echo!empty($total_ust) ? $total_ust : '0'; ?>
            </td>
            
            
             <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>DATA DE CRIAÇÃO: </strong><?php echo!empty($dataformat) ? $dataformat : ''; ?>
            </td>
            
            
           
        </tr>
       
        
    </table>
</div>