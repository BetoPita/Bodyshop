<?php

class Mexcel extends CI_Model {

		var $debug=false;
	    
		function __construct(){
				parent::__construct();
								
		}
		
		
	
		function generar_by_tabla($htmltable,$datosHeader='',$fname='',$ruta='',$descargar=true){
				
	
				if($this->debug){						
					$handle = fopen("application/cache/exportlog.txt", "w");
					fwrite($handle, "\nDebugging On...");
						
				}
				
				
				$htmltable = strip_tags($htmltable, "<table><tr><th><thead><tbody><tfoot><td><br><br /><b><span>");
				$htmltable = str_replace("<br />", "\n", $htmltable);
				$htmltable = str_replace("<br/>", "\n", $htmltable);
				$htmltable = str_replace("<br>", "\n", $htmltable);
				$htmltable = str_replace("&nbsp;", " ", $htmltable);
				$htmltable = str_replace("\n\n", "\n", $htmltable);
				
				//
				//  Extract HTML table contents to array
				//
				
				$dom = new domDocument;
				$dom->loadHTML($htmltable);
				if(!$dom) {
				  echo "<br />Invalid HTML DOM, nothing to Export.";
				  exit;
				}
				$dom->preserveWhiteSpace = false;             // remove redundant whitespace
				$tables = $dom->getElementsByTagName('table');

				if(!is_object($tables)) {
				  echo "<br />Invalid HTML Table DOM, nothing to Export.";
				  exit;
				}

				if($this->debug) {
				  fwrite($handle, "\nTable Count: ".$tables->length);				  
				}
				$tbcnt = $tables->length - 1;                 // count minus 1 for 0 indexed loop over tables
				
		
		
				//
				//
				// Create new PHPExcel object with default attributes
				//

				//require_once ('PHPExcel/PHPExcel.php');
				$this->load->library('excel');
				
				
				//$objPHPExcel = new PHPExcel();
				//$this->phpexcel->createWorksheet(); 
				
				$this->phpexcel->getDefaultStyle()->getFont()->setName('Verdana');
				$this->phpexcel->getDefaultStyle()->getFont()->setSize(11);
					
				$this->phpexcel->disconnectWorksheets();
    			$this->phpexcel->createSheet(0);



				//
				// Loop over tables in DOM to create an array, each table becomes a worksheet
				//
				for($z=0;$z<=$tbcnt;$z++) {
				  $maxcols = 0;
				  $totrows = 0;
				  $headrows = array();
				  $bodyrows = array();
				  $r = 0;
				  $h = 0;
				  $rows = $tables->item($z)->getElementsByTagName('tr');
				  
				  
				  $totrows = $rows->length;
				  if($this->debug) {
				    fwrite($handle, "\nTotal Rows: ".$totrows);
				  }
				  foreach ($rows as $row) {
				      $ths = $row->getElementsByTagName('th');
				    
				      if(is_object($ths)) {
					if($ths->length > 0) {
					  $headrows[$h]['colcnt'] = $ths->length;
					    
					  if($ths->length > $maxcols) {
					    $maxcols = $ths->length;
					  }
					  $nodes = $ths->length - 1;
					  for($x=0;$x<=$nodes;$x++) {
					    $thishdg = $ths->item($x)->nodeValue;
					    
					    $headrows[$h]['th'][] = $thishdg;
					    $headrows[$h]['bold'][] = $this->findBoldText($this->innerHTML($ths->item($x)));
					    if($ths->item($x)->hasAttribute('style')) {
					      $style = $ths->item($x)->getAttribute('style');
					      $stylecolor = $this->findStyleColor($style);
					      if($stylecolor == '') {
						$headrows[$h]['color'][] = $this->findSpanColor($this->innerHTML($ths->item($x)));
					      }else{
						$headrows[$h]['color'][] = $stylecolor;
					      }
					    }else{
					      $headrows[$h]['color'][] = $this->findSpanColor($this->innerHTML($ths->item($x)));
					    }
					    if($ths->item($x)->hasAttribute('colspan')) {
					      $headrows[$h]['colspan'][] = $ths->item($x)->getAttribute('colspan');
					    }else{
					      $headrows[$h]['colspan'][] = 1;
					    }
					    if($ths->item($x)->hasAttribute('rowspan')) {
					      $headrows[$h]['rowspan'][] = $ths->item($x)->getAttribute('rowspan');
					    }else{
					      $headrows[$h]['rowspan'][] = 1;
					    }
					    
					    if($ths->item($x)->hasAttribute('align')) {
					      $headrows[$h]['align'][] = $ths->item($x)->getAttribute('align');
					    }else{
					      $headrows[$h]['align'][] = 'left';
					    }
					    if($ths->item($x)->hasAttribute('valign')) {
					      $headrows[$h]['valign'][] = $ths->item($x)->getAttribute('valign');
					    }else{
					      $headrows[$h]['valign'][] = 'top';
					    }
					    if($ths->item($x)->hasAttribute('bgcolor')) {
					      $headrows[$h]['bgcolor'][] = str_replace("#", "", $ths->item($x)->getAttribute('bgcolor'));
					    }else{
					      $headrows[$h]['bgcolor'][] = 'EEEEEE';
					    }
					  }
					  $h++;
					}
				      }
				  }
	
				  foreach ($rows as $row) {
				      $tds = $row->getElementsByTagName('td');
				      
				      if(is_object($tds)) {
					if($tds->length > 0) {
					  $bodyrows[$r]['colcnt'] = $tds->length;
					  if($tds->length > $maxcols) {
					    $maxcols = $tds->length;
					  }
					  $nodes = $tds->length - 1;
					  for($x=0;$x<=$nodes;$x++) {
					    $thistxt = $tds->item($x)->nodeValue;
					    $bodyrows[$r]['td'][] = $thistxt;
					    $bodyrows[$r]['bold'][] = $this->findBoldText($this->innerHTML($tds->item($x)));
					    if($tds->item($x)->hasAttribute('style')) {
					      $style = $tds->item($x)->getAttribute('style');
					      $stylecolor = $this->findStyleColor($style);
					      if($stylecolor == '') {
						$bodyrows[$r]['color'][] = $this->findSpanColor($this->innerHTML($tds->item($x)));
					      }else{
						$bodyrows[$r]['color'][] = $stylecolor;
					      }
					    }else{
					      $bodyrows[$r]['color'][] = $this->findSpanColor($this->innerHTML($tds->item($x)));
					    }
					    if($tds->item($x)->hasAttribute('colspan')) {
					      $bodyrows[$r]['colspan'][] = $tds->item($x)->getAttribute('colspan');
					    }else{
					      $bodyrows[$r]['colspan'][] = 1;
					    }
					    
					    if($tds->item($x)->hasAttribute('rowspan')) {
					      $bodyrows[$r]['rowspan'][] = $tds->item($x)->getAttribute('rowspan');
					    }else{
					      $bodyrows[$r]['rowspan'][] = 1;
					    }
					    
					    if($tds->item($x)->hasAttribute('align')) {
					      $bodyrows[$r]['align'][] = $tds->item($x)->getAttribute('align');
					    }else{
					      $bodyrows[$r]['align'][] = 'left';
					    }
					    if($tds->item($x)->hasAttribute('valign')) {
					      $bodyrows[$r]['valign'][] = $tds->item($x)->getAttribute('valign');
					    }else{
					      $bodyrows[$r]['valign'][] = 'top';
					    }
					    if($tds->item($x)->hasAttribute('bgcolor')) {
					      $bodyrows[$r]['bgcolor'][] = str_replace("#", "", $tds->item($x)->getAttribute('bgcolor'));
					    }else{
					      $bodyrows[$r]['bgcolor'][] = 'FFFFFF';
					    }
					  }
					  $r++;
					}
				      }
				  }

				  if($z > 0) {
				    $this->phpexcel->createSheet($z);
				  }
				  $suf = $z + 1;
				  $tableid = $suf;
				  $wksheetname = ucfirst($tableid);
				  $this->phpexcel->setActiveSheetIndex($z);                      // each sheet corresponds to a table in html
				  $this->phpexcel->getActiveSheet()->setTitle($wksheetname);     // tab name
				  $worksheet = $this->phpexcel->getActiveSheet();                // set worksheet we're working on
				  $style_overlay = array('font' =>
						    array('color' =>
						      array('rgb' => '000000'),'bold' => false,),
							  'fill' 	=>
							      array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'CCCCFF')),
							  'alignment' =>
							      array('wrap' => true, 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
									 'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP),
							  'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
									     'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
									     'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
									     'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
						       );
				  
				  
				   $style_header = array('font' =>
						    array('size'=>13,'color' =>
						      array('rgb' => '000000'),'bold' => true,),							  
							  'alignment' =>
							      array('wrap' => true, 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
									 'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP),
							  
						       );
				  
				  
				  
				$cellImagen = 'A';						
				if(isset($headrows[0]['th'])){				
						if(isset($headrows[1]['th'])){
								$totalSumar = count($headrows[1]['th']) - 2;
						}else{
								$totalSumar = count($headrows[0]['th']) - 2;
						}
				}else{
					$totalSumar = 9;
				}
				for($contImgCell=0;$contImgCell<$totalSumar;$contImgCell++){
					$cellImagen++;	
				}
				
				$xrow = 1;				
				//$this->phpexcel->setImagen('./assets/img/empresas/empresa_1.jpg',$cellImagen.'1',50);
				
				
				
				if(is_array($datosHeader)){
						
						
						if(isset($datosHeader['titulo']) && $datosHeader['titulo'] != ''){
								$cellImagen--;$cellImagen--;
								$worksheet->mergeCells('D'.$xrow.':'.($cellImagen).($xrow+2));				
								$worksheet->getStyle('D'.$xrow)->applyFromArray($style_header);
								$worksheet->setCellValue('D'.$xrow, $datosHeader['titulo']);
						}
						if(isset($datosHeader['revision'])&& $datosHeader['revision'] != ''){
								$worksheet->mergeCells('A'.$xrow.':C'.$xrow);
								$worksheet->setCellValue('A'.$xrow, 'Revisión: '.$datosHeader['revision']);
								$xrow++;
						}
						if(isset($datosHeader['codigo'])&& $datosHeader['codigo'] != ''){
								$worksheet->mergeCells('A'.$xrow.':C'.$xrow);
								$worksheet->setCellValue('A'.$xrow, 'Código: '.$datosHeader['codigo']);
								$xrow++;
						}
						if(isset($datosHeader['fecha'])&& $datosHeader['fecha'] != ''){
								$worksheet->mergeCells('A'.$xrow.':C'.$xrow);
								$worksheet->setCellValue('A'.$xrow, 'Fecha: '.$datosHeader['fecha']);				
								$xrow++;
						}
				}
				
				
				
				  
				  $xcol = '';
				  $xrow = 1;
				  $usedhdrows = $xrow-1;
				  $heightvars = array(1=>'42', 2=>'42', 3=>'48', 4=>'52', 5=>'58', 6=>'64', 7=>'68', 8=>'76', 9=>'82');
				  for($h=0;$h<count($headrows);$h++) {
				    $th = $headrows[$h]['th'];
				    $colspans = $headrows[$h]['colspan'];
				    $rowspans = $headrows[$h]['rowspan'];
				    $aligns = $headrows[$h]['align'];
				    $valigns = $headrows[$h]['valign'];
				    $bgcolors = $headrows[$h]['bgcolor'];
				    $colcnt = $headrows[$h]['colcnt'];
				    $colors = $headrows[$h]['color'];
				    $bolds = $headrows[$h]['bold'];
				    $usedhdrows++;
				    $mergedcells = false;
				    for($t=0;$t<count($th);$t++) {
				      if($xcol == '') {$xcol = 'A';}else{$xcol++;}
				      $thishdg = utf8_decode($th[$t]);
				      $thisalign = $aligns[$t];
				      $thisvalign = $valigns[$t];
				      $thiscolspan = $colspans[$t];
				      $thisrowspan = $rowspans[$t];
				      $thiscolor = $colors[$t];
				      $thisbg = $bgcolors[$t];
				      $thisbold = $bolds[$t];
				      $strbold = ($thisbold==true) ? 'true' : 'false';
				      if($thisbg == 'FFFFFF') {
					$style_overlay['fill']['type'] = PHPExcel_Style_Fill::FILL_NONE;
				      }else{
					$style_overlay['fill']['type'] = PHPExcel_Style_Fill::FILL_SOLID;
				      }
				      $style_overlay['alignment']['vertical'] = $thisvalign;              // set styles for cell
				      $style_overlay['alignment']['horizontal'] = $thisalign;
				      $style_overlay['font']['color']['rgb'] = $thiscolor;
				      $style_overlay['font']['bold'] = $thisbold;
				      $style_overlay['fill']['color']['rgb'] = $thisbg;
				      $worksheet->setCellValue($xcol.$xrow, $thishdg);
				      $worksheet->getStyle($xcol.$xrow)->applyFromArray($style_overlay);
				      if($this->debug) {
					fwrite($handle, "\n".$xcol.":".$xrow." ColSpan:".$thiscolspan." Color:".$thiscolor." Align:".$thisalign." VAlign:".$thisvalign." BGColor:".$thisbg." Bold:".$strbold." cellValue: ".$thishdg);
				      }
				      if($thiscolspan > 1) {                                                // spans more than 1 column
						$mergedcells = true;
						$lastxcol = $xcol;
						for($j=1;$j<$thiscolspan;$j++) {
						  $lastxcol++;
						  $worksheet->setCellValue($lastxcol.$xrow, '');
						  $worksheet->getStyle($lastxcol.$xrow)->applyFromArray($style_overlay);
						}
						$cellRange = $xcol.$xrow.':'.$lastxcol.$xrow;
						if($this->debug) {
						  fwrite($handle, "\nmergeCells: ".$xcol.":".$xrow." ".$lastxcol.":".$xrow);
						}
						
						
						
						$worksheet->mergeCells($cellRange);
						$worksheet->getStyle($cellRange)->applyFromArray($style_overlay);
						$num_newlines = substr_count($thishdg, "\n");                       // count number of newline chars
						if($num_newlines > 1) {
						  $rowheight = $heightvars[1];                                      // default to 35
						  if(array_key_exists($num_newlines, $heightvars)) {
						    $rowheight = $heightvars[$num_newlines];
						  }else{
						    $rowheight = 75;
						  }
						  $worksheet->getRowDimension($xrow)->setRowHeight($rowheight);     // adjust heading row height
					}
					$xcol = $lastxcol;
				      }
				    }
				    $xrow++;
				    $xcol = '';
				  }
				  
				  //Put an auto filter on last row of heading only if last row was not merged
				  if(!$mergedcells) {						
				    $worksheet->setAutoFilter("A$usedhdrows:" . $worksheet->getHighestColumn() . $worksheet->getHighestRow() );
				  }
				  if($this->debug) {
				    fwrite($handle, "\nautoFilter: A".$usedhdrows.":".$worksheet->getHighestColumn().$worksheet->getHighestRow());
				  }
				  // Freeze heading lines starting after heading lines
				  $usedhdrows++;
				  $worksheet->freezePane("A$usedhdrows");
				  if($this->debug) {
				    fwrite($handle, "\nfreezePane: A".$usedhdrows);
				  }
				  //
				  // Loop thru data rows and write them out
				  //
				  $xcol = '';
				  $xrow = $usedhdrows;
				 
				  for($b=0;$b<count($bodyrows);$b++) {
				    $td = $bodyrows[$b]['td'];
				    $colcnt = $bodyrows[$b]['colcnt'];
				    $colspans = $bodyrows[$b]['colspan'];
				    $aligns = $bodyrows[$b]['align'];
				    $valigns = $bodyrows[$b]['valign'];
				    $bgcolors = $bodyrows[$b]['bgcolor'];
				    $colors = $bodyrows[$b]['color'];
				    $bolds = $bodyrows[$b]['bold'];
				    for($t=0;$t<count($td);$t++) {
				      if($xcol == '') {$xcol = 'A';}else{$xcol++;}
				      $thistext = utf8_decode($td[$t]);
				      $thisalign = $aligns[$t];
				      $thisvalign = $valigns[$t];
				      $thiscolspan = $colspans[$t];
				      $thiscolor = $colors[$t];
				      $thisbg = $bgcolors[$t];
				      $thisbold = $bolds[$t];
				      $strbold = ($thisbold==true) ? 'true' : 'false';
				      if($thisbg == 'FFFFFF') {
					$style_overlay['fill']['type'] = PHPExcel_Style_Fill::FILL_NONE;
				      }else{
					$style_overlay['fill']['type'] = PHPExcel_Style_Fill::FILL_SOLID;
				      }
				      $style_overlay['alignment']['vertical'] = $thisvalign;              // set styles for cell
				      $style_overlay['alignment']['horizontal'] = $thisalign;
				      $style_overlay['font']['color']['rgb'] = $thiscolor;
				      $style_overlay['font']['bold'] = $thisbold;
				      $style_overlay['fill']['color']['rgb'] = $thisbg;
				      if($thiscolspan == 1) {
					$worksheet->getColumnDimension($xcol)->setWidth(25);
				      }
				      $worksheet->setCellValue($xcol.$xrow, $thistext);
				      if($this->debug) {
					fwrite($handle, "\n".$xcol.":".$xrow." ColSpan:".$thiscolspan." Color:".$thiscolor." Align:".$thisalign." VAlign:".$thisvalign." BGColor:".$thisbg." Bold:".$strbold." cellValue: ".$thistext);
				      }
				      $worksheet->getStyle($xcol.$xrow)->applyFromArray($style_overlay);
				      if($thiscolspan > 1) {                                                // spans more than 1 column
					$lastxcol = $xcol;
					for($j=1;$j<$thiscolspan;$j++) {
					  $lastxcol++;
					}
					$cellRange = $xcol.$xrow.':'.$lastxcol.$xrow;
					if($this->debug) {
					  fwrite($handle, "\nmergeCells: ".$xcol.":".$xrow." ".$lastxcol.":".$xrow);
					}
					$worksheet->mergeCells($cellRange);
					$worksheet->getStyle($cellRange)->applyFromArray($style_overlay);
					$xcol = $lastxcol;
				      }
				    }
				    $xrow++;
				    $xcol = '';
				  }
				  
				  // autosize columns to fit data
				  $azcol = 'A';
				  for($x=1;$x<=$maxcols;$x++) {						
				    $worksheet->getColumnDimension($azcol)->setAutoSize(true);
				    $azcol++;
				  }
				  if($this->debug) {
				    fwrite($handle, "\nHEADROWS: ".print_r($headrows, true));
				    fwrite($handle, "\nBODYROWS: ".print_r($bodyrows, true));
				  }
				} // end for over tables


				$this->phpexcel->setActiveSheetIndex(0);                      // set to first worksheet before close
				//
				// Write to Browser
				//
				if($this->debug) {
				  fclose($handle);
				}
			 
			
				$this->excel->printexcel($fname,$ruta,$descargar);


				 
  
 
				
		}
		
		
		
