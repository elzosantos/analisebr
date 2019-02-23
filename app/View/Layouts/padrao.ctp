<!DOCTYPE html>
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>AnáliseBr</title>
        <?php
        echo $this->Html->meta('icon', '/img/favicon.png', array('type' => 'png'));
        //echo $this->Html->meta('icon', $this->Html->url('/img/favicon.png'));
        echo $this->Html->css('bootstrap');
        echo $this->Html->css('custom');
        echo $this->Html->css('jquery-ui-1.8.4.custom');
        echo $this->Html->css('table_jui');
        echo $this->Html->css('tables');
        echo $this->Html->css('bootstrap-responsive');
        echo $this->Html->script('jquery');
        echo $this->Html->script('jquery-ui-1.10.3.custom');
        echo $this->Html->script('bootstrap');
        echo $this->Html->script('flashMessenger');
        echo $this->Html->script('jquery.dataTables.min');
        echo $this->Html->script('jquery.dataTables.columnFilter');
        echo $this->Html->script('geral');
        echo $this->Html->script('jquery.maskedinput');
        echo $this->Html->script('bootbox');
        ?>   

        <style type="text/css">
            body {
                padding-top: 20px;
                padding-bottom: 40px;
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
            .carregando         { background-color: #FFF; border: 1px solid #0081c2; text-align: center; width: 250px; height: 70px; top: 50%; left: 50%; margin: -10px 0 0 -125px; position: fixed; z-index: 9999; display: none; }
            .carregando strong  { font-size: 12px; text-align: center; float: left; display: block; width: 100%; color: black }
        </style>
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="../assets/js/html5shiv.js"></script>
        <![endif]-->
    </head>


    <body class="default">

        <div class="container-narrow">
            <div class="carregando" style="display: none">
                <?php echo $this->Html->image('ajax-loader.gif', array('alt' => 'Carregando')); ?>
                <br /><strong id="msgCarregando">Aguarde carregando...</strong>
            </div>
            <?php echo $this->element('header_padrao'); ?>
            <?php echo $this->Session->flash('auth'); ?>
            <?php echo $this->Session->flash(); ?>

            <?php echo $this->fetch('content'); ?>

            <div id="footer-container">
                <div id="footer">
                    <?php echo $this->element('footer_padrao'); ?>
                </div>
            </div>


        </div>
    </body>
</html>



