<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**

 **/
class tablero extends MX_Controller {

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
        date_default_timezone_set('America/Mexico_City');
        $this->perPage = 10;
        
    }
    public function index()
    {
      if($this->session->userdata('login')){
        $estatus = $this->principal->get_estatus_byorden();

        $totales=array();
        $cont =0;
        $conditions['order_by'] = "proyectoId DESC";
        $conditions['limit'] = $this->perPage;
        foreach ($estatus as $key => $value) {
          //if($cont==0){
            $totales[$cont]['estatus']=$value;
            $totales[$cont]['proyectos']=$this->principal->bodyshop_par_estatus($this->session->userdata('id'),$value->estatusId,true);
           //echo $this->db->last_query();die();
          $cont++;
          //}
        }

        //debug_var($totales);die;
        $data['data']=$totales;
        $data['total']= count($estatus);
        //print_r($data);die();
        $this->blade->render('bodyshop/tablero3',$data);
      }else{
        $this->blade->render('login');
      }
    }
     public function indexbk()
    {
      $estatus = $this->principal->get_table('bodyshop_estatus');
      $totales=array();
      $cont =0;
      $conditions['order_by'] = "proyectoId DESC";
      $conditions['limit'] = $this->perPage;
      foreach ($estatus as $key => $value) {
        $totales[$cont]['estatus']=$value;
        $totales[$cont]['proyectos']=$this->principal->bodyshop_par_estatus($this->session->userdata('id'),$value->estatusId,true,$conditions);
        $cont++;
      }

      debug_var($totales);die;
      $data['data']=$totales;
      $data['total']= count($estatus);
      //print_r($data);die();
      $this->blade->render('bodyshop/tablero',$data);
    }
    function loadMoreDataTablero(){
        $conditions = array();
        $estatus = $this->principal->get_estatus_byorden();
        $totales=array();
        $cont =0;
        // Get last post ID
        $lastID = $this->input->post('id');
        
        // Get post rows num
        $conditions['where'] = array('proyectoId <'=>$lastID);
        $conditions['returnType'] = 'count';
        // Get posts data from the database
        $conditions['returnType'] = '';
        $conditions['order_by'] = "proyectoId DESC";
        $conditions['limit'] = $this->perPage;
        foreach ($estatus as $key => $value) {
        $totales[$cont]['estatus']=$value;
        $totales[$cont]['proyectos']=$this->principal->bodyshop_par_estatus($this->session->userdata('id'),$value->estatusId,true,$conditions);
        $data['RegNum'] = $this->principal->bodyshop_par_estatus($this->session->userdata('id'),$value->estatusId,true,$conditions);
        //echo $this->db->last_query();die();
        $cont++;
      }
      //echo $this->db->last_query();die();
      //debug_var($totales);die;
      $data['data']=$totales;
      $data['total']= count($estatus);
        
        $data['postLimit'] = $this->perPage;
        
        // Pass data to view
        $this->blade->render('load-data-tablero', $data, false); //
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
   public function cambiar_status(){
      //print_r($_POST);die();
     
      $id = $this->input->post('id_proyecto');
      //$status = (int)$this->input->post('status');
      $status = (int)$this->principal->getStatus($id)+1; //agarrar el estatus siguiente    
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
    public function scroll(){
      $data = array();
        
      // Get posts data from the database
      $conditions['order_by'] = "id DESC";
      $conditions['limit'] = $this->perPage;
      $data['posts'] = $this->principal->getRows($conditions);
      //debug_var($data);die();
      $this->blade->render('scroll',$data);
    }
    function loadMoreData(){
        $conditions = array();
        
        // Get last post ID
        $lastID = $this->input->post('id');
        
        // Get post rows num
        $conditions['where'] = array('id <'=>$lastID);
        $conditions['returnType'] = 'count';
        $data['postNum'] = $this->principal->getRows($conditions);
        
        // Get posts data from the database
        $conditions['returnType'] = '';
        $conditions['order_by'] = "id DESC";
        $conditions['limit'] = $this->perPage;
        $data['posts'] = $this->principal->getRows($conditions);
        
        $data['postLimit'] = $this->perPage;
        
        // Pass data to view
        $this->blade->render('load-more-data', $data, false); //load-data-tablero
    }
  public function validar_login(){
    if($this->input->post()){
      $usuario = $this->input->post('usuario');
      $password = $this->input->post('password');

      if($usuario=="ford" && $password =="ford1001"){

        $this->session->set_userdata('login',1);
        redirect(base_url('tablero-bodyshop'));
       
       
      }else{
        $this->session->set_userdata('login',0);
        $datos['error'] = "Usuario o contraseña incorrectos";
        $this->blade->render('login',$datos);
        
      }
      
    }
    
  }
  public function validar_login_backup(){
    if($this->input->post()){
      $usuario = $this->input->post('usuario');
      $password = $this->input->post('password');
      $tipo = $this->input->post('tipo'); //1 es de backup, 2 es de estadisticas

      if($tipo==1){
        if($usuario=="contacto" && $password =="conplas116b10"){
          $this->session->set_userdata('login_backup',1);
          redirect('bodyshop/backup');
         
        }else{
          $this->session->set_userdata('login_backup',0);
          $datos['error'] = "Usuario o contraseña incorrectos";
          $datos['tipo'] = $tipo;
          $this->blade->render('login_backup',$datos);
        }
      }else{
        if($usuario=='master' && $password =='sh0paqu10'){
            $this->session->set_userdata('login_estadisticas',1);
          redirect('bodyshop/estadisticas_estatus');
        }else{
          $this->session->set_userdata('login_estadisticas',0);
          $datos['error'] = "Usuario o contraseña incorrectos";
          $datos['tipo'] = $tipo;
          $this->blade->render('login_backup',$datos);
        }
      }
      
      
    }
    
  }
  public function cerrar_sesion_tablero(){
     $this->session->set_userdata('login',0);
     redirect(base_url('tablero-bodyshop'));
  }
  public function cerrar_sesion_backup(){
     $this->session->set_userdata('login_backup',0);
     redirect('bodyshop/backup');
  }
  public function cerrar_sesion_estadisticas(){
     $this->session->set_userdata('login_estadisticas',0);
     redirect('bodyshop/estadisticas_estatus');
  }
  public function tecnicosAsignados(){
    $datos = $this->principal->getTecnicosByStatusAndProyect($_POST['proyectoId'],$_POST['status']);
    //debug_var($datos);
    $this->blade->render('bodyshop/tecnicos_asignados',array('datos'=>$datos));
    //debug_var($datos);
  }
  public function asignarTecnico(){
      $tecnicos_asignados = $this->principal->getTecnicosStatus($this->input->post('proyectoId'));
        //echo $this->db->last_query();die();
        $cadena = '';
        if(count($tecnicos_asignados)>0){
          foreach ($tecnicos_asignados as $key => $value) {
           $cadena.= $value->id_tecnico.',';
          }
          
          $cadena = substr ($cadena, 0, strlen($cadena) - 1);
          //echo $cadena;die();
        }
        $data['catalogo_tecnicos'] = $this->principal->getTecnicosByProyect($cadena,$this->input->post('status'));
        $data['proyectoIdTecnico'] = $this->input->post('proyectoId');
        //echo $this->db->last_query();die();
        $this->blade->render('bodyshop/modal_asignar_tecnico',$data);
  }
  public function cambiarTecnico(){
    //print_r($_POST);die();
    if ($this->input->post('proyectoIdTecnico')) {
            $idproyecto = $this->input->post('proyectoIdTecnico');
            $idtecnicos = $this->input->post('nuevotecnico');
            //Insertar en la tabla de los técnicos por estatus por proyecto
            $data = array('proyectoId' => $idproyecto,'status'=>$this->principal->getStatus($idproyecto),'idusuario'=>$this->session->userdata('id'),'fecha'=>date('Y-m-d H:i:s'),'id_tecnico'=>$idtecnicos );

            $this->db->insert('bodyshop_tecnicos_estatus',$data);
            //$data = array('idtecnico' => $this->input->post('tecnicos'));

            //$update = $this->principal->update("proyectoId",$idproyecto,'bodyshop',$data);  
            echo 1;
        }else{
          echo 0;
        }
        exit();
  }
  //Finalizar el proyecto
  public function finalizar(){
    $this->db->where('proyectoId',$this->input->post('proyectoId'))->set('finalizado',1)->update('bodyshop');
    echo 1;exit();
  }
   //Transito estatus
  public function transito(){
    $this->db->where('proyectoId',$this->input->post('proyectoId'))->set('transito',$this->input->post('transito'))->update('bodyshop');
    echo 1;exit();
  }
  //Guardar comentario
  function modalComentario($id=0)
    {
      $data['id_proyecto'] = $this->input->get('id_proyecto');
      $data['input_comentario'] = form_textarea('comentario_cambio','','class="form-control" rows="5" id="comentario_cambio" ');
      $this->blade->render('nuevo_comentario',$data);
  }
  //Ver historial de estatus
  public function ver_historial_comentarios_estatus(){
    $data['historial'] = $this->principal->getHistorialComentarios($this->input->post('proyectoId'));
    //debug_var($data['historial']);die();
    $this->blade->render('historial_comentarios_status',$data);
  }
  //Guarda comentario
  public function saveOnlyComment(){
      //print_r($_POST);die();
     
      $id = $this->input->post('id_proyecto');
      //$status = (int)$this->input->post('status');
      $status = (int)$this->principal->getStatus($id); //agarrar el estatus actual    
      if(isset($_POST['id_usuario']))
      {
        $usuarioId = $this->input->post('id_usuario');
      }
      else{
        $usuarioId = $this->session->userdata('id');
      }
      $data = array('proyectoId' => $id,
                    'status'=>$status,
                    'idusuario'=>$usuarioId,
                    'comentario'=>$this->input->post('comentario'),
                    'fecha'=>date('Y-m-d H:i:s')
      );

      $this->db->insert('bodyshop_comentarios_estatus',$data);
      echo 1;exit();
    }
    
}
