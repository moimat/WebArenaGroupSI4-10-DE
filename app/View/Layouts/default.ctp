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
                echo $this->Html->css('cake.generic');
                echo $this->Html->css('webarena');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>

                            <!-- Static navbar -->
                            <nav class="navbar navbar-default navbar-static-top" role="navigation">

                                <div class="container">
                                    <div class="navbar-header">
                                        <a class="navbar-brand" href="#">
                                            WebArena Home
                                        </a>
                                    </div>
                                    <div id="navbar" class="navbar-collapse collapse">
                                        <ul class="nav navbar-nav">
                                            <li class="active">
                                                <a href="#">
                                                    Home
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#about">
                                                    Vision
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#contact">Personnage</a>
                                            </li>
                                            <li>
                                                <a href="#contact">Journal</a>
                                            </li>
                                            <li>
                                                <a href="#contact">Se Connecter </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <!--
                            <?php 
                                echo $this->Html->link('Accueil ', '/');
                                echo $this->Html->link('Vision ', array('controller' => 'Arena', 'action' => 'sight')); 
                                echo $this->Html->link('Personnage ', array('controller' => 'Arena', 'action' => 'character'));
                                echo $this->Html->link('Journal ', array('controller' => 'Arena', 'action' => 'diary'));
                                echo $this->Html->link('Se Connecter ', array('controller' => 'Arena', 'action' => 'login'));
                            ?>
                            -->

		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
            
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
				);
			?>
			<p>
                            Projet WebArena Group SI4-10-DE<br>
                            <br>
                            BOUCOU Matthieu<br>
                            EL KORJI Youssef<br>
                            GRIERE Nicolas<br>
                            LY Pascal<br>
                            <br>
				<?php echo $cakeVersion; ?>
			</p>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
