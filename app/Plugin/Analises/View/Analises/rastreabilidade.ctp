<?php
if (!empty($resultado)) {
    foreach ($resultado as $value) {
        ?>
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <td>
                    <strong>Sistema: </strong><?php echo!empty($value['sistema']) ? $value['sistema'] : ''; ?>
                </td>
                <td>

                    <strong>Funcionalidade: </strong> <?php echo $value['funcionalidade']; ?>
                </td>

            </tr>
            <tr>
                <td colspan="2" style="text-align: center"> <strong>Funcionalidade | TDs </strong></td>
            </tr>

            <?php foreach ($value['tds'] as $v) {
                ?>
                <tr>
                    <td colspan="2" style="text-align: center">
                        <?php echo $v; ?>
                    </td>
                </tr>
            <?php } ?>



        </table>

    <?php
    }
}
?>