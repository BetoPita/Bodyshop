<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

if ( ! function_exists('hoy'))
{
	function hoy()
	{
		return date('Y-m-d H:i:s',now());
	}
}

if ( ! function_exists('get_tiempo_laboral'))
{
	function get_tiempo_laboral($star_date,$horas)
	{
		$minutos=0;
		$star_date=strtotime($star_date);
		$end_date=now();
		$tmp_date =$star_date;
		$star_date_string = date('Y-m-d',$star_date);
		$end_date_string = date('Y-m-d',$end_date);
		//si es el mismo dia;
		if($star_date_string==$end_date_string)
		{
			$minutos=horas_undia($star_date,$end_date);
		}
		// si es un dia mayor
		else{
			//Obtener los dias de diferencia
			$dStart = new DateTime($star_date_string);
			$dEnd  = new DateTime($end_date_string);
			$dDiff = $dStart->diff($dEnd);
			//ver si son mas de dos dias 
			$primerDia = true;
			$opc = 1;
			if($dDiff->days > 1){
				while($tmp_date < $end_date){
					if($primerDia)
					{
						$opc=1;
					}
					else if($end_date_string==date('Y-m-d',$tmp_date)) {
						$opc=3;
					}
					else {
						$opc=2;
					}
					$minutos += horas_dia($tmp_date,$opc);
					$tmp_date=strtotime(date('Y-m-d',strtotime(date('Y-m-d',$tmp_date).' + 1 days')));
					$primerDia=false;
				}
			}
			else{
				//echo 'menor o igual a 1';
				//Sacar las horas del primer dia
				$minutos += horas_dia($tmp_date,1);
				//Sacar las horas del segun dia
				$minutos += horas_dia($end_date,3);
				
			}
		}
		//echo 'min'.$minutos.'horas'.$horas;
		return $minutos >= ($horas*60);
	}
}

