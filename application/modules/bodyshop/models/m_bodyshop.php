<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_bodyshop extends CI_Model{

    public function __construct(){
        parent::__construct();
    }
   public function getLamineroStatus($proyectoId=''){
    //Obtener el laminero del proyecto
    $q = $this->db->select('id_tecnico')->where('proyectoId',$proyectoId)->where('status',7)->get('bodyshop_tecnicos_estatus');
    if($q->num_rows()==1){
        return $q->row()->id_tecnico;
    }else{
        return '';
    }
   }
}
