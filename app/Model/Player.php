<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Player
 *
 * @author Youssef
 */
App::uses('AppModel', 'Model');
class Player extends AppModel{
    //put your code here
    public function newPlayer($email, $password)
    {
        $data = array(
            'email'=> $email,
            'password'=>$password,);
        $this->create();
        $this->save($data);
    }
}