		function innerHTML($node) {
				$doc = $node->ownerDocument;
				$frag = $doc->createDocumentFragment();
				foreach ($node->childNodes as $child) {
				  $frag->appendChild($child->cloneNode(TRUE));
				}
				return $doc->saveXML($frag);
			      }
		function findSpanColor($node) {
		  $pos = stripos($node, "color:");       // ie: looking for style='color: #FF0000;'
		  if ($pos === false) {                  //                        12345678911111
		    return '000000';                     //                                 01234
		  }
		  $node = substr($node, $pos);           // truncate to color: start
		  $start = "#";                          // looking for html color string
		  $end = ";";                            // should end with semicolon
		  $node = " ".$node;                     // prefix node with blank
			$ini = stripos($node,$start);          // look for #
			if ($ini === false) return "000000";   // not found, return default color of black
			$ini += strlen($start);                // get 1 byte past start string
			$len = stripos($node,$end,$ini) - $ini; // grab substr between start and end positions
			return substr($node,$ini,$len);        // return the RGB color without # sign
		}
		function findStyleColor($style) {
				$pos = stripos($style, "color:");      // ie: looking for style='color: #FF0000;'
				if ($pos === false) {                  //                        12345678911111
				  return '';                           //                                 01234
				}
				$style = substr($style, $pos);           // truncate to color: start
				$start = "#";                          // looking for html color string
				$end = ";";                            // should end with semicolon
				$style = " ".$style;                     // prefix node with blank
				      $ini = stripos($style,$start);          // look for #
				      if ($ini === false) return "";         // not found, return default color of black
				      $ini += strlen($start);                // get 1 byte past start string
				      $len = stripos($style,$end,$ini) - $ini; // grab substr between start and end positions
				      return substr($style,$ini,$len);        // return the RGB color without # sign
			      }
			      function findBoldText($node) {
				$pos = stripos($node, "<b>");          // ie: looking for bolded text
				if ($pos === false) {                  //                        12345678911111
				  return false;                        //                                 01234
				}
				return true;                           // found <b>
			      }
	    
}