<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');
App::uses('AuthComponent', 'Controller/Component');
App::uses('CakeLogInterface', 'Log');

App::import('Core', 'l10n');

App::import('Vendor', 'Dominio/TipoImpacto');
App::import('Vendor', 'Dominio/MetodoContagem');
App::import('Vendor', 'Dominio/TipoFuncionalidade');
App::import('Vendor', 'Dominio/TipoContagem');
App::import('Vendor', 'Dominio/TipoComplexidade');
App::import('Vendor', 'Dominio/Perfil');
App::import('Vendor', 'Dominio/Tdtrar');
App::import('Vendor', 'Dominio/TipoAnalise');
App::import('Vendor', 'Dominio/ListaAnalise');
App::import('Vendor', 'Dominio/TipoImpactoRelatorio');
App::import('Vendor', 'Dominio/Tipo');  

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $uses = array('Baseline');
    public $components = array(
        'Session',
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'users',
                'action' => 'login',
                'plugin' => 'users'
            ),
            'authError' => "Você não pode acessar essa página.",
            'authenticate' => array(
                AuthComponent::ALL => array(
                    'userModel' => 'User',
                    'fields' => array(
                        'username' => 'username',
                    ),
                    'scope' => array(
                        'User.st_registro' => 'S',
                    ),
                ),
//                'Facebook.Oauth',
                'Form'
            ),
            'authorize' => array(
                AuthComponent::ALL => array('actionPath' => 'controllers/', 'userModel' => 'Role'),
                'Actions'
            ),
            'loginRedirect' => array(
                'controller' => 'painel',
                'action' => 'index',
                'plugin' => 'painel',
            ),
            'logoutRedirect' => array(
                'plugin' => 'users',
                'controller' => 'users',
                'action' => 'login'
            )
        ),
        'Acl',
        'RequestHandler'
    );

    public function beforeFilter() {

        if ($this->Auth->user()) {
            $roleId = $this->Auth->user('role_id');
        } else {
            $roleId = 4;
        }
        $aro = $this->Acl->Aro->find('first', array(
            'conditions' => array(
                'Aro.model' => 'Role',
                'Aro.foreign_key' => $roleId
            )
        ));
        $aroId = $aro['Aro']['id'];


        $thisControllerNode = $this->Acl->Aco->node('controllers/' . $this->name);

        if ($thisControllerNode) {
            $thisControllerActions = $this->Acl->Aco->find('list', array(
                'conditions' => array(
                    'Aco.parent_id' => $thisControllerNode['0']['Aco']['id']
                ),
                'fields' => array(
                    'Aco.id',
                    'Aco.alias'
                ),
                'recursive' => '-1'
            ));
            $thisControllerActionsIds = array_keys($thisControllerActions);
            $allowedActions = $this->Acl->Aco->Permission->find('list', array(
                'conditions' => array(
                    'Permission.aro_id' => $aroId,
                    'Permission.aco_id' => $thisControllerActionsIds,
                    'Permission._create' => 1,
                    'Permission._read' => 1,
                    'Permission._update' => 1,
                    'Permission._delete' => 1,
                ),
                'fields' => array(
                    'id',
                    'aco_id'
                ),
                'recursive' => '-1'
            ));
            $allowedActionsIds = array_values($allowedActions);
        }
        $allow = array();
        if (isset($allowedActionsIds) && is_array($allowedActionsIds) && count($allowedActionsIds)) {
            foreach ($allowedActionsIds as $i => $aId) {
                $allow[] = $thisControllerActions[$aId];
            }
        }


        $this->Auth->allowedActions = $allow;
    }

    protected function _flash($message, $type = 'success', $url = false) {
        if ($type == 'success') {
            $this->Session->setFlash($message, 'success', array(), 'success');
        } else if ($type == 'error') {
            $this->Session->setFlash($message, 'error', array(), 'error');
        }
        if ($url) {
            $this->redirect($url);
        }
    }

    function controlaBaseline($dataBaseline, $tipoAnalise) {
        if ($tipoAnalise == 'I') {
            if (isset($dataBaseline['Funcionalidade'])) {
                $index = 'Funcionalidade';
            } else {
                $index = 'Analise';
            }
            $updateBases = $this->Baseline->find('all', array(
                'conditions' => array(
                    'st_ultimo_registro' => 'S',
                    'sistema_id' => $dataBaseline[$index]['sistema_id']
            )));


            if (!empty($updateBases)) {
                foreach ($updateBases as $key => $value) {
                    $value['Baseline']['st_ultimo_registro'] = 'N';
                    $this->Baseline->save($value);
                }
            }
            $baseline['Baseline']['user_id'] = $dataBaseline[$index]['user_id'];
            $baseline['Baseline']['analise_id'] = $dataBaseline[$index]['analise_id'];
            $baseline['Baseline']['sistema_id'] = $dataBaseline[$index]['sistema_id'];
            $baseline['Baseline']['tipo'] = $tipoAnalise == \Dominio\TipoAnalise::$INM ? \Dominio\TipoAnalise::$INM : \Dominio\TipoAnalise::$UST;
            $baseline['Baseline']['st_ultimo_registro'] = $dataBaseline[$index]['st_ultimo_registro'];


            $this->Baseline->save($baseline);
        } else if ($tipoAnalise == 'U') {

            $updateBases = $this->Baseline->find('first', array(
                'conditions' => array(
                    'st_ultimo_registro' => 'S',
                    'sistema_id' => $dataBaseline['Analiust']['sistema_id']
            )));

            $baseline['Baseline']['id'] = !empty($updateBases) ? $updateBases['Baseline']['id'] : null;
            $baseline['Baseline']['user_id'] = $dataBaseline['Analiust']['user_id'];
            $baseline['Baseline']['analise_id'] = $dataBaseline['Analiust']['analise_id'];
            $baseline['Baseline']['sistema_id'] = $dataBaseline['Analiust']['sistema_id'];
            $baseline['Baseline']['tipo'] =  'U';
            $baseline['Baseline']['st_ultimo_registro'] = 'S';
            $this->Baseline->save($baseline);
        }
    }

}
