<legend>Funcionalidade: <?php echo $funcionalidade['nome'] ?></legend>
<table class="table table-striped table-hover">

    <tr>
        <?php if ($funcionalidade['tipo'] == '1' || $funcionalidade['tipo'] == '2') { ?>
            <th>TD</th>
            <th>TR</th>
        <?php } else { ?>
            <th>TD</th>
            <th>AR</th>
        <?php } ?>
    </tr>
    <?php if ($tipos) { ?>
        <?php
        $aux = 0;
        $string = '';
        foreach ($tipos as $key => $dado):
            ?>
            <?php
            if ($dado['Tdstrsar']['tipo'] == '1') {
                $string .= '<td>' . $dado['Tdstrsar']['nome'] . '</td>';
                $aux++;
            }
            ?>
            <?php
            if ($dado['Tdstrsar']['tipo'] == '2') {
                $string .= '<td>' . $dado['Tdstrsar']['nome'] . '</td>';
                $aux++;
            }
            ?>
            <?php
            if ($dado['Tdstrsar']['tipo'] == '3') {
                $string .= '<td>' . $dado['Tdstrsar']['nome'] . '</td>';
                $aux++;
            }
            ?>
            <?php
            if ($aux == 2) {
                echo
                '<tr>' . $string . '</tr>';
                $aux = 0;
                $string = '';
            }
            ?>


        <?php endforeach; ?>
    <?php unset($dados); ?>
<?php } else { ?>
        <div class="alert-info">
            Sem Registros.
        </div>
<?php } ?>
</table>