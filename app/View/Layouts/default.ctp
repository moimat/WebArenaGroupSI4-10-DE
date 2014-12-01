<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>

            <?php echo $this->fetch('title'); ?>
        </title>
        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css('bootstrap.min.css');
        echo $this->Html->css('bootstrap.css');
        echo $this->Html->css('bootstrap.css.map');
        echo $this->Html->css('bootstrap-theme.css');
        echo $this->Html->css('bootstrap-theme.css.map');
        echo $this->Html->css('bootstrap-theme.min.css');
        echo $this->Html->css('jquery.dataTables.min.css');
        echo $this->Html->css('webarena');
        
        echo $this->Html->script('jquery.min');
        echo $this->Html->script('jquery.dataTables.min');
       
        echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min');
        echo $this->Html->script('bootstrap.min');
        echo $this->Html->script('bootstrap');
        echo $this->Html->script('npm');
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body>
        <div id="header">
            <!-- Static navbar -->
            <nav class="navbar navbar-inverse navbar-static-top" role="navigation">

                <div class="container">
                    <div class="navbar-header">
                        <a class="navbar-brand">
                            <span class="glyphicon glyphicon-globe"></span>
                            WebArena
                        </a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li>
                                <?php echo $this->Html->link('<span></span> Accueil', '/', array('class' => 'glyphicon glyphicon-home', 'escape' => false)); ?>                                             
                            </li>
                            <li class="<?php echo (!empty($this->params['action']) && ($this->params['action'] == 'sight') ) ? 'active' : 'inactive' ?>">
                                <?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"> Vision </i>', array('controller' => 'Arena', 'action' => 'sight'), array('escape' => false)); ?>
                            </li>
                            <li class="<?php echo (!empty($this->params['action']) && ($this->params['action'] == 'character') ) ? 'active' : 'inactive' ?>">
                                <?php echo $this->Html->link('<i class="glyphicon glyphicon-user"> Personnage </i>', array('controller' => 'Arena', 'action' => 'character'), array('escape' => false)); ?>
                            </li>
                            <li class="<?php echo (!empty($this->params['action']) && ($this->params['action'] == 'diary') ) ? 'active' : 'inactive' ?>">
                                <?php echo $this->Html->link('<i class="glyphicon glyphicon-book"> Journal </i>', array('controller' => 'Arena', 'action' => 'diary'), array('escape' => false)); ?>
                            </li>
                            <li class="<?php echo (!empty($this->params['action']) && ($this->params['action'] == 'login') ) ? 'active' : 'inactive' ?>">
                                <?php echo $this->Html->link('<i class="glyphicon glyphicon-log-in"> Connexion </i>', array('controller' => 'Arena', 'action' => 'login'), array('escape' => false)); ?>
                            </li>
                            <li><?php echo $this->Form->create('deco', array('class' => 'form_inline formClass', 'role' => 'form')); ?>
                                <button class="btn btn-danger" controller="Arena" action="login" type=direction name=data[deco] value="deco">
                                    <span class="glyphicon glyphicon-log-out"> Déconnexion</span> 
                                </button>
                                <?php echo $this->Form->end(); ?></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>

        <div id="content">

            <?php echo $this->Session->flash(); ?>

            <?php echo $this->fetch('content'); ?>
        </div>

        <div id="footer">
            <div class="navbar navbar-inverse navbar-fixed-bottom ">
                <div class="container">
                    <div class="navbar-header">
                        <a class="navbar-brand">
                            <span class="glyphicon glyphicon-book"></span>
                            Projet WebArena Group SI4-10-DE
                        </a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li>
                                <?php echo $this->Html->link('<span></span> BOUCON Matthieu', 'mailto:boucon@ece.fr', array('class' => 'glyphicon glyphicon-envelope', 'escape' => false)); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link('<span></span> ELKORJI Youssef', 'mailto:elkorji@ece.fr', array('class' => 'glyphicon glyphicon-envelope', 'escape' => false)); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link('<span></span> GRIERE Nicolas', 'mailto:griere@ece.fr', array('class' => 'glyphicon glyphicon-envelope', 'escape' => false)); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link('<span></span> LY Pascal', 'mailto:ly@ece.fr', array('class' => 'glyphicon glyphicon-envelope', 'escape' => false)); ?>
                            </li>
                            <li>
                                <?php
                                echo $this->Html->link($this->Html->image('github-icon.png', array('width' => '24', 'height' => '24')) . __(' Repository Log'), 'https://github.com/moimat/WebArenaGroupSI4-10-DE/commits/master', array('escape' => false));
                                ?>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php // echo $this->element('sql_dump');    ?>
    </body>
</html>
