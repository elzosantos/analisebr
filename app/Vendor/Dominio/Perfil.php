<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Dominio;

class Perfil {

    public static $admin = '1';
    public static $analista = '2';
    public static $visitante = '3';
    public static $publico = '4';
    
    private static $perfis = array
        (
        '1' => 'Administrador',
        '2' => 'Analista de Métricas',
        '3' => 'Visitante',
        '4' => 'Público'
    );

    public static function getTodosPerfis()
    {
        return self::$perfis;
    }
    
    public static function getPerfilById($id){
        
        return self::$perfis[$id];
    }

}
