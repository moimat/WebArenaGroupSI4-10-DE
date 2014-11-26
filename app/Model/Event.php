<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

class Event extends AppModel {

    public function createEvent($coordX, $coordY, $date, $name) {
        // Give new Id to row
        $id = $this->find('count');
        $id++;

        $data = array(
            'coordinate_x' => $coordX,
            'coordinate_y' => $coordY,
            'date' => $date,
            'id' => $id,
            'name' => $name,
        );

        // prepare the model for adding a new entry
        $this->create();

        // save the data
        $this->save($data);
    }

}
