<div class="col-md-12">
    <table class="table table-bordered table-striped table-hover">
        <tr>
            <td>
                <strong>Sistema: </strong><?php echo!empty($analise['Analise']['sistema']) ? $analise['Analise']['sistema'] : ''; ?>
            </td>
            <td>

                <strong>Demanda: </strong> <?php echo $analise['Analise']['nu_demanda']; ?>
            </td>
            <td>
                <strong>Tipo de Cont.: </strong> <?php echo!empty($analise['Analise']['tipo_contagem']) ? \Dominio\TipoContagem::getTipoById($analise['Analise']['tipo_contagem']) : ''; ?>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Método de Cont.: </strong><?php echo!empty($analise['Analise']['metodo_contagem']) ? \Dominio\MetodoContagem::getMetodoById($analise['Analise']['metodo_contagem']) : ''; ?>
            </td>
            <td>
                <strong>Qtde PF: </strong> <?php echo $analise['Analise']['total_pf']; ?>
            </td>
            <td>
                <strong>Qtde PF Itens: </strong> <?php echo $analise['Analise']['total_pf_itens']; ?>
            </td>
        </tr>
       
        <tr>
            <td>
                <strong>Expectativa de horas : </strong> <?php echo $analise['Analise']['cofator'] * ( $analise['Analise']['valor_fator']  ); ?>h
            </td>
            <td>
                <strong>Qtde PF ajustado: </strong> <?php echo $analise['Analise']['total_pf_ajustado']; ?>
            </td>
            <td>
                <strong>Qtde PF (deflator) + INM: </strong> <?php echo $analise['Analise']['valor_fator'] ; ?>
            </td>
        </tr>
         <tr>
            <td>
                <strong>Fator de Ajuste: </strong><?php echo!empty($analise['Analise']['fator']) ? $analise['Analise']['fator'] : ''; ?>
            </td>
            <td>
                <strong>Versão CPM: </strong> <?php echo!empty($analise['Analise']['versao_cpm']) ? $analise['Analise']['versao_cpm'] : ''; ?>
            </td>
            <td>
                <strong>Data de criação: </strong> <?php echo!empty($analise['Analise']['created']) ? $analise['Analise']['created'] : ''; ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <strong>Propósito da Contagem : </strong> <?php echo $analise['Analise']['proposta']; ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <strong>Escopo da Contagem: </strong> <?php echo $analise['Analise']['escopo']; ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <strong>Premissas da Contagem : </strong> <?php echo $analise['Analise']['premissa']; ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <strong>Documentação : </strong> <?php echo $analise['Analise']['documentacao']; ?>
            </td>
        </tr>
    </table>
</div>