if ( ! function_exists('horas_dia'))
{
	function horas_dia($date, $opc = 1)
	{
		$horas_trabajadas = 8;
		$horas_trabajadas_sabado=5;
		$semana_hora_inicio =' 09:00:00';
		$semana_hora_inicio_comida =' 14:00:00';
		$semana_hora_fin_comida =' 16:00:00';
		$semana_hora_fin =' 19:00:00';
		$sabado_hora_inicio =' 09:00:00';
		$sabado_hora_fin =' 14:00:00';
		$day_string = date('l',$date);
		$minutos =0;
		switch ($day_string) {
			case 'Sunday':
				break;
			case 'Saturday':
				switch ($opc) {
					case 1:
						//si fue antes de las nueve entonces son todas las horas
						if($date < strtotime(date('Y-m-d',$date).$sabado_hora_inicio)){
							$minutos=$horas_trabajadas_sabado*60;
							//echo 'minutos sabado menor a las 9'.$minutos.'<br>';
						}
						elseif ($date > strtotime(date('Y-m-d',$date).$sabado_hora_fin)) {
							//nada
						}
						else{
							$dStart = new DateTime(date('Y-m-d H:i:s',$date));
							$dEnd  = new DateTime(date('Y-m-d',$date).$sabado_hora_fin);
							$dDiff = $dStart->diff($dEnd);
							$minutos += ($dDiff->h*60)+$dDiff->i;
							//echo 'minutos sabado menor a las 2 '.$minutos.'<br>';
						}
						break;
					//dia completo.Se toman todo el horario del dia
					case 2:
						$minutos=$horas_trabajadas_sabado*60;
						break;
					//ultimo dia, se toma el tiempo trancurrido del dia actual
					case 3:
						if($date > strtotime(date('Y-m-d',$date).$sabado_hora_inicio) && $date < strtotime(date('Y-m-d',$date).$sabado_hora_fin)){
							//sumar solo la diferencia
							$dStart = new DateTime(date('Y-m-d',$date).$sabado_hora_inicio);
							$dEnd  = new DateTime(date('Y-m-d H:i:s',$date));
							$dDiff = $dStart->diff($dEnd);
							$minutos +=  ($dDiff->h*60)+$dDiff->i;
							//echo 'minutos sabado ulitmo dia menor a las 2'.$minutos.'<br>';
						}
						//si la fecha es mayor a la de cierre, regresar todo el dia
						elseif($date < strtotime(date('Y-m-d',$date).$sabado_hora_fin)) {
							$minutos=$horas_trabajadas_sabado*60;
							//echo 'minutos sabado ulitmo dia mayor a las 2'.$minutos.'<br>';
						}
						break;
				}
				break;
			default:
				switch ($opc) {
					//es el primer dia, se toma de la fecha hasta el fin del fia
					case 1:
							//si fue antes de las nueve entonces son todas las horas
							if($date < strtotime(date('Y-m-d',$date).$semana_hora_inicio)){
								$minutos=$horas_trabajadas*60;
							}
							elseif ($date > strtotime(date('Y-m-d',$date).$semana_hora_fin)) {
								//nada
							}
							else{
								if($date < strtotime(date('Y-m-d',$date).$semana_hora_inicio_comida))
								{
									$dStart = new DateTime(date('Y-m-d H:i:s',$date));
									$dEnd  = new DateTime(date('Y-m-d',$date).$semana_hora_inicio_comida);
									$dDiff = $dStart->diff($dEnd);
									$minutos += ($dDiff->h*60)+$dDiff->i;
									//sumar el horario de 4-7
									$minutos += 3*60;
									//echo 'minutos menor a 2 '.$minutos.'<br>';;
								}
								else{
									if($date < strtotime(date('Y-m-d',$date).$semana_hora_fin_comida))
									{
										//sumar el horario de 4-7
										//echo 'minutos menor a 4'.$minutos.'<br>';;
										$minutos += 3*60;
									}
									else {
										//sumar solo la diferencia
										$dStart = new DateTime(date('Y-m-d H:i:s',$date));
										$dEnd  = new DateTime(date('Y-m-d',$date).$semana_hora_fin);
										$dDiff = $dStart->diff($dEnd);
										$minutos +=  ($dDiff->h*60)+$dDiff->i;
										//echo 'minutos mayor a 4'.$minutos.'<br>';;
									}
								}
								
							}
						break;
					//dia completo.Se toman todo el horario del dia
					case 2:
						$minutos=$horas_trabajadas*60;
						break;
					//ultimo dia, se toma el tiempo trancurrido del dia actual
					case 3:
							if($date > strtotime(date('Y-m-d',$date).$semana_hora_inicio) && $date < strtotime(date('Y-m-d',$date).$semana_hora_fin_comida)){
								//sumar solo la diferencia
								$dStart = new DateTime(date('Y-m-d',$date).$semana_hora_inicio);
								if($date < strtotime(date('Y-m-d',$date).$semana_hora_inicio_comida))
								{
									$dEnd  = new DateTime(date('Y-m-d H:i:s',$date));
								}
								else{
									$dEnd  = new DateTime(date('Y-m-d',$date).$semana_hora_inicio_comida);
								}
								$dDiff = $dStart->diff($dEnd);
								$minutos +=  ($dDiff->h*60)+$dDiff->i;
								//echo 'minutos ulitmo dia menor a las 4'.$minutos.'<br>';;
							}
							elseif ($date > strtotime(date('Y-m-d',$date).$semana_hora_fin_comida)) {
								//si ya termino el dia regresar las 8 horas en minnutos
								if($date > strtotime(date('Y-m-d',$date).$semana_hora_fin))
								{
									$minutos += $horas_trabajadas*60;
									//echo 'minutos ulitmo dia mayor a las 7'.$minutos.'<br>';;
								}
								//si no sacar la diferencia y restar las dos horas de comida
								else{
									$dStart = new DateTime(date('Y-m-d',$date).$semana_hora_inicio);
									$dEnd  = new DateTime(date('Y-m-d H:i:s',$date));
									$dDiff = $dStart->diff($dEnd);
									$minutos +=  (($dDiff->h*60)+$dDiff->i)-(2*60);
									//echo 'minutos ulitmo dia menor a las 7'.$minutos.'<br>';;
								}
							}
						break;
				}
				break;
		}
		return $minutos;
	}
}

