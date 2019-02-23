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
                    <strong>Qtde PF: </strong> <?php echo!empty($value['Analise']['total_pf']) ? $value['Analise']['total_pf'] : ''; ?>
                </td>
                <td>
                    <strong>Qtde PF ajustado + INM:</strong>  <?php echo $value['Analise']['total_pf_ajustado'] + $value['Analise']['total_pf_itens']  ; ?>
                </td>
                <td>
                    <strong>Tipo Contagem: </strong>  <?php echo!empty($value['Analise']['tipo_contagem']) ? \Dominio\TipoContagem::getTipoById($value['Analise']['tipo_contagem']) : ''; ?>
                </td>
            </tr>
            <tr>

                <td colspan="3">
                    <strong>Proposito: </strong> <?php echo!empty($value['Analise']['proposta']) ? $value['Analise']['proposta'] : ''; ?>
                </td>
    
              
            </tr>
                     <tr>

    
                 <td colspan="3">
                    <strong>Escopo: </strong>  <?php echo!empty($value['Analise']['escopo']) ? $value['Analise']['escopo'] : ''; ?>
                </td>
              
            </tr>
             <tr>
                 <td colspan="3">
                    <strong>Premissas: </strong> <?php echo!empty($value['Analise']['premissa']) ? $value['Analise']['premissa'] : ''; ?>
                </td>

            </tr> <tr>
       
                 <td colspan="3">
                    <strong>Documentação: </strong>  <?php echo!empty($value['Analise']['documentacao']) ? $value['Analise']['documentacao'] : ''; ?>
                </td>
                
            </tr>

        </table>

        <p><h4>Funcionalidades</h4></p>   
        <table class="table table-hover table-striped table-bordered table-condensed">


            <?php if (!empty($value['Analise']['Funcionalidade'])) { ?>
                <?php foreach ($value['Analise']['Funcionalidade'] as $dado): ?>
                    <tr>
                        <th style="background: #A8BDCF">Nome</th>
                        <th style="background: #A8BDCF">Tipo</th>
                        <th style="background: #A8BDCF">Impacto</th>
                        <th style="background: #A8BDCF">Complexidade</th>
                        <th style="background: #A8BDCF">Total PF</th>
                    </tr>
                    <tr>
                        <td><?php echo $dado['Thfuncionalidade']['nome']; ?></td>
                        <td><?php echo \Dominio\TipoFuncionalidade::getTipoById($dado['Thfuncionalidade']['tipo_funcionalidade']); ?></td>
                        <td><?php echo \Dominio\TipoImpacto::getImpactoById($dado['Thfuncionalidade']['impacto']); ?></td>
                        <td><?php echo \Dominio\TipoComplexidade::getComplexidadeById($dado['Thfuncionalidade']['complexidade']); ?></td>
                        <td><?php echo $dado['Thfuncionalidade']['qtd_pf']; ?></td>
                    </tr>      
                     <tr>
                        <td colspan="6" style="text-align: center"><strong>Observações</strong></td>
                        
                </tr>
                <tr>
                    <td colspan="6"><?php echo !empty($dado['Funcionalidade']['observacao']) ? $dado['Funcionalidade']['observacao'] : ''; ?></td>

                </tr>
                    <?php if ($dado['Thfuncionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$ALI || $dado['Thfuncionalidade']['tipo_funcionalidade'] == \Dominio\TipoFuncionalidade::$AIE) { ?>
                        <tr>
                            <td colspan="2" style="text-align: center"><strong>TRs</strong></td>
                            <td colspan="3" style="text-align: center"><strong>TDs</strong></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php
                                foreach ($dado['Thfuncionalidade']['trs'] as $valorTr) {
                                    echo $valorTr['Thtdstrsar']['nome'] . ' ; ';
                                }
                                ?>
                            </td>
                            <td colspan="3">
                                <?php
                                foreach ($dado['Thfuncionalidade']['tds'] as $valorTd) {
                                    echo $valorTd['Thtdstrsar']['nome'] . ' ; ';
                                }
                                ?>
                            </td>
                        </tr>

                    <?php } else { ?>
                        <tr>
                            <td colspan="2" style="text-align: center"><strong>ARs</strong></td>
                            <td colspan="3" style="text-align: center"><strong>TDs</strong></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php
                                foreach ($dado['Thfuncionalidade']['ars'] as $valorAr) {
                                    echo $valorAr['Thtdstrsar']['nome'] . ' ; ';
                                }
                                ?>
                            </td>
                            <td colspan="3">
                                <?php
                                foreach ($dado['Thfuncionalidade']['tds'] as $valorTds) {
                                    echo $valorTds['Thtdstrsar']['nome'] . ' ; ';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                <?php endforeach; ?>

                <?php unset($dados); ?>
            <?php } else { ?>
                <tr>
                    <td colspan="6"> Sem Registros.</td>
                </tr>  
            <?php } ?>


        </table>
        <hr>
    <?php } ?>
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