<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**

 **/
class bodyshop extends MX_Controller {

    /**

     **/
    public function __construct()
    {
        parent::__construct();

        $this->load->model('principal', '', TRUE);
        $this->load->model('m_catalogos', 'mcatalogos', TRUE);
        $this->load->library(array('session','blade','form_validation','zip','table'));
        $this->load->helper(array('form', 'html', 'companies', 'url','dompdf','date','download'));
        $this->load->model('m_citas', 'mcat', TRUE);
        $this->load->model('presupuesto/m_presupuesto', 'mp', TRUE);
        if(!$this->session->userdata('id')){redirect('login');}
        date_default_timezone_set('America/Mexico_City');

        
    }

    public function index(){
      $data['tabla'] = $this->principal->buscar_proyectos();//
      $data['datos'] = $this->principal->get_row('adminId', $this->session->userdata('id'), 'admin');

      //debug_var($data['datos']);die();
      $data['drop_status'] = form_dropdown('status',array_combos($this->mcatalogos->get('bodyshop_estatus','orden','asc'),'estatusId','nombre',TRUE),'','class="form-control busqueda" id="status"'); 

      $data['input_placas'] = form_input('placas','','class="form-control" rows="5" id="placas" ');

      $data['input_modelo'] = form_input('modelo','','class="form-control" rows="5" id="modelo" ');

      $data['drop_asesores'] = form_dropdown('asesor',array_combos($this->mcatalogos->get('operadores','id','nombre'),'id','nombre',TRUE),'','class="form-control busqueda" id="asesor"'); 

      $data['drop_tecnicos'] = form_dropdown('id_tecnico',array_combos($this->mcatalogos->get('bodyshop_tecnicos','id','tecnico'),'id','tecnico',TRUE),'','class="form-control busqueda" id="id_tecnico"'); 

      $data['input_fecha_inicio'] = form_input('fecha_inicio',"",'class="form-control" id="fecha_inicio" ');
      $data['input_fecha_fin'] = form_input('fecha_fin',"",'class="form-control" id="fecha_fin" ');

      $content = $this->load->view('bodyshop/proyectos', $data, true);
      $this->load->view('main/panel', array('content'=>$content,
                                            'included_js'=>array('')));

    }
    public function indexbk(){
      $data['proyectos'] = $this->principal->bodyshop_par($this->session->userdata('id'));//get_result_proyectos('proyectoIdAdmin',$this->session->userdata('id'),'proyectos');
      //echo $this->db->last_query();die();
      //debug_var($data['proyectos']);die();
      //echo $this->db->last_query();die();
      $data['datos'] = $this->principal->get_row('adminId', $this->session->userdata('id'), 'admin');

      //debug_var($data['datos']);die();
      $content = $this->load->view('bodyshop/proyectos', $data, true);
      $this->load->view('main/panel', array('content'=>$content,
                                            'included_js'=>array('')));

    }
    public function buscar_proyectos(){
      echo $this->principal->buscar_proyectos();
    }
    public function backup(){
      if($this->session->userdata('login_backup')){
          $data['proyectos'] = $this->principal->bodyshop_par($this->session->userdata('id'),true);//get_result_proyectos('proyectoIdAdmin',$this->session->userdata('id'),'proyectos');
        //echo $this->db->last_query();die();
        //debug_var($data['proyectos']);die();
        //echo $this->db->last_query();die();
        $data['datos'] = $this->principal->get_row('adminId', $this->session->userdata('id'), 'admin');

        //debug_var($data['datos']);die();
        $content = $this->blade->render('bodyshop/backup', $data, true);
        $this->load->view('main/panel', array('content'=>$content,
                                              'included_js'=>array('')));
      }else{
        $this->blade->render('login_backup',array('tipo'=>1));
      }

    }

    public function crear_proyecto($modal=false){
      $info=new Stdclass();
      $data['datos'] = $this->principal->get_row('adminId', $this->session->userdata('id'), 'admin');
      
      $data['drop_vehiculo_anio'] = form_dropdown('save[vehiculo_anio]',array_combos($this->mcat->get('cat_anios','anio','desc'),'anio','anio',TRUE),set_value('vehiculo_anio',exist_obj($info,'vehiculo_anio')),'class="form-control busqueda" id="vehiculo_anio"'); 
      $data['numero_siniestro'] = form_input('save[numero_siniestro]',set_value('numero_siniestro',exist_obj($info,'numero_siniestro')),'class="form-control" rows="5" id="numero_siniestro" ');
      $data['numero_poliza'] = form_input('save[numero_poliza]',set_value('numero_poliza',exist_obj($info,'numero_poliza')),'class="form-control" rows="5" id="numero_poliza" ');
      $data['input_vehiculo_placas'] = form_input('save[vehiculo_placas]',set_value('vehiculo_placas',exist_obj($info,'vehiculo_placas')),'class="form-control" rows="5" id="vehiculo_placas" ');
      $data['drop_color'] = form_dropdown('save[id_color]',array_combos($this->mcat->get('cat_colores','color'),'id','color',TRUE),set_value('id_color',exist_obj($info,'id_color')),'class="form-control busqueda" id="id_color"');
      $data['drop_vehiculo_modelo'] = form_dropdown('save[vehiculo_modelo]',array_combos($this->principal->get_table_order('bodyshop_modelos','modelo','ASC'),'modelo','modelo',TRUE),set_value('vehiculo_modelo',exist_obj($info,'vehiculo_modelo')),'class="form-control busqueda" id="vehiculo_modelo"'); 
      $data['input_vehiculo_numero_serie'] = form_input('save[vehiculo_numero_serie]',set_value('vehiculo_numero_serie',exist_obj($info,'vehiculo_numero_serie')),'class="form-control" rows="5" id="vehiculo_numero_serie" ');
      $data['drop_asesor'] = form_dropdown('save[asesor]',array_combos($this->principal->get_table_order('operadores','nombre','asc'),'id','nombre',TRUE),set_value('asesor',exist_obj($info,'asesor')),'class="form-control busqueda" id="asesor"');

      $info_horario=new Stdclass();
      $id_horario = 0;

      if(isset($info_horario->fecha)){
          $fecha = $info_horario->fecha;
        }else{
          $fecha = date('Y-m-d');
        }
        //$id_asesor=$info->asesor;
        $id_asesor=0;
          $opciones_fecha = array_combos_fechas($this->principal->getFechasAsesor($id_asesor,$fecha),'fecha','fecha',TRUE);
        $disabled = '';
        
        $data['drop_fecha'] = form_dropdown('save[fecha]',$opciones_fecha,set_value('fecha',exist_obj($info_horario,'fecha')),'class="form-control" id="fecha" '); 

        $opciones_horario = array();
        $data['drop_horario'] = form_dropdown('save[id_horario]',$opciones_horario,set_value('id',exist_obj($info_horario,'id')),'class="form-control" id="horario" ');

      //Tipo de golpe
        $opciones_golpe = array(''=>'-- Selecciona --','A'=>'A','B'=>'B','C'=>'C','D'=>'D');
        $data['drop_tipo_golpe'] = form_dropdown('save[tipo_golpe]',$opciones_golpe,set_value('tipo_golpe',exist_obj($info,'tipo_golpe')),'class="form-control" id="tipo_golpe" ');



      $data['input_comentarios'] = form_textarea('save[comentarios_servicio]',set_value('comentarios_servicio',exist_obj($info,'comentarios_servicio')),'class="form-control" id="comentarios_servicio" rows="2"');
      $data['input_email'] = form_input('save[datos_email]',set_value('datos_email',exist_obj($info,'datos_email')),'class="form-control" rows="5" id="datos_email" ');
      $data['input_datos_password'] = form_password('save[datos_password]',set_value('datos_password',exist_obj($info,'datos_password')),'class="form-control" rows="5" id="datos_password" ');

      $data['input_datos_nombres'] = form_input('save[datos_nombres]',set_value('datos_nombres',exist_obj($info,'datos_nombres')),'class="form-control"  id="datos_nombres" ');
      $data['input_datos_apellido_paterno'] = form_input('save[datos_apellido_paterno]',set_value('datos_apellido_paterno',exist_obj($info,'datos_apellido_paterno')),'class="form-control"  id="datos_apellido_paterno" ');
      $data['input_datos_apellido_materno'] = form_input('save[datos_apellido_materno]',set_value('datos_apellido_materno',exist_obj($info,'datos_apellido_materno')),'class="form-control"  id="datos_apellido_materno" ');
      $data['input_datos_telefono'] = form_input('save[datos_telefono]',set_value('datos_telefono',exist_obj($info,'datos_telefono')),'class="form-control"  id="datos_telefono" ');
      $data['input_datos_telefono2'] = form_input('save[datos_telefono2]',set_value('datos_telefono2',exist_obj($info,'datos_telefono2')),'class="form-control"  id="datos_telefono2" ');
      $data['drop_proyectoNombre'] = form_dropdown('save[proyectoNombre]',array_combos($this->principal->get_table_order('bodyshop_tipo','nombre','ASC'),'nombre','nombre',TRUE),set_value('bodyshop_tipo',exist_obj($info,'bodyshop_tipo')),'class="form-control busqueda" id="proyectoNombre"'); 

      $dia_completo = 0;
      $data['drop_id_status_color'] = form_dropdown('save[id_status_color]',array_combos($this->principal->get_table_order('estatus','nombre','ASC'),'id','nombre',TRUE),set_value('id_status_color',exist_obj($info,'id_status_color')),'class="form-control busqueda" id="id_status_color"'); 
      $data['input_dia_completo'] = form_checkbox('save[dia_completo]',$dia_completo,($dia_completo==1)?'checked':'','class="" id="dia_completo" ');
      $data['drop_tecnicos_dias'] = form_dropdown('save[tecnico_dias]',array_combos($this->mcat->get('tecnicos','nombre'),'id','nombre',TRUE),set_value('tecnico_dias',exist_obj($info,'tecnico_dias')),'class="form-control busqueda" id="tecnico_dias"');
      $data['input_fecha_inicio'] = form_input('save[fecha_inicio]',set_value('fecha_inicio',exist_obj($info,'fecha_inicio')),'class="form-control" id="fecha_inicio" ');
      $data['input_fecha_fin'] = form_input('save[fecha_fin]',set_value('fecha_fin',exist_obj($info,'fecha_fin')),'class="form-control" id="fecha_fin" ');
      $data['input_hora_comienzo'] = form_input('save[hora_comienzo]',set_value('hora_comienzo',exist_obj($info,'hora_comienzo')),'class="form-control" id="hora_comienzo" ');
      $data['input_fecha_parcial'] = form_input('save[fecha_parcial]',set_value('fecha_inicio',exist_obj($info,'fecha_parcial')),'class="form-control" id="fecha_parcial" ');
      $data['input_hora_inicio_extra'] = form_input('save[hora_inicio_extra]',"",'class="form-control" id="hora_inicio_extra" ');
      $data['input_hora_fin_extra'] = form_input('save[hora_fin_extra]',set_value('hora_fin',exist_obj($info,'hora_fin')),'class="form-control" id="hora_fin_extra" ');
      $data['drop_tecnicos'] = form_dropdown('save[tecnico]',array_combos($this->mcat->get('tecnicos','nombre'),'id','nombre',TRUE),set_value('tecnico',exist_obj($info,'tecnico')),'class="form-control" id="tecnicos" '); 
      $data['input_hora_inicio'] = form_input('save[hora_inicio]',set_value('hora_inicio',exist_obj($info,'hora_inicio')),'class="form-control" id="hora_inicio" ');
      $data['input_hora_fin'] = form_input('save[hora_fin]',set_value('hora_fin',exist_obj($info,'hora_fin')),'class="form-control" id="hora_fin" ');

      $tablero = 1;
      $data['input_tablero'] = form_checkbox('save[tablero]',$tablero,($tablero==1)?'checked':'','class="" id="tablero" ');
      $data['modal']=$modal;
      if($modal== true){
        $content = $this->blade->render('bodyshop/crear_proyecto', $data, true);
        echo $content;
        exit;
      }
      $data['transito'] = 0;
      $content = $this->blade->render('bodyshop/crear_proyecto', $data, true);
      $this->load->view('main/panel', array('content' => $content,
                                            'included_js'=>array('')));
    }

