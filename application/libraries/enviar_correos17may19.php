<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enviar_correos
{
	protected $ci;

	public function __construct()
	{
        $this->ci =& get_instance();
	}


  public function enviar_correo($data)
  {
    $this->ci->load->library('email');
    $config['mailtype'] = 'html';
    $config['charset'] = 'utf-8';
    $this->ci->email->initialize($config);
    $cuerpo = "";
    $cuerpo .= "Se creo un usuario y contraseña para ver el proceso del proyecto <br> usuario: ".$data['sendTo']."<br> contraseña: ".$data['password']."<br> Para ingresar de click a este enlace ";
    $cuerpo .= "<a href='".base_url('login/clientes/')."' >Ir a sitio</a>";
    $cuerpo .= "<br>";
    $cuerpo .= "<img src='".URL_IMG.'Firma_BodyShop.png'."' alt='Firma BodyShop'>";
    //SEND THE EMAIL
    //$this->ci->email->from('soporte@planificadorempresarial.com', 'Ford Plasencia');
    $this->ci->email->from('planificadorempresarial@gmail.com', 'Ford Plasencia');
    $this->ci->email->to($data['sendTo']);
    $this->ci->email->subject('Body shop');
    $this->ci->email->message($cuerpo);
    $this->ci->email->send();
    $this->ci->email->clear();

  }

	

}

/* End of file enviar_correos.php */
/* Location: ./application/libraries/enviar_correos.php */
