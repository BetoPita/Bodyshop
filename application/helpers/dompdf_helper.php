<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('pdf_create')){
    function pdf_create($html, $filename='', $stream=FALSE,$orientacion='landscape')
    {

        require_once(APPPATH."libraries/dompdf/dompdf_config.inc.php");
        $elements=explode("/", $_SERVER['SCRIPT_NAME']);
        $path= $_SERVER['DOCUMENT_ROOT'].$elements[1].'/assets/css';
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->set_paper('letter',$orientacion);
        $dompdf->set_base_path($path);
        $dompdf->render();
        if ($stream) {
            $dompdf->stream($filename.".pdf");
        } else {
            //return $dompdf->output();
             $dompdf->stream($filename.".pdf", array("Attachment" => 0));
        }
    }
}

if ( ! function_exists('pdf_create_ticket')){
    function pdf_create_ticket($html, $filename='', $stream=FALSE,$orientacion='portrait')
    {

        require_once(APPPATH."libraries/dompdf/dompdf_config.inc.php");

        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->set_paper('letter',$orientacion);
        //$dompdf->set_paper(array(0, 0, 180, 841), $orientacion);        
        $dompdf->render();
        if ($stream) {
            $dompdf->stream($filename.".pdf",array('Attachment'=>0));
        } else {
            $output= $dompdf->output();
            file_put_contents('uploads/'.$filename.'.pdf', $output);
        }
    }
}





