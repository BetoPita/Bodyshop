<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proyectos extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('principal', '', TRUE);
        $this->load->model('m_catalogos', 'mcatalogos', TRUE);
        $this->load->library(array('session','blade','form_validation','zip','table'));
        $this->load->helper(array('form', 'html', 'companies', 'url','dompdf','date','download'));
        $this->load->model('m_citas', 'mcat', TRUE);
        $this->load->model('presupuesto/m_presupuesto', 'mp', TRUE);
        if(!$this->session->userdata('idcliente')){ redirect('login/clientes');}
        
        date_default_timezone_set('America/Mexico_City');
	}

	public function index(){
		
      	$data['proyectos'] = $this->principal->get_result_clientes( $this->session->userdata('datos_email'));
      	$data['datos'] = $this->principal->get_row('adminId', $this->session->userdata('id'), 'admin');
        

      	$content = $this->load->view('bodyshop/proyectosusuarios', $data, true);
      	$this->load->view('bodyshop/cliente_proyectos', array('content'=>$content,
                                            'included_js'=>array('')));

    }

    public function detalle_proyecto_temp()
    {
      $idProyecto = base64_decode($this->uri->segment(4));
      if ($idProyecto != '') {
        $data['inputs'] = $this->precargar_detalle_proyecto($idProyecto);
        $data['comentarios'] =$this->principal->get_result_order('comentarioIdProyecto', $idProyecto,'bodyshop_comentarios','comentarioId','desc');
        $data['descargables'] = $this->principal->get_result_order('descargableIdProyecto', $idProyecto,'bodyshop_desargable','descargableId','desc');
        $content = $this->load->view('bodyshop/detalle_proyecto', $data, true);
        $this->load->view('bodyshop/cliente_proyectos', array('content' => $content,'included_js'=>array('')));
      }else{
        redirect('bodyshop/proyectos');
      }
    }

    public function detalle_proyecto()
    {
    	$id = base64_decode($this->input->get('id'));
    	if ($id != '') {
    		$data['cronograma'] =$this->principal->get_result_order('cronoIdProyecto',$id,'bodyshop_cronograma','cronoId','desc');

            $data['comentarios'] =$this->principal->get_result_order('comentarioIdProyecto', $id,'bodyshop_comentarios','comentarioId','desc');
            $data['participantes'] = $this->principal->get_result('ppIdProyecto', $id,'bodyshop_participantes');
            $data['proyecto'] = $this->principal->get_row('proyectoId',$id,'bodyshop' );
            $data['estatus'] = $this->principal->get_row('estatusId',$data['proyecto']->status,'bodyshop_estatus' );
            $data['datos'] = $this->principal->get_row('adminId', $this->session->userdata('id'), 'admin');
            $data['progress'] = ($data['proyecto']->status * 100)/12;
            $data['id_proyecto'] = $id;
            $data['descargables'] = $this->principal->get_result_order('descargableIdProyecto', $id,'bodyshop_desargable','descargableId','desc');
            $data['gastos'] =$this->principal->get_result('idProyecto', $id,'bodyshop_gasto_proyecto');

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
            $content = $this->blade->render('bodyshop/detalle_clienteproyecto', $data, true);

            $this->load->view('bodyshop/cliente_proyectos', array('content'=>$content,
                                                  'included_js'=>array('')));
            
            $pro['pro'] = $this->principal->get_row('proyectoId',$id,'bodyshop');
            $pro['estatus'] = $this->principal->get_estatus_byorden();
            $this->load->view('bodyshop/ver_estatus', $pro, false);

            $this->load->view('bodyshop/m_cronograma', $pro, false);
            $this->load->view('bodyshop/m_status_actividad', $pro, false);
    	}else{
        	redirect('bodyshop/proyectos');
      	}

    }

    
    public function save_comentario_detalle_proyecto(){
        $data = $this->input->post('commen');
        $data['idusuariocliente'] = $this->session->userdata('idcliente');
        $data['fecha'] =  date("Y-m-d");
        $data['hora'] =  date("H:i:s");
        $this->principal->insert('bodyshop_comentarios', $data);
        $res = $this->principal->get_result('ppIdProyecto', $data['comentarioIdProyecto'],'bodyshop_participantes');
        foreach($res as $noti):
          $notific['titulo'] = 'bodyshop';
          $notific['texto']= 'se agrego un nuevo comentario';
          $notific['id_user'] = $noti->ppIdAdmin;
          $notific['estado'] = 1;
          $notific['url'] = base_url().'index.php/bodyshop/proyecto/detalle_proyecto/'.$data['comentarioIdProyecto'];
          $notific['estadoWeb'] = 1;
          $this->principal->insert('noti_user',$notific);

        endforeach;
        
        redirect('bodyshop/proyectos/detalle_proyecto/'.base64_encode($data['comentarioIdProyecto']));
    }

    public function precargar_detalle_proyecto($id)
    {

      $reg = $this->principal->get_row('proyectoId', $id, 'bodyshop');
      $estatus = $this->principal->get_row('id',$reg->id_status_color,'estatus');
      $color = $this->principal->get_row('id',$reg->id_color,'colores');
      $asesores = $this->principal->get_row('id',$reg->asesor,'operadores');
      $data['id_proyecto'] = $id;
      $data['drop_vehiculo_anio'] = form_input('save[vehiculo_anio]',isset($reg->vehiculo_anio) ? $reg->vehiculo_anio :'','class="form-control busqueda" disabled id="vehiculo_anio"'); 
      $data['numero_siniestro'] = form_input('save[numero_siniestro]',isset($reg->numero_siniestro) ? $reg->numero_siniestro :'','class="form-control" rows="5" disabled id="numero_siniestro" ');
      $data['numero_poliza']    = form_input('save[numero_poliza]',isset($reg->numero_poliza) ? $reg->numero_poliza :'','class="form-control" disabled rows="5" id="numero_poliza"');
      $data['proyectoCliente']    = form_input('save[proyectoCliente]',isset($reg->proyectoCliente) ? $reg->proyectoCliente :'','class="form-control" disabled rows="5" id="numero_poliza"');
      $data['proyectoDescripcion']    = form_input('save[proyectoDescripcion]',isset($reg->proyectoDescripcion) ? $reg->proyectoDescripcion :'','class="form-control" disabled rows="5" id="numero_poliza"');
      $data['input_vehiculo_placas'] = form_input('save[vehiculo_placas]',isset($reg->vehiculo_placas) ? $reg->vehiculo_placas :'','class="form-control" disabled rows="5" id="vehiculo_placas" ');
      $data['drop_color'] = form_input('save[id_color]',isset($color->id_color) ? $color->color :'','class="form-control busqueda" disabled id="id_color"');
      $data['drop_vehiculo_modelo'] = form_input('save[vehiculo_modelo]',isset($reg->vehiculo_modelo) ? $reg->vehiculo_modelo :'','class="form-control busqueda" disabled id="vehiculo_modelo"'); 
      $data['input_vehiculo_numero_serie'] = form_input('save[vehiculo_numero_serie]',isset($reg->vehiculo_numero_serie) ? $reg->vehiculo_numero_serie :'','class="form-control" disabled rows="5" id="vehiculo_numero_serie" ');
      $data['drop_asesor'] = form_input('save[asesor]',isset($asesores->nombre) ? $asesores->nombre :'','class="form-control busqueda" disabled id="asesor"');
      
      $data['drop_fecha'] = form_input('save[fecha]',isset($reg->fecha) ? $reg->fecha :'','class="form-control" disabled id="fecha" '); 
      $data['drop_horario'] = form_input('save[id_horario]',isset($reg->id_horario) ? $reg->id_horario :'','class="form-control" disabled id="horario" ');

      $data['input_comentarios'] = form_textarea('save[comentarios_servicio]',isset($reg->comentarios_servicio) ? $reg->comentarios_servicio :'','class="form-control" disabled id="comentarios_servicio" rows="2"');
      $data['input_email'] = form_input('save[datos_email]',isset($reg->datos_email) ? $reg->datos_email :'','class="form-control" rows="5" disabled id="datos_email" ');

      $data['input_datos_nombres'] = form_input('save[datos_nombres]',isset($reg->datos_nombres) ? $reg->datos_nombres :'','class="form-control" disabled id="datos_nombres" ');
      $data['input_datos_apellido_paterno'] = form_input('save[datos_apellido_paterno]',isset($reg->datos_apellido_paterno) ? $reg->datos_apellido_paterno :'','class="form-control" disabled id="datos_apellido_paterno" ');
      $data['input_datos_apellido_materno'] = form_input('save[datos_apellido_materno]',isset($reg->datos_apellido_materno) ? $reg->datos_apellido_materno :'','class="form-control" disabled id="datos_apellido_materno" ');
      $data['input_datos_telefono'] = form_input('save[datos_telefono]',isset($reg->datos_telefono) ? $reg->datos_telefono :'','class="form-control" disabled id="datos_telefono" ');
      $data['input_datos_telefono2'] = form_input('save[datos_telefono2]',isset($reg->datos_telefono2) ? $reg->datos_telefono2 :'','class="form-control" disabled id="datos_telefono2" ');
      $data['drop_proyectoNombre'] = form_input('save[proyectoNombre]',isset($reg->proyectoNombre) ? $reg->proyectoNombre :'','class="form-control busqueda" disabled id="proyectoNombre"'); 

      $data['drop_id_status_color'] = form_input('save[id_status_color]',isset($reg->id_status_color) ? $estatus->nombre :'','class="form-control busqueda" disabled id="id_status_color"'); 
      $data['drop_tecnicos_dias'] = form_input('save[tecnico_dias]',isset($reg->tecnico_dias) ? $reg->tecnico_dias :'','class="form-control busqueda" id="tecnico_dias"');
      $data['input_fecha_inicio'] = form_input('save[fecha_inicio]',isset($reg->fecha_inicio) ? $reg->fecha_inicio :'','class="form-control" disabled id="fecha_inicio" ');
      $data['input_fecha_fin'] = form_input('save[fecha_fin]',isset($reg->fecha_fin) ? $reg->fecha_fin :'','class="form-control" disabled id="fecha_fin" ');
      $data['input_hora_comienzo'] = form_input('save[hora_comienzo]',isset($reg->hora_comienzo) ? $reg->hora_comienzo :'','class="form-control" id="hora_comienzo" ');
      $data['input_fecha_parcial'] = form_input('save[fecha_parcial]',isset($reg->fecha_parcial) ? $reg->fecha_parcial :'','class="form-control" id="fecha_parcial" ');
      $data['input_hora_inicio_extra'] = form_input('save[hora_inicio_extra]',isset($reg->hora_inicio_extra) ? $reg->hora_inicio_extra :'','class="form-control" id="hora_inicio_extra" ');
      $data['input_hora_fin_extra'] = form_input('save[hora_fin_extra]',isset($reg->hora_fin_extra) ? $reg->hora_fin_extra :'','class="form-control" id="hora_fin_extra" ');
      $data['drop_tecnicos'] = form_input('save[tecnico]',isset($reg->tecnico) ? $reg->tecnico :'','class="form-control" id="tecnicos" '); 
      $data['input_hora_inicio'] = form_input('save[hora_inicio]',isset($reg->hora_inicio) ? $reg->hora_inicio :'','class="form-control" id="hora_inicio" ');
      $data['input_hora_fin'] = form_input('save[hora_fin]',isset($reg->hora_fin) ? $reg->hora_fin :'','class="form-control" id="hora_fin" ');

      return $data;
    }

}

/* End of file proyectos.php */
/* Location: ./application/modules/bodyshop/controllers/proyectos.php */