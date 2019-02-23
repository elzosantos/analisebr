<?php

class Datatable extends AppModel {

    public function GetData($sTable, $aColumns, $aConditions = null, $lista = null, $id_equipe = null) {

        /*         * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * Easy set variables
         */

        /* Array of database columns which should be read and sent back to DataTables. Use a space where
         * you want to insert a non-database field (for example a counter or static image)
         */
        $aColumns = $aColumns;

        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "id";

        /* DB table to use */
        $sTable = $sTable;




        App::uses('ConnectionManager', 'Model');
        $dataSource = ConnectionManager::getDataSource('default');

        /* Database connection information */
        $gaSql['user'] = $dataSource->config['login'];
        $gaSql['password'] = $dataSource->config['password'];
        $gaSql['db'] = $dataSource->config['database'];
        $gaSql['server'] = $dataSource->config['host'];


        /*         * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP server-side, there is
         * no need to edit below this line
         */

        /*
         * Local functions
         */

        function fatal_error($sErrorMessage = '') {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
            die($sErrorMessage);
        }

        /*
         * MySQL connection
         */
        if (!$gaSql['link'] = mysql_pconnect($gaSql['server'], $gaSql['user'], $gaSql['password'])) {
            fatal_error('Could not open connection to server');
        }

        if (!mysql_select_db($gaSql['db'], $gaSql['link'])) {
            fatal_error('Could not select database ');
        }


        /*
         * Paging
         */
        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " .
                    intval($_GET['iDisplayLength']);
        }


        /*
         * Ordering
         */
        $sOrder = "";



        if (isset($_GET['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder .= "`" . $aColumns[intval($_GET['iSortCol_' . $i])] . "` " .
                            ($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
                }
            }

            $sOrder = substr_replace($sOrder, "", -2);

            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }


        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */


        $sWhere = "";
        $sWhereConditions = "";

//
//        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
//            $sWhere = "WHERE (";
//            for ($i = 0; $i < count($aColumns); $i++) {
//                $sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . mysql_real_escape_string($_GET['sSearch']) . "%' OR ";
//            }
//            $sWhere = substr_replace($sWhere, "", -3);
//            $sWhere .= ')';
//        }

   

        /* Individual column filtering */
        for ($i = 0; $i < count($aColumns); $i++) {
             
            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '' && $_GET['sSearch_' . $i] != '0') {
                
                if ($sWhere == "") {
                    $sWhere = "WHERE ";
                } else {
                    $sWhere .= " AND ";
                }
                if ($lista == 'lista_analises') {
                   if ($i == 2 && $_GET['sSearch_2'] != '0') {
                       $sWhere .= " ana.sistema_id = " . $_GET['sSearch_2'];
                   }
                   
                   if ($i == 3 && $_GET['sSearch_3'] != '0') {
                       $sWhere .= " ana.nu_demanda LIKE '%" . mysql_real_escape_string($_GET['sSearch_3']) . "%' " ;
                   }
                   
                   if ($i == 4 && $_GET['sSearch_4'] != '0') { 
                        $sWhere .= " ana.user_id = " . $_GET['sSearch_4'];
                   }
                   
                   if ($i == 5 && $_GET['sSearch_5'] != '0' && $_GET['sSearch_5'] == '999999') {
                        $sWhere .= " ana.equipe_id is null ";
                   }elseif($i == 5 && $_GET['sSearch_5'] != '0'){
                        $sWhere .= " ana.equipe_id = " .  $_GET['sSearch_5'];
                   }
                   
                   if ($i == 6 && $_GET['sSearch_6'] != '0') { 
                        $sWhere .= " ana.tipo_contagem = " . $_GET['sSearch_6'];
                   }
                
                   if ($i == 10) {
                       $data_ini = $_GET['sSearch_10'];
                       $arrData = split('a', $data_ini); 
                       $sWhere .= "ana.created between '" . $arrData[0] . "' AND '" . $arrData[1] . "' ";
                   } 
                }elseif ($lista === 'lista_analises_usts') {
                    
                   if ($i == 2 && $_GET['sSearch_2'] != '0') {
                       $sWhere .= " ana.sistema_id = " . $_GET['sSearch_2'];
                   }
                   
                   if ($i == 3 && $_GET['sSearch_3'] != '0') {
                       $sWhere .= " ana.nu_demanda LIKE '%" . mysql_real_escape_string($_GET['sSearch_3']) . "%' " ;
                   }
                   
                   if ($i == 4 && $_GET['sSearch_4'] != '0') { 
                        $sWhere .= " ana.user_id = " . $_GET['sSearch_4'];
                   }
                   
                   if ($i == 5 && $_GET['sSearch_5'] != '0' && $_GET['sSearch_5'] == '999999') {
                        $sWhere .= " ana.equipe_id is null ";
                   }elseif($i == 5 && $_GET['sSearch_5'] != '0'){
                        $sWhere .= " ana.equipe_id = " .  $_GET['sSearch_5'];
                   }
                   
                   if ($i == 6 && $_GET['sSearch_6'] != '0') { 
                        $sWhere .= " ana.metodo_contagem = " . $_GET['sSearch_6'];
                   }
                
                   if ($i == 10) {
                       $data_ini = $_GET['sSearch_8'];
                       $arrData = split('a', $data_ini); 
                       $sWhere .= "ana.created between '" . $arrData[0] . "' AND '" . $arrData[1] . "' ";
                   } 
                } 
                else {
                    $sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . mysql_real_escape_string($_GET['sSearch_' . $i]) . "%' ";
                }
            }
        }



     
        if (!empty($aConditions) && empty($sWhere)) {
            $sWhereConditions = "WHERE (" . $aConditions . " )";
        }

