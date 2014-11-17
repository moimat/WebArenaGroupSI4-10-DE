<?php 

App::uses('AppController', 'Controller');

/**
 * APIs controller
 *
 * @author Nicolas
 */
class ApisController extends AppController
{ 
    public $uses = array('Player', 'Fighter', 'Event');
    
     public function fighterview($id=1){
         $this->layout = 'ajax';
         $this->set('datas', $this->Fighter->findById($id));
     } 
     
     public function domove($id=1){
         $this->layout = 'ajax';
         $this->set('datas', $this->Fighter->findById($id));
     }
     
     public function doattack($id=1){
         $this->layout = 'ajax';
         $this->set('datas', $this->Fighter->findById($id));
     }
}
?>

