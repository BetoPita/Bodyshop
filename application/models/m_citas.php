<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_citas extends CI_Model{

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
    	return $this->db->get('matriz_citas.'.$tabla)->result();
    }
}
