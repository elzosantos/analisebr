<!DOCTYPE html>
<html lang="en">
    <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>APFBr - Sistema de Ponto de Função</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <?php
        echo $this->Html->meta('icon', '/img/favicon.png', array('type' => 'png'));
        echo $this->Html->css('bootstrap_land');
        echo $this->Html->css('landing-page');
        echo $this->Html->script('jquery-1.10.2');
        echo $this->Html->script('alertify.min');
        echo $this->Html->css('alertify.core');
        echo $this->Html->css('alertify.default');
        ?>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-collapse" role="navigation">
            <div class="container">
                <?php echo $this->Session->flash('success', array('element' => 'success')); ?>
                <?php echo $this->Session->flash('error', array('element' => 'error')); ?>
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <?php echo $this->Html->image('apfbr.png'); ?> 
                </div>
                <div class="navbar-right">
                    <!--<ul class="nav navbar-nav">-->
                        <?php echo $this->fetch('content'); ?>
                  
<!--                    </ul>
                </div>-->
            </div>
        </nav>
        <div class="intro-header">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="intro-message">
                            <h1>APFBr</h1>
                            <h3>Sistema de Análise Ponto de Função</h3>
                            <hr class="intro-divider">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <div class="container">
                <?php echo $this->element('footer_padrao'); ?>
                <input class="revisao" type="hidden" value="#rv.2015.001"/>
            </div>
        </footer>
    </body>
</html>