        /*
         * SQL queries
         * Get data to display
         */



        if ($lista == 'lista_analises_usts') {



            if (empty($sWhere)) {
                $sWhere = "WHERE ana.st_registro = 'S' " . $aConditions;
            } else {

                $sWhere .= " AND ana.st_registro = 'S' ";
            }
            $sQuery = "SELECT SQL_CALC_FOUND_ROWS
                        ana.id,
                        ana.status, 
                        sis.nome as sistema_id,
                        ana.nu_demanda, 
                        usu.name as user_id, 
                      
                        CASE 
                            WHEN equ.nome is null THEN 'Administrador' 
                            WHEN equ.nome is not  null THEN equ.nome
                        END  as equipe_id,
             
                        CASE  ana.metodo_contagem
                        WHEN 1 THEN 'Detalhada (IFPUG)'
                        WHEN 2 THEN 'Estimada (NESMA)'
                        WHEN 3 THEN 'Indicativa (NESMA)'
                        END metodo_contagem
                        , 
                         ana.total_ust, 
                         ana.created,
                         ana.baseline
                          FROM analiusts ana
                        inner join sistemas sis on ana.sistema_id = sis.id
                        left join equipes equ on equ.id = ana.equipe_id
                        inner join users usu on usu.id = ana.user_id
                        $sWhere 

                        $sOrder
                        $sLimit";
        } else if ($lista == 'lista_analises') {
         
            if (empty($sWhere)) {
                $sWhere = "WHERE ana.st_registro = 'S' " . $aConditions;
            } else {
                $sWhere .= " AND ana.st_registro = 'S' ";
            }
            $sQuery = "SELECT SQL_CALC_FOUND_ROWS
                       ana.id,
                        ana.status, 
                        sis.nome as sistema_id,
                        ana.nu_demanda, 
                        usu.name as user_id, 
                      
                        CASE 
                            WHEN equ.nome is null THEN 'Administrador' 
                            WHEN equ.nome is not  null THEN equ.nome
                        END  as equipe_id,
                        CASE ana.tipo_contagem
                                WHEN 1 THEN 'Projeto de Desenvolvimento' 
                                WHEN 2 THEN 'Projeto de Melhoria'
                                WHEN 3 THEN 'Contagem de Aplicação'
                        END AS tipo_contagem,
                        CASE  ana.metodo_contagem
                        WHEN 1 THEN 'Detalhada (IFPUG)'
                        WHEN 2 THEN 'Estimada (NESMA)'
                        WHEN 3 THEN 'Indicativa (NESMA)'
                        END metodo_contagem
                        , 
                         ana.total_pf, 
                         (ana.total_pf_ajustado + ana.total_pf_itens) valor_fator, 
                         ana.created,
                         ana.baseline
                          FROM analises ana
                        inner join sistemas sis on ana.sistema_id = sis.id
                        left join equipes equ on equ.id = ana.equipe_id
                        inner join users usu on usu.id = ana.user_id
                        $sWhere 

                        $sOrder
                        $sLimit";
        } else if ($lista == 'lista_funcionalidades') {
            if (empty($sWhere) && empty($sWhereConditions)) {
                $sWhere = "WHERE func.st_registro = 'S' " . $aConditions;
            } else
            if (empty($sWhere) && !empty($sWhereConditions)) {
               
                $sWhere .= $sWhereConditions;
            } else {

                $sWhere .= " AND func.st_registro = 'S' ";
            }


            $sQuery = "SELECT SQL_CALC_FOUND_ROWS
                    func.id  ,  
                         func.nome,
                        CASE func.tipo_funcionalidade
                            WHEN 1 THEN 'ALI' 
                            WHEN 2 THEN 'AIE'
                            WHEN 3 THEN 'SE'
                            WHEN 4 THEN 'CE'
                            WHEN 5 THEN 'EE'
			END AS tipo_funcionalidade,
			CASE func.impacto
                            WHEN 1 THEN 'Inclusão' 
                            WHEN 2 THEN 'Alteração'
                            WHEN 3 THEN 'Exclusão'
			END AS impacto,
                        CASE func.complexidade
			WHEN 1 THEN 'Baixa' 
                            WHEN 2 THEN 'Média'
                            WHEN 3 THEN 'Alta'
			END AS complexidade,
			func.qtd_pf,
			CASE func.impacto
                        WHEN 1 THEN (func.qtd_pf * con.inclusao) / 100
                        WHEN 2 THEN (func.qtd_pf * con.alteracao) / 100
                        WHEN 3 THEN (func.qtd_pf * con.exclusao) / 100
                        END as qtd_pf_deflator
                    FROM funcionalidades func
                        inner join analises ana on func.analise_id = ana.id
                        left join contratos con on con.id = ana.id_contrato
                            $sWhere 

                        $sOrder
                        $sLimit
                        ";
        } else {
            $sQuery = "
         SELECT SQL_CALC_FOUND_ROWS `" . str_replace(" , ", " ", implode("`, `", $aColumns)) . "`
            FROM $sTable
            $sWhereConditions
            $sOrder
            $sLimit
            ";
        }

//        print_r($sQuery);exit;

