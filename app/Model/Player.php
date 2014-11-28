<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Player
 *
<<<<<<< Updated upstream
 * @author Youssef
 */
App::uses('AppModel', 'Model');
App::uses('Security', 'Utility');
class Player extends AppModel{
    //put your code here
    public function newPlayer($email, $password)
    {
        if($this->find('first', array('conditions' => array('email' => $email))))
        {echo "mail deja existant";}
        else
        {
        $newpassword=Security::hash($password,'sha1',true);
        $data = array(
            'email'=> $email,
            'password'=>$newpassword,);
        $this->create();
        $this->save($data);}

    }
    public function connexion($email, $password)
    {
        $newpassword=Security::hash($password,'sha1',true);
        if($this->find('first', array('conditions' => array('email' => $email,'password'=>$newpassword))))
        {
            
            echo "Vous êtes connecté !!";
            
            return $this->field('id',array('email'=>$email));
        }else {echo "connexion échouée !!";return false;}
    }
}