    public function editar_proyecto()
    {
        $idProyecto = $this->uri->segment(3);
        
        $data['inputs'] = $this->precargar_detalle_proyecto($idProyecto);
        //debug_var($data['inputs']);die();
        $data['comentarios'] =$this->principal->get_result_order('comentarioIdProyecto', $idProyecto,'bodyshop_comentarios','comentarioId','desc');
        $data['descargables'] = $this->principal->get_result_order('descargableIdProyecto', $idProyecto,'bodyshop_desargable','descargableId','desc');
        $data['transito'] = $data['inputs']['transito'];
        $content = $this->blade->render('bodyshop/detalle_proyecto', $data, true);
        $this->load->view('main/panel', array('content' => $content,'included_js'=>array('')));
    }

    public function precargar_detalle_proyecto($id)
    {

      $reg = $this->principal->get_row('proyectoId', $id, 'bodyshop');
      $data['transito'] = $reg->transito;
      $tipo = $this->principal->get_row('id', $reg->tipo, 'bodyshop_tipo');
      $usuario = $this->principal->get_row('idusuarios', $reg->idusuario_bodyshop, 'bodyshop_usuarios');
      
      $estatus = $this->principal->get_row('id',$reg->id_status_color,'estatus');
      $color = $this->principal->get_row('id',$reg->id_color,'colores');
      $asesores = $this->principal->get_row('id',$reg->asesor,'operadores');
      $data['id_proyecto'] = $id;

      $info=new Stdclass();
      $data['drop_vehiculo_anio'] = form_dropdown('save[vehiculo_anio]',array_combos($this->mcat->get('cat_anios','anio','desc'),'anio','anio',TRUE),$reg->vehiculo_anio,'class="form-control busqueda" id="vehiculo_anio"'); 
      //form_input('save[vehiculo_anio]',isset($reg->vehiculo_anio) ? $reg->vehiculo_anio :'','class="form-control busqueda"  id="vehiculo_anio"'); 
      $data['numero_siniestro'] = form_input('save[numero_siniestro]',isset($reg->numero_siniestro) ? $reg->numero_siniestro :'','class="form-control" rows="5" id="numero_siniestro" ');
      $data['numero_poliza']    = form_input('save[numero_poliza]',isset($reg->numero_poliza) ? $reg->numero_poliza :'','class="form-control"  rows="5" id="numero_poliza"');
      $data['datos_password']    = form_password('save[datos_password]',isset($usuario->password) ? $usuario->password :'','class="form-control"  rows="5" id="datos_password"');
      
      $data['proyectoCliente']    = form_input('save[proyectoCliente]',isset($reg->proyectoCliente) ? $reg->proyectoCliente :'','class="form-control"  rows="5" id="numero_poliza"');
      $data['proyectoDescripcion']    = form_input('save[proyectoDescripcion]',isset($reg->proyectoDescripcion) ? $reg->proyectoDescripcion :'','class="form-control"  rows="5" id="numero_poliza"');
      $data['input_vehiculo_placas'] = form_input('save[vehiculo_placas]',isset($reg->vehiculo_placas) ? $reg->vehiculo_placas :'','class="form-control"  rows="5" id="vehiculo_placas" ');
      
      $data['drop_color'] = form_dropdown('save[id_color]',array_combos($this->mcat->get('cat_colores','color'),'id','color',TRUE),$reg->id_color,'class="form-control busqueda" id="id_color"');
      
      //form_input('save[id_color]',isset($color->id_color) ? $color->color :'','class="form-control busqueda" id="id_color"');
      $data['drop_vehiculo_modelo'] = form_dropdown('save[vehiculo_modelo]',array_combos($this->principal->get_table_order('bodyshop_modelos','modelo','ASC'),'modelo','modelo',TRUE),$reg->vehiculo_modelo,'class="form-control busqueda" id="vehiculo_modelo"'); 
      //form_input('save[vehiculo_modelo]',isset($reg->vehiculo_modelo) ? $reg->vehiculo_modelo :'','class="form-control busqueda"  id="vehiculo_modelo"'); 
      $data['input_vehiculo_numero_serie'] = form_input('save[vehiculo_numero_serie]',isset($reg->vehiculo_numero_serie) ? $reg->vehiculo_numero_serie :'','class="form-control" rows="5" id="vehiculo_numero_serie" ');
      
      $data['drop_asesor'] = form_dropdown('save[asesor]',array_combos($this->principal->get_table_order('operadores','nombre','asc'),'id','nombre',TRUE),$reg->asesor,'class="form-control busqueda" id="asesor"');

      //debug_var($reg);die();
       $opciones_golpe = array(''=>'-- Selecciona --','A'=>'A','B'=>'B','C'=>'C','D'=>'D');
      $data['drop_tipo_golpe'] = form_dropdown('save[tipo_golpe]',$opciones_golpe,set_value('tipo_golpe',exist_obj($reg,'tipo_golpe')),'class="form-control" id="tipo_golpe" ');
      //debug_var($data['drop_tipo_golpe']);die();
      //form_input('save[asesor]',isset($asesores->nombre) ? $asesores->nombre :'','class="form-control busqueda" id="asesor"');
      
      $info_horario=new Stdclass();
      $id_horario = 0;

      if(isset($info_horario->fecha)){
          $fecha = $info_horario->fecha;
        }else{
          $fecha = date('Y-m-d');
      }
        //$id_asesor=$info->asesor;
      $id_asesor=0;
      $opciones_fecha = array_combos_fechas($this->principal->getFechasAsesor($id_asesor,$fecha),'fecha','fecha',TRUE);
      $disabled = '';
      
      $data['drop_fecha'] = form_dropdown('save[fecha]',$opciones_fecha,set_value('fecha',exist_obj($info_horario,'fecha')),'class="form-control" id="fecha" '); 
      $opciones_horario = array();
      $data['drop_horario'] = form_dropdown('save[id_horario]',$opciones_horario,set_value('id',exist_obj($info_horario,'id')),'class="form-control" id="horario" ');
      // $data['drop_fecha'] = form_input('save[fecha]',isset($reg->fecha) ? $reg->fecha :'','class="form-control"  id="fecha" '); 
      // $data['drop_horario'] = form_input('save[id_horario]',isset($reg->id_horario) ? $reg->id_horario :'','class="form-control"  id="horario" ');

      $data['input_comentarios'] = form_textarea('save[comentarios_servicio]',isset($reg->comentarios_servicio) ? $reg->comentarios_servicio :'','class="form-control" id="comentarios_servicio" rows="2"');
      $data['input_email'] = form_input('save[datos_email]',isset($reg->datos_email) ? $reg->datos_email :'','class="form-control" rows="5"  id="datos_email" ');

      $data['input_datos_nombres'] = form_input('save[datos_nombres]',isset($reg->datos_nombres) ? $reg->datos_nombres :'','class="form-control"  id="datos_nombres" ');
      $data['input_datos_apellido_paterno'] = form_input('save[datos_apellido_paterno]',isset($reg->datos_apellido_paterno) ? $reg->datos_apellido_paterno :'','class="form-control"  id="datos_apellido_paterno" ');
      $data['input_datos_apellido_materno'] = form_input('save[datos_apellido_materno]',isset($reg->datos_apellido_materno) ? $reg->datos_apellido_materno :'','class="form-control"  id="datos_apellido_materno" ');
      $data['input_datos_telefono'] = form_input('save[datos_telefono]',isset($reg->datos_telefono) ? $reg->datos_telefono :'','class="form-control"  id="datos_telefono" ');
      $data['input_datos_telefono2'] = form_input('save[datos_telefono2]',isset($reg->datos_telefono2) ? $reg->datos_telefono2 :'','class="form-control"  id="datos_telefono2" ');
      
      $data['drop_proyectoNombre'] = form_dropdown('save[proyectoNombre]',array_combos($this->principal->get_table_order('bodyshop_tipo','nombre','ASC'),'nombre','nombre',TRUE),isset($tipo->nombre) ? $tipo->nombre :'','class="form-control busqueda" id="proyectoNombre"'); 
      //form_input('save[proyectoNombre]',isset($reg->proyectoNombre) ? $reg->proyectoNombre :'','class="form-control busqueda"  id="proyectoNombre"'); 

      $data['drop_id_status_color'] = form_dropdown('save[id_status_color]',array_combos($this->principal->get_table_order('estatus','nombre','ASC'),'id','nombre',TRUE),$reg->proyectoStatus,'class="form-control busqueda" id="id_status_color"');
      //form_input('save[id_status_color]',isset($reg->id_status_color) ? $reg->id_status_color :'','class="form-control busqueda"  id="id_status_color"'); 
      $data['drop_tecnicos_dias'] = form_input('save[tecnico_dias]',isset($reg->tecnico_dias) ? $reg->tecnico_dias :'','class="form-control busqueda" id="tecnico_dias"');
      
      $data['input_fecha_inicio'] = form_input('save[fecha_inicio]',date_eng2esp_1($reg->fecha_inicio),'class="form-control"  id="fecha_inicio" ');
      $data['input_fecha_fin'] = form_input('save[fecha_fin]',date_eng2esp_1($reg->fecha_fin),'class="form-control"  id="fecha_fin" ');
      $data['input_hora_comienzo'] = form_input('save[hora_comienzo]',isset($reg->hora_comienzo) ? $reg->hora_comienzo :'','class="form-control" id="hora_comienzo" ');
      $data['input_fecha_parcial'] = form_input('save[fecha_parcial]',isset($reg->fecha_parcial) ? $reg->fecha_parcial :'','class="form-control" id="fecha_parcial" ');
      $data['input_hora_inicio_extra'] = form_input('save[hora_inicio_extra]',isset($reg->hora_inicio_extra) ? $reg->hora_inicio_extra :'','class="form-control" id="hora_inicio_extra" ');
      $data['input_hora_fin_extra'] = form_input('save[hora_fin_extra]',isset($reg->hora_fin_extra) ? $reg->hora_fin_extra :'','class="form-control" id="hora_fin_extra" ');
      $data['drop_tecnicos'] = form_input('save[tecnico]',isset($reg->tecnico) ? $reg->tecnico :'','class="form-control" id="tecnicos" '); 
      $data['input_hora_inicio'] = form_input('save[hora_inicio]',isset($reg->hora_inicio) ? $reg->hora_inicio :'','class="form-control" id="hora_inicio" ');
      $data['input_hora_fin'] = form_input('save[hora_fin]',isset($reg->hora_fin) ? $reg->hora_fin :'','class="form-control" id="hora_fin" ');

      return $data;
    }

