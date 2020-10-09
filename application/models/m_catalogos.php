<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_catalogos extends CI_Model{

    public function __construct(){
        parent::__construct();
    }
    public function get($tabla='',$order='',$asc='asc',$where=array()){
    	if($order!=''){
    		$this->db->order_by($order,$asc);
    	}
    	if(count($where)>0){
            $this->db->where($where);
    		
    	}
    	return $this->db->get($tabla)->result();
    }
    public function getImagenPrincipal($id=''){
        $q= $this->db->select('url')->from('imagenes')->where('idproducto',$id)->where('principal',1)->get();
        if($q->num_rows()==1){
            return $q->row()->url;
        }else{
            $q2= $this->db->select('url')->from('imagenes')->where('idproducto',$id)->limit(1)->get();
            if($q2->num_rows()==1){
                return $q2->row()->url;
            }else{
                return '';
            }
        }
    }
}
