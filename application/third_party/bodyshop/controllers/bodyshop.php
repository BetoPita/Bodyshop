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
        $this->load->library(array('session','blade','form_validation'));
        $this->load->helper(array('form', 'html', 'companies', 'url','dompdf'));
        $this->load->model('m_citas', 'mcat', TRUE);
        $this->load->model('presupuesto/m_presupuesto', 'mp', TRUE);
        if(!$this->session->userdata('id')){redirect('login');}
        date_default_timezone_set('America/Mexico_City');
    }

    public function index(){
      $data['proyectos'] = $this->principal->bodyshop_par($this->session->userdata('id'));//get_result_proyectos('proyectoIdAdmin',$this->session->userdata('id'),'proyectos');
      $data['datos'] = $this->principal->get_row('adminId', $this->session->userdata('id'), 'admin');
      $content = $this->load->view('bodyshop/proyectos', $data, true);
      $this->load->view('main/panel', array('content'=>$content,
                                            'included_js'=>array('')));

    }

    public function crear_proyecto($modal=false){
      $info=new Stdclass();
      $data['datos'] = $this->principal->get_row('adminId', $this->session->userdata('id'), 'admin');
      $data['drop_vehiculo_anio'] = form_dropdown('save[vehiculo_anio]',array_combos($this->mcat->get('cat_anios','anio','desc'),'anio','anio',TRUE),set_value('vehiculo_anio',exist_obj($info,'vehiculo_anio')),'class="form-control busqueda" id="vehiculo_anio"'); 
      $data['numero_siniestro'] = form_input('save[numero_siniestro]',set_value('numero_siniestro',exist_obj($info,'numero_siniestro')),'class="form-control" rows="5" id="numero_siniestro" ');
      $data['numero_poliza'] = form_input('save[numero_poliza]',set_value('numero_poliza',exist_obj($info,'numero_poliza')),'class="form-control" rows="5" id="numero_poliza" ');
      $data['input_vehiculo_placas'] = form_input('save[vehiculo_placas]',set_value('vehiculo_placas',exist_obj($info,'vehiculo_placas')),'class="form-control" rows="5" id="vehiculo_placas" ');
      $data['drop_color'] = form_dropdown('save[id_color]',array_combos($this->mcat->get('cat_colores','color'),'id','color',TRUE),set_value('id_color',exist_obj($info,'id_color')),'class="form-control busqueda" id="id_color"');
      $data['drop_vehiculo_modelo'] = form_dropdown('save[vehiculo_modelo]',array_combos($this->principal->get_table_order('cat_modelo','modelo','ASC'),'modelo','modelo',TRUE),set_value('vehiculo_modelo',exist_obj($info,'vehiculo_modelo')),'class="form-control busqueda" id="vehiculo_modelo"'); 
      $data['input_vehiculo_numero_serie'] = form_input('save[vehiculo_numero_serie]',set_value('vehiculo_numero_serie',exist_obj($info,'vehiculo_numero_serie')),'class="form-control" rows="5" id="vehiculo_numero_serie" ');
      $data['drop_asesor'] = form_dropdown('save[asesor]',array_combos($this->principal->get_table_order('operadores','nombre','asc'),'id','nombre',TRUE),set_value('asesor',exist_obj($info,'asesor')),'class="form-control busqueda" id="asesor"');
      $data['input_comentarios'] = form_textarea('save[comentarios_servicio]',set_value('comentarios_servicio',exist_obj($info,'comentarios_servicio')),'class="form-control" id="comentarios_servicio" rows="2"');
      $data['input_email'] = form_input('save[datos_email]',set_value('datos_email',exist_obj($info,'datos_email')),'class="form-control" rows="5" id="datos_email" ');
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
      $data['modal']=$modal;
      if($modal== true){
        $content = $this->load->view('bodyshop/crear_proyecto', $data, true);
        echo $content;
        exit;
      }
      $content = $this->load->view('bodyshop/crear_proyecto', $data, true);
      $this->load->view('main/panel', array('content'=>$content,
                                            'included_js'=>array('')));
    }

    public function saveModelo()
    {
      if($this->input->post())
      {
        $this->form_validation->set_rules('modelo', 'modelo', 'trim|required|xss_clean');
        if($this->form_validation->run() == TRUE)
        {
          $datos = array('modelo' => $this->input->post('modelo'));
          $id = $this->principal->insert('cat_modelo',$datos);
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
      $data['drop_vehiculo_modelo'] = form_dropdown('save[vehiculo_modelo]',array_combos($this->principal->get_table_order('cat_modelo','modelo','ASC'),'modelo','modelo',TRUE),set_value('vehiculo_modelo',exist_obj($info,'vehiculo_modelo')),'class="form-control busqueda" id="vehiculo_modelo"'); 
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
        $post['proyectoIdAdmin'] = $this->session->userdata('id');
        $post['proyectoFechaCreacion'] = date("Y-m-d H:i");
        $post['tipo'] = 1;
        $post['status'] = 1;
        $res = $this->principal->insert('bodyshop', $post);
        $id = $res;
        $this->principal->insert_preguntas($id);
        $this->principal->insert_conformidades($id);
        $id_parti = $this->session->userdata('id');
        $aux = $this->principal->get_participantes_bodyshop($id,$id_parti);
        if($aux!=1){
          $data['ppIdAdmin'] = $id_parti;
          $data['ppIdProyecto'] = $id;
          $this->principal->insert('bodyshop_participantes',$data);
        }
        $res = $this->principal->get_result('ppIdProyecto', $id,'bodyshop_participantes');
        redirect('bodyshop/');

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
            $data['progress'] = ($data['proyecto']->status * 100)/9;
            $data['id_proyecto'] = $id;
            $data['descargables'] =$this->principal->get_result_order('descargableIdProyecto', $id,'bodyshop_desargable','descargableId','desc');
            $data['gastos'] =$this->principal->get_result('idProyecto', $id,'bodyshop_gasto_proyecto');
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



            // PITA 
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
            //debug_var($presupuesto);die();
            //
            $data['datos'] = $presupuesto;
            //debug_var($presupuesto);die();

            $info= $this->mp->getProyectoById($id);
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


            //
            $content = $this->blade->render('bodyshop/ver_proyecto', $data, true);

            $this->load->view('main/panel', array('content'=>$content,
                                                  'included_js'=>array('')));

            $parti['parti'] =$this->principal->get_contactos_admin($this->session->userdata('id')); //$this->principal->get_table('admin');//get_result('status',2,'admin');
            $this->load->view('bodyshop/m_agregar_participante', $parti, false);
            $pro['pro'] = $this->principal->get_row('proyectoId',$id,'bodyshop');
            $pro['estatus'] = $this->principal->get_table('bodyshop_estatus');
            $this->load->view('bodyshop/m_cambiar_status', $pro, false);

            $this->load->view('bodyshop/m_cronograma', $pro, false);
            $this->load->view('bodyshop/m_status_actividad', $pro, false);

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

    public function cambiar_status(){
      $id = $this->input->post('id_proyecto');
      $status = $this->input->post('status');
      $data['status'] = $status;
      $data['fecha_estatus'] = date("Y-m-d H:i");
      $this->principal->insert_transicion($id,$status);
      $this->principal->update('proyectoId',$id,'bodyshop',$data);
      $res = $this->principal->get_result('ppIdProyecto', $id,'bodyshop_participantes');
      foreach($res as $noti):
        $res1 = $this->principal->get_result('ppIdProyecto', $id,'bodyshop_participantes');
        foreach($res1 as $noti):
          $notific['titulo'] = 'bodyshop';
          $notific['texto']= 'cambio de estatus';
          $notific['id_user'] = $noti->ppIdAdmin;
          $notific['estado'] = 1;
          $notific['url'] = base_url().'index.php/bodyshop/ver_proyecto/'.$id;
          $notific['estadoWeb'] = 1;
          $this->principal->insert('noti_user',$notific);
        endforeach;

      endforeach;
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
      $id = $this->input->post('id_proyecto');
      $id_parti = $this->input->post('id_parti');
      $aux = $this->principal->get_participantes_bodyshop($id,$id_parti);
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
       redirect('bodyshop/ver_proyecto/'.$idProyecto);
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


      if($_FILES['image']['name'] != ''){
          $post = $this->input->post('save');

          $name = date('dmyHis').'_'.str_replace(" ", "", $_FILES['image']['name']);

          $path_to_save = 'statics/url_descargable/'.$this->session->userdata('id');
          if(!file_exists($path_to_save)){
            mkdir($path_to_save, 0777, true);
          }

          move_uploaded_file($_FILES['image']['tmp_name'], $path_to_save.$name);

          $data = $this->input->post('desca');
          $data['descargableIdAdmin'] = $this->session->userdata('id');
          $data['descargableFechaCreacion']= date("Y-m-d H:i:s");
          $data['descargableUrl'] = $path_to_save.$name;
          $this->principal->insert('bodyshop_desargable', $data);
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
                                      'idbody'=>$this->input->post('idproyectosave'));
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
      $estatus = $this->principal->get_table('bodyshop_estatus');
      $totales=array();
      $cont =0;
      foreach ($estatus as $key => $value) {
        $totales[$cont]['nombre']=$value->nombre;
        $totales[$cont]['total']=$this->principal->get_num_rows(array('status'=>$value->estatusId),'bodyshop');
        $cont++;
      }
      //var_dump($totales);
      $data['data']=$totales;
      $content = $this->load->view('bodyshop/dashboard', $data, true);
      $this->load->view('main/panel', array('content'=>$content,
                                                  'included_js'=>array(
                                                  '/statics/js/custom/c3.min.js')));
    }
    public function info(){
      echo phpinfo();
    }
    public function version(){
      echo phpversion();
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
    }
    //debug_var($where_in);die();
    $subcategorias_elegir = $this->db->where('idcategoria',$this->input->post('idcategoria'))->where_not_in('id',$where_in)->get('bodyshop_subcategoria')->result();
    //debug_var($subcategorias_elegir);die();
    $data['subcategorias'] = $subcategorias_elegir;
    $data['idcat'] = $this->input->post('idcategoria');
    $this->blade->render('v_addfield',$data);
  }


}
