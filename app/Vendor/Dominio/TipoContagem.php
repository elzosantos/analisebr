<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Dominio;

class TipoContagem {

 

    public static $projetoDesenvolvimento = '1';
    public static $projetoMelhoria = '2';
    public static $contagemAplicação = '3';
    
    private static $tipos = array
        (
        '1' => 'Projeto de Desenvolvimento',
        '2' => 'Projeto de Melhoria',
        '3' => 'Contagem de Aplicação',
    );

    public static function getTodosTipos()
    {
        return self::$tipos;
    }
    
    public static function getTipoById($id){
        return self::$tipos[$id];
    }

}