    public function saveModelo()
    {
      if($this->input->post())
      {
        $this->form_validation->set_rules('modelo', 'modelo', 'trim|required|xss_clean');
        if($this->form_validation->run() == TRUE)
        {
          $datos = array('modelo' => $this->input->post('modelo'));
          $id = $this->principal->insert('bodyshop_modelos',$datos);
          echo json_encode(array('success'=>true,'id'=>$this->input->post('modelo')));
        }else{
          $errors = array(
            'modelo' => form_error('modelo')
          );
          echo json_encode(array('success'=>false,"errors"=>$errors));
        }
        exit;

      }
      $info=new Stdclass();
      $data['input_modelo'] = form_input('modelo',set_value('modelo',exist_obj($info,'modelo')),'class="form-control" id="modelo" ');
      $this->load->view('bodyshop/save_modelo',$data);
    }

    public function getDropModelo()
    {
      $info=new Stdclass();
      $info->vehiculo_modelo=$this->input->post('id');
      $data['drop_vehiculo_modelo'] = form_dropdown('save[vehiculo_modelo]',array_combos($this->principal->get_table_order('bodyshop_modelos','modelo','ASC'),'modelo','modelo',TRUE),set_value('vehiculo_modelo',exist_obj($info,'vehiculo_modelo')),'class="form-control busqueda" id="vehiculo_modelo"'); 
      $this->load->view('bodyshop/p_drop_modelo',$data);
    }

    public function save_proyecto(){
        
        $post = $this->input->post('save');
       
        if(isset($post['fecha_inicio']))
          $post['fecha_inicio']=date2sql($post['fecha_inicio']);
        if(isset($post['fecha_fin']))
          $post['fecha_fin']=date2sql($post['fecha_fin']);
        if(isset($post['fecha_parcial']))
          $post['fecha_parcial']=date2sql($post['fecha_parcial']);
        if(!isset($post['dia_completo']))
          $post['dia_completo']=0;
        if(!isset($post['tablero']))
          $post['tablero']=0;

        if(!$post['tablero'])
          unset($post['id_horario']);

        $post['proyectoIdAdmin'] = $this->session->userdata('id');
        $post['proyectoFechaCreacion'] = date("Y-m-d H:i");
        $post['tipo'] = 1;

        //var_dump($post['tipo_golpe']);die();
        if($post['tipo_golpe'] == 'A'){
          $post['status'] = 7;
        }else{
          $post['status'] = 1;
        }
        

        $usuario = array('datos_email' => $post['datos_email'],'password'=> $post['datos_password'], 
                             'datos_nombres'=> $post['datos_nombres'], 'datos_apellido_paterno'=> $post['datos_apellido_paterno'],
                             'datos_apellido_materno'=> $post['datos_apellido_materno']);
        // $existeusuario = $this->principal->get_where_num_rows('datos_email', $post['datos_email'],'bodyshop_usuarios');

        $existeusuario = $this->principal->get_row('datos_email', $post['datos_email'], 'bodyshop_usuarios');
        
        if ($post['datos_email'] != '' && count($existeusuario) > 0 ) {
            
            $actualizaUsuario = $this->principal->update('datos_email', $post['datos_email'], 'bodyshop_usuarios', $usuario);
            if ($actualizaUsuario) {
                $obtenerusuarioActualizado = $this->principal->get_row("datos_email",$post['datos_email'],'bodyshop_usuarios');
                // $usuario['idusuario_bodyshop'] = $obtenerusuarioActualizado->idusuarios;
                $post['idusuario_bodyshop']= $obtenerusuarioActualizado->idusuarios;
            }

        }else{

          $post['idusuario_bodyshop']= $this->principal->insert('bodyshop_usuarios', $usuario);  
        }
        
        

        

        //unset($post['datos_password']);
        $postarray = array(
          'proyectoNombre'=>$post['proyectoNombre'],
          'proyectoCliente'=>$post['proyectoCliente'],
          'proyectoDescripcion'=>$post['proyectoDescripcion'],
          'numero_siniestro'=>$post['numero_siniestro'],
          'numero_poliza'=>$post['numero_poliza'],
          'vehiculo_anio'=>$post['vehiculo_anio'],
          'vehiculo_placas'=>$post['vehiculo_placas'],
          'id_color'=>$post['id_color'],
          'vehiculo_modelo'=>$post['vehiculo_modelo'],
          'vehiculo_numero_serie'=>$post['vehiculo_numero_serie'],
          'tablero'=>$post['tablero'],
          'asesor'=>$post['asesor'],
          'fecha'=>$post['fecha'],
          'id_horario'=>isset($post['id_horario']) ? $post['id_horario']: '',
          'id_status_color'=>$post['id_status_color'],
          'fecha_inicio'=>$post['fecha_inicio'],
          'fecha_fin'=>$post['fecha_fin'],
          'comentarios_servicio'=>$post['comentarios_servicio'],
          'datos_nombres'=>$post['datos_nombres'],
          'datos_apellido_paterno'=>$post['datos_apellido_paterno'],
          'datos_apellido_materno'=>$post['datos_apellido_materno'],
          'datos_telefono'=>$post['datos_telefono'],
          'datos_telefono2'=>$post['datos_telefono2'],
          'datos_email'=>$post['datos_email'],
          'dia_completo'=>$post['dia_completo'],
          'proyectoIdAdmin'=>$post['proyectoIdAdmin'],
          'tipo'=>$post['tipo'],
          'status'=>$post['status'],
          'idusuario_bodyshop'=>$post['idusuario_bodyshop'],
          'transito'=>$post['transito'],
          'tipo_golpe'=>$post['tipo_golpe']
        );
        //debug_var($postarray);die();
        if (isset($post['idproyecto'])) {
            if($post['tipo_golpe'] == 'A'){
              $post['status'] = 7;
            }else{
              unset($postarray['status']);
            }

            $this->principal->update_object('proyectoId','bodyshop',$post['idproyecto'], $postarray);
        }else{
          //debug_var($_POST);die();
        $postarray['proyectoFechaCreacion'] = $post['proyectoFechaCreacion'];
        $postarray['fecha_estatus'] = $post['proyectoFechaCreacion'];
        $this->load->library('enviar_correos');
        $dataCorreo = array('sendTo' => $post['datos_email'], 
                            'nombre'=> $post['datos_nombres'],
                            'password'=> $post['datos_password']);
          $res = $this->principal->insert('bodyshop', $postarray);

          $dataCorreo['idProyecto'] = $res;
          $this->enviar_correos->enviar_correo($dataCorreo);
          $id = $res;
          $this->principal->insert_preguntas($id);
          $this->principal->insert_conformidades($id);
          $id_parti = $this->session->userdata('id');
          $aux = $this->principal->get_participantes_bodyshop($id,$id_parti);
          
          if($aux!=1){
            $data['ppIdAdmin'] = $id_parti;
            $data['ppIdProyecto'] = $id;
            $data['fecha_creacion'] = date('Y-m-d');
            $this->principal->insert('bodyshop_participantes',$data);
          }
          //Cambiar estatus CAMBIO 10 JUL 18
          //print_r($_POST['save']['id_horario']);die();
          if(isset($_POST['save']['id_horario']) && $post['tablero']==1){
            $this->db->where('id',$_POST['save']['id_horario'])->set('ocupado',1)->update('bodyshop_aux');
          }
          //53 1  83 88 87 86 84 81 82 //INSERTAR SIEMPRE LOS PARTICIPANTES
          $res = $this->principal->get_result('ppIdProyecto', $id,'bodyshop_participantes');
        }


        redirect('bodyshop/');

    }

    //Asignar todos los participantes
    public function asignarTodosParticipantes(){
      //insertar siempre los mismos participantes
        $id = $this->input->post('idproyecto');
        $userId = $this->session->userdata('id');
        if($userId != 45)
          $this->db->set('ppIdAdmin',45)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');
        if($userId != 68)  
          $this->db->set('ppIdAdmin',68)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');
        if($userId != 53)
          $this->db->set('ppIdAdmin',53)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');
        if($userId != 1)  
          $this->db->set('ppIdAdmin',1)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');
        if($userId != 88)  
          $this->db->set('ppIdAdmin',88)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');
        if($userId != 87)  
          $this->db->set('ppIdAdmin',87)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');
        if($userId != 86)  
          $this->db->set('ppIdAdmin',86)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');
        if($userId != 84)  
          $this->db->set('ppIdAdmin',84)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');
        if($userId != 83)  
          $this->db->set('ppIdAdmin',83)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');
        if($userId != 89)
          $this->db->set('ppIdAdmin',89)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');

        if($userId != 98)
          $this->db->set('ppIdAdmin',98)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');

        if($userId != 99)
          $this->db->set('ppIdAdmin',99)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');

        if($userId != 100)
          $this->db->set('ppIdAdmin',100)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');

        if($userId != 101)
          $this->db->set('ppIdAdmin',101)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');

        if($userId != 102)
          $this->db->set('ppIdAdmin',102)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');

        if($userId != 103)
          $this->db->set('ppIdAdmin',103)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');

        if($userId != 104)
          $this->db->set('ppIdAdmin',104)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');

        if($userId != 105)
          $this->db->set('ppIdAdmin',105)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');

        if($userId != 106)
          $this->db->set('ppIdAdmin',106)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');

        if($userId != 109)
          $this->db->set('ppIdAdmin',106)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');

        if($userId != 108)
          $this->db->set('ppIdAdmin',106)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');

        if($userId != 50)
          $this->db->set('ppIdAdmin',50)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');

        if($userId != 118)
          $this->db->set('ppIdAdmin',118)->set('ppIdProyecto',$id)->set('fecha_creacion',date('Y-m-d'))->insert('bodyshop_participantes');

          //Actualizar que ya agregué los participantes 98 106
          $this->db->where('proyectoId',$id)->set('participantes_asignados',1)->set('fecha_creacion',date('Y-m-d'))->update('bodyshop');
          $res1 = $this->principal->get_result('ppIdProyecto', $id,'bodyshop_participantes');
          foreach($res1 as $noti):
            $notific['titulo'] = 'bodyshop';
            $notific['texto']= 'se agregaron nuevos participantes';
            $notific['id_user'] = $noti->ppIdAdmin;
            $notific['estado'] = 1;
            $notific['url'] = base_url().'index.php/bodyshop/ver_proyecto/'.$id;
            $notific['estadoWeb'] = 1;
            $this->principal->insert('noti_user',$notific);
          endforeach;
          echo 1;die();
    }

    public function insert_preguntas()
    {
      $res = $this->principal->get_table('bodyshop');
      foreach ($res as $key => $value) {
        $this->principal->insert_preguntas($value->proyectoId);
        $this->principal->insert_conformidades($value->proyectoId);
      }
      echo 'hecho';
    }


