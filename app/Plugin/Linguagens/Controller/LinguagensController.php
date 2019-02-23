<?php

Class LinguagensController extends LinguagensAppController {

    public $uses = array('Linguagens.Linguagem', 'Datatable', 'Sistema');

    public function index()
    {

        $this->layout = 'novo';
    }

    public function response()
    {
        $this->layout = '';
        $aColumns = array("id", "nome", "produtividade_desen", "produtividade_mel");
        $sTable = 'linguagems';
        $aConditions = ' st_registro = "S" ';
        $this->autoRender = false;
        $output = $this->Datatable->GetData($sTable, $aColumns, $aConditions);
        echo json_encode($output);
    }

    public function add($id = null)
    {
        $this->layout = 'novo';
        if ($this->request->is('post') || $this->request->is('put')) {

            $validLinguagem = $this->Linguagem->find('first', array('conditions' => array('nome' => $this->data['Linguagem']['nome'], 'st_registro' => 'S')));
            if (!empty($validLinguagem) && $validLinguagem['Linguagem']['id'] != $id) {
                $this->_flash('O nome dessa Linguagem já existe. Tente novamente!', 'error');
                return;
            }

            if (!empty($this->data['Linguagem']['id'])) {
                $guardaLinguagem = $this->Linguagem->find('first', array('conditions' => array('id' => $this->data['Linguagem']['id'], 'st_registro' => 'S')));
            }

            if ($this->Linguagem->save($this->request->data)) {
                if (empty($this->data['Linguagem']['id'])) {
                    CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} adicionou a Linguagem, Nome:\'' . $this->request->data['Linguagem']['nome'] . '\',' . ' Prod. Desenvolvimento:\'' . $this->request->data['Linguagem']['produtividade_desen'] . '\', Prod. Melhoria:\'' . $this->request->data['Linguagem']['produtividade_mel'] . '\'.', array('linguagem'));
                    $this->_flash('Linguagem foi salva com sucesso.', 'success', '/linguagens/linguagens/');
                } else {
                    CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} alterou a Linguagem, Nome:\'' . $guardaLinguagem['Linguagem']['nome'] . '\' para \'' . $this->request->data['Linguagem']['nome'] . '\',' . ' Prod. Desenvolvimento:\'' . $guardaLinguagem['Linguagem']['produtividade_desen'] . '\' para \'' . $this->request->data['Linguagem']['produtividade_desen'] . '\', Prod. Melhoria:\'' . $guardaLinguagem['Linguagem']['produtividade_mel'] . '\' para \'' . $this->request->data['Linguagem']['produtividade_mel'] . '\'.', array('linguagem'));
                    $this->_flash('Linguagem foi alterada com sucesso.', 'success', '/linguagens/linguagens/');
                }
            } else {
                CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu adicionar a Linguagem.', array('linguagem'));
                $this->_flash('Linguagem não foi salva.', 'error', '/linguagens/linguagens/');
            }
        } elseif ($id != null) {
            $linguagem = $this->Linguagem->find('first', array('conditions' => array('id' => $id, 'st_registro' => 'S')));

            if (empty($linguagem)) {
                $this->_flash('Linguagem não existente no sistema.', 'error', '/linguagens/linguagens/');
            }
            $this->Linguagem->id = $id;
            $this->request->data = $this->Linguagem->read();
        }
    }

    public function delete($id)
    {
        $this->Linguagem->id = $id;

        $linguagem = $this->Linguagem->find('first', array('conditions' => array('id' => $id, 'st_registro' => 'S'), 'fields' => 'nome'));
        if (empty($linguagem)) {
            $this->_flash('Linguagem não existente no sistema.', 'error', '/linguagens/linguagens/');
        }
        $integridade = $this->Sistema->find('first', array('conditions' => array('Sistema.linguagem_id' => $id, 'Sistema.st_registro' => 'S'), 'fields' => array('id')));
        if (!empty($integridade)) {
            $this->_flash('Linguagem não foi deletada pois está vinculada a um Sistema.', 'error', '/linguagens/linguagens/');
        }
        $this->Linguagem->read('st_registro', $id);
        $this->Linguagem->set(array(
            'st_registro' => 'N',
        ));
        if ($this->Linguagem->save()) {
            CakeLog::write('sucesso', 'Usuário {' . $this->Session->read('Auth.User.username') . '} deletou a Linguagem \'' . $linguagem['Linguagem']['nome'] . '\'.', array('linguagem'));
            $this->_flash('Linguagem foi deletada com sucesso.', 'success', '/linguagens/linguagens/');
        } else {
            CakeLog::write('erro', 'Usuário {' . $this->Session->read('Auth.User.username') . '} não conseguiu deletar a Linguagem \'' . $linguagem['Linguagem']['nome'] . '\'.', array('linguagem'));
            $this->_flash('Linguagem não foi deletada.', 'error', '/linguagens/linguagens/');
        }
    }

}
