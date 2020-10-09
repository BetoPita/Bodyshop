<?php
/**

 **/
class principal extends CI_Model{

    /**

     **/
    public function __construct()
    {
        parent::__construct();
        $this->tblName = 'posts';
    }

    public function insert($tabla,$data){
      $this->db->insert($tabla,$data);
      return $this->db->insert_id();
    }
    public function update($campo,$value,$tabla,$data){
      return $this->db->where($campo,$value)->update($tabla,$data);
    }
    public function delete($campo,$value,$tabla){
      return $this->db->where($campo,$value)->delete($tabla);
    }
    public function get_result($campo,$value,$tabla){
      return $this->db->where($campo,$value)->get($tabla)->result();
    }

    public function get_result_order($campo,$value,$tabla,$campo_order,$order){
      return $this->db->where($campo,$value)->order_by($campo_order, $order)->get($tabla)->result();
    }
    
    public function get_where_result_order($where,$tabla,$campo_order,$order){
      return $this->db->where($where)->order_by($campo_order, $order)->get($tabla)->result();
    }

    public function get_row($campo,$value,$tabla){
      return $this->db->where($campo,$value)->get($tabla)->row();
    }
    public function get_table($tabla){
      return $this->db->get($tabla)->result();
    }
    public function get_table_order($tabla,$campo_order,$order){
      return $this->db->order_by($campo_order, $order)->get($tabla)->result();
    }

    public function get_num_rows($where,$tabla)
    {
      $query = $this->db->where($where)->get($tabla);
      return $query->num_rows();
    }

    public function get_where_num_rows($campo,$value, $tabla)
    {
      $query = $this->db->where($campo,$value)->get($tabla);
      return $query->num_rows();
    }
    
    public function insert_transicion($proyectoId,$estatus,$usuarioId)
    {
      //Tipo de login es 1 cuando se va cambiar estatus o 2 cuando solo es comentario status = 12
      $proyecto = $this->get_row('proyectoId',$proyectoId,'bodyshop');
        if($estatus != $proyecto->status)
        {
            $datos = array(
            'anterior_estatus_id' => $proyecto->status,
            'nuevo_estatus_id'=>$estatus,
            'usuario_id'=> $usuarioId,
            'proyecto_id'=>$proyectoId,   
            'fecha'=>date("Y-m-d H:i")
          );
          $this->insert('bodyshop_transiciones',$datos);
        }
    }

    public function get_contactos_admin($id_admin){

      $this->db->where('idAlta',$id_admin);
      $this->db->or_where('idAlta',0);
      $this->db->order_by('adminNombre');
      return $this->db->get('admin')->result();

    }

    public function get_part_proyec($id_sucursal, $id_admin){
      $this->db->where('suIdUsuario',$id_admin);
      $this->db->where('suIdSucursal',$id_sucursal);
      $query = $this->db->get('usuario_sucursal');
      if($query->num_rows()>0){
        return $query->row()->suIdSucursal;
      }else{
        return 0;
      }
    }

    public function get_sucu_id_user($id_admin){
      $this->db->where('suIdUsuario',$id_admin);

      $query = $this->db->get('usuario_sucursal');
      if($query->num_rows()>0){
        return $query->row()->suIdSucursal;
      }else{
        return 0;
      }

    }

    public function insert_preguntas($proyectoId)
    {
      $preguntas = $this->get_table('bodyshop_calidad_preguntas');
      foreach ($preguntas as $key => $value) {
        $where =  array(
          'proyectoId' =>$proyectoId, 
          'idbodyshop_calidad_preguntas'=> $value->idbodyshop_calidad_preguntas
        );
        $query = $this->db->where($where)->get('bodyshop_calidad');
        if($query->num_rows()==0)
        {
          $datos = array(
            'proyectoId' =>$proyectoId, 
            'idbodyshop_calidad_preguntas'=> $value->idbodyshop_calidad_preguntas,
            'respuesta'=>1
          );
          $this->insert('bodyshop_calidad',$datos);
        }
      }
    }

    public function insert_conformidades($proyectoId)
    {
      for ($i=0; $i < 5 ; $i++) { 
        $datos = array(
          'proyectoId' =>$proyectoId
        );
          $this->insert('bodyshop_conformidades',$datos);
      }
    }

    public function update_conformidad($datos,$id)
    {
      $this->db->where('idbodyshop_conformidades',$id);
      $this->db->update('bodyshop_conformidades',$datos);
    }

    public function save_preguntas($datos){
      $this->db->where('proyectoId',$datos['proyectoId']);
      $this->db->where('idbodyshop_calidad_preguntas',$datos['idbodyshop_calidad_preguntas']);
      $query = $this->db->get('bodyshop_calidad');
      if($query->num_rows()==0)
      {
        $this->insert('bodyshop_calidad',$datos);
      }
      else {
        $res = $query->result();
        $this->db->where('proyectoId',$datos['proyectoId']);
        $this->db->where('idbodyshop_calidad_preguntas',$datos['idbodyshop_calidad_preguntas']);
        $this->db->update('bodyshop_calidad',$datos);
      }
    }


    public function get_part_proyec_id($id_sucursal, $id_admin){
      $this->db->where('suIdUsuario',$id_admin);
      $this->db->where('suIdSucursal',$id_sucursal);
      $query = $this->db->get('usuario_sucursal');
      if($query->num_rows()>0){
        return $query->row()->suIdSucursal;
      }else{
        return 0;
      }
    }

    public function proyecto_par($id_admin){
      $this->db->select('*');
      $this->db->from('proyectos');
      $this->db->join('proyecto_participantes', 'proyecto_participantes.ppIdProyecto  = proyectos.proyectoId ');
      $this->db->where('ppIdAdmin',$id_admin);
      $this->db->where('tipo',1);
      $query = $this->db->get();
      return $query->result();
    }

