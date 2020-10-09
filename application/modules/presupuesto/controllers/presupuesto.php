<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Presupuesto extends MX_Controller {
	 public function __construct()
    {
        parent::__construct();
        $this->load->model('m_catalogos', 'mcat', TRUE);
        $this->load->model('principal', '', TRUE);
        $this->load->model('m_presupuesto', 'mp', TRUE);
        $this->load->library(array('session','table','blade'));
        $this->load->helper(array('form', 'html', 'companies', 'url','date'));

        date_default_timezone_set('America/Mexico_City');
    }
    public function index($idproyecto=8){
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

      $data['drop_color'] = form_dropdown('id_color',array_combos($this->mcat->get('colores','color'),'id','color',TRUE),set_value('id_color',exist_obj($info,'id_color')),'class="form-control busqueda" id="id_color"');

      $data['drop_vehiculo_modelo'] = form_dropdown('idmodelo',array_combos($this->mcat->get('modelos','modelo'),'modelo','modelo',TRUE),set_value('vehiculo_modelo',exist_obj($info,'vehiculo_modelo')),'class="form-control busqueda" id="idmodelo"'); 

       $data['input_aseguradora'] = form_input('aseguradora',set_value('aseguradora',exist_obj($info,'aseguradora')),'class="form-control" id="aseguradora" ');

      $content = $this->blade->render('presupuesto/presupuesto', $data, TRUE);
        $this->load->view('main/panel', array('content'=>$content,
                                                       'included_js'=>array('')));
    }
    public function savePresupuesto(){
      //print_r($_POST);die();
      if($_POST['tipo']!=''){
        $this->db->where('idbody',1)->delete('bodyshop_detalle_presupuesto');
        foreach ($_POST['tipo'] as $key => $value) {
          if($value!=''){
            $datos_presupuesto = array('tipo'=>$_POST['tipo'][$key],
                                      'idparte' => $key,
                                      'noparte'=>$_POST['noparte'][$key],
                                      'precio'=>$_POST['precio'][$key],
                                      'existencia'=>$_POST['existencia'][$key],
                                      'idbody'=>1);
            $this->db->insert('bodyshop_detalle_presupuesto',$datos_presupuesto);
          }
          
        }
        
      }
      
    }
    public function buscar_datos(){
      echo $this->mp->buscar_bitacora();
    }
    public function generar_reporte_excel(){
      $this->mp->generar_reporte_excel($this->mp->getTabla());
    }

}
?>