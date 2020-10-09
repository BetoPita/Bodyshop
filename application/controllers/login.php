<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**

 **/
class login extends MX_Controller {

    /**

     **/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('principal', '', TRUE);
        $this->load->library(array('session'));
        $this->load->helper(array('form', 'html', 'companies', 'url'));
    }

	public function index(){

        $content = $this->load->view('login', '', FALSE);

	}

  public function clientes()
  {
    $content = $this->load->view('v_logincliente', '', FALSE);
  }

  public function cliente_login()
  {
    $username = $this->input->post('username');
    $password = $this->input->post('password');
        
   if(isset($username) && isset($password) && !empty($password) && !empty($username)){
            $total = $this->principal->count_results_users_clientes($username, $password);
            
      if ($total > 0) {
          $dataUser = $this->principal->get_all_data_users_clientes($username, $password);
          $array_session = array('idcliente'=> $dataUser->idusuarios,
                                 'datos_email'=> $dataUser->datos_email,
                                 'nombre_cliente' => $dataUser->datos_nombres);

          $this->session->set_userdata($array_session);

              if ($this->session->userdata('idcliente')) {
                     redirect('bodyshop/proyectos/','refresh');
              }else{
                 redirect('bodyshop/proyectos/login','refresh');
                }
             }else{
               redirect('bodyshop/proyectos/login','refresh');
             }
      }else{
          redirect('bodyshop/proyectos/login','refresh');
      }
  }

  public function mainView()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if(isset($username) && isset($password) && !empty($password) && !empty($username))
        {

            $total = $this->principal->count_results_users($username, $password);
            if($total == 1)
            {
                $dataUser = $this->principal->get_all_data_users_specific($username, $password);

                $array_session = array('id'=>$dataUser->adminId,'adminStatus'=>$dataUser->adminStatus,'statusPerfil'=>$dataUser->status,'nombre_asesor_session'=>$dataUser->adminNombre,'is_admin'=>$dataUser->status);
                $this->session->set_userdata($array_session);

                if($this->session->userdata('id'))
                {
                   //redirect('contactos/');

                  //if(status_admin($this->session->userdata('id'))==3){
                  if($this->session->userdata('statusPerfil')==4){
                    redirect('contactos/');
                  }else{
                      redirect('login/selecciona_sucursal');
                  }

                    /*$aside = $this->load->view('companies/left_menu', '', TRUE);
                    $content = $this->load->view('companies/main_view', '', TRUE);
                    $this->load->view('main/template', array('aside'=>$aside,
                                                             'content'=>'',
                                 'included_js'=>array('statics/js/modules/menu.js')));*/
                }
                else{
                }
            }
            else{
                redirect('login');
            }
        }
        else{
            redirect('login');
        }
    }



    public function registro(){
     /*if($this->session->userdata('id'))
        {
        $menu_header = $this->load->view('companies/menu_header', '', TRUE);
        $aside = $this->load->view('companies/left_menu', '', TRUE);
        $content = $this->load->view('companies/panel', '', TRUE);
        $this->load->view('main/panel', array('menu_header'=>$menu_header,
                                                       'aside'=>$aside,
                                                       'content'=>$content,
                                                       'included_js'=>array('statics/js/libraries/form.js','statics/js/modules/notificaciones.js')));
        }
        else{
            redirect('companies');
        }*/
        $content = $this->load->view('registro', '', FALSE);

    }

    public function saveregistro(){
        $post = $this->input->post('save');
        $post['status'] = 2;
        $res = $this->principal->insert('admin', $post);
        if($res>0){
            redirect('login/');
        }


    }

     public function registroexito(){
     /*if($this->session->userdata('id'))
        {
        $menu_header = $this->load->view('companies/menu_header', '', TRUE);
        $aside = $this->load->view('companies/left_menu', '', TRUE);
        $content = $this->load->view('companies/panel', '', TRUE);
        $this->load->view('main/panel', array('menu_header'=>$menu_header,
                                                       'aside'=>$aside,
                                                       'content'=>$content,
                                                       'included_js'=>array('statics/js/libraries/form.js','statics/js/modules/notificaciones.js')));
        }
        else{
            redirect('companies');
        }*/
        $content = $this->load->view('registroexito', '', FALSE);

    }


    public function selecciona_sucursal(){

      if($this->session->userdata('id'))
      {

        if(status_admin($this->session->userdata('id'))==1){
          $array_session = array('sucursal'=>0);
          $this->session->set_userdata($array_session);
          redirect('contactos/');
        }else{
          $sucursales = $this->principal->get_result('suIdUsuario',$this->session->userdata('id'),'usuario_sucursal');
          $data['sucursales'] = $sucursales;
          $content = $this->load->view('sucursal', $data, FALSE);
        }


      }
      else{
      }

    }

    public function update_sucursal($id_sucursal){
      $array_session = array('sucursal'=>$id_sucursal);
      $this->session->set_userdata($array_session);
    //  echo $this->session->userdata('sucursal');
      redirect('contactos/');
    }



    public function logout()
    {
        $this->session->unset_userdata('id');
        $this->session->sess_destroy();
        redirect('login');
    }


}