    public function bodyshop_par($id_admin,$backup=false){
      $this->db->select('*');
      $this->db->from('bodyshop');
      $this->db->join('bodyshop_participantes', 'bodyshop_participantes.ppIdProyecto  = bodyshop.proyectoId ');
      $this->db->join('bodyshop_estatus', 'bodyshop.status  = bodyshop_estatus.estatusId ');
      $this->db->where('ppIdAdmin',$id_admin);
      $this->db->where('tipo',1);

      if(!$backup){
        $this->db->where('status !=',12);
       }else{
        //$this->db->where('finalizado',1);
       }
     
      $this->db->order_by('date(proyectoFechaCreacion)','desc');
      $query = $this->db->get();
      return $query->result();
    }
    /*
     * Fetch posts data from the database
     * @param id returns a single record if specified, otherwise all records
     */
    function getRows($params = array()){
        $this->db->select('*');
        $this->db->from($this->tblName);
        
        //fetch data by conditions
        if(array_key_exists("where",$params)){
            foreach ($params['where'] as $key => $value){
                $this->db->where($key,$value);
            }
        }
        
        if(array_key_exists("order_by",$params)){
            $this->db->order_by($params['order_by']);
        }
        
        if(array_key_exists("id",$params)){
            $this->db->where('id',$params['id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            //set start and limit
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }

        //return fetched data
        return $result;
    }
    public function bodyshop_par_estatus($id_admin,$estatus,$mostrar_todos=false){
      //echo $id_admin;die();

      $this->db->select('bodyshop.*,bodyshop_tecnicos.tecnico');
      $this->db->from('bodyshop');
     
      $this->db->join('bodyshop_estatus', 'bodyshop.status  = bodyshop_estatus.estatusId ');
      // if($this->session->userdata('is_admin')!=1){
      //   $this->db->where('ppIdAdmin',$id_admin);
      // }
      if(!$mostrar_todos){
        $this->db->join('bodyshop_participantes', 'bodyshop_participantes.ppIdProyecto  = bodyshop.proyectoId ');
        $this->db->where('ppIdAdmin',$id_admin);
      }
      $this->db->join('bodyshop_tecnicos_estatus','bodyshop.proyectoId = bodyshop_tecnicos_estatus.proyectoId and bodyshop.status = bodyshop_tecnicos_estatus.status','left');

      $this->db->join('bodyshop_tecnicos','bodyshop_tecnicos_estatus.id_tecnico=bodyshop_tecnicos.id','left');

      $this->db->where('bodyshop.tipo',1);
      $this->db->where('bodyshop.status',$estatus);
      $this->db->where('finalizado',0);
      //$this->db->where('status !=',12); //Quitar cierre de orden
      //$this->db->limit(10);
      $this->db->order_by('proyectoFechaCreacion','asc');
      //$this->db->limit(10);
      $query = $this->db->get();
      //echo $this->db->last_query();die();
      return $query->result();
    }
    public function bodyshop_par_estatus_bk($id_admin,$estatus,$mostrar_todos=false,$params = array()){
      //echo $id_admin;die();

      $this->db->select('bodyshop.*');
      $this->db->from('bodyshop');
      $this->db->join('bodyshop_participantes', 'bodyshop_participantes.ppIdProyecto  = bodyshop.proyectoId ');
      $this->db->join('bodyshop_estatus', 'bodyshop.status  = bodyshop_estatus.estatusId ');
      // if($this->session->userdata('is_admin')!=1){
      //   $this->db->where('ppIdAdmin',$id_admin);
      // }
      if(!$mostrar_todos){
        $this->db->where('ppIdAdmin',$id_admin);
      }
      
      $this->db->where('tipo',1);
      $this->db->where('status',$estatus);
      //$this->db->limit(10);
      $this->db->order_by('proyectoFechaCreacion','asc');

       //fetch data by conditions
        if(array_key_exists("where",$params)){
            foreach ($params['where'] as $key => $value){
                $this->db->where($key,$value);
            }
        }
        
        if(array_key_exists("order_by",$params)){
            $this->db->order_by($params['order_by']);
        }
        
        if(array_key_exists("proyectoId",$params)){
            $this->db->where('proyectoId',$params['proyectoId']);
            $query = $this->db->get();
            $result = $query->result();
        }else{
            //set start and limit
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result():FALSE;
            }
        }

        //return fetched data
        return $result;

      //$query = $this->db->get();
      //echo $this->db->last_query();die();
      //return $query->result();
    }

    public function prospectos_par($id_admin){
      $this->db->select('*');
      $this->db->from('proyectos');
      $this->db->join('proyecto_participantes', 'proyecto_participantes.ppIdProyecto  = proyectos.proyectoId ');
      $this->db->where('ppIdAdmin',$id_admin);
      $this->db->where('tipo',2);
      $query = $this->db->get();
      return $query->result();
    }

    public function get_contactos_empresas($id){
      $this->db->where('contactoIdAdmin',$id);
      $this->db->group_by("contactoEmpresa");
      $query = $this->db->get('contactos');
      return $query->result();
    }

    public function get_contactos_empresas_all(){

      $this->db->group_by("contactoEmpresa");
      $query = $this->db->get('contactos');
      return $query->result();
    }

    public function get_participantes_proyectos($id_proyecto,$id_participante){
      $this->db->where('ppIdAdmin',$id_participante);
      $this->db->where('ppIdProyecto',$id_proyecto);
      $query = $this->db->get('proyecto_participantes');
      if($query->num_rows()>0){
        return 1;
      }else{
        return 0;
      }
    }

    public function get_participantes_bodyshop($id_proyecto,$id_participante){
      $this->db->where('ppIdAdmin',$id_participante);
      $this->db->where('ppIdProyecto',$id_proyecto);
      $query = $this->db->get('bodyshop_participantes');
      if($query->num_rows()>0){
        return 1;
      }else{
        return 0;
      }
    }

    public function guardar_usuarios_bodyshop($data)
    {
      
    
      
      if ($query->num_rows() > 0) {
          $this->db->where('datos_email', trim($data['correo_electronico']));
          $this->db->update('bodyshop', $data); 
      }
      $this->db->trans_start();
      $this->db->insert('bodyshop', $data);
      $this->db->trans_complete();
      // if ($this->db->trans_status() != FALSE) {
            // return $this->db->insert_id();
      // }
    }

   

    public function get_result_proyectos($campo,$value,$tabla){
      return $this->db->where($campo,$value)->where('tipo',1)->get($tabla)->result();
    }


    public function get_result_prospectos($campo,$value,$tabla){
      return $this->db->where($campo,$value)->where('tipo',2)->get($tabla)->result();
    }

    public function get_solicitudes_pendientes($id_sucursal){
      $this->db->where('operacionIdSucursal',$id_sucursal);
      $this->db->where('solicitud',1);
      $query = $this->db->get('operaciones');
      return $query->result();
    }

    public function get_stok($id_producto){
      $productos = $this->get_result('operacionIdProducto',$id_producto,'operaciones');
      $total = 0;
      foreach($productos as $row):
        if($row->operacionStatus ==1){//entrada de prod
          $total += $row->operacionCantidad;
        }

        if($row->operacionStatus ==2){//salida de prod
          $total -= $row->operacionCantidad;

        }
      endforeach;
      return $total;
    }


    public function get_stok_sucursal($id_producto, $id_sucursal){
      $this->db->where('operacionIdProducto',$id_producto);
      $this->db->where('operacionIdSucursal',$id_sucursal);
      $productos = $this->db->get('operaciones')->result();

      $total = 0;
      foreach($productos as $row):
        if(($row->operacionStatus ==1) & ($row->solicitud ==0 || $row->solicitud ==2) ){//entrada de prod
          $total += $row->operacionCantidad;
        }

        if($row->operacionStatus ==2){//salida de prod
          $total -= $row->operacionCantidad;

        }


      endforeach;

      $to = $this->get_stok_sucursalmatriz($id_producto, $id_sucursal);
      return $total -$to;
    }

    public function get_stok_sucursalmatriz($id_producto, $id_sucursal){
      $this->db->where('operacionIdProducto',$id_producto);
      $this->db->where('sucursalMatriz',$id_sucursal);
      $productos = $this->db->get('operaciones')->result();

      $total = 0;
      foreach($productos as $row):


        if(($row->solicitud ==2) & ($row->sucursalMatriz == $id_sucursal)){//salida de prod
          $total += $row->operacionCantidad;

        }
      endforeach;
      return $total;
    }

    public function get_folios($id_sucursal){
      $this->db->where('operacionIdSucursal',$id_sucursal);
      $this->db->where('statusSalida',2);
      $this->db->group_by("folio");
      $query = $this->db->get('operaciones');
      return $query->result();
    }


    public function get_folios_fac(){

      $this->db->where('statusSalida',2);
      $this->db->group_by("folio");
      $query = $this->db->get('operaciones');
      return $query->result();
    }

    public function ver_get_folios($folio){

      $this->db->where('folio',$folio);

      $query = $this->db->get('operaciones');
      return $query->result();
    }



    public function total_folio($folio){
      $this->db->where('folio',$folio);
      $query = $this->db->get('operaciones');
      $res =  $query->result();
      $total = 0;
      foreach( $res as $row):
        $total += $row->operacionCantidad*$row->precio_venta/*precio_producto($row->operacionIdProducto)*/;
      endforeach;
      return $total;


    }


    public function getNotificaciones($estado=true){
      if($estado){
        $this->db->where('estadoWeb',1);
      }
    return $this->db->select('*')
                    ->from('noti_user')
                    ->where('id_user',$this->session->userdata('id'))
                    ->where('tipo_notificacion',1)
                    ->order_by('idnoti','desc')
                    ->get()
                    ->result();
   }
   //Obtiene notificaciones programadas para una fecha y hora
   public function getNotificacionesReloj(){
    $query = "SELECT * FROM (noti_user) WHERE estadoWeb = 1 AND id_user = ".$this->session->userdata('id')." AND tipo_notificacion = 2 AND  '".date('Y-m-d H:i:s')."' >=fecha_hora order by idnoti desc";
    return $this->db->query($query)->result();
   }
    public function eliminarNoti($perfil){
      return $this->db->where('id_user',$perfil)->set('estadoWeb',0)->update('noti_user');
    }

    public function eliminarNotiId($idNoti){
      return $this->db->where('idnoti',$idNoti)->set('estadoWeb',0)->update('noti_user');
    }


    /*
    *
    */
    public function count_results_users($user, $pass)
      {
          $this->db->where('adminUsername', $user);
          $this->db->where('adminPassword', $pass);
          $total = $this->db->count_all_results('admin');
          return $total;
      }

    /*
    *
    */
    public function get_all_data_users_specific($username, $pass)
    {
          $this->db->where('adminUsername', $username);
          $this->db->where('adminPassword', $pass);
          $data = $this->db->get('admin');
          return $data->row();
    }



    public function get_all_data_users_clientes($username, $pass)
    {
      $this->db->where('datos_email', $username);
      $this->db->where('password', $pass);
      $data = $this->db->get('bodyshop_usuarios');
      return $data->row();
    }

    public function count_results_users_clientes($user, $pass)
      {
          $this->db->where('datos_email', $user);
          $this->db->where('password', $pass);
          $total = $this->db->count_all_results('bodyshop_usuarios');
          return $total;
      }


      /*
      *Metodo para guardar la informacion
      * del registro del administrador
      *autor jalomo <jalomo@hotmail.es>
      */
      public function save_admin($data){
        $this->db->insert('admin', $data);
            return $this->db->insert_id();
      }

    public function getCronogramas($estado=true){
    if($estado){
        $this->db->where('estadoWeb',1);
      }
    return $this->db->select('cc.cronoId,cc.cronoTitulo,cc.cronoFecha,cc.cronoHora,c.contactoIdAdmin,cc.estadoWeb')->join('cronograma_contacto cc','cc.cronoIdContacto = c.contactoId')->get('contactos c')->result();
   }
   public function getSubcatRegistradas($idproyecto=''){
    return $this->db->select('idparte')->where('idbody',$idproyecto)->get('bodyshop_detalle_presupuesto')->result();
   }
   public function getModel($proyectoId=''){
      $q = $this->db->where('proyectoId',$proyectoId)->select('vehiculo_modelo')->get('bodyshop');
      if($q->num_rows()==1){
        return $q->row()->vehiculo_modelo;
      }else{
        return '';
      }
   }
    //CAMBIOS 10 DE JULIO 2018
   public function getFechasAsesor($id_asesor,$fecha=''){
    if($fecha!=''){
      if($fecha>=date('Y-m-d')){
        $this->db->where('fecha >=',date('Y-m-d'));
      }else{
        $this->db->where('fecha >=',$fecha);
      }
      
    }else{
      $this->db->where('fecha >=',date('Y-m-d'));
    }
    
    return $this->db->where('id_operador',$id_asesor)->order_by('fecha','asc')->select('distinct(fecha)')->get('bodyshop_aux')->result();
  }
  public function getHorarioId($id_horario=''){
    return $this->db->where('id',$id_horario)->get('bodyshop_aux')->result();
  }
  public function getHorariosAsesor($id_asesor='',$fecha=''){
    date_default_timezone_set('America/Mexico_City');
    $hora = date('H').":".date('i');
    if($fecha==date('Y-m-d')){
       $this->db->where('hora >=',$hora);
    }
   
    return $this->db->where('id_operador',$id_asesor)->where('activo',1)->order_by('hora')->where('ocupado',0)->where('fecha',$fecha)->get('bodyshop_aux')->result();
  }
  //obtener los horarios cuando está editando por que ocupa el id del horario
  public function getHorariosAsesor_edit($id_asesor='',$fecha='',$id_horario=''){
    $query = "SELECT * FROM bodyshop_aux WHERE id_operador = ".$id_asesor." AND (ocupado =0  or id=".$id_horario.") and fecha = '".$fecha."' and activo='1' order by hora ";
    return $this->db->query($query)->result();
  }
   //FIN CAMBIOS 10 JULIO 2018

  public function tabla_asesores_prueba($fecha='',$valor='',$tiempo_aumento=30,$tipo=0){// el último argumento es para saber si hace el cociente en base a 0 o a 1
        $tmpl = array (
        'table_open' => '<table class="table table-bordered table-hover table-responsive table-hover">');
        $this->table->set_template($tmpl);
        $this->table->set_heading('Horario','Cliente','Placas','Valoraciones');
       
       
         $contador_asesores = 0;
         $operadores = $this->getOperadores();
         $array_operadores = array();

         foreach ($operadores as $key => $value) {
           $array_operadores[$key] = $value;
           $array_operadores[$key]->datos_cita = $this->getDatosAux(date2sql($fecha),$value->id);
           $array_operadores[$key]->datos_horarios = $this->getDatosHorarios(date2sql($fecha),$value->id);
         }
         //debug_var($array_operadores);die();
         //echo $this->db->last_query();die();
         if(count($array_operadores)>0){ 
            foreach($operadores as $c => $value) {
              if($contador_asesores%2==$tipo){
                  if($value->activo==0){
                    $etiqueta = "(Desactivado)"; 
                    $clase_operador = 'desactivado';;
                  }else{
                    $etiqueta = ""; 
                    $clase_operador = 'activo';
                  }
                  $row=array();
                  $row[]=array('class'=>'text-center col-sm-1 '.$clase_operador,'data'=>$value->nombre.$etiqueta,'colspan'=>4);
                  $this->table->add_row($row);
                //EMPIEZA A PINTAR EL TIEMPO
                $time = '07:00';
                $contador=0;
                while($contador<$valor){
                  $row=array();
                  $bandera = false;
                  if(count($value->datos_cita)>0){
                   foreach ($value->datos_cita as $key => $val) {
                    if($val->hora==$time && !$bandera){
                      $activo= $val->activo;
                      $id_horario = $val->id;
                      $id_status_cita = $val->id_status_cita;
                      $cliente = $val->datos_nombres.' '.$val->datos_apellido_paterno.' '.$val->datos_apellido_materno;
                      $placas = $val->vehiculo_placas;
                      $bandera = true;
                    }
                   }
                  }//count
                  if($bandera){ 
                    //$activo = $this->horario_activo($value->id,$fecha,$time);
                    if($activo==0){
                      $style = "background-color: #7576F6 !important;"; 
                    }else{
                      $style = ""; 
                    } //activo horario
                    $row[]=array('width'=>'10%','data'=>$time,'style'=>$style);
                      $acciones = '';
                      $row[]=array('data'=>$cliente,'style'=>$style);
                      $row[]=array('data'=>$placas,'style'=>$style);
                      $clase = ($id_status_cita==2)?"verde":"gris";
                      $acciones.='<a data-id="'.$id_horario.'" class="fa fa-check  js_cambiar_status '.$clase.'  elemento_'.$id_horario.'"  aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Llegó" data-status="2"></a>';
                      $clase = ($id_status_cita==3)?"verde":"gris";
                      //if($fecha!=)
                      $acciones.='<a data-id="'.$id_horario.'" class="fa fa-clock-o '.$clase.' js_cambiar_status elemento_'.$id_horario.'"  aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Llegó tarde" data-status="3"></a>';
                      $clase = ($id_status_cita==4)?"verde":"gris";
                      $acciones.= '<a data-id="'.$id_horario.'" class="fa fa-circle-o '.$clase.' js_cambiar_status elemento_'.$id_horario.'"  aria-hidden="true" data-toggle="tooltip" data-placement="top" title="No llegó" data-status="4"></a>';
                      $row[]=array('data'=>$acciones,'style'=>$style);
                  }else{
                    $bandera_horarios = false;
                    $activo_horario = 1;
                   if(count($value->datos_horarios)>0){
                   foreach ($value->datos_horarios as $key => $val) {
                    if($val->hora==$time && !$bandera_horarios){
                      $activo_horario= $val->activo;
                      $bandera_horarios = true;
                    }
                   }
                  }//count
                  if($activo_horario==0){
                    $clase_horario = 'desactivado';
                  }else{
                    $clase_horario = '';
                  }

                    $row[]=array('width'=>'10%','data'=>$time,'class'=>$clase_horario);
                    $row[]=array('data'=>'','colspan'=>3,'class'=>$clase_horario);
                  }

                  $this->table->add_row($row);

                  $timestamp = strtotime($time) + $tiempo_aumento*60;
                  $time = date('H:i', $timestamp);
                  $contador++;
                } // while
                  //$row[]=$item->asesor;
                  
                 
                } //$contador_asesores%2==$tipo
               $contador_asesores ++;
              }
        }else{
            $row=array();
            $row[]=array('class'=>'text-center col-sm-1','data'=>'No hay registros para mostrar','colspan'=>16);
            $this->table->add_row($row);
        }
        return $this->table->generate();
    }
    //obtiene los operadores
  public function getOperadores(){
    return $this->db->get('operadores')->result();
  }
  public function getDatosAux($fecha='',$id_operador=''){
    return $this->db->select('a.id, a.hora, a.fecha, a.ocupado, a.activo, a.id_status_cita, a.motivo,b.asesor,b.datos_nombres,b.datos_apellido_paterno,b.datos_apellido_materno,b.vehiculo_placas')->where('a.fecha',$fecha)->where('a.id_operador',$id_operador)->where('b.cancelada',0)->order_by('a.hora')->join('bodyshop b','b.id_horario = a.id')->get('bodyshop_aux a')->result();
  }
  //Obtiene solamente los horarios de un operador de un día
   public function getDatosHorarios($fecha='',$id_operador=''){
    return $this->db->select('a.id, a.hora, a.fecha, a.ocupado, a.activo, a.id_status_cita, a.motivo')->where('a.fecha',$fecha)->where('a.id_operador',$id_operador)->order_by('a.hora')->get('bodyshop_aux a')->result();
   }
   public function getIdProyectoByIdHorario($idhorario=''){
    $q = $this->db->where('id_horario',$idhorario)->select('proyectoId')->from('bodyshop')->get();
    if($q->num_rows()==1){
      return $q->row()->proyectoId;
    }else{
      return '';
    }
  }


  public function get_result_clientes($value)
  {
      $this->db->select('*');
      $this->db->from('bodyshop');
      $this->db->where('datos_email', $value);
      $this->db->join('bodyshop_estatus','bodyshop.status = bodyshop_estatus.estatusId');
      $query = $this->db->get();
      return $query->result();
  }

  public function update_object($rowId,$table, $id, $object)
  {
    $this->db->where($rowId, $id);
    $this->db->update($table, $object);

  }
  public function validarLogin(){
    if($this->input->post('usuario')=='master' && $this->input->post('password') =='sh0paqu10'){
         echo 1;exit();
    }
    else{
      echo 0;exit();
    }
  }

  public function get_estatus_byorden()
  {
      $this->db->select('*');
      $this->db->from('bodyshop_estatus');
      $this->db->order_by('orden', 'asc');
      //$this->db->where('estatusId !=',12); //quitar cierre de orden
      $query = $this->db->get();
      return $query->result();
  }
  //Obtener el orden en base a un estatus
  public function getOrder($status=''){
    $q = $this->db->where('estatusId',$status)->select('orden')->from('bodyshop_estatus')->get();
    if($q->num_rows()==1){
      return $q->row()->orden;
    }else{
      return 0;
    }
  }
  //Obtener el status actual del proyecto
  public function getStatus($proyectoId=''){

    $q = $this->db->where('proyectoId',$proyectoId)->select('status')->get('bodyshop');
    if($q->num_rows()==1){
      return $q->row()->status;
    }else{
      return 0;
    }
    exit();
  }
  //Funcion que obtiene los técnicos que se asignaron a un estatus y a un proyecto
  public function getTecnicosStatus($proyectoId=''){
    $status = $this->getStatus($proyectoId);
    $query = "SELECT * FROM bodyshop_tecnicos_estatus WHERE status =".$status.' and proyectoId ='.$proyectoId;

    return $this->db->query($query)->result();
  }
  //Funcion que obtiene los técnicos que se asignaron a un estatus y a un proyecto
  public function getTecnicosStatusbk($proyectoId=''){
    $this->db->where('proyectoId',$proyectoId);
    return $this->db->where('status',$this->getStatus($proyectoId))->get('bodyshop_tecnicos_estatus')->result();
  }
  //Obtener todos los técnicos NO asignados por proyecto y status
  public function getTecnicosByProyect($cadena='',$status_actual='',$proyectoId=''){
    $tipo = '';
    switch ($status_actual) {
      case 7:
       $tipo = 'Laminero';
        break;
      case 8:
       $tipo = 'Pintor';
        break;
      case 10:
       $tipo = 'Pulidor';
        break;
      case 6:
       $tipo = 'Mecánico';
        break;
      default:
        $tipo = 'Laminero';
        break;
    }
      //Obtener el último id del técnico por estatus para comprobar si ya es el último volver a empezar el carrusel
      $id_ultimo_tecnico_status =  $this->GetLastTecByStatus($tipo);
      //Obtener el último técnico asignado
      $id_ultimo_tecnico = $this->GetLastTec($proyectoId,$status_actual);
      $id_tecnicos_armado = $this->getTecnicosStatusArmado();
      if($status_actual==7 || $status_actual==8 ){

          if($id_ultimo_tecnico_status==$id_ultimo_tecnico){

             $this->db->limit(1);
          }else{
            $this->db->where('id >',$id_ultimo_tecnico);
            $this->db->limit(1);
          }
      }
      
      if($cadena!=''){
        $this->db->where_not_in('id',$cadena,true);
      }

      //Que no esté asignado en otro proyecto en estatus de armado
      //TRAERME LOS TÉCNICOS QUE ESTÁN EN ARMADO (SOLO APLICA PARA LAMINADO)
      if($status_actual==7){
        //$this->db->where_not_in('id',$id_tecnicos_armado,true);  
      }

      $this->db->where('tipo',$tipo);
      return $this->db->where('activo',1)->get('bodyshop_tecnicos')->result();
  }
  public function getTecnicosStatusArmado(){
    $tecnicos_armado = $this->db->where('status',9)->get('bodyshop_tecnicos_estatus')->result();
    $cadena = '';
    if(count($tecnicos_armado)>0){
      foreach ($tecnicos_armado as $key => $value) {
           $cadena.= $value->id_tecnico.',';
      }
      $cadena = substr ($cadena, 0, strlen($cadena) - 1);
    }
    return $cadena;
  }
  public function getTecnicosByStatusAndProyect($proyectoId='',$status=''){
    return $this->db->select('*')->where('proyectoId',$proyectoId)->where('status',$status)->join('bodyshop_tecnicos','bodyshop_tecnicos_estatus.id_tecnico=bodyshop_tecnicos.id')->get('bodyshop_tecnicos_estatus')->result();
  }
  //Obtener valor actual del detalle de laminado en base al técnico y al catálogo de laminado
  public function getValorFalla($idfalla='',$proyectoId='',$idtecnico=''){
    $q = $this->db->where('proyectoId',$proyectoId)->where('idfalla',$idfalla)->where('idtecnico',$idtecnico)->select('valor')->get('bodyshop_detalle_fallas');
    if($q->num_rows()==1){
      return $q->row()->valor;
    }else{
      return 0;
    }
    exit();
  }
  //Obtiene los valores para la gráfica por técnico, estatus y proyecto
  public function getValuesbk($proyectoId='',$status=''){
    return $this->db->where('proyectoId',$proyectoId)->where('status',$status)->select('tecnico,valor')->join('bodyshop_tecnicos','bodyshop_detalle_fallas.idtecnico = bodyshop_tecnicos.id')->get('bodyshop_detalle_fallas')->result();
  }
  //Obtiene los valores para la gráfica por técnico, estatus y proyecto
  public function getValues($proyectoId='',$status=''){
    return $this->db->where('proyectoId',$proyectoId)->where('status',$status)->select('idfalla, valor, tecnico')->join('bodyshop_tecnicos','bodyshop_detalle_fallas.idtecnico = bodyshop_tecnicos.id')->order_by('idtecnico , idfalla')->get('bodyshop_detalle_fallas')->result();
  }
  //Obtiene el último técnico asignado a un proyecto y a un estatus
  public function GetLastTec($proyectoId='',$status=''){
    $q = $this->db->select('id_tecnico')->where('status',$status)->order_by('fecha','desc')->limit(1)->get('bodyshop_tecnicos_estatus');
    if($q->num_rows()==1){
      return $q->row()->id_tecnico;
    }else{
      return 0;
    }
  }
  //Función obtiene el id del último técnico en base a los tipos mecánico, laminero, pintor, pulidor
  public function GetLastTecByStatus($tipo=''){
    $q = $this->db->select('id')->where('tipo',$tipo)->where('activo',1)->order_by('id','desc')->limit(1)->get('bodyshop_tecnicos');
    if($q->num_rows()==1){
      return $q->row()->id;
    }else{
      return 0;
    }
  }
  //Saber si a un proyecto en un estatus ya se le asigno técnico
  public function ExistsTec($proyectoId='',$status=''){
    $q = $this->db->where('proyectoId',$proyectoId)->where('status',$status)->limit(1)->get('bodyshop_tecnicos_estatus');
    if($q->num_rows()==1){
      return 1;
    }else{
      return 0;
    }
  }
  //obtener los técnicos por estatus 
  public function getTecnicosByStatus($proyectoId=''){
    $query = "select b.tecnico,be.nombre as estatus from bodyshop_tecnicos_estatus bt join bodyshop_tecnicos b on bt.id_tecnico = b.id join bodyshop_estatus be on bt.status = be.estatusId where bt.proyectoId =".$proyectoId;
    return $this->db->query($query)->result();
  }
  //Obtener diferencia entre fechas
  public function getDiffDate($fecha_fin=''){
    if($fecha_fin=='0000-00-00'){
      return '';
    }
    $date1 = new DateTime(date('Y-m-d'));
    if($fecha_fin==''){
      return '';
    }
    $date2 = new DateTime($fecha_fin);
    $diff = $date1->diff($date2);
    // will output 2 days
    return $diff->days . ' días ';
  }
  public function getHistorialComentarios($proyectoId=''){
    return $this->db->order_by('fecha','desc')->where('proyectoId',$proyectoId)->get('v_comentarios_proyecto_estatus')->result();
  }
  //Ver si tiene permisos el usuario 
  public function getPermiso($idadmin='',$status=''){
    $q = $this->db->where('idadmin',$idadmin)->where('status',$status)->get('bodyshop_permisos_estatus');
    if($q->num_rows()==1){
      return 1;
    }else{
      return 0;
    }
  }
  public function getTransiciones($proyectoId=''){
    return $this->db->select('bt.fecha,be1.nombre as estatus_anterior,be2.nombre as estatus_nuevo,bt.nuevo_estatus_id')->join('bodyshop_estatus be1','bt.anterior_estatus_id = be1.estatusId')->join('bodyshop_estatus be2','bt.nuevo_estatus_id = be2.estatusId')->where('proyecto_id',$proyectoId)->get('bodyshop_transiciones bt')->result();
  }
  //Ver si tiene permisos el usuario 
  public function getFechaCreacion($proyectoId=''){
    $q = $this->db->where('proyectoId',$proyectoId)->get('bodyshop');
    if($q->num_rows()==1){
      return $q->row()->proyectoFechaCreacion;
    }else{
      return '';
    }
  }
  //Obtener las horas que de cada estatus
  public function getHorasEstatus($estatusId=''){
    $q = $this->db->where('estatusId',$estatusId)->get('bodyshop_estatus');
    if($q->num_rows()==1){
      return (int)$q->row()->horas;
    }else{
      return '';
    }
  }
  //Obtener las graficas por ténicos
  public function tiempos_tecnicos($id_tecnico='',$status=''){
      $fecha_inicio = $this->input->post('fecha_inicio');
      $fecha_fin = $this->input->post('fecha_fin');
      $where_fecha = '';
      if($fecha_inicio!='' && $fecha_fin!=''){
        $where_fecha = " and date(proyectoFechaCreacion) >='".date2sql($fecha_inicio)."'".' and date(proyectoFechaCreacion) <='."'".date2sql($fecha_fin)."'";
       
      }else if($fecha_inicio!='' && $fecha_fin==''){
        $where_fecha = " and date(proyectoFechaCreacion) >='".date2sql($fecha_inicio)."'".' and date(proyectoFechaCreacion) <='."'".date('Y-m-d')."'";
      }else if($fecha_inicio=='' && $fecha_fin!=''){
        $where_fecha = " and date(proyectoFechaCreacion) >='".date('Y-m-d')."'".' and date(proyectoFechaCreacion) <='."'".date2sql($fecha_fin)."'";
      }

    $query = "select b.proyectoId,bte.id_tecnico,concat(b.proyectoNombre,'-',b.proyectoId) as proyectoNombre,bt.nuevo_estatus_id,bt.fecha ,be.nombre as estatus,be.horas,(select fecha from bodyshop_transiciones where proyecto_id = b.proyectoId and anterior_estatus_id = bt.nuevo_estatus_id and nuevo_estatus_id = ".($status+1)." group by b.proyectoId) as fecha_siguiente, concat('bodyshop/ver_proyecto/',b.proyectoId) as url from bodyshop_tecnicos_estatus bte join bodyshop b on bte.proyectoId = b.proyectoId join bodyshop_transiciones bt on bt.proyecto_id = b.proyectoId and bt.nuevo_estatus_id = bte.status join bodyshop_estatus be on be.estatusId= bte.status where bte.id_tecnico = ".$id_tecnico.$where_fecha." group by b.proyectoId";
      //echo $query;die();
    return $this->db->query($query)->result();
  }
  //  Nuevas funciones para búsquedas de proyectos
  public function buscar_proyectos(){   

        $page=$this->input->get('per_page');
          $this->load->library('pagination');
          $paginaNum=50;
          $config = array();
          $config["base_url"] = site_url() . "/bodyshop/buscar_proyectos?";
          $total_row = $this->getProyectos(true,'','');
          $total_row = $total_row[0]->id;

          //echo $total_row;die();
          $config["total_rows"] = $total_row;
          $config["per_page"] = $paginaNum;
          $config['page_query_string'] = TRUE;
          $config['display_pages'] = TRUE;
          $config['use_page_numbers'] = TRUE;
          $config['num_links'] = $total_row;
          $config['cur_tag_open'] = '&nbsp;<a class="current">';
          $config['cur_tag_close'] = '</a>';
          $config['next_link'] = 'Siguiente';
          $config['prev_link'] = 'Anterior';
          $config['clase'] = 'busquedalink';
          $this->pagination->initialize($config);

         if($page!=''){
          $page = (($page-1)*($config["per_page"]));
          }else{
            $page = 0;
          }
          $data["links"] = $this->pagination->create_links();
          $data['tabla'] = $this->getTablaProyectos($config["per_page"],$page);
          $data['resultados'] = $total_row;


          $data['total'] = $this->db->select("count(bodyshop.proyectoId) as id")->from('bodyshop')->count_all_results();
        return $this->blade
                ->set_data($data)    //Datos que e van a mostrar en la página
                ->render('bodyshop/v_busqueda_proyectos',$data,TRUE); //Nombre de mi vista

    }
    public function getTablaProyectos($limit='',$start=''){
      $tmpl = array (
        'table_open' => '<table table-responsive border="0" id="tbl" cellpadding="4" cellspacing="0" class="table table-striped table-bordered table-hover">');
      $this->table->set_template($tmpl);
      $this->table->set_heading('Fecha de creación','Estatus','Proyecto','Auto','Avance','Acciones');


      $res=$this->getProyectos(false,$limit,$start);
      //echo $this->db->last_query();die();
      if(count($res)>0){ 
        foreach ($res as $item) {
          $row=array();
          $row[]=$item->proyectoFechaCreacion;
          $row[]=array('data'=>'<span class="label label-primary">'.$item->nombre.'</span>','class'=>'project-status');
          $row[]=array('data'=>'<a>'.$item->proyectoNombre.'</a><br/><small>Fecha de entrega:'.$item->fecha_fin.'</small>','class'=>'project-title');
          
          $row[]=array('data'=>'<a>Placas: '.$item->vehiculo_placas.'</a><br/><small>Modelo: '.$item->vehiculo_modelo.'</small>','class'=>'project-title');

          //$data['progress'] = ($this->getOrder($item->status) * 100)/17;

          $row[]=array('data'=>'<div class="progress progress-mini"><div style="width: '.($this->getOrder($item->status) * 100)/17 .'%" class="progress-bar"></div></div>','class'=>'project-completion');

          $acciones = '';
          $acciones.= '<a href="bodyshop/ver_proyecto/'.$item->proyectoId.'" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> Ver </a> ';

          $acciones.= '<a class="editar_cita btn btn-white btn-sm" data-id_proyecto="'.$item->proyectoId.'"> <i class="fa fa-pencil-square-o"></i> Editar </a>';

          $acciones.='<button type="button" class="btn btn-white btn-sm jsTimeline" data-id="'.$item->proyectoId.'"><i class="fa fa-calendar"></i></button>';

          
          $row[]=array('data'=>$acciones,'class'=>'project-actions','style'=>'text-align:left;');
//$row[]='<span title="'.$item->vehiculo_modelo.'">'.trim_text($item->vehiculo_modelo,1).'</span>';

          $this->table->add_row($row);
        }
      }else{
        $row=array();
        $row[]=array('class'=>'text-center col-sm-1','data'=>'No hay registros para mostrar','colspan'=>16);
        $this->table->add_row($row);
      }
      return $this->table->generate();
    }
    public function getProyectos($iscount=true,$limit='',$start=''){
      //Si llega el técnic hacer el join
      if($this->input->post('id_tecnico')){
        $tipo_tecnicos = $this->getTipoTecnico($this->input->post('id_tecnico'));
        if($tipo_tecnicos!=''){
          $this->db->join('bodyshop_tecnicos_estatus', 'bodyshop_tecnicos_estatus.proyectoId  = bodyshop.proyectoId');
          $this->db->where('bodyshop_tecnicos_estatus.status',$tipo_tecnicos);
          $this->db->where('bodyshop_tecnicos_estatus.id_tecnico',$this->input->post('id_tecnico'));
        }

      }

      if($start!='' && $limit !=''){
        $this->db->limit($limit,$start);
      }else{
        $this->db->limit(50,0);
      }

      if($this->input->post('status')!=''){
        $this->db->where('bodyshop.status',$this->input->post('status'));
      }
      if($this->input->post('placas')!=''){
        $this->db->like('vehiculo_placas',$this->input->post('placas'));
      }
      if($this->input->post('modelo')!=''){
        $this->db->like('vehiculo_modelo',$this->input->post('modelo'));
      }

      if($this->input->post('asesor')!=''){
        $this->db->where('asesor',$this->input->post('asesor'));
      }
      if($this->input->post('proyectoNombre')!=''){
        $this->db->where('proyectoNombre',$this->input->post('proyectoNombre'));
      }

      
      if($iscount){
        $this->db->select('count(bodyshop.proyectoId) as id');
      }else{
        $this->db->select('*');

      } 
      //$this->db->where('a.fecha >=',date2sql($this->input->post('finicio')));
      $fecha_inicio = $this->input->post('fecha_inicio');
      $fecha_fin = $this->input->post('fecha_fin');
      if($fecha_inicio!='' && $fecha_fin!=''){
        $this->db->where('date(proyectoFechaCreacion) >=',date2sql($fecha_inicio));
        $this->db->where('date(proyectoFechaCreacion) <=',date2sql($fecha_fin));
      }else if($fecha_inicio!='' && $fecha_fin==''){
        $this->db->where('date(proyectoFechaCreacion) >=',date2sql($fecha_inicio));
        $this->db->where('date(proyectoFechaCreacion) <=',date('Y-m-d'));
      }else if($fecha_inicio=='' && $fecha_fin!=''){
        $this->db->where('date(proyectoFechaCreacion) >=',date('Y-m-d'));
        $this->db->where('date(proyectoFechaCreacion) <=',date2sql($fecha_inicio));
      }


      $this->db->join('bodyshop_participantes', 'bodyshop_participantes.ppIdProyecto  = bodyshop.proyectoId ');
      $this->db->join('bodyshop_estatus', 'bodyshop.status  = bodyshop_estatus.estatusId ');
      $this->db->where('ppIdAdmin',$this->session->userdata('id'));
      $this->db->where('tipo',1);
      $this->db->where('bodyshop.status !=',12);
      $this->db->order_by('proyectoFechaCreacion','desc');
      return $this->db->get('bodyshop')->result();  



    }
    //Sabe el técnico de que es
    public function getTipoTecnico($idtecnico=''){
    $q = $this->db->where('id',$idtecnico)->get('bodyshop_tecnicos');
    if($q->num_rows()==1){
      $tipo = $q->row()->tipo;
      switch ($tipo) {
        case 'Laminero':
          return 7;
          break;
        case 'Pintor':
        return 8;
        break;
        case 'Mecánico':
        return 6;
        break;

        default:
          # code...
          break;
      }
    }else{
      return '';
    }
  }
}

