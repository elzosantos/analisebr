<div class="well">Histórico da Análise</div>

<?php if (!empty($result)) { ?>

    <?php foreach ($result as $key => $value) { 
             ?>
 
        <legend>Análise : <?php echo!empty($value['Analise']['modified']) ? date("d/m/Y H:i ", strtotime($value['Analise']['modified'])) : ''; ?></legend>
        <table class="table table-bordered">
            <tr>
                <td>
                    <strong>Autor: </strong> <?php echo!empty($value['Analise']['user']) ? $value['Analise']['user'] : ''; ?>
                </td>
                <td>
                    <strong>Perfil:</strong>  <?php echo!empty($value['Analise']['perfil']) ? \Dominio\Perfil::getPerfilById($value['Analise']['perfil']) : ''; ?>
                </td>
                <td>
                    <strong>Email: </strong>  <?php echo!empty($value['Analise']['email']) ? $value['Analise']['email'] : ''; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Nº Demanda: </strong> <?php echo!empty($value['Analise']['nu_demanda']) ? $value['Analise']['nu_demanda'] : ''; ?>
                </td>
                <td>
                    <strong>Fase: </strong>  <?php echo!empty($value['Analise']['fase_id']) ? $value['Analise']['fase_id'] : ''; ?>
                </td>
                <td>
                    <strong>Metodo Contagem: </strong>  <?php echo!empty($value['Analise']['metodo_contagem']) ? \Dominio\MetodoContagem::getMetodoById($value['Analise']['metodo_contagem']) : ''; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Qtde UST: </strong> <?php echo!empty($value['Analise']['total_ust']) ? $value['Analise']['total_ust'] : ''; ?>
                </td>
               
            </tr>
       
                 <td colspan="3">
                    <strong>Observação: </strong>  <?php echo!empty($value['Analise']['documentacao']) ? $value['Analise']['documentacao'] : ''; ?>
                </td>
                
            </tr>

        </table>

        
        <hr>
    <?php } ?>
<?php }else{ ?>
        Sem registro.
        <?php } ?>
<div style="text-align: center" class="hidden-print">
    <a href="/painel" class="btn btn-info">VOLTAR</a>
    <input type="button" class="btn btn-success" value="Imprimir" onclick="self.print();">
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).ajaxStart(function() {
            $(".carregando").fadeIn();
            $('input[type="button"], input[type="submit"]').attr('disabled', 'disabled');
        });
        $(document).ajaxStop(function() {
            $(".carregando").fadeOut();
            $('input[type="button"], input[type="submit"]').removeAttr('disabled');
        });

        $(".checkTipo").click(function() {
            var aux = $(this).attr('id');
            var hist = $(this).attr('hist');

            var cont = aux.split('-');
            $.ajax({
                type: "POST",
                url: '/analises/analises/gettiposhistorico',
                data: {id: cont[1], history: hist},
                dataType: 'html'
            }).done(function(e) {
                bootbox.alert(e);
            });
        });
    });

</script>