<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	function enviar_correo_general($correo,$titulo,$cuerpo,$archivo=array()){
		
         $configGmail = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_user' => 'fordplasencia@planificadorempresarial.mx',
            'smtp_pass' => 'rxxY2yYCMPke3RZy1',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'smtp_crypto'=> 'tls',
            'newline' => "\r\n"
        );
        
		$CI = & get_instance();
		$CI->email->initialize($configGmail); 
		
        $CI->email->from('fordplasencia@planificadorempresarial.mx', 'Ford Plasencia');
		$CI->email->to($correo);
		
		foreach ($archivo as $key => $value) {
			$CI->email->attach($value);
		}
        //si quieres que te envíen una copia a otro correo descomenta abajo y ponlo
		//$CI->email->cc('albertopitava@gmail.com'); 
		$CI->email->subject($titulo);
		$CI->email->message($cuerpo);
		$CI->email->send();

		//var_dump($CI->email->print_debugger());exit();
	}
	/************Fin correo_helper.php*********************/

