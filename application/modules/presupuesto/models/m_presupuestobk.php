<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class M_presupuesto extends CI_Model {
  public function getDatos(){
    return $this->db->select('c.*,s.subcategoria,s.id as id_subcategoria')->join('bodyshop_subcategoria s','s.idcategoria=c.id')->get('bodyshop_categoria c')->result();
  }
  public function save_presupuesto(){

  }
  public function getProyectoById($id){
    return $this->db->where('proyectoId',$id)->get('bodyshop')->result();
  }
  public function getDatosDetalle($idbody='',$idparte=''){
    return $this->db->where('idbody',$idbody)->where('idparte',$idparte)->get('bodyshop_detalle_presupuesto')->result();
  }

}