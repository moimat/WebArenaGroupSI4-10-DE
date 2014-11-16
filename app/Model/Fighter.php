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
    
public function doMove($fighterId, $direction)
    {
        // récupérer la position et fixer l'id de travail
        $datas = $this->read(null, $fighterId);
        //@todo empêcher le joueur de sortir des limites du terrain
        //@todo empêcher le joueur de se déplacer sur une case occupée
        // falre la modif
        if ($direction == 'north')
            $this->set('coordinate_x', $datas['Fighter']['coordinate_x'] + 1);
        elseif ($direction == 'south')
            $this->set('coordinate_x', $datas['Fighter']['coordinate_x'] - 1);
        elseif ($direction == 'east')
            $this->set('coordinate_y', $datas['Fighter']['coordinate_y'] + 1);
        elseif ($direction == 'west')
            $this->set('coordinate_y', $datas['Fighter']['coordinate_y'] - 1);
        else
            return false;

        // sauver la modif
        $this->save();
        return true;
    }
    
    public function lvlUp($fighterId)
    {
        $datas = $this->read(null, $fighterId);
        $this->set('level', $datas['Fighter']['level'] + 1);
        $this->save();
    }
    

    public function doAttack($fighterId, $direction)
    {
        // récupérer la position et fixer l'id de travail
        $joueur = $this->read(null, $fighterId);
        $cible = $this->read(null, 2);
        // Selon la direction chercher un fighter dans sa position+vue
        if ($direction == 'north' && $cible['Fighter']['coordinate_y']==$joueur['Fighter']['coordinate_y'] 
                && $cible['Fighter']['coordinate_x']==$joueur['Fighter']['coordinate_x']+1 ){
            $this->set('current_health', $cible['Fighter']['current_health'] - $joueur['Fighter']['skill_strength']);     
        }
            
        elseif ($direction == 'south' && $joueur['Fighter']['coordinate_y']==$cible['Fighter']['coordinate_y'] 
             && $cible['Fighter']['coordinate_x']==$joueur['Fighter']['coordinate_x']-1 ){
            $this->set('current_health', $cible['Fighter']['current_health'] - $joueur['Fighter']['skill_strength']);     
        }
            
        elseif ($direction == 'west' && $joueur['Fighter']['coordinate_x']==$cible['Fighter']['coordinate_x'] 
              && $cible['Fighter']['coordinate_y']==$joueur['Fighter']['coordinate_y']-1 ){
            $this->set('current_health', $cible['Fighter']['current_health'] - $joueur['Fighter']['skill_strength']);     
        }
            
        elseif ($direction == 'eastt' && $joueur['Fighter']['coordinate_x']==$cible['Fighter']['coordinate_x'] 
            && $cible['Fighter']['coordinate_y']==$joueur['Fighter']['coordinate_y']+1 ){
            $this->set('current_health', $cible['Fighter']['current_health'] - $joueur['Fighter']['skill_strength']);     
        }
            
        else
            return false;

        // sauver la modif
        $this->save();
        return true;
    }
    
  public function fileUpload($id){

            $repertoire = "img/Avatars/";
           
            
            
             $image = $repertoire . 'avatar-' . $id . '.jpg' ;
            
 
            print_r ($_FILES['data']['tmp_name']['Upload']['Avatar']);
    if (move_uploaded_file($_FILES['data']['tmp_name']['Upload']['Avatar'], WWW_ROOT.$image)) {
        echo "The file ". basename( $_FILES["data"]["name"]['Upload']['Avatar']). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
  }
  
  public function createCharacter($newName)
    {       
        // Give new Id to row
        $id= $this->find('count');
        $id++;


        $data = array(
            'id'=> $id,
            'name' => $newName,
            'coordinate_x' => 1,
            'coordinate_y' => 1,
            'level' => 1,
            'xp' => 0,
            'skill_sight' => 1,
            'skill_strength' => 1,
            'skill_health' => 3,
            'current_health' => 3,
                );

        // prepare the model for adding a new entry
        $this->create();

        // save the data
        $this->save($data);
    }
}
