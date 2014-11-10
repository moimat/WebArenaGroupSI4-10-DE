<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Fighter
 *
 * @author matthieu
 */

App::uses('AppModel', 'Model');

class Fighter extends AppModel {

    public $displayField = 'name';

    public $belongsTo = array(

        'Player' => array(

            'className' => 'Player',

            'foreignKey' => 'player_id',

        ),

   );
    
   public function doMove($fighterId, $direction){
       if($direction='nord') 
               $coor=$this->fighters->read(null,1);
               
               echo $coor;
               $this->fighters->set('coordinate_x',$coor+1);
               $this->fighters->save();
       
   }

}