    public function ver_proyecto($id){
            $data['idproyectoall'] = $id;
            $data['cronograma'] =$this->principal->get_result_order('cronoIdProyecto',$id,'bodyshop_cronograma','cronoId','desc');
            $data['actividades'] =$this->principal->get_result_order('actividadIdProyecto',$id,'bodyshop_actividades','actividadId','desc');
            $data['comentarios'] =$this->principal->get_result_order('comentarioIdProyecto', $id,'bodyshop_comentarios','comentarioId','desc');
            $data['participantes'] = $this->principal->get_result('ppIdProyecto', $id,'bodyshop_participantes');
            $data['proyecto'] = $this->principal->get_row('proyectoId',$id,'bodyshop' );
            $data['asesor'] = $this->principal->get_row('id', $data['proyecto']->asesor,'operadores' );
            if(count($data['asesor'])==0)
            {
              $data['asesor'] = new stdClass();
              $data['asesor']->nombre='';
            }
            $data['estatus'] = $this->principal->get_row('estatusId',$data['proyecto']->status,'bodyshop_estatus' );
            $data['datos'] = $this->principal->get_row('adminId', $this->session->userdata('id'), 'admin');
            $data['progress'] = ($this->principal->getOrder($data['proyecto']->status) * 100)/17;
            $data['id_proyecto'] = $id;
            $data['descargables'] =$this->principal->get_result_order('descargableIdProyecto', $id,'bodyshop_desargable','descargableId','desc');
            $data['gastos'] =$this->principal->get_result('idProyecto', $id,'bodyshop_gasto_proyecto');
           

            // PITA 
            $todo = $this->mp->getDatos();
            
            //Técnicos asignados
            $data['tecnicos_asignados'] = $this->principal->getTecnicosByStatus($id);
            //debug_var($data['tecnicos_asignados']);die();
            $info= $this->mp->getProyectoById($id);
            $info=$info[0];

            $datos_proyecto = 1;
            //Obtiene los técnicos asignados
            $tecnicos_asignados = $this->principal->getTecnicosStatus($id);
            //print_r($tecnicos_asignados);die();
            $cadena = '';
            if(count($tecnicos_asignados)>0){
              foreach ($tecnicos_asignados as $key => $value) {
               $cadena.= $value->id_tecnico.',';
              }
              
              $cadena = substr ($cadena, 0, strlen($cadena) - 1);
              //echo $cadena;die();
            }
            $data['tecnicos_asignado'] = $this->principal->ExistsTec($id,$data['estatus']->estatusId); //1 si ya existe proyecto 0 no

            if(!$data['tecnicos_asignado']){
              $data['catalogo_tecnicos'] = $this->principal->getTecnicosByProyect($cadena,$data['estatus']->estatusId,$id);
            }else{
              $data['catalogo_tecnicos'] = array();
            }

            
            //echo $this->db->last_query();die();
            //drop para saber si es CRP
            //echo $this->db->last_query();die();
            //debug_var($data['catalogo_tecnicos']);die();
            $data['input_fecha'] = form_input('fecha',set_value('fecha',exist_obj($info,'fecha')),'class="form-control" id="fecha" ');

            $data['input_torre'] = form_input('torre',set_value('torre',exist_obj($info,'torre')),'class="form-control" id="torre" ');

            $data['input_tipo_vehiculo'] = form_input('tipo_vehiculo',set_value('tipo_vehiculo',exist_obj($info,'tipo_vehiculo')),'class="form-control" id="tipo_vehiculo" ');

            $data['input_placas'] = form_input('placas',set_value('placas',exist_obj($info,'vehiculo_placas')),'class="form-control" id="placas" ');

            $data['input_serie'] = form_input('serie',set_value('serie',exist_obj($info,'vehiculo_numero_serie')),'class="form-control" id="serie" ');

            $data['input_orden_reparacion'] = form_input('orden_reparacion',set_value('orden_reparacion',exist_obj($info,'orden_reparacion')),'class="form-control" id="orden_reparacion" ');

            $data['drop_color'] = form_dropdown('id_color',array_combos($this->mcatalogos->get('colores','color'),'id','color',TRUE),set_value('id_color',exist_obj($info,'id_color')),'class="form-control busqueda" id="id_color"');

            $data['drop_vehiculo_modelo'] = form_dropdown('idmodelo',array_combos($this->mcatalogos->get('bodyshop_modelos','modelo'),'modelo','modelo',TRUE),set_value('vehiculo_modelo',exist_obj($info,'vehiculo_modelo')),'class="form-control busqueda" id="idmodelo"'); 

             $data['input_aseguradora'] = form_input('aseguradora',set_value('aseguradora',exist_obj($info,'aseguradora')),'class="form-control" id="aseguradora" ');
            
            //si el estatus es refacciones mostrar el checkbox
            if($data['estatus']->estatusId == 5)
              $data['input_llegaron_refacciones'] = form_checkbox('llegaron_refacciones]',$data['proyecto']->llegaron_refacciones==1 ? true : false,'','class="jsLlegaronRefacciones" id="llegaron_refacciones" ');
            else
              $data['input_llegaron_refacciones'] ='';
            //

            //LO DE INDICADORES
            //Traerme el catálogo de acuerdo al estatus

            $data['catalogo_fallas_mecanica'] = $this->mcatalogos->get('bodyshop_cat_fallas','','',array('status'=>6));

            $data['catalogo_fallas_laminado'] = $this->mcatalogos->get('bodyshop_cat_fallas','','',array('status'=>7));

            $data['catalogo_fallas_pintura'] = $this->mcatalogos->get('bodyshop_cat_fallas','','',array('status'=>8));

            //debug_var($data['catalogo_fallas_laminado']);die();
            //FIN INDICADORES

            //Gráfica de mecánica

            $datos_mecanica = $this->principal->getValues($id,6);
            $array_valores_mecanica = array();
            //debug_var($datos_mecanica);die();

            foreach ($datos_mecanica as $key => $value) {
              $array_valores_mecanica[$value->tecnico][] = $value->valor;
              //echo $this->db->last_query();die();
            }
            //debug_var($array_valores_mecanica);die();
            $data['grafica_mecanica'] = $this->blade->render('bodyshop/grafica_indicadores',array('catalogo'=>$data['catalogo_fallas_mecanica'],'datos'=>$array_valores_mecanica,'tipo'=>'mecanica'),TRUE);

            //debug_var($data['grafica_mecanica']);die();
            //Fin gráfica mecánica

            //Gráfica de laminado

            $datos_laminado = $this->principal->getValues($id,7);
            $array_valores_laminado = array();
            //debug_var($datos_laminado);die();

            foreach ($datos_laminado as $key => $value) {
              $array_valores_laminado[$value->tecnico][] = $value->valor;
              //echo $this->db->last_query();die();
            }
            //debug_var($array_valores_laminado);die();
            $data['grafica_laminado'] = $this->blade->render('bodyshop/grafica_indicadores',array('catalogo'=>$data['catalogo_fallas_laminado'],'datos'=>$array_valores_laminado,'tipo'=>'laminado'),TRUE);


            //Fin gráfica laminado

            //Gráfica de pintura

            $datos_pintura = $this->principal->getValues($id,8);
            $array_valores_pintura = array();
            //debug_var($datos_laminado);die();

            foreach ($datos_pintura as $key => $value) {
              $array_valores_pintura[$value->tecnico][] = $value->valor;
              //echo $this->db->last_query();die();
            }
            //debug_var($array_valores_pintura);die();
            $data['grafica_pintura'] = $this->blade->render('bodyshop/grafica_indicadores',array('catalogo'=>$data['catalogo_fallas_pintura'],'datos'=>$array_valores_pintura,'tipo'=>'pintura'),TRUE);

            //debug_var($data['grafica_pintura']);die();
            //Fin gráfica pintura

            //historial de comentarios
            $data['historial'] = $this->principal->getHistorialComentarios($id);
           
            //Fin de historial
            $content = $this->blade->render('bodyshop/ver_proyecto', $data, true);

            $this->load->view('main/panel', array('content'=>$content,
                                                  'included_js'=>array('')));
            $parti['id_proyecto'] =$id;
            $parti['parti'] =$this->principal->get_contactos_admin($this->session->userdata('id')); //$this->principal->get_table('admin');//get_result('status',2,'admin');
            //debug_var($parti['parti']);die();
            //echo $this->db->last_query();die();
            $parti['id_proyecto'] = $id;
            $this->load->view('bodyshop/m_agregar_participante', $parti, false);
            $pro['pro'] = $this->principal->get_row('proyectoId',$id,'bodyshop');
            //debug_var($pro['pro']);

            $pro['estatus'] = $this->principal->get_estatus_byorden();
            //debug_var($pro['estatus']);die();
            //die();
            //$this->load->view('bodyshop/m_cambiar_status', $pro, false);

            $this->load->view('bodyshop/m_cronograma', $pro, false);
            $this->load->view('bodyshop/m_status_actividad', $pro, false);

    }

    public function llegaronrefacciones()
    {
      if($this->input->post())
      {
        
        $llegaron = $this->input->post('llegaron')=='true' ? 1 : 0;
        $datos = array('llegaron_refacciones'=>$llegaron);
        $this->principal->update('proyectoId',$this->input->post('idproyecto'),'bodyshop',$datos);
        echo '1';
      }
    }

    public function asignar_tecnico()
    {
        
        if ($this->input->post('idproyecto')) {
            $idproyecto = $this->input->post('idproyecto');
            $idtecnicos = $this->input->post('tecnicos');
            //Insertar en la tabla de los técnicos por estatus por proyecto
            $data = array('proyectoId' => $idproyecto,'status'=>$this->principal->getStatus($idproyecto),'idusuario'=>$this->session->userdata('id'),'fecha'=>date('Y-m-d H:i:s'),'id_tecnico'=>$idtecnicos );

            $this->db->insert('bodyshop_tecnicos_estatus',$data);
            //$data = array('idtecnico' => $this->input->post('tecnicos'));

            //$update = $this->principal->update("proyectoId",$idproyecto,'bodyshop',$data);  
            redirect('bodyshop/ver_proyecto/'.$idproyecto,'refresh');
        }else{
          redirect('bodyshop','refresh');
        }

        
    }

    public function pdf_calidad($id)
    {
      $preguntas = array();
      $conformidades = array();
      $secciones = $this->principal->get_table('bodyshop_calidad_preguntas_seccion');
      foreach ($secciones as $key => $value) {
        $where = array(
          'idbodyshop_calidad_preguntas_seccion' => $value->idbodyshop_calidad_preguntas_seccion, 
          'proyectoId' =>$id
        );
        $temp = $this->principal->get_where_result_order($where,'v_bodyshop_preguntas','idbodyshop_calidad_preguntas','asc');
        if($value->idbodyshop_calidad_preguntas_seccion==10)
        {
          $conformidades[$value->idbodyshop_calidad_preguntas_seccion]['seccion']=$value;
          $conformidades[$value->idbodyshop_calidad_preguntas_seccion]['preguntas']=$temp;
        }
        else {
          $preguntas[$value->idbodyshop_calidad_preguntas_seccion]['seccion']=$value;
          $preguntas[$value->idbodyshop_calidad_preguntas_seccion]['preguntas']=$temp;
        }
      }
      $data['proyecto'] = $this->principal->get_row('proyectoId',$id,'bodyshop' );
      $data['preguntas'] = $preguntas;
      $data['conformidades'] = $conformidades;
      $data['conformidadesText'] = $this->principal->get_result('proyectoId', $id,'bodyshop_conformidades');
      $content = $this->load->view('bodyshop/pdf_calidad', $data, true);
      pdf_create($content,'Calidad',false);
    }
    public function pdf_presupuesto($idproyecto){
       $todo = $this->mp->getDatos();
        $presupuesto= array();
        //debug_var($data);die();
        foreach ($todo as $key => $value) {
          if($value->tipo==1){
            $tipo = 'Hojalatería';
          }else{
            $tipo = 'Mecánica';
          }
          $presupuesto[$tipo][$value->categoria][] = $value;
        }
        //TRAEME LOS DATOS DE LA CATEGORÍA 3 SI EXISTEN
        $catNew = $this->mp->getDatosNuevaCategoria($idproyecto);
        //echo $this->db->last_query();die();
        foreach ($catNew as $k => $val) {
          $presupuesto['NUEVA'][$val->categoria][] = $val;
        }
        $data['proyecto'] = $this->principal->get_row('proyectoId',$idproyecto,'bodyshop' );
        $data['datos'] = $presupuesto;
        $data['id_proyecto'] = $idproyecto;
      
      $content = $this->blade->render('bodyshop/pdf_presupuesto', $data, true);
      //print_r($content);die();
      pdf_create($content,'Presupuesto',false);
    }
    public function modal_cambiar_status(){
      $id = $this->input->post('idproy');
      $pro['id_proyecto'] = $id;
      $pro['pro'] = $this->principal->get_row('proyectoId',$id,'bodyshop');
      //debug_var($pro);die();
      $pro['estatus'] = $this->principal->get_estatus_byorden();
      $this->blade->render('bodyshop/v_cambiar_status', $pro, false);
    }
    public function cambiar_status(){
      //print_r($_POST);die();
      $id = $this->input->post('id_proyecto_estatus');
      $status = $this->input->post('status');
      $data['status'] = $status;
      $data['fecha_estatus'] = date("Y-m-d H:i");
      if(isset($_POST['id_usuario']))
      {
        $usuarioId = $this->input->post('id_usuario');
      }
      else{
        $usuarioId = $this->session->userdata('id');
      }
      $this->principal->insert_transicion($id,$status,$usuarioId);
      $this->principal->update('proyectoId',$id,'bodyshop',$data);
      $res = $this->principal->get_result('ppIdProyecto', $id,'bodyshop_participantes');
      foreach($res as $noti):
        $notific['titulo'] = 'bodyshop';
        $notific['texto']= 'cambio de estatus';
        $notific['id_user'] = $noti->ppIdAdmin;
        $notific['estado'] = 1;
        $notific['url'] = base_url().'index.php/bodyshop/ver_proyecto/'.$id;
        $notific['estadoWeb'] = 1;
        $this->principal->insert('noti_user',$notific);
      endforeach;
      if(isset($_POST['tablero']))
      {
        echo 1;exit;
      }
      redirect('bodyshop/ver_proyecto/'.$id);
    }

