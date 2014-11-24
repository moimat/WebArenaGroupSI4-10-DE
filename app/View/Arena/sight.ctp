<table class= "table table-striped table-bordered">
    <thead>
        <tr>
            <?php		// pour chaque colonne (de la ligne)
                        for ($j=1; $j<=15; $j++) 
                        { 
        ?>		<th>
        <?php			// -------------------------
                                // DONNEES A AFFICHER dans la cellule
                                echo $j; // CONTENU de la CELLULE (exemple)
                                // -------------------------
        ?>		</th>
        <?php	} // end for
        ?>
        </tr>
    </thead>
    
    <tbody>
    <?php
            // pour chaque ligne
            for ($i=1; $i<=10; $i++) 
            { 
    ?>
            <tr>
    <?php		// pour chaque colonne (de la ligne)
                    for ($j=1; $j<=15; $j++) 
                    { 
    ?>		<td>
    <?php			// -------------------------
                            // DONNEES A AFFICHER dans la cellule
                            echo 'ligne '. $i .', colonne '. $j; // CONTENU de la CELLULE (exemple)
                            // -------------------------
    ?>		</td>
    <?php	} // end for
    ?>
            </tr>
    <?php
            } // end for
    ?>
    </tbody>
</table>

<?php
echo $this->Form->create('Fighteratk',array('class'=>'form_inline','role'=>'form'));
echo $this->Form->input('direction',array('class'=>'form-control','options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east'));
echo $this->Form->input('id', array('label' => 'id','class'=>'form-control'));
echo $this->Form->end(array('label'=>'Attack','div'=>false, 'class'=>'btn btn-primary')); 

echo $this->Form->create('Fightermove',array('class'=>'form_inline','role'=>'form'));
echo $this->Form->input('direction',array('class'=>'form-control','options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east'));
echo $this->Form->input('id', array('label' => 'id','class'=>'form-control'));
echo $this->Form->end(array('label'=>'Move','div'=>false, 'class'=>'btn btn-primary')); 
?>

<?php $this->assign('title', 'Sight');?>
<?php pr($raw); ?>