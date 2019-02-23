<?php


 $timestamp = strtotime($analise['Analiust']['created']);
$dataformat = date('d/m/Y H:i:s', $timestamp );

?>
<div class="col-md-12 excel">
    <table class="table table-bordered table-striped table-hover">
        <tr >
            <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>Sistema: </strong><?php echo!empty($analise['Analiust']['sistema']) ? $analise['Analiust']['sistema'] : ''; ?>
            </td>
            <td style="font-size: 12px; padding: 1px 1px 1px">

                <strong>Demanda: </strong> <?php echo $analise['Analiust']['nu_demanda']; ?>
            </td>
           <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>Resposável pela contagem : </strong> <?php echo $analise['Analiust']['usuario']; ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>Método de Cont.: </strong><?php echo!empty($analise['Analiust']['metodo_contagem']) ? \Dominio\MetodoContagem::getMetodoById($analise['Analiust']['metodo_contagem']) : ''; ?>
            </td>
            <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>Qtde PF: </strong> <?php echo $analise['Analiust']['total_ust']; ?>
            </td>
               <td style="font-size: 12px; padding: 1px 1px 1px">
                <strong>Data de criação: </strong> <?php 
                          echo!empty($analise['Analiust']['created']) ? $dataformat : ''; ?>
            </td>
           
        </tr>
       
        <tr>
           
           <td style="font-size: 12px; padding: 1px 1px 1px" colspan="3"> 
                <strong>Equipe da contagem: </strong><?php echo $analise['Analiust']['equipe']; ?>
            </td>
        </tr>
         <tr>
            
             <td  style="font-size: 12px; padding: 1px 1px 1px" colspan="3" >
                <strong>Observação: </strong> <?php echo $analise['Analiust']['observacao']; ?>
            </td>
             
         
        </tr>
        <tr>
            
        </tr>
       
    </table>
</div>