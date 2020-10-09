<?php
  function selectDatos(){
    $ins = &get_instance();
    return $ins->db->select('*')
                    ->from('usuario')
                    ->get()
                    ->result();
  }

  function insertNoti($titulo,$texto,$id_user,$url){
    $ins = &get_instance();
    return $ins->db->set('titulo',$titulo)->set('texto',$texto)->set('id_user',$id_user)->set('estado',1)->set('url',$url)->set('estadoWeb',1)->insert('noti_user');
  }
?>
