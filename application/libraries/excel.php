<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Excel {
	
	var $objPHPExcel;
	
	
	public function __construct()
	{	    
		$this->CI =& get_instance();
		
		
		/** Error reporting */
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		error_reporting (0);		
		ini_set("memory_limit","500M");
		




		$this->CI->load->library('PHPExcel');
		
		
		$this->CI->phpexcel->getProperties()->setCreator("Sistema Intranet")
							 ->setLastModifiedBy("Sistema Intranet")
							 ->setTitle("Reportes");
		
	    
		
       }
       
       
       
       
       public function printexcel($archivo,$ruta='',$descargar=true){
		
	// Save Excel 2003 file
		
		

		
		if($descargar){
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');		
			header('Content-Disposition: attachment;filename="'.$archivo.'.xlsx"');
			header('Cache-Control: max-age=0');
		}
	
	
		$objWriter = PHPExcel_IOFactory::createWriter($this->CI->phpexcel, 'Excel2007');		
	
		if($descargar){
			$objWriter->save('php://output');	
			exit;	
	    }else{
	    	$objWriter->save($ruta.'/'.$archivo.'.xlsx');
		}	
	
		//$objWriter = null;
		//$objWriter->disconnectWorksheets();
		//unset($objWriter);
       }
     
    
}