    public function cambiar_status_actividad(){
      $id = $this->input->post('id_actividad');
      $status = $this->input->post('status');
      $data['actividadStatus'] = 0;
      $this->principal->update('actividadId',$id,'actividades',$data);

      redirect('bodyshop/ver_proyecto/'.$id);
    }

    public function save_proy_parti(){
      //print_r($_POST);die();
      $id = $this->input->post('id_proyecto');
      $id_parti = $this->input->post('id_parti');
      $aux = $this->principal->get_participantes_bodyshop($id,$id_parti);
      //echo $this->db->last_query();die();
      if($aux!=1){
        $data['ppIdAdmin'] = $id_parti;
        $data['ppIdProyecto'] = $id;
        $this->principal->insert('bodyshop_participantes',$data);
        $res1 = $this->principal->get_result('ppIdProyecto', $id,'bodyshop_participantes');
        foreach($res1 as $noti):
          $notific['titulo'] = 'bodyshop';
          $notific['texto']= 'se agrego un nuevo participante';
          $notific['id_user'] = $noti->ppIdAdmin;
          $notific['estado'] = 1;
          $notific['url'] = base_url().'index.php/bodyshop/ver_proyecto/'.$id;
          $notific['estadoWeb'] = 1;
          $this->principal->insert('noti_user',$notific);
        endforeach;
        redirect('bodyshop/ver_proyecto/'.$id);

      }else{
        redirect('bodyshop/ver_proyecto/'.$id);
      }

    }

    public function save_calidad()
    {
       $data = $this->input->post('pregunta');
       $idProyecto = $data['idProyecto'];
       foreach ($data['item'] as $key => $value) {
        $respuesta = 0;
        if($value['si']=='1')
          $respuesta=1;
        if(isset($value['autorizo']))
        {
          $datos = array(
            'proyectoId' => $idProyecto , 
            'respuesta' => $respuesta,
            'autorizo' => $value['autorizo'],
            'observaciones' => $value['observaciones'],
            'idbodyshop_calidad_preguntas' => $key
          );
        }else {
          $datos = array(
            'proyectoId' => $idProyecto , 
            'respuesta' => $respuesta,
            'idbodyshop_calidad_preguntas' => $key
          );
        }
        $this->principal->save_preguntas($datos);
       }
       $data = $this->input->post('conformidad');
       foreach ($data['item'] as $key => $value) {
        $datos = array(
          'conformidad' => $value['conformidad'],
          'proceso' => $value['proceso']
        );
        $this->principal->update_conformidad($datos,$key);
       }
       echo 1;die();
      //redirect('bodyshop/ver_proyecto/'.$idProyecto);
    }

    public function save_cronograma(){
      $data = $this->input->post('crono');
      $data['cronoFechaFechaCreacion'] = date('Y-m-d H:i');
      $this->principal->insert('bodyshop_cronograma', $data);
      $res = $this->principal->get_result('ppIdProyecto', $data['cronoIdProyecto'],'bodyshop_participantes');
      foreach($res as $noti):
        $notific['titulo'] = 'bodyshop';
        $notific['texto']= 'se agrego un nuevo cronograma';
        $notific['id_user'] = $noti->ppIdAdmin;
        $notific['estado'] = 1;
        $notific['tipo_notificacion'] = 1;
        $notific['url'] = base_url().'index.php/bodyshop/ver_proyecto/'.$data['cronoIdProyecto'];
        $notific['estadoWeb'] = 1;
        $this->principal->insert('noti_user',$notific);

      endforeach;
      redirect('bodyshop/ver_proyecto/'.$data['cronoIdProyecto']);


    }

    public function save_activi(){
        $data = $this->input->post('act');
        $this->principal->insert('bodyshop_actividades', $data);
        $res = $this->principal->get_result('ppIdProyecto', $data['actividadIdProyecto'],'bodyshop_participantes');
        foreach($res as $noti):
          $notific['titulo'] = 'bodyshop';
          $notific['texto']= 'se agrego una  actividad';
          $notific['id_user'] = $noti->ppIdAdmin;
          $notific['estado'] = 1;
          $notific['url'] = base_url().'index.php/bodyshop/ver_proyecto/'.$data['actividadIdProyecto'];
          $notific['estadoWeb'] = 1;
          $this->principal->insert('noti_user',$notific);

        endforeach;
        redirect('bodyshop/ver_proyecto/'.$data['actividadIdProyecto']);

    }

    public function save_comentario(){
        $data = $this->input->post('commen');
        $data['comentarioIdAdmin'] = $this->session->userdata('id');
        $data['fecha'] =  date("Y-m-d");
        $data['hora'] =  date("H:i:s");
        $this->principal->insert('bodyshop_comentarios', $data);
        $res = $this->principal->get_result('ppIdProyecto', $data['comentarioIdProyecto'],'bodyshop_participantes');
        foreach($res as $noti):
          $notific['titulo'] = 'bodyshop';
          $notific['texto']= 'se agrego un nuevo comentario';
          $notific['id_user'] = $noti->ppIdAdmin;
          $notific['estado'] = 1;
          $notific['url'] = base_url().'index.php/bodyshop/ver_proyecto/'.$data['comentarioIdProyecto'];
          $notific['estadoWeb'] = 1;
          $this->principal->insert('noti_user',$notific);

        endforeach;
        redirect('bodyshop/ver_proyecto/'.$data['comentarioIdProyecto']);

    }

    public function save_descargable(){

      $data='';
      if($_FILES['image']['name'] != ''){
        $res='';
        foreach ($_FILES['image']['name'] as $key => $value) {
          $post = $this->input->post('save');

          $name = date('dmyHis').'_'.str_replace(" ", "",$value);

          $path_to_save = 'statics/url_descargable/'.$this->session->userdata('id');
          if(!file_exists($path_to_save)){
            mkdir($path_to_save, 0777, true);
          }
          move_uploaded_file($_FILES['image']['tmp_name'][$key], $path_to_save.$name);
          $data = $this->input->post('desca');
          $data['descargableIdAdmin'] = $this->session->userdata('id');
          $data['descargableFechaCreacion']= date("Y-m-d H:i:s");
          $data['descargableUrl'] = $path_to_save.$name;
          $this->principal->insert('bodyshop_desargable', $data);
        }
          $res = $this->principal->get_result('ppIdProyecto', $data['descargableIdProyecto'],'bodyshop_participantes');
          foreach($res as $noti):
            $notific['titulo'] = 'bodyshop';
            $notific['texto']= 'se agrego un nuevo descargable';
            $notific['id_user'] = $noti->ppIdAdmin;
            $notific['estado'] = 1;
            $notific['url'] = base_url().'index.php/bodyshop/ver_proyecto/'.$data['descargableIdProyecto'];
            $notific['estadoWeb'] = 1;
            $this->principal->insert('noti_user',$notific);
          endforeach;
          redirect('bodyshop/ver_proyecto/'.$data['descargableIdProyecto']);
      }

    }
    public function save_gasto(){
        $data = $this->input->post('gasto');
        $data['idAdmin'] = $this->session->userdata('id');
        $data['fechaCreacion'] =  date("Y-m-d H:i:s");
        $this->principal->insert('bodyshop_gasto_proyecto', $data);
        $res = $this->principal->get_result('ppIdProyecto', $data['idProyecto'],'bodyshop_participantes');
        foreach($res as $noti):
          $notific['titulo'] = 'bodyshop';
          $notific['texto']= 'se agrego un nuevo gasto';
          $notific['id_user'] = $noti->ppIdAdmin;
          $notific['estado'] = 1;
          $notific['url'] = base_url().'index.php/bodyshop/ver_proyecto/'.$data['idProyecto'];
          $notific['estadoWeb'] = 1;
          $this->principal->insert('noti_user',$notific);

        endforeach;
        redirect('bodyshop/ver_proyecto/'.$data['idProyecto']);

    }

    public function mis_numeros(){
      $content = $this->load->view('bodyshop/mis_numeros', '', true);
      $this->load->view('main/panel', array('content'=>$content,
                                            'included_js'=>array('')));
    }
    public function presupuesto($idproyecto=20){
      $todo = $this->mp->getDatos();
      $presupuesto= array();
      //debug_var($data);die();
      foreach ($todo as $key => $value) {
        if($value->tipo==1){
          $tipo = 'Hojalatería';
        }else{
          $tipo = 'Mecánica';
        }
        $presupuesto[$tipo][$value->categoria][] = $value;
      }

      $data['datos'] = $presupuesto;


      $info= $this->mp->getProyectoById($idproyecto);
      
      $info=$info[0];

      $datos_proyecto = 1;

      //drop para saber si es CRP
      

      $data['input_fecha'] = form_input('fecha',set_value('fecha',exist_obj($info,'fecha')),'class="form-control" id="fecha" ');

      $data['input_torre'] = form_input('torre',set_value('torre',exist_obj($info,'torre')),'class="form-control" id="torre" ');

      $data['input_tipo_vehiculo'] = form_input('tipo_vehiculo',set_value('tipo_vehiculo',exist_obj($info,'tipo_vehiculo')),'class="form-control" id="tipo_vehiculo" ');

      $data['input_placas'] = form_input('placas',set_value('placas',exist_obj($info,'vehiculo_placas')),'class="form-control" id="placas" ');

      $data['input_serie'] = form_input('serie',set_value('serie',exist_obj($info,'vehiculo_numero_serie')),'class="form-control" id="serie" ');

      $data['input_orden_reparacion'] = form_input('orden_reparacion',set_value('orden_reparacion',exist_obj($info,'orden_reparacion')),'class="form-control" id="orden_reparacion" ');

      $data['drop_color'] = form_dropdown('id_color',array_combos($this->mcatalogos->get('colores','color'),'id','color',TRUE),set_value('id_color',exist_obj($info,'id_color')),'class="form-control busqueda" id="id_color"');

      $data['drop_vehiculo_modelo'] = form_dropdown('idmodelo',array_combos($this->mcatalogos->get('modelos','modelo'),'modelo','modelo',TRUE),set_value('vehiculo_modelo',exist_obj($info,'vehiculo_modelo')),'class="form-control busqueda" id="idmodelo"'); 

       $data['input_aseguradora'] = form_input('aseguradora',set_value('aseguradora',exist_obj($info,'aseguradora')),'class="form-control" id="aseguradora" ');

      $content = $this->blade->render('presupuesto/presupuesto', $data, TRUE);

      echo $content;exit();
      //$this->load->view('main/panel', array('content'=>$content,
                                                      // 'included_js'=>array('')));
    }
    public function savePresupuesto(){
      //print_r($_POST);die();
      if($_POST['tipo']!=''){
        //print_r($_POST);die();
        $this->db->where('idbody',$this->input->post('idproyectosave'))->delete('bodyshop_detalle_presupuesto');
        foreach ($_POST['tipo'] as $key => $value) {
          if($value!=''){
            $datos_presupuesto = array('tipo'=>$_POST['tipo'][$key],
                                      'idparte' => $key,
                                      'noparte'=>$_POST['noparte'][$key],
                                      'precio'=>$_POST['precio'][$key],
                                      'existencia'=>$_POST['existencia'][$key],
                                      'idbody'=>$this->input->post('idproyectosave'),
                                      'pintura'=>isset($_POST['pintura'][$key])?1:0,
                                    );
            //debug_var($datos_presupuesto);die();
            $this->db->insert('bodyshop_detalle_presupuesto',$datos_presupuesto);
          }
          
        }
        echo 1;
        exit();
        
      }
      echo 0;
      exit();
    }
  
