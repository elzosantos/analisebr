<?php
/**
 * This is email configuration file.
 *
 * Use it to configure email transports of Cake.
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
 * @package       app.Config
 * @since         CakePHP(tm) v 2.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 *
 * Email configuration class.
 * You can specify multiple configurations for production, development and testing.
 *
 * transport => The name of a supported transport; valid options are as follows:
 * 		Mail 		- Send using PHP mail function
 * 		Smtp		- Send using SMTP
 * 		Debug		- Do not send the email, just return the result
 *
 * You can add custom transports (or override existing transports) by adding the
 * appropriate file to app/Network/Email. Transports should be named 'YourTransport.php',
 * where 'Your' is the name of the transport.
 *
 * from =>
 * The origin email. See CakeEmail::from() about the valid values
 *
 */
class EmailConfig {

     public $default = array(
    	#'host' => 'analisebr.com.br',
        #'port' => 25, 
        #'from' => 'apfbr@analisebr.com.br',
        #'transport' => 'Smtp'
        #'username' => 'apfbr@brb.com.br',
        #'password' => 'password',
     );
     
     /*public $default = array(
        'transport' => 'Mail',
       // 'from' => 'teste@brb.com.br'
        'from' => 'analisebr@analisebr.com.br'
            //'charset' => 'utf-8',
            //'headerCharset' => 'utf-8',
    );*/
     public $smtp  = array(
        'transport' => 'Smtp',
        'from' => array('apfbr@analisebr.com.br' => 'APFBr'),
        'host' => 'analisebr.com.br',
        'port' => 26,
        #'timeout' => 30,
     //   'username' => 'apfbr@analisebr.com.br',
      //  'password' => 'apfbr2@15',
        'client' => null,
        'log' => false,
    );
     
   /* public $smtp = array(
        'transport' => 'Mail',
        'from' => 'teste@brb.com.br'
            //'charset' => 'utf-8',
            //'headerCharset' => 'utf-8',
    );*/
//	public $smtp = array(
//		'transport' => 'Smtp',
//		'from' => array('site@localhost' => 'My Site'),
//		'host' => 'localhost',
//		'port' => 25,
//		'timeout' => 30,
//		'username' => 'user',
//		'password' => 'secret',
//		'client' => null,
//		'log' => false,
//		//'charset' => 'utf-8',
//		//'headerCharset' => 'utf-8',
//	);
/*    public $smtp = array(
        'transport' => 'Smtp',
        'from' => array('apf@brb.com.br' => 'APFBr'),
        'host' => 'email.brb.com.br',
        'port' => 25,
        'timeout' => 30,
 //       'username' => 'apf@brb.com.br',
//        'password' => 'ALTERAR SENHA AQUI',
        'client' => null,
        'log' => false,
            //'charset' => 'utf-8',
            //'headerCharset' => 'utf-8',
    );
*/
    public $fast = array(
      #  'from' => 'teste@brb.com.br',
        'sender' => null,
        'to' => null,
        'cc' => null,
        'bcc' => null,
        'replyTo' => null,
        'readReceipt' => null,
        'returnPath' => null,
        'messageId' => true,
        'subject' => null,
        'message' => null,
        'headers' => null,
        'viewRender' => null,
        'template' => false,
        'layout' => false,
        'viewVars' => null,
        'attachments' => null,
        'emailFormat' => null,
        'transport' => 'Smtp',
        'host' => 'localhost',
        'port' => 25,
        'timeout' => 30,
        'username' => 'user',
        'password' => 'secret',
        'client' => null,
        'log' => true,
            //'charset' => 'utf-8',
            //'headerCharset' => 'utf-8',
    );
}
