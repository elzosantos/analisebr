<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <meta charset="utf-8">
        <title>APFBr - Sistema de Ponto de Função</title>
        <meta name="generator" content="analise">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <?php
        echo $this->Html->meta('icon', '/img/favicon.png', array('type' => 'png'));
        echo $this->Html->script('jquery-1.10.2');
        echo $this->Html->script('quant');
        echo $this->Html->script('analytics');
        echo $this->Html->script('bootstrap.min');
        echo $this->Html->css('bootstrap.min');
        echo $this->Html->css('jquery-ui-1.8.4.custom');
        echo $this->Html->css('table_jui');
        echo $this->Html->css('tables');
        echo $this->Html->script('alertify.min');
        echo $this->Html->css('alertify.core');
        echo $this->Html->css('alertify.default');
        echo $this->Html->script('flashMessenger');
        echo $this->Html->script('jquery.dataTables.min');
        echo $this->Html->script('jquery.dataTables.columnFilter');
        echo $this->Html->script('geral');
        echo $this->Html->script('jquery.maskedinput');
        echo $this->Html->script('bootbox');
        ?>
        <style type="text/css">
            .navbar-static-top {
                margin-bottom:20px;
            }

            i {
                font-size:16px;
            }

            .nav > li > a {
                color:#787878;
            }

            footer {
                margin-top:20px;
                padding-top:20px;
                padding-bottom:20px;
                background-color:#efefef;
            }

            /* count indicator near icons */
            .nav>li .count {
                position: absolute;
                bottom: 12px;
                right: 6px;
                font-size: 10px;
                font-weight: normal;
                background: rgba(51,200,51,0.55);
                color: rgba(255,255,255,0.9);
                line-height: 1em;
                padding: 2px 4px;
                -webkit-border-radius: 10px;
                -moz-border-radius: 10px;
                -ms-border-radius: 10px;
                -o-border-radius: 10px;
                border-radius: 10px;
            }

            /* indent 2nd level */
            .list-unstyled li > ul > li {
                margin-left:10px;
                padding:8px;
            }
            body {
                padding-top: 0px;
                padding-bottom: 0px;
            }

            /* Custom container */
            .container-narrow {
                margin: 0 auto;
                max-width: 700px;
            }
            .container-narrow > hr {
                margin: 30px 0;
            }

            /* Main marketing message and sign up button */
            .jumbotron {
                margin: 5px 0;
                text-align: center;
            }
            .jumbotron h1 {
                font-size: 72px;
                line-height: 1;
            }
            .jumbotron .btn {
                font-size: 21px;
                padding: 14px 24px;
            }

            /* Supporting marketing content */
            .marketing {
                margin: 60px 0;
            }
            .marketing p + h4 {
                margin-top: 28px;
            }
            .carregando         { background-color: #FFF; border: 1px solid #0081c2; text-align: center; width: 250px; height: 70px; top: 50%; left: 50%; margin: -10px 0 0 -125px; padding: 5px; position: fixed; z-index: 9999; display: none; }
            .carregando strong  { font-size: 12px; text-align: center; float: left; display: block; width: 100%; color: black }
        </style>
    </head>
    <body>
        <?php echo $this->element('header_novo_recuperar'); ?>
        <?php echo $this->Session->flash('success', array('element' => 'success')); ?>
        <?php echo $this->Session->flash('error', array('element' => 'error')); ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <a href="#"><strong><i class="glyphicon glyphicon-dashboard"></i> Painel de Informações</strong></a>  
                    <hr>
                    <div class="row">
                        <div class="carregando" style="display: none">
                            <?php echo $this->Html->image('ajax-loader.gif', array('alt' => 'Carregando')); ?>
                            <br /><strong id="msgCarregando">Aguarde carregando...</strong>
                        </div>
                        <?php echo $this->fetch('content'); ?>
                    </div><!--/row-->
                </div><!--/col-span-9-->
            </div>
        </div>
        <?php echo $this->element('footer_novo'); ?>
    </body>
</html>

