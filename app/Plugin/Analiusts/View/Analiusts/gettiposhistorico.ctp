
<?php
$total = (sizeof($trs) > sizeof($tds) ) ? sizeof($trs) : sizeof($tds);
?>
<legend>Funcionalidade: <?php echo $funcionalidade['nome'] ?></legend>
<table class="table table-striped table-hover">
    <?php if ($funcionalidade['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$AIE || $funcionalidade['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$ALI) { ?>
        <tr>

            <th>TR</th>
            <th>TD</th>

        </tr>
        <?php  for ($index = 0; $index <= $total; $index++) { ?>
            <tr> 
                <td><?php  echo isset($trs[$index]['Thtdstrsar']['nome']) ? $trs[$index]['Thtdstrsar']['nome'] :  '' ?></td>
                <td><?php  echo isset($tds[$index]['Thtdstrsar']['nome']) ? $tds[$index]['Thtdstrsar']['nome'] :  '' ?></td>
            </tr>
        <?php  } ?>
    <?php } else { ?>
        <tr>
            <th>AR</th>
            <th>TD</th>
        </tr>
         <?php  for ($index = 0; $index <= $total; $index++) { ?>
            <tr> 
                <td><?php  echo isset($ars[$index]['Thtdstrsar']['nome']) ? $ars[$index]['Thtdstrsar']['nome'] :  '' ?></td>
                <td><?php  echo isset($tds[$index]['Thtdstrsar']['nome']) ? $tds[$index]['Thtdstrsar']['nome'] :  '' ?></td>
            </tr>
        <?php  } ?>
    <?php } ?>
</table>