        $rResult = mysql_query($sQuery, $gaSql['link']) or fatal_error('MySQL Error: ' . mysql_errno());



        /* Data set length after filtering */
        $sQuery = "
    SELECT FOUND_ROWS()
";


        $rResultFilterTotal = mysql_query($sQuery, $gaSql['link']) or fatal_error('MySQL Error: ' . mysql_errno());
        $aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
        $iFilteredTotal = $aResultFilterTotal[0];

        /* Total data set length */
        $sQuery = "
        SELECT COUNT(`" . $sIndexColumn . "`)
            FROM   $sTable
            ";
        $rResultTotal = mysql_query($sQuery, $gaSql['link']) or fatal_error('MySQL Error: ' . mysql_errno());
        $aResultTotal = mysql_fetch_array($rResultTotal);
        $iTotal = $aResultTotal[0];



        /*
         * Output
         */
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );

        while ($aRow = mysql_fetch_array($rResult)) {
            $row = array();

            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == "version") {
                    /* Special output formatting for 'version' column */
                    $row[] = ($aRow[$aColumns[$i]] == "0") ? '-' : $aRow[$aColumns[$i]];
                } else if ($aColumns[$i] != ' ') {


                    /* General output */
                    $row[] = $aRow[$aColumns[$i]];
                }
            }


            $output['aaData'][] = $row;
        }




        $output['aaData'] = $this->prepareLock($output['aaData'], $lista);

        return $output;
    }

    protected function prepareLock($output, $lista = null) {

        $data = array();
        if ($lista == 'lista_analises') {
            $data = array();
            foreach ($output as $value) {
                $lock = $this->checkLock($value[0], 'inm'); //verifica que se a analise está bloqueada
                if (!empty($lock['Datalock']['user_id'])) {
                    $name = ClassRegistry::init('User')->find('first', array('conditions' => array('User.id' => $lock['Datalock']['user_id']), 'fields' => array('User.name')));
                    $resultLock = '<a onClick="desbloquear(' . $value[0] . ' ,\'/analises/analises/datalock/' . $value[0] . '/true' . '\',\'' . $name['User']['name'] . '\')"  href="#"><img  id="desblock' . $value[0] . '" title=\'Desbloquear\' src=\'/img/icons/cadeado.jpg\'></a> ';
                } else {
                    $resultLock = '<img title=\'Desbloqueado\' src=\'/img/icons/desbloqueado.png\'>';
                }
                $value[1] = $resultLock;
                //debug($value);exit;
                $dt = strtotime($value[10]); //make timestamp with datetime string 
                $value[10] = date("d-m-Y", $dt); //echo the year of the datestamp just created 
                $data[] = $value;
            }
        } else if ($lista == 'lista_analises_usts') {
            $data = array();
            foreach ($output as $value) {
                $lock = $this->checkLock($value[0], 'ust'); //verifica que se a analise está bloqueada
                if (!empty($lock['Datalock']['user_id'])) {

                    $name = ClassRegistry::init('User')->find('first', array('conditions' => array('User.id' => $lock['Datalock']['user_id']), 'fields' => array('User.name')));
                    $resultLock = '<a onClick="desbloquear(' . $value[0] . ' ,\'/analiusts/analiusts/datalock/' . $value[0] . '/true' . '\',\'' . $name['User']['name'] . '\')"  href="#"><img  id="desblock' . $value[0] . '" title=\'Desbloquear\' src=\'/img/icons/cadeado.jpg\'></a> ';
                } else {
                    $resultLock = '<img title=\'Desbloqueado\' src=\'/img/icons/desbloqueado.png\'>';
                }
                $value[1] = $resultLock;
                //debug($value);exit;

                $data[] = $value;
            }
        } else {
            $data = $output;
        }

        return $data;
    }

    public function checkLock($id, $tipo) {
        if ($tipo == 'inm') {
            $datalock = ClassRegistry::init('Datalock')->find('first', array('conditions' => array(
                    'Datalock.analise_id' => $id,
                    'Datalock.st_registro' => 'S',
                    'Datalock.tipo' => 'I'
                ), 'fields' => 'user_id'));
        } else if ($tipo == 'ust') {
            $datalock = ClassRegistry::init('Datalock')->find('first', array('conditions' => array(
                    'Datalock.analise_id' => $id,
                    'Datalock.st_registro' => 'S',
                    'Datalock.tipo' => 'U'
                ), 'fields' => 'user_id'));
        }


        return $datalock;
    }

}
