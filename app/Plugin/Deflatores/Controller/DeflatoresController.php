<?php

Class DeflatoresController extends DeflatoresAppController {

    public $uses = array('Deflatores.Deflatore');

    public function index()
    {
        $this->layout = 'novo';
    }

    public function add($id = null)
    {
        $this->layout = 'novo';
        if ($this->request->is('post') || $this->request->is('put')) {

//            if ($this->request->data['Deflatore']['fator'] < '0.65' || $this->request->data['Deflatore']['fator'] > '1.35') {
//                $this->_flash('O valor do Fator de Ajuste deve ser entre 0,65 e 1,35. Não foi possível salvar!', 'error');
//                return;
//            }
      
           if(!empty($this->data['Deflatore']['id'])){
            	$guardaDeflatore = $this->Deflatore->find('first', array('conditions' => array('id' => $this->data['Deflatore']['id'])));
            }
      
            if ($this->Deflatore->save($this->request->data)) {
                CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} alterou o valor dos Deflatores para, Funcionalidades incluídas: {' . $guardaDeflatore['Deflatore']['deflator_inc'] . '} para {'.$this->request->data['Deflatore']['deflator_inc'].'} ,  Funcionalidades alteradas: {' . $guardaDeflatore['Deflatore']['deflator_alt'] . '}  para {'.$this->request->data['Deflatore']['deflator_alt'].'} ,  Funcionalidades excluídas: {' .$guardaDeflatore['Deflatore']['deflator_exc']. '} para {'.$this->request->data['Deflatore']['deflator_exc'].'}, Fator de ajuste: {' . $guardaDeflatore['Deflatore']['fator'] . '} para {'.$this->request->data['Deflatore']['fator'].'} . ', array('deflator'));
                $this->_flash('Deflatores foram salvos com sucesso.', 'success', '/deflatores/deflatores/add');
            } else {
                CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu alterar o valor dos Deflatores.', array('deflator'));
                $this->_flash('Deflatores não foram salvos .', 'error', '/deflatores/deflatores/add');
            }
        } else {
            $this->Deflatore->id = '1';
            
            if ($this->Deflatore->exists()) {
                $this->request->data = $this->Deflatore->read();
            }
        }
    }
}
