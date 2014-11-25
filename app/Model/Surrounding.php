<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * @author Nicolas
 */

class Surrounding extends AppModel {

    public $displayField = 'name';

    public function createSurrounding($type, $randCoordX, $randCoordY) {
        // Give new Id to row
        $id = $this->find('count');
        $id++;

        $data = array(
            'id' => $id,
            'type' => $newtype,
            'coordinate_x' => $randCoordX,
            'coordinate_y' => $randCoordY
        );

        // prepare the model for adding a new entry
        $this->create();

        // save the data
        $this->save($data);
    }

}
