<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * @author Nicolas
 */

class Surrounding extends AppModel {

    private function createSurrounding($type, $randCoordX, $randCoordY) {
        // Give new Id to row
        $id = $this->find('count');
        $id++;

        $data = array(
            'id' => $id,
            'type' => $type,
            'coordinate_x' => $randCoordX,
            'coordinate_y' => $randCoordY
        );

        // prepare the model for adding a new entry
        $this->create();

        // save the data
        $this->save($data);
    }

    public function createArena() {

        // Delete previous datatable surroundings
        $this->deleteAll(array('1 = 1'));

        // Repopulate surroundings datatable
        for ($i = 0; $i < 45; $i++) {

            // Generate random positions of surroundings
            $randCoordX = rand(BORDER_WEST, BORDER_EAST);
            $randCoordY = rand(BORDER_NORTH, BORDER_SOUTH);

            // Create one column for every 10 cells
            if ($i < 15) {
                $this->createSurrounding('colonne', $randCoordX, $randCoordY);
            }

            // Create one invisible monster for every 10 cells
            if ($i >= 15 && $i < 30) {
                $this->createSurrounding('monstre', $randCoordX, $randCoordY);
            }

            // Create one invisible trap for every 10 cells
            if ($i >= 30) {
                $this->createSurrounding('piege', $randCoordX, $randCoordY);
            }
        }
    }
}
