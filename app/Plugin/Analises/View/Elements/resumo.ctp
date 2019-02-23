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
                <strong>Qtde PF: </strong> <?php echo  !empty($analise['Analise']['total_pf']) ? $analise['Analise']['total_pf'] : '0'; ?>
            </td>
            <td>
                <strong>Qtde PF Itens: </strong> <?php echo  !empty($analise['Analise']['total_pf_itens'])? $analise['Analise']['total_pf_itens'] : '0'; ?>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Expectativa de horas: </strong> <?php echo $analise['Analise']['cofator'] * ( $analise['Analise']['total_pf_ajustado'] + $analise['Analise']['total_pf_itens']  ); ?>h
            </td>
            <td>
                <strong>Qtde PF ajustado: </strong> <?php echo !empty($analise['Analise']['total_pf_ajustado']) ? $analise['Analise']['total_pf_ajustado']: '0'; ?>
            </td>
            <td>
                <strong>Qtde PF (deflator) + INM: </strong> <?php echo  	number_format(($analise['Analise']['total_pf_ajustado'] + $analise['Analise']['total_pf_itens']), 2)   ; ?>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Qtde PF Função de Transação: </strong> <?php echo !empty($qtd_transacao) ? $qtd_transacao: '0'; ?>
            </td>
            <td>
                <strong>Qtde PF Função de Dados: </strong> <?php echo !empty($qtd_dados) ? $qtd_dados: '0'; ?>
            </td>
            <td>
                
            </td>
        </tr>
    </table>
</div>