if ( ! function_exists('horas_undia'))
{
	function horas_undia($date, $end_date)
	{
		//echo 'dia '.date('Y-m-d H:i:s',$date).'<br>';
		$horas_trabajadas = 8;
		$horas_trabajadas_sabado=5;
		$semana_hora_inicio =' 09:00:00';
		$semana_hora_inicio_comida =' 14:00:00';
		$semana_hora_fin_comida =' 16:00:00';
		$semana_hora_fin =' 19:00:00';
		$sabado_hora_inicio =' 09:00:00';
		$sabado_hora_fin =' 14:00:00';
		$day_string = date('l',$date);
		$minutos =0;
		switch ($day_string) {
			case 'Sunday':
				//echo 'Sunday';
				break;
			case 'Saturday':
				if($date < strtotime(date('Y-m-d',$date).$sabado_hora_inicio))
				{
					$date = strtotime(date('Y-m-d',$date).$sabado_hora_inicio);
				}
				if($end_date > strtotime(date('Y-m-d',$end_date).$sabado_hora_fin))
				{
					$end_date = strtotime(date('Y-m-d',$end_date).$sabado_hora_fin);
				}
				$dStart = new DateTime(date('Y-m-d H:i:s',$date));
				$dEnd  = new DateTime(date('Y-m-d H:i:s',$end_date));
				$dDiff = $dStart->diff($dEnd);
				$minutos +=  ($dDiff->h*60)+$dDiff->i;
				break;
			default:
			//si la fecha es mayor que la hora de inicio
				if($date < strtotime(date('Y-m-d',$date).$semana_hora_inicio))
				{
					$date = strtotime(date('Y-m-d',$date).$semana_hora_inicio);
				}
				elseif ($date > strtotime(date('Y-m-d',$date).$semana_hora_inicio_comida) && $date < strtotime(date('Y-m-d',$date).$semana_hora_fin_comida)) {
					$date = strtotime(date('Y-m-d',$date).$semana_hora_fin_comida);
				}
				if($end_date > strtotime(date('Y-m-d',$end_date).$semana_hora_fin))
				{
					$end_date = strtotime(date('Y-m-d',$end_date).$semana_hora_fin);
				}
				elseif ($end_date > strtotime(date('Y-m-d',$end_date).$semana_hora_inicio_comida) && $end_date < strtotime(date('Y-m-d',$end_date).$semana_hora_fin_comida)) {
					$end_date = strtotime(date('Y-m-d',$end_date).$semana_hora_fin_comida);
				}
				$dStart = new DateTime(date('Y-m-d H:i:s',$date));
				$dEnd  = new DateTime(date('Y-m-d H:i:s',$end_date));
				$dDiff = $dStart->diff($dEnd);
				$minutos +=  ($dDiff->h*60)+$dDiff->i;
				//validar si se resta el horario de comida
				if($date < strtotime(date('Y-m-d',$date).$semana_hora_inicio_comida) && $end_date >= strtotime(date('Y-m-d',$date).$semana_hora_fin_comida))
				{
					$minutos -= 120;
				}
				//echo 'minutos un dia'.$minutos.'<br>';;
				break;
		}
		return $minutos;
	}
}




if ( ! function_exists('rfc2822_to_mysql'))
{
	function rfc2822_to_mysql($date)
	{
		return date('Y-m-d H:i:s',strtotime($date));
	}
}


if ( ! function_exists('array_day'))
{
	function array_day()
	{
		$ret = array();
		for($i=1;$i<=31;$i++){
			$ret[$i] = (($i<10) ? '0'.$i : $i);
		}
		return $ret;
	}
}



