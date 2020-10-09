<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function subirImg($carpeta,$ancho,$alto,$ImgName,$name){
	/*$carpeta: donde se va guardar
	$ImgName=nombre con el que se guardará la imagen
	$name= el name que trae el file 
	*/
	if (!file_exists($carpeta)) {
	    mkdir($carpeta, 0777, true);
	}
	$CI =& get_instance();
	if($ImgName==''){
		$ImgName=uniqid().date('Y-m-d');
	}
	$ImgName=sanear_string($ImgName);
	$config['upload_path'] = $carpeta;
	$config['allowed_types'] = 'gif|jpg|png|jpeg';
	$config['max_width']  = $ancho;
	$config['max_height']  =$alto;
	$config['file_name']=$ImgName;

	$CI->load->library('upload', $config);
	if ( ! $CI->upload->do_upload($name))
		{
			$error = $CI->upload->display_errors();
			$CI->msg=$error;
			$dataimg=$error;
		}	
		else
		{
			$dataimg = $CI->upload->data();
		}
	return $dataimg;

}

	function DimensionarImg($nombre,$ancho,$alto,$new_imagec){
		// https://ellislab.com/codeigniter/user-guide/libraries/image_lib.html      DOC.
		/*$nombre: toda la ruta donde estará y el nombre de la imagen anterior
		$new_imagec: nombre que tendrá la nueva imagen ya dimensionada
		*/

		$CI =& get_instance();
	
		//está funcion vuelve a subir la imagen original, por que antes ya se renombró la retina redimensionandola			
		$config['source_image']	= $nombre; 
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = FALSE; //mantener imagen
		$config['width']	= $ancho;
		$config['height']	= $alto;
		$config['new_image']	= $new_imagec; //seria la imagen principal, antes de cambiar el @2x
		
		$CI->load->library('image_lib', $config); 
		$CI->image_lib->resize();
	}


	function sanear_string($string) 
	 { $string = trim($string); 
	 	$string = str_replace( array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $string );
	 	$string = str_replace( array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $string );
	 	$string = str_replace( array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $string );
	 	$string = str_replace( array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $string ); 
	 	$string = str_replace( array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $string ); 
	 	$string = str_replace( array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C'), $string ); 
	 	$string = str_replace( array('!', '#', '$', '%','&','(',')','?','¡','¿',',','.',';','+','<','>','{','}','~','´','[',']'), array('', '', '', '','','','','','','','','','','','','','','','','','',''), $string ); 
	 	return $string;
	 }

?>