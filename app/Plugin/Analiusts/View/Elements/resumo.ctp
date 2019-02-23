<div class="col-md-12">
    <table class="table table-bordered table-striped table-hover">
        <tr>
            <td>
                <strong>Sistema: </strong><?php echo!empty($resumo['sistema']) ? $resumo['sistema'] : ''; ?>
            </td>
            <td>

                <strong>Demanda: </strong> <?php echo!empty($resumo['nu_demanda']) ? $resumo['nu_demanda'] : ''; ?>
            </td>
        
        </tr>
        <tr>
            <td>
                <strong>Método de Cont.: </strong><?php echo!empty($resumo['metodo_contagem']) ? \Dominio\MetodoContagem::getMetodoById($resumo['metodo_contagem']) : ''; ?>
            </td>
            <td>
                <strong>Qtde UST: </strong> <?php echo!empty($resumo['total_ust']) ? $resumo['total_ust'] : '0'; ?>
            </td>
        </tr>
    </table>
</div>