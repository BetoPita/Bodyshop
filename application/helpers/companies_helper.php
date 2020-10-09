<?php
/**
 * Helper that use to check different
 * information in function will create for
 * can check or take information and easy
 * form and this functions could use it
 * in the view
 *
 * @createsAt May 20, 2013
 * @package Helpers
 * @author blackfoxgdl <ruben.alonso21@gmail.com>
 **/

/**
 * Helper that use for create the password token and can
 * encrypt the value. Is for do the password more secure
 *
 * @params string username
 * @params string password
 * @params string key
 *
 * @return string keyEncrypted
 * @author blackfoxgdl <ruben.alonso21@gmail.com>
 **/
function encrypt_password($username, $password, $key)
{
    $pass = sha1($password.$key.$username);
    return $pass;
}


function nombre_producto($id)
{
    $CI =& get_instance();
    $CI->db->select('*')
           ->from('productos')
           ->where('productoId', $id);
    $data = $CI->db->get();
    $nombre = $data->row();
    return $nombre->productoNombre;
}

function get_cliente_folio($folio)
{
    $CI =& get_instance();
    $CI->db->select('*')
           ->from('operaciones')
           ->where('folio', $folio);
    $data = $CI->db->get();
    $nombre = $data->row();
    return $nombre->clienteId;

}

function sucursal_principal()
{
    $CI =& get_instance();
    $CI->db->select('*')
           ->from('sucursales')
           ->where('principal', 1);
    $data = $CI->db->get();
    $nombre = $data->row();
    return $nombre->sucursalId;
}

function precio_producto($id)
{
    $CI =& get_instance();
    $CI->db->select('*')
           ->from('productos')
           ->where('productoId', $id);
    $data = $CI->db->get();
    $nombre = $data->row();
    return $nombre->productoPrecioVenta;
}


function nombre_codigo($id)
{
    $CI =& get_instance();
    $CI->db->select('*')
           ->from('productos')
           ->where('productoId', $id);
    $data = $CI->db->get();
    $nombre = $data->row();
    return $nombre->productoCodigo;
}

function nombre_sucursal($id)
{
    $CI =& get_instance();
    $CI->db->select('*')
           ->from('sucursales')
           ->where('sucursalId', $id);
    $data = $CI->db->get();
    $nombre = $data->row();
    return $nombre->sucursalNombre;
}

function status_admin($id)
{
    $CI =& get_instance();
    $CI->db->select('*')
           ->from('admin')
           ->where('adminId', $id);
    $data = $CI->db->get();
    $nombre = $data->row();
    return $nombre->status;
}

function nombre_proveedor($id)
{
    $CI =& get_instance();
    $CI->db->select('*')
           ->from('proveedores')
           ->where('proveedorId', $id);
    $data = $CI->db->get();
    $nombre = $data->row();
    if(isset($nombre->proveedorNombre)){
      return $nombre->proveedorNombre;
    }else{
      return "sin proveedor";
    }

}




function get_cliente($id){
	 $CI =& get_instance();
    $CI->db->select('clienteNombre')
           ->from('clientes')
           ->where('clienteId', $id);
    $data = $CI->db->get();
    $datos = $data->row();

    return $datos->clienteNombre;
	}

function get_cliente_info($id){
	 $CI =& get_instance();
    $CI->db->select('*')
           ->from('clientes')
           ->where('clienteId', $id);
    $data = $CI->db->get();
    $datos = $data->row();

    return $datos;
	}


  function nombre_usuario($id)
  {
      $CI =& get_instance();
      $CI->db->select('*')
             ->from('admin')
             ->where('adminId', $id);
      $data = $CI->db->get();
      $nombre = $data->row();
      return isset($nombre->adminNombre) ? $nombre->adminNombre : '';
  }



  function imagen_usuario($id)
  {
      $CI =& get_instance();
      $CI->db->select('*')
             ->from('admin')
             ->where('adminId', $id);

      $data = $CI->db->get();
      $nombre = $data->row();
     
      return isset($nombre->adminUrlImage) ? $nombre->adminUrlImage : '';
  }
  function debug_var($data = array()){
    echo '<pre>';
    print_r($data);
    echo '</pre>';
  }
  function trim_text($text, $count=''){
  $trimed = "";
  if($count==''){
    $count=100;
  }
  $text = str_replace("  ", " ", $text);
  if(strlen($text)>$count){
    return substr($text, 0,$count).'...';
  }else{
    return $text;
  }
}