if ( ! function_exists('array_month'))
{
	function array_month()
	{
		$ci =& get_instance();
		$ci->lang->load('calendar');

		$ret = array();
		$ret[1] = $ci->lang->line('cal_january');
		$ret[2] = $ci->lang->line('cal_february');
		$ret[3] = $ci->lang->line('cal_march');
		$ret[4] = $ci->lang->line('cal_april');
		$ret[5] = $ci->lang->line('cal_mayl');
		$ret[6] = $ci->lang->line('cal_june');
		$ret[7] = $ci->lang->line('cal_july');
		$ret[8] = $ci->lang->line('cal_august');
		$ret[9] = $ci->lang->line('cal_september');
		$ret[10] = $ci->lang->line('cal_october');
		$ret[11] = $ci->lang->line('cal_november');
		$ret[12] = $ci->lang->line('cal_december');
		return $ret;
	}
}




if ( ! function_exists('array_hour'))
{
	function array_hour($intervalo = 15, $HoraDesde = array('hora'=>0,'min'=>0), $HoraHasta=array('hora'=>23,'min'=>00))
	{

		$ret = array();
		$HoraMin = $HoraDesde;
		$hora = str_pad($HoraMin['hora'],2,0,STR_PAD_LEFT);
		$minuto = str_pad($HoraMin['min'],2,0,STR_PAD_LEFT);
		$ret[$hora.':'.$minuto] = $hora.':'.$minuto;
		do {
			$HoraMin['min'] = $HoraMin['min'] + $intervalo;
			if ($HoraMin['min'] >= 60) {
			   $HoraMin['min'] = 0;
			   $HoraMin['hora'] = $HoraMin['hora'] + 1;
			   if ($HoraMin['hora'] >= 24) {
			      $HoraMin['hora'] = 0;
			   }
			}
			if (($HoraMin['hora'] >= $HoraHasta['hora']) and ($HoraMin['min'] >= $HoraHasta['min'])) {
				break;
			}else{

				$hora = str_pad($HoraMin['hora'],2,0,STR_PAD_LEFT);
				$minuto = str_pad($HoraMin['min'],2,0,STR_PAD_LEFT);
				$ret[$hora.':'.$minuto] = $hora.':'.$minuto;


			}
		} while (true);
		return $ret;
	}
}



if ( ! function_exists('month_text')){
	function month_text($month)
	{
		$ci =& get_instance();
		$ci->lang->load('calendar');
		$ret = '';
		switch((integer) $month){
			case 1:
				$ret = $ci->lang->line('cal_january');
				break;
			case 2:
				$ret = $ci->lang->line('cal_february');
				break;
			case 3:
				$ret = $ci->lang->line('cal_march');
				break;
			case 4:
				$ret = $ci->lang->line('cal_april');
				break;
			case 5:
				$ret = $ci->lang->line('cal_mayl');
				break;
			case 6:
				$ret = $ci->lang->line('cal_june');
				break;
			case 7:
				$ret = $ci->lang->line('cal_july');
				break;
			case 8:
				$ret = $ci->lang->line('cal_august');
				break;
			case 9:
				$ret = $ci->lang->line('cal_september');
				break;
			case 10:
				$ret = $ci->lang->line('cal_october');
				break;
			case 11:
				$ret = $ci->lang->line('cal_november');
				break;
			case 12:
				$ret = $ci->lang->line('cal_december');
				break;

		}

		return $ret;
	}
}


if ( ! function_exists('date2sql'))
{
	function date2sql($date)
	{
		//D-M-Y

		$dateARR = explode('-',str_replace('/','-',$date));
		if(count($dateARR) == 3){
			if(strlen($dateARR[0]) == '4'){
				return $date;
			}else{
				return $dateARR[2].'-'.$dateARR[1].'-'.$dateARR[0]; //YYYY-MM-DD
			}
		}else{
			return '';
		}
	}
}

