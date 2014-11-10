<?php 

App::uses('AppController', 'Controller');

/**
 * Main controller of our small application
 *
 * @author ...
 */
class ArenaController extends AppController
{

    public $uses = array('Player', 'Fighter', 'Event');
    /**
     * index method : first page
     *
     * @return void
     */
    public function index()
    {
        $this->set('myname', "Matthieu Boucon");
    }
    
    public function login()
    {
        
    }
    
    public function character()
    {
        $this->set('raw',$this->Fighter->findById(1));
    }
    
    public function diary()
    {
        $this->set('raw',$this->Event->find());
    }
    
    public function sight()
    {
        if ($this->request->is('post'))       
{            pr($this->request->data);        }
        $this->set('raw',$this->Fighter->find('all'));  
    }

}
?>