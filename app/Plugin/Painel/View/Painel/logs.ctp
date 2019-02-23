<div class="well">Ferramentas</div>
<div class="col-md-12"> 
    <div class="form-group">
        <label class="col-md-6 control-label" for="textinput">O tempo de sessão inativo é de :</label>
        <div class="col-md-6">
            <strong> 30</strong> minutos<br>
        </div>

    </div>
</div>
<div class="col-md-12"> 
    <div class="form-group">
        <label class="col-md-6 control-label" for="textinput">Versão do sistema:</label>
        <div class="col-md-6">
            <strong> rev.2018.003</strong> 
        </div>

    </div>
</div>
<div class="col-md-12"> 

    <div class="form-group">
        <label class="col-md-6 control-label" for="textinput">O ID da sessão atual é :</label>

        <div class="col-md-6">
            <strong> <?php echo session_id(); ?></strong>
        </div>

    </div>
</div>
<?php echo $this->Form->create('LOG', array('class' => 'form-horizontal')); ?>

<div class="col-md-12"> 
    <div class="form-group">
        <label class="col-md-6 control-label" for="textinput">DOWNLOAD de LOG</label>
        <div class="col-md-6">
            <?php
            echo $this->Form->input('log_name', array(
                'label' => false,
                'required' => TRUE,
                'options' => array(
                    'acesso' => 'Acessos',
                    'analise' => 'Analises (APF)',
                    'analiust' => 'Analises (UST)',
                    'deflator' => 'Deflatores',
                    'equipe' => 'Equipes',
                    'fase' => 'Fases',
                    'fronteira' => 'Fronteiras',
                    'inm' => 'Itens Não Mensuráveis',
                    'linguagem' => 'Linguagens',
                    'sistema' => 'Sistemas',
                    'usuario' => 'Usuários',
                    'ust' => 'USTs',
                    'debug' => 'DEBUG',
                    'error' => 'Erros'),
                'empty' => '-- Selecione --',
                'class=' => "form-control input-md"));
            ?>
        </div>
    </div>
    <?php echo $this->Form->end('Download'); ?>
</div>

