<?php if (isset($dado)) { ?>
<table border="1">
    <fieldset><legend>Resultado</legend>
        <div class="well">
            <?php echo $result; ?> 
        </div>
    </fieldset>
</table>

   
<?php } else { ?>
    <?php if ($post == '1') { ?>
        <?php echo $this->Form->create('Analise'); ?>
        <table class="table table-striped table-hover">
            <th style="width: 50%">Pergunta</th>
            <th style="width: 50%">Resposta</th>
            <tr>
                <td style="width: 50%"> O grupo de dados ou de informações de controle é lógico e reconhecido pelo usuário?</td>
                <td style="width: 50%"><?php
                    echo $this->Form->radio('opt1', array('1' => 'Sim  ', '2' => '  Não'), array('legend' => false, 'required' => true, 'value' => '1', ));
                    ?>
                </td>
            </tr>
            <tr>
                <td>O grupo de dados é mantido através de um processo elementar dentro da fronteira da aplicação que está sendo contada?</td>
                <td><?php
                    echo $this->Form->radio('opt2', array(
                        '1' => 'Sim', '2' => 'Não'), array('legend' => false, 'required' => true, 'value' => '1'));
                    ?></</td>
            </tr>
            <tr>
                <td> O grupo de dados é referenciado por, e externo a aplicação que está sendo contada?</td>
                <td><?php
                    echo $this->Form->radio('opt3', array(
                        '1' => 'Sim', '2' => 'Não'), array('legend' => false, 'required' => true, 'value' => '1'));
                    ?></</td>
            </tr>
            <tr>
                <td>O grupo de dados é mantido em um ALI de outra aplicação?</td>
                <td><?php
                    echo $this->Form->radio('opt4', array(
                        '1' => 'Sim', '2' => 'Não'), array('legend' => false, 'required' => true, 'value' => '1'));
                    ?></</td>
            </tr>
        </table>
        <?php echo $this->Form->end(); ?>
    <?php } else { ?>
        <?php echo $this->Form->create('Analise'); ?>
        <table class="table table-striped table-hover">
            <th style="width: 50%">Pergunta</th>
            <th style="width: 50%">Resposta</th>
            <tr>
                <td style="width: 50%"> A intenção primária do processo elementar é manter um ALI ou alterar o comportamento do sistema?</td>
                <td style="width: 50%"><?php
                    echo $this->Form->radio('opt1', array(
                        '1' => ' Sim ', '2' => ' Não '), array('legend' => false, 'required' => true, 'value' => '1', 'separator' => '  '));
                    ?></td>
            </tr>
            <tr>
                <td>A intenção primária do processo elementar é aprensentar informações a um usuário?</td>
                <td><?php
                    echo $this->Form->radio('opt2', array(
                        '1' => 'Sim', '2' => 'Não'), array('legend' => false, 'required' => true, 'value' => '1'));
                    ?></</td>
            </tr>
            <tr>
                <td> A função envia dados ou informação de controle para fora da fronteira da aplicação?</td>
                <td><?php
                    echo $this->Form->radio('opt3', array(
                        '1' => 'Sim', '2' => 'Não'), array('legend' => false, 'required' => true, 'value' => '1'));
                    ?></</td>
            </tr>
            <tr>
                <td>O grupo de dados é mantido em um ALI de outra aplicação?</td>
                <td><?php
                    echo $this->Form->radio('opt4', array(
                        '1' => 'Sim', '2' => 'Não'), array('legend' => false, 'required' => true, 'value' => '1'));
                    ?></</td>
            </tr>
            <tr>
                <td>A lógica de processamento do processo elementar cria dados derivados, altera o comportamento ou mantém pelo menos um ALI?</td>
                <td><?php
                    echo $this->Form->radio('opt5', array(
                        '1' => 'Sim', '2' => 'Não'), array('legend' => false, 'required' => true, 'value' => '1'));
                    ?></</td>
            </tr>
        </table>
        <?php echo $this->Form->end(); ?>
    <?php } ?>
<?php } ?>