    public function dashboard()
    {
      $estatus = $this->principal->get_estatus_byorden('bodyshop_estatus');
      
      $totales=array();
      $cont =0;
      $contAtrasados = 0;
      foreach ($estatus as $key => $value) {
        $totales[$cont]['nombre']=$value->nombre;
        $contAtrasados=0;
        $proyectos = $this->principal->bodyshop_par_estatus($this->session->userdata('id'),$value->estatusId,false);
        foreach ($proyectos as $key2 => $value2) {
          if(!is_null($value->horas) && !is_null($value2->fecha_estatus) && get_tiempo_laboral($value2->fecha_estatus,$value->horas)){
            $contAtrasados++;
          }
        }
        $totales[$cont]['total']=count($proyectos);
        $totales[$cont]['totalAtrasados']=$contAtrasados;
        $cont++;
      }
      //var_dump($totales);
      $data['data']=$totales;
      $content = $this->load->view('bodyshop/dashboard', $data, true);
      $this->load->view('main/panel', array('content'=>$content,
                                                  'included_js'=>array(
                                                  '/statics/js/custom/c3.min.js')));
    }

    public function login(){
      if($this->input->post()){ 
        header('Content-Type: application/json'); 
        $this->form_validation->set_rules('usuario', 'usuario', 'trim|required');
        $this->form_validation->set_rules('password', 'contraseña', 'trim|required');
        if ($this->form_validation->run()){
          $total = $this->principal->count_results_users($this->input->post('usuario'), $this->input->post('password'));
          if($total == 1){
            $dataUser = $this->principal->get_all_data_users_specific($this->input->post('usuario'), $this->input->post('password'));
            echo json_encode(array('success'=>true,'id_usuario'=>$dataUser->adminId));
          }
          else{
            echo json_encode(array('success'=>false,'validation'=>false,'message'=>'Usuario y/o password incorrecto'));
          }
          exit();
        }
        else{
          $errors = array(
            'usuario' => form_error('usuario'),
            'password' => form_error('password'),
          );
          echo json_encode(array('success'=>false,'validation'=>true,'errors'=>$errors)); 
          exit();
        }
      }
      $data['input_usuario'] = form_input('usuario',"",'class="form-control" rows="5" id="usuario" ');
      $data['input_password'] = form_password('password',"",'class="form-control" rows="5" id="password" ');
      $this->load->view('bodyshop/m_login',$data);
    }

    public function downloadFiles($files)
    {
      $file_path='./';
      $archive_file_name = 'descargables'.date('dmyHis').'.zip';
      $arr =explode('-',$files);
      foreach($arr as $files)
      {
        $desca = $this->principal->get_row('descargableId',$files,'bodyshop_desargable');
        $this->zip->read_file($file_path.$desca->descargableUrl,false);
      }
      $this->zip->download($archive_file_name);
    }

    public function down()
    {
      $this->load->helper('file');
      $path = './statics/temp/';

      $files = get_filenames($path);
      foreach ($files as $f) {
       $this->zip->read_file($path.$f,false);
      }
      $this->zip->download('hola');
      //var_dump($files);
    }

    public function dowloadFile($fileid)
    {
      $file_path=getcwd().'/';
      $desca = $this->principal->get_row('descargableId',$fileid,'bodyshop_desargable');
      $this->load->helper('file');
      $mime = get_mime_by_extension($file_path.$desca->descargableUrl);
      force_download2($file_path.$desca->descargableUrl,$desca->descargableNombre,$mime);
    }

    public function timeline($proyecto_id){
      $data['transiciones'] =$this->principal->get_result('proyecto_id',$proyecto_id,'v_bodyshop_transiciones');
      $this->load->view('bodyshop/m_timeline',$data);
    }

    public function tablero()
    {
      $estatus = $this->principal->get_estatus_byorden();
      $totales=array();
      $cont =0;
      foreach ($estatus as $key => $value) {
        $totales[$cont]['estatus']=$value;
        $totales[$cont]['proyectos']=$this->principal->bodyshop_par_estatus($this->session->userdata('id'),$value->estatusId,false);
        $cont++;
      }
      //var_dump($totales);die;
      $data['data']=$totales;
      $data['total']= count($estatus);
      //print_r($data);die();
      $this->load->view('bodyshop/tablero',$data);
    }
    public function info(){
      echo phpinfo();
    }
    public function version(){
      echo phpversion();
    }
     public function fecha(){
      get_tiempo_laboral('2018-07-03 09:30:00',10);
    }
    function agregar_subcategoria($id=0)
    {
      
    
      if($this->input->post()){   
        //$this->form_validation->set_rules('categoria', 'categoría', 'trim|required');
        $this->form_validation->set_rules('subcategoria', 'parte', 'trim|required');
       if ($this->form_validation->run()){ 
        //Insertar categoría
            //$this->db->set('categoria',$this->input->post('categoria'))->set('tipo',3)->insert('bodyshop_categoria');
            //$idcategoria = $this->db->insert_id();
            $subcategoria = array('subcategoria'=>$this->input->post('subcategoria'),
                                  'idcategoria'=>13,
                                  'idbody' =>$this->input->post('idproyecto')
          );
            //print_r($subcategoria);die();
            //Insertar subcategoría
            $this->db->insert('bodyshop_subcategoria',$subcategoria);
            echo json_encode(array('idsubcategoria'=>$this->db->insert_id(),'subcategoria'=>$this->input->post('subcategoria')));
            exit();
          }else{
             $errors = array(
                  //'categoria' => form_error('categoria'),
                  'subcategoria' => form_error('subcategoria'),
             );
            echo json_encode($errors); exit();
          }
      }

      if($id==0){
        $info=new Stdclass();

        
      }else{
        $info= $this->mc->getOperadorId($id);
        $info=$info[0];
      }


      $data['input_categoria'] = form_input('categoria',"",'class="form-control" rows="5" id="categoria" ');

      $data['input_subcategoria'] = form_input('subcategoria',"",'class="form-control" rows="5" id="subcategoria" ');
      $this->blade->render('newCategory',$data);
  }
  //Funcion para agregar nuevos rows a la tabla de subcategorias
  public function agregar_field_to_category(){ //
    //echo 'entre';die();
    //Obtengo las subcategorías ya registradas.
    //print_r($_POST);die();
    $subcategorias = $this->principal->getSubcatRegistradas($this->input->post('idbody'));
    //debug_var($subcategorias);die();
    if(count($subcategorias)==0){
      $where_in = array();
    }else{
      foreach ($subcategorias as $key => $value) {
        $where_in[] = $value->idparte;
      }
      //$where_in = implode(",", $subcategorias);
    }

    //Tengo que ver que las subcategorías que ya había puesto temporales quitarlas de la consulta

    if($this->input->post('sub_registradas')!=''){
      foreach ($this->input->post('sub_registradas') as $key => $value) {
        $where_in[] = $value;
      }
      $this->db->where_not_in('id',$where_in);
    }
    //debug_var($where_in);die();
    $subcategorias_elegir = $this->db->where('idcategoria',$this->input->post('idcategoria'))->get('bodyshop_subcategoria')->result();
    //debug_var($subcategorias_elegir);die();
    $data['subcategorias'] = $subcategorias_elegir;
    $data['idcat'] = $this->input->post('idcategoria');
    $this->blade->render('v_addfield',$data);
  }
  public function allProyects(){
     $data['proyectos'] = $this->db->get('bodyshop')->result();
     $data['modelos'] = $this->db->get('bodyshop_modelos')->result();
     //debug_var($data['modelos']);die();
      $content = $this->blade->render('bodyshop/allProyects', $data, true);
      $this->load->view('main/panel', array('content'=>$content,
                                            'included_js'=>array('')));
  }
  public function updateModelo(){
    $this->db->where('proyectoId',$this->input->post('idproyecto'))->set('vehiculo_modelo',$this->input->post('modelo'))->update('bodyshop');
    echo 1;die();
  }
  public function converBody(){
      $body = $this->mcatalogos->get('bodyshop');
      foreach ($body as $key => $value) {
       $datos = array('proyectoId' => $value->proyectoId,
                    'proyectoNombre' => trim($value->proyectoNombre),
                    'proyectoStatus' => $value->proyectoStatus,
                    'proyectoIdAdmin' => $value->proyectoIdAdmin,
                    'proyectoCliente' => trim($value->proyectoCliente),
                    'proyectoFechaCreacion' => date('Y-m-d'),
                    'proyectoDecscripcion' => trim($value->proyectoDescripcion),
                    'status' => $value->status,
                    'tipo' => $value->tipo,
                    'vehiculo_anio' => $value->vehiculo_anio,
                    'vehiculo_placas' => trim($value->vehiculo_placas),
                    'id_color' => $value->id_color,
                    'vehiculo_modelo' => $value->vehiculo_modelo,
                    'vehiculo_numero_serie' => $value->vehiculo_numero_serie,
                    'asesor' => $value->asesor,
                    'comentarios_servicio' => trim($value->comentarios_servicio),
                    'datos_email' => $value->datos_email,
                    'datos_nombres' => $value->datos_nombres,
                    'datos_apellido_paterno' => $value->datos_apellido_paterno,
                    'datos_apellido_materno' => $value->datos_apellido_materno,
                    'datos_telefono' => $value->datos_telefono,
                    'id_status_color' => $value->id_status_color,
                    'dia_completo' => $value->dia_completo,
                    'tecnico_dias' => $value->tecnico_dias,
                    'fecha_inicio' => date2sql($value->fecha_inicio),
                    'fecha_fin' => date2sql($value->fecha_fin),
                    'hora_comienzo' => $value->hora_comienzo,
                    'fecha_parcial' => date2sql($value->fecha_parcial),
                    'hora_inicio_extra' => $value->hora_inicio_extra,
                    'hora_fin_extra' => $value->hora_fin_extra,
                    'tecnico' => $value->tecnico,
                    'hora_inicio' => $value->hora_inicio,
                    'hora_fin' => $value->hora_fin,
                    'numero_siniestro' => $value->numero_siniestro,
                    'numero_poliza' => $value->numero_poliza,
                    'datos_telefono2' => $value->datos_telefono2,

        );
       $this->db->insert('bodyshop2',$datos);
      }
  }
  public function insertPartBody(){

    $body = $this->mcatalogos->get('bodyshop2');
    foreach ($body as $key => $value) {

        $this->db->set('ppIdAdmin',45)->set('ppIdProyecto',$value->proyectoId)->insert('bodyshop_participantes');
        $this->db->set('ppIdAdmin',68)->set('ppIdProyecto',$value->proyectoId)->insert('bodyshop_participantes');
        $this->db->set('ppIdAdmin',53)->set('ppIdProyecto',$value->proyectoId)->insert('bodyshop_participantes');
        $this->db->set('ppIdAdmin',1)->set('ppIdProyecto',$value->proyectoId)->insert('bodyshop_participantes');
        $this->db->set('ppIdAdmin',88)->set('ppIdProyecto',$value->proyectoId)->insert('bodyshop_participantes');
        $this->db->set('ppIdAdmin',87)->set('ppIdProyecto',$value->proyectoId)->insert('bodyshop_participantes');
        $this->db->set('ppIdAdmin',86)->set('ppIdProyecto',$value->proyectoId)->insert('bodyshop_participantes');
        $this->db->set('ppIdAdmin',84)->set('ppIdProyecto',$value->proyectoId)->insert('bodyshop_participantes');
          
        $this->db->set('ppIdAdmin',83)->set('ppIdProyecto',$value->proyectoId)->insert('bodyshop_participantes');

        $this->db->set('ppIdAdmin',89)->set('ppIdProyecto',$value->proyectoId)->insert('bodyshop_participantes');

         
    }
      
  }
  //CAMBIOS 10 DE JULIO 2018
 public function generarhorariosAux(){
    ini_set('max_execution_time', 300);
    echo 'entre';die();
    $this->db->where('id',5);
    $operadores = $this->db->get('operadores')->result();
    //debug_var($operadores);die();
    $contador = 0;
      foreach ($operadores as $key => $value) {
        $contador++;
        //$fecha = date('Y-m-j');
        $fecha = '2018-09-18';
        while($fecha<'2018-12-31'){
          $time = '07:00';
          $contador=0;
          while($contador<13){
            $fecha_parcial = explode('-', $fecha);
            $aux = array('hora' => $time,
                       'id_operador' =>$value->id,
                       'fecha_creacion'=>date('Y-m-d'),
                        'dia' => $fecha_parcial[2],
                        'mes' => $fecha_parcial[1],
                        'anio' => $fecha_parcial[0],
                        'fecha'=>$fecha,
                        'ocupado'=>0,
                        'activo'=>1,
                        'id_status_cita'=>1

            );
            $timestamp = strtotime($time) + 60*60;
            $time = date('H:i', $timestamp);
            $contador++;
            $this->db->insert('bodyshop_aux',$aux);
            //echo $this->db->last_query().';';
            //echo '<br>';
          }
          $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
          $fecha = date ( 'Y-m-j' , $nuevafecha );
        }
        
        
      }

      echo $contador;
  }
   public function getfechas(){
    if($this->input->post()){
      $id_asesor=$this->input->post("asesor");
      $fechas=$this->principal->getFechasAsesor($id_asesor);
      echo json_encode($fechas);
    }else{
    echo 'Nada';
    }

  }
  public function getHorarios(){
    if($this->input->post()){
      $id_asesor=$this->input->post("asesor");
      $id_horario=$this->input->post("id_horario");
      $fecha = $this->input->post('fecha');
      //esta validación la puse por que si está editando debe ir por los horarios que no están ocupados y además el que ya tenía registrado
      if($id_horario==0){
        $horarios=$this->principal->getHorariosAsesor($id_asesor,$fecha);
        //echo $this->db->last_query();die();
      }else{
         $horarios=$this->principal->getHorariosAsesor_edit($id_asesor,$fecha,$id_horario);
      }
      echo json_encode($horarios);
    }else{
    echo 'Nada';
    }

  }
  //Insertar participantes extra
  public function insertPartExtra(){
    $proyectos = $this->db->get('bodyshop')->result();
    foreach ($proyectos as $key => $value) {
      $participantes = $this->db->where('ppIdAdmin',$value->proyectoId)->get('bodyshop_participantes')->result();
        // $this->existeRegistro($value->proyectoId,98);
        // $this->existeRegistro($value->proyectoId,99);
        // $this->existeRegistro($value->proyectoId,100);
        // $this->existeRegistro($value->proyectoId,101);
        // $this->existeRegistro($value->proyectoId,102);
        // $this->existeRegistro($value->proyectoId,103);
        // $this->existeRegistro($value->proyectoId,104);
        // $this->existeRegistro($value->proyectoId,105);
        // $this->existeRegistro($value->proyectoId,106);
        //$this->existeRegistro($value->proyectoId,50);
        //$this->existeRegistro($value->proyectoId,118);
        $this->existeRegistro($value->proyectoId,45);
    }
  }
  //98 -106

