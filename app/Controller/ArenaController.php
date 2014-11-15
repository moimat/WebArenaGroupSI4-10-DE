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
        if ($this->request->is('post'))       
        {
            if(isset($this->request->data['viewchar']))
            {
                $this->set('raw',$this->Fighter->findById($this->request->data['viewchar']['id']));
            }
        }
    }
    
    public function diary()
    {
        $this->set('raw',$this->Event->find());
    }
    
    public function sight()
    {
        if ($this->request->is('post'))       
{            pr($this->request->data);        }
        $this->Fighter->doMove(1, $this->request->data['Fightermove']['direction']);
        $this->set('raw',$this->Fighter->find('all'));  
    }

}
?>