if ( ! function_exists('hoy2sql'))
{
	function hoy2sql(){
		return date('Y-m-d\TH:i:s');
	}
}


if ( ! function_exists('esBisiesto'))
{
	function esBisiesto($year){
	   return date('L',mktime(1,1,1,1,1,$year));
	}
}


if ( ! function_exists('date_eng2esp_1'))
{
	function date_eng2esp_1($date='')
	{
		//Convertir fecha ingles a español
		// Y-M-D a d/m/Y
		// 0-1-2
		$dateARR = array();
		$dateARR = explode('-',str_replace('/','-',$date));
		if(count($dateARR) == 3){
			if($dateARR[2]=='0000'){
				return '';
			}
			return $dateARR[2].'/'.$dateARR[1].'/'.$dateARR[0];
		}else{
			return '';
		}
	}
}
if ( ! function_exists('date_eng2esp_time'))
{
	function date_eng2esp_time($date)
	{
		//Convertir fecha ingles a español cuando es datetime
		
		$date = explode(" ",$date);
		$dateARR = explode('-',str_replace('/','-',$date[0]));
		if(count($dateARR) == 3){
			return $dateARR[2].'/'.$dateARR[1].'/'.$dateARR[0]." ".$date[1];
		}else{
			return '';
		}
	}
}

if ( ! function_exists('date_esp2eng'))
{
	function date_esp2eng($date)
	{
		//Convertir fecha español a ingles
		// d/m/Y a Y-M-D a
		// 0-1-2
		$res = '';
		$date = str_replace('/','-',trim($date));
		//Separar fecha hora
		$dateARR0 = explode(' ',$date);
		if(count($dateARR0) > 0){
			$dateARR = explode('-',$dateARR0[0]);
			if(count($dateARR) == 3){

				if(strlen($dateARR[0]) == 4){ //Esta en ingles
					$res = $dateARR[0].'-'.$dateARR[1].'-'.$dateARR[2];
				}else{
					$res = $dateARR[2].'-'.$dateARR[1].'-'.$dateARR[0];
				}
			}
		}

		if(count($dateARR0) == 2){
			$res .= ' ' . $dateARR0[1];
		}

		return $res;
	}
}

if ( ! function_exists('date_eng2esp'))
{
	function date_eng2esp($date,$format='d-m-Y H:i')
	{
		//Convertir fecha español a ingles
		// d/m/Y a Y-M-D a
		// 0-1-2

		$conv = new DateTime($date);
		return $conv->format($format);
	}
}




if ( ! function_exists('spanish_date'))
{
function spanish_date($date){

	$ci =& get_instance();
	$ci->lang->load('calendar');
	$ingles = array('jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec');
	$espanol = array(
			$ci->lang->line('cal_jan'),
			$ci->lang->line('cal_feb'),
			$ci->lang->line('cal_mar'),
			$ci->lang->line('cal_apr'),
			$ci->lang->line('cal_may'),
			$ci->lang->line('cal_jun'),
			$ci->lang->line('cal_jul'),
			$ci->lang->line('cal_aug'),
			$ci->lang->line('cal_sep'),
			$ci->lang->line('cal_oct'),
			$ci->lang->line('cal_nov'),
			$ci->lang->line('cal_dec'));


	return str_replace($ingles,$espanol,strtolower($date));


}
}




if ( ! function_exists('proceso_tiempo'))
{
   function proceso_tiempo ($fecha,$fecha2){



      if($fecha2 == ''){
	return $fecha;
      }

      $a  = explode(' ',$fecha);
      $a[1] = substr($a[1],0,8);
      $aFecha = explode('-',str_replace('/','-',$a[0]));
      $aHora = explode(':',$a[1]);


      $a2  = explode(' ',$fecha2);
      $a2[1] = substr($a2[1],0,8);
      $aFecha2 = explode('-',str_replace('/','-',$a2[0]));
      $aHora2 = explode(':',$a2[1]);

      $horaOrig = $aHora[0];
      $minOrig = $aHora[1];

      $diaOrig = $aFecha[2];
      $mesOrig = $aFecha[1];
      $anioOrig = $aFecha[0];


      $horaOrig2 = $aHora2[0];
      $minOrig2 = $aHora2[1];

      $diaOrig2 = $aFecha2[2];
      $mesOrig2 = $aFecha2[1];
      $anioOrig2 = $aFecha2[0];


       $fecha_unix = mktime($aHora[0],$aHora[1],$aHora[2],$aFecha[1],$aFecha[2],$aFecha[0]);
       $fecha_unix2 = mktime($aHora2[0],$aHora2[1],$aHora2[2],$aFecha2[1],$aFecha2[2],$aFecha2[0]);


      //obtener la hora en formato unix
        $ahora= $fecha_unix2;


        //obtener la diferencia de segundos
        $segundos=$ahora-$fecha_unix;

        //dias es la division de n segs entre 86400 segundos que representa un dia;
        $dias=floor($segundos/86400);

        //mod_hora es el sobrante, en horas, de la division de días;
        $mod_hora=$segundos%86400;

        //hora es la division entre el sobrante de horas y 3600 segundos que representa una hora;
        $horas=floor($mod_hora/3600);

        //mod_minuto es el sobrante, en minutos, de la division de horas;
        $mod_minuto=$mod_hora%3600;

        //minuto es la division entre el sobrante y 60 segundos que representa un minuto;
        $minutos=floor($mod_minuto/60);
        if($horas<=0 && $dias == 0){
		    if($minutos < 1){
		       if($segundos == 1){
				  $result = $segundos.' seg';
		       }else{
				  $result = $segundos.' seg';
	       		}
		    }elseif($minutos == 1){
			  $result = '1 min';
	    	}else{
	       		$result = $minutos.' min';
		    }
        }elseif($dias==0){
		    if($horas == 1){
			$result =  $horas.' hr '.$minutos.' min';
		    }else{
		       $result =  $horas.' hrs '.$minutos.' min';
		    }
	    }elseif($dias==1){
		if($horas == 1){
			$result =  $dias.' día, '.$horas.' hr '.$minutos.' min';
		}else{
		       $result =  $dias.' día, '.$horas.' hrs '.$minutos.' min';
		}
        }else{
		if($horas == 1){
			$result =  $dias.' días, '.$horas.' hr '.$minutos.' min';
		}else{
		       $result =  $dias.' días, '.$horas.' hrs '.$minutos.' min';
		}
	}
      return $result;
   }
}

if ( ! function_exists('dias_transcurridos'))
{
	function dias_transcurridos($fecha_i,$fecha_f)
	{
		$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
		$dias 	= abs($dias); $dias = floor($dias);
		return $dias;
	}
}

if ( ! function_exists('fecha_array')){

	function fecha_array($start, $end) {
	    $range = array();

	    if (is_string($start) === true) $start = strtotime($start);
	    if (is_string($end) === true ) $end = strtotime($end);

	    if ($start > $end) return createDateRangeArray($end, $start);

	    do {
	    	$fechaFinal = date_eng2esp(date('Y-m-d', $start));
	        $range[$fechaFinal] = $fechaFinal;
	        $start = strtotime("+ 1 day", $start);
	    } while($start <= $end);

	    return $range;
	}
}


 
if ( ! function_exists('format_hour'))
{
	function format_hour($hora)
	{
		$arrHORA =explode(':', $hora);

		if(count($arrHORA)>=2){
			return $arrHORA[0].':'.$arrHORA[1];
		}else{
			return $hora;
		}


	}
}

if ( ! function_exists('format_hour_date'))
{
	function format_hour_date($fecha)
	{
		
		$arrHORA =explode(' ', $fecha);
		if(count($arrHORA)>=2){

			return $arrHORA[0];
		}else{
			return $fecha;
		}


	}
}