  public function existeRegistro($ppIdProyecto='',$ppIdAdmin=''){
    $q = $this->db->where('ppIdAdmin',$ppIdAdmin)->where('ppIdProyecto',$ppIdProyecto)->get('bodyshop_participantes');
    if($q->num_rows()==0){
       $this->db->set('ppIdAdmin',$ppIdAdmin)->set('ppIdProyecto',$ppIdProyecto)->set('fecha_creacion','2019-07-15')->insert('bodyshop_participantes');
       //die();
    }
  }

  //FIN DE CAMBIOS

   public function tablero_asesores(){
    $datos['fecha'] = date('Y-m-d');
    $datos['tiempo_aumento'] = 60;
    $datos['valor'] = 14;
    
    $datos['tabla1'] = $this->principal->tabla_asesores_prueba($datos['fecha'],$datos['valor'],$datos['tiempo_aumento'],0); // el último argumento es para saber si hace el cociente en base a 0 o a 1
    $datos['tabla2'] = $this->principal->tabla_asesores_prueba($datos['fecha'],$datos['valor'],$datos['tiempo_aumento'],1); // el último argumento es para saber si hace el cociente en base a 0 o a 1

    //debug_var($datos);die();
    $this->blade->render('tablero_asesores',$datos);
  }
  public function tabla_horarios_asesores(){
    $datos['fecha'] = date_esp2eng($this->input->post('fecha'));
    $datos['tiempo_aumento'] = 60;
    $datos['valor'] = 14;
    $datos['tabla1'] = $this->principal->tabla_asesores_prueba($datos['fecha'],$datos['valor'],$datos['tiempo_aumento'],0); // el último argumento es para saber si hace el cociente en base a 0 o a 1
    $datos['tabla2'] = $this->principal->tabla_asesores_prueba($datos['fecha'],$datos['valor'],$datos['tiempo_aumento'],1); // el último argumento es para saber si hace el cociente en base a 0 o a 1
    $this->blade->render('tabla_horarios_asesores',$datos);
  }
  public function cambiar_status_cita(){
    //print_r($_POST);die();
    if($this->db->where('id',$this->input->post('id'))->set('id_status_cita',$this->input->post('status'))->update('bodyshop_aux')){
      $idproyecto = $this->principal->getIdProyectoByIdHorario($this->input->post('id'));
      //FALTA LA VALIDACIÓN
      if($this->input->post('status')==4){
        $this->db->where('proyectoId',$idproyecto)->set('historial',0)->update('bodyshop');
      }

      if($this->input->post('status')==3 || $this->input->post('status')==2){
        $this->db->where('proyectoId',$idproyecto)->set('historial',0)->update('bodyshop');
      }
      echo 1;
    }else{
      echo 0;
    }
  }
   public function cerrar_sesion(){
     $this->session->sess_destroy();
     $this->session->set_userdata('login',0);
     redirect('bodyshop/tablero_tecnicos');
  }
  public function cerrar_sesion_asesor(){
     $this->session->sess_destroy();
     $this->session->set_userdata('login_asesores',0);
     redirect('bodyshop/tablero_asesores');
  }
  public function login_editar(){
       if($this->input->post()){   
        $this->form_validation->set_rules('usuario', 'usuario', 'trim|required');
        $this->form_validation->set_rules('password', 'contraseña', 'trim|required');
       
       if ($this->form_validation->run()){ 
          $this->principal->validarLogin();
          exit();
          }else{
             $errors = array(
                  'usuario' => form_error('usuario'),
                  'password' => form_error('password'),
             );
            echo json_encode($errors); exit();
          }
      }


      $data['input_usuario'] = form_input('usuario',$this->input->get('usuario_tecnico'),'class="form-control" rows="5" id="usuario" ');

     $data['input_password'] = form_password('password',"",'class="form-control" rows="5" id="password" ');
     $this->blade->render('bodyshop/login_editar',$data);
  }
  //Funciones de laminado
  public function saveFalla(){
   if($this->input->post('falla')>0){
    $this->db->where('proyectoId',$this->input->post('proyectoId'))->where('status',$this->input->post('status_actual'))->delete('bodyshop_detalle_fallas');
    foreach ($this->input->post('falla') as $key => $value) {
      $k = explode('-', $key); //el primero es el idtecnico el segundo el id del catálogo de laminado
      $idtecnico = $k[0];
      $idfalla = $k[1];
      $datos = array('idfalla' => $idfalla,'idusuario' => $this->session->userdata('id'),'valor' => $value,'updated_at' => date('Y-m-d H:i:s'),'proyectoId' => $this->input->post('proyectoId'),'idtecnico' => $idtecnico,'status'=>$this->input->post('status_actual') );
      //Insertar en el detalle de laminado
      $this->db->insert('bodyshop_detalle_fallas',$datos);
    }
   }
   echo 1;exit();
  }
  public function updateGrafica(){
    //Gráfica 
    $status = $this->input->post('status_actual');
    $id = $this->input->post('proyectoId');
    $data['catalogo_fallas'] = $this->mcatalogos->get('bodyshop_cat_fallas','','',array('status'=>$status));

    $datos_fallas = $this->principal->getValues($id,$status);
    $array_valores = array();
    //debug_var($datos_fallas);die();

    foreach ($datos_fallas as $key => $value) {
      $array_valores[$value->tecnico][] = $value->valor;
      //echo $this->db->last_query();die();
    }
    //debug_var($array_valores_mecanica);die();
    echo $this->blade->render('bodyshop/grafica_indicadores',array('catalogo'=>$data['catalogo_fallas'],'datos'=>$array_valores));

    //Fin gráfica mecánicay
  }
  public function fechas(){
    $this->principal->getDiffDate();
  }
  //Fin funciones laminado
  public function comentar_backup($proyectoId=''){
       if($this->input->post()){   
        //print_r($_POST);die();
        $this->form_validation->set_rules('comentario', 'comentario', 'trim|required');
       
       if ($this->form_validation->run()){ 
          $datos = array('idusuario' =>$this->session->userdata('id'),
                        'created_at'=>date('Y-m-d H:i:s'),
                        'proyectoId'=>$this->input->post('idp'),
                        'comentario'=>$this->input->post('comentario'),

           );
          if($this->db->insert('bodyshop_comentarios_backup',$datos)){
            if($this->input->post('cronoFecha')!='' && $this->input->post('cronoFecha')!='cronoHora'){
              $notific['titulo'] = $this->input->post('cronoTitulo');
              $notific['texto']= $this->input->post('comentario');
              $notific['id_user'] = $this->session->userdata('id');
              $notific['estado'] = 1;
              $notific['tipo_notificacion'] = 2;
              $notific['fecha_hora'] = date2sql($this->input->post('cronoFecha')).' '.$this->input->post('cronoHora');
              $notific['url'] = base_url().'index.php/bodyshop/ver_proyecto/'.$this->input->post('idp');
              $notific['estadoWeb'] = 1;
              $this->principal->insert('noti_user',$notific);
            }
            

            echo 1;
          }else{
            echo 0;
          }
          exit();
          }else{
             $errors = array(
                  'comentario' => form_error('comentario'),
             );
            echo json_encode($errors); exit();
          }
      }


      $data['input_comentario'] = form_input('comentario','','class="form-control" rows="5" id="comentario" maxlength="70" ');
      $data['proyectoId'] = $proyectoId;
    
     $this->blade->render('bodyshop/comentario_backup',$data);
  }
  public function historial_comentariosbk($proyectoId=''){
    $data['historial'] = $this->db->order_by('created_at','desc')->where('proyectoId',$proyectoId)->get('bodyshop_comentarios_backup')->result();
    $this->blade->render('bodyshop/historial_comentariosbk',$data);
  }
  public function getTimes($proyecto_id=0){
    $data['transiciones'] = $this->principal->getTransiciones($proyecto_id);
    $fecha_inicio = $this->principal->getFechaCreacion($proyecto_id);
    //echo $fecha_inicio;
    if($fecha_inicio=='' || $fecha_inicio=='0000-00-00'){
      echo '<h1>No se especifico la fecha de inicio</h1>';
      exit();
    }
    $array_diferencias = array();
    //debug_var($data['transiciones']);
    foreach ($data['transiciones'] as $key => $value) {
      $array_diferencias[$key] = $value;

      if($key==0){
        $fecha_comparar = $fecha_inicio;
      }

      $fecha1 = new DateTime($fecha_comparar);//fecha inicial
      $fecha2 = new DateTime($value->fecha);//fecha de cierre
      $intervalo = $fecha1->diff($fecha2);

      //Transformar todo a minutos
      $meses_horas = (int)$intervalo->format('%m')*31*24*60;// meses
      $dias_horas = (int)$intervalo->format('%d')*24*60;// días
      $horas = (int)$intervalo->format('%H')*60;// días

      //Las horas pasadas contando horas, meses
      
      $array_diferencias[$key]->tiempo_transcurrido = $intervalo->format('%d día(s) %H hora(s) %i minuto(s)');

      $array_diferencias[$key]->minutos_pasados = $meses_horas+$dias_horas+$horas+(int)$intervalo->format("%i");

      //El tiempo que debería durar cada estatus... lo uso para comparar
      $array_diferencias[$key]->tiempo_estatus = $this->principal->getHorasEstatus($value->nuevo_estatus_id);

      //Poner en el array la fecha del estatus anterior

      $array_diferencias[$key]->fecha_estatus_anterior = $fecha_comparar;
      //Inicializar fecha comparar con la última fecha del último cambio de estatus

      $fecha_comparar = $value->fecha;

    }
    $data['diferencias'] = $array_diferencias;
    //debug_var($array_diferencias);die();
    //$content = $this->blade->render('bodyshop/diffestatus', $data, true);
    //$this->load->view('main/panel', array('content'=>$content,'included_js'=>array('')));

    echo $this->blade->render('bodyshop/diffestatus',$data,true);
  }
  public function calidad($id){
     $data['conformidadesText'] = $this->principal->get_result('proyectoId', $id,'bodyshop_conformidades');
            $preguntas = array();
            $conformidades = array();
            $secciones = $this->principal->get_table('bodyshop_calidad_preguntas_seccion');
            foreach ($secciones as $key => $value) {
              $where = array(
                'idbodyshop_calidad_preguntas_seccion' => $value->idbodyshop_calidad_preguntas_seccion, 
                'proyectoId' =>$id
              );
              $temp = $this->principal->get_where_result_order($where,'v_bodyshop_preguntas','idbodyshop_calidad_preguntas','asc');
              if($value->idbodyshop_calidad_preguntas_seccion==10)
              {
                $conformidades[$value->idbodyshop_calidad_preguntas_seccion]['seccion']=$value;
                $conformidades[$value->idbodyshop_calidad_preguntas_seccion]['preguntas']=$temp;
              }
              else {
                $preguntas[$value->idbodyshop_calidad_preguntas_seccion]['seccion']=$value;
                $preguntas[$value->idbodyshop_calidad_preguntas_seccion]['preguntas']=$temp;
              }
            }
            $data['preguntas'] = $preguntas;
            $data['conformidades'] = $conformidades;
            $data['id_proyecto'] = $id;
    echo $this->blade->render('bodyshop/calidad', $data, true);
    //$content = $this->blade->render('bodyshop/calidad', $data, true);
    //$this->load->view('main/panel', array('content'=>$content,'included_js'=>array('')));
  }
  public function vpresupuesto($id){
    $info= $this->mp->getProyectoById($id);
    $info=$info[0];
    $data['proyecto'] = $this->principal->get_row('proyectoId',$id,'bodyshop' );
    $data['estatus'] = $this->principal->get_row('estatusId',$data['proyecto']->status,'bodyshop_estatus' );
    $datos_proyecto = 1;
    $todo = $this->mp->getDatos();
    $presupuesto= array();
    //debug_var($todo);die();
    foreach ($todo as $key => $value) {
      if($value->tipo==1){
        $tipo = 'Hojalatería';
      }else{
        $tipo = 'Mecánica';
      }
      $presupuesto[$tipo][$value->categoria][] = $value;
    }
    //TRAEME LOS DATOS DE LA CATEGORÍA 3 SI EXISTEN
    $catNew = $this->mp->getDatosNuevaCategoria($id);
    //echo $this->db->last_query();die();
    foreach ($catNew as $k => $val) {
      $presupuesto['NUEVA'][$val->categoria][] = $val;
    }
    
    //
    $data['input_fecha'] = form_input('fecha',set_value('fecha',exist_obj($info,'fecha')),'class="form-control" id="fecha" ');

    $data['input_torre'] = form_input('torre',set_value('torre',exist_obj($info,'torre')),'class="form-control" id="torre" ');

    $data['input_tipo_vehiculo'] = form_input('tipo_vehiculo',set_value('tipo_vehiculo',exist_obj($info,'tipo_vehiculo')),'class="form-control" id="tipo_vehiculo" ');

    $data['input_placas'] = form_input('placas',set_value('placas',exist_obj($info,'vehiculo_placas')),'class="form-control" id="placas" ');

    $data['input_serie'] = form_input('serie',set_value('serie',exist_obj($info,'vehiculo_numero_serie')),'class="form-control" id="serie" ');

    $data['input_orden_reparacion'] = form_input('orden_reparacion',set_value('orden_reparacion',exist_obj($info,'orden_reparacion')),'class="form-control" id="orden_reparacion" ');

    $data['drop_color'] = form_dropdown('id_color',array_combos($this->mcatalogos->get('colores','color'),'id','color',TRUE),set_value('id_color',exist_obj($info,'id_color')),'class="form-control busqueda" id="id_color"');

    $data['drop_vehiculo_modelo'] = form_dropdown('idmodelo',array_combos($this->mcatalogos->get('bodyshop_modelos','modelo'),'modelo','modelo',TRUE),set_value('vehiculo_modelo',exist_obj($info,'vehiculo_modelo')),'class="form-control busqueda" id="idmodelo"'); 

    $data['input_aseguradora'] = form_input('aseguradora',set_value('aseguradora',exist_obj($info,'aseguradora')),'class="form-control" id="aseguradora" ');

    //si el estatus es refacciones mostrar el checkbox
    if($data['estatus']->estatusId == 5)
      $data['input_llegaron_refacciones'] = form_checkbox('llegaron_refacciones]',$data['proyecto']->llegaron_refacciones==1 ? true : false,'','class="jsLlegaronRefacciones" id="llegaron_refacciones" ');
    else
      $data['input_llegaron_refacciones'] ='';

    $data['datos'] = $presupuesto;
    $data['id_proyecto'] = $id;
    echo $this->blade->render('bodyshop/presupuesto', $data, true);
    //$content = $this->blade->render('bodyshop/presupuesto', $data, true);
    //$this->load->view('main/panel', array('content'=>$content,'included_js'=>array('')));
  }
  public function estadisticas_estatus(){
      if($this->session->userdata('login_estadisticas')){
        $data['drop_tecnicos_mecanicos'] = form_dropdown('id_tecnico_mecanico',array_combos($this->mcatalogos->get('bodyshop_tecnicos','tecnico','',array('tipo'=>'Mecánico','activo'=>1)),'id','tecnico',TRUE),"",'class="form-control busqueda" id="id_tecnico_mecanico"'); 

        $data['drop_tecnicos_lamineros'] = form_dropdown('id_tecnico_laminero',array_combos($this->mcatalogos->get('bodyshop_tecnicos','tecnico','',array('tipo'=>'Laminero','activo'=>1)),'id','tecnico',TRUE),"",'class="form-control busqueda" id="id_tecnico_laminero"'); 

        $data['drop_tecnicos_pintores'] = form_dropdown('id_tecnico_pintor',array_combos($this->mcatalogos->get('bodyshop_tecnicos','tecnico','',array('tipo'=>'Pintor','activo'=>1)),'id','tecnico',TRUE),"",'class="form-control busqueda" id="id_tecnico_pintor"'); 

        //debug_var($data);die();
        $content = $this->blade->render('bodyshop/estadisticas_estatus', $data, true);
        $this->load->view('main/panel', array('content'=>$content,'included_js'=>array('')));
      }else{
        $this->blade->render('login_estadisticas',array('tipo'=>2));
      }
  }
  public function tiempos_tecnicos(){
    $data = array();
    //print_r($_POST);die();
    $datos = $this->principal->tiempos_tecnicos($this->input->post('id_tecnico'),$this->input->post('status'));
    $datos_vista = array();
    foreach ($datos as $key => $value) {
       $fecha1 = new DateTime($value->fecha);//fecha inicial
       $fecha2 = new DateTime($value->fecha_siguiente);//fecha de cierre
       $intervalo = $fecha1->diff($fecha2);

       //Transformar todo a minutos
       $meses_horas = (int)$intervalo->format('%m')*31*24*60;// meses
       $dias_horas = (int)$intervalo->format('%d')*24*60;// días
       $horas = (int)$intervalo->format('%H')*60;// horas
       $minutos = (int)$intervalo->format('%i');// minutos

      //Saber cuanto tardó en realizar la cita
      $minutos_realizo_cita = $meses_horas+$dias_horas+$horas+$minutos;
      $datos_vista[$key] = $value;

      //Los minutos que debería durar la cita
      $minutos_cita = ($value->horas=='')?0:($value->horas*60);

      $datos_vista[$key]->minutos_cita = $minutos_cita;

      $datos_vista[$key]->minutos_realizo_cita = $minutos_realizo_cita;

      if($minutos_cita==0){
        $datos_vista[$key]->minutos_retraso = 0 ;
      }else if($minutos_realizo_cita > $minutos_cita){
        $datos_vista[$key]->minutos_retraso = (int)$minutos_realizo_cita-(int)$minutos_cita;
      }else{
        $datos_vista[$key]->minutos_retraso = 0 ;
      }
    } 
    //debug_var($datos_vista);die();
    $data['datos'] = $datos_vista;
    $data['titulo'] = $this->input->post('titulo');
    $data['status'] = $this->input->post('status');
    echo $this->blade->render('bodyshop/tiempos_tecnicos', $data, true);
    // $content = $this->blade->render('bodyshop/tiempos_tecnicos', $data, true);
    // $this->load->view('main/panel', array('content'=>$content,'included_js'=>array('')));
    //$this->blade->render('tiempos_tecnicos');
  }

}
