<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	function conversorSegundosHoras($tiempo_en_segundos) {
		$horas = floor($tiempo_en_segundos / 3600);
		$minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
		$segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);

		$hora_texto = "";
		if($horas > 0 ){
			$hora_texto .= $horas . "h ";
		}
		if($minutos > 0 ) {
			$hora_texto .= $minutos . "m ";
		}
		if($segundos > 0 ) {
			$hora_texto .= $segundos . "s";
		}
		if($hora_texto == ''){
			$hora_texto = ' -';
		}
		return $hora_texto;
	}
	function getDiffHour($fecha='',$hora='',$cantidad_horas=''){
		if($fecha=='' || $hora==''){
			return -1;
		}
	 	//  $CI =& get_instance();
	  	// 	$CI->load->model('bitacora_negocios_model', 'mb');
   		//  return $CI->mb->prueba_fechas(date_esp2eng($fecha),$hora);
   		$tiempo_respuesta = fechas(date_esp2eng($fecha),$hora,$cantidad_horas);
   		if($tiempo_respuesta==-1){
   			return -1;
   		}else{
   			$tiempo_junto = date_esp2eng($fecha).' '.$hora;
   			if($tiempo_respuesta>=date('Y-m-d H:i')){
   				return 1;
   			}else{
   				return -1;
   			}
   		}
	}
    function fechas($fecha='',$hora_llegada='',$tiempo_respuesta=''){
          date_default_timezone_set('America/Mexico_City');
          // de 09:00 am a 19:00 pm 2 horas de comida y sabado de 09:00 a 14:00
          //24 12 o 8
         if($fecha=='' || $hora_llegada=='' || $tiempo_respuesta == ''){
         	return -1;
         }

          $diasemana = strtolower(date('w', strtotime($fecha))); // 0 (para domingo) hasta 6 (para sábado)
          
          //   $timestamp = strtotime($time) + (60 *60 * $tiempo_respuesta);
          //   $time = date('H:i', $timestamp);
          // echo $time;  
         if($tiempo_respuesta==8){
            if($diasemana==6){
                $nuevafecha = date('Y-m-d', strtotime("+2 day", strtotime($fecha)));
            }else if($diasemana==0){
                 $nuevafecha = date('Y-m-d', strtotime("+1 day", strtotime($fecha)));
            }else if ($diasemana==5 && $hora_llegada<='14:00'){
                $nuevafecha = date('Y-m-d', strtotime("+3 day", strtotime($fecha)));
                return $nuevafecha.' 08:00';die();
            }else{
                $nuevafecha = date('Y-m-d', strtotime("+1 day", strtotime($fecha)));
               
            }
            return $nuevafecha.' '.$hora_llegada;
            
         }else if($tiempo_respuesta == 12){
            if($diasemana==6){
                if($hora_llegada <="10:00"){
                    $nuevafecha = date('Y-m-d', strtotime("+2 day", strtotime($fecha)));
                    $timestamp = strtotime($hora_llegada) + (60 *60 * 4);
                    $hora_llegada = date('H:i', $timestamp);
                }else{
                    $nuevafecha = date('Y-m-d', strtotime("+3 day", strtotime($fecha)));
                    $hora_llegada = "08:00";
                }
                
            }else if($diasemana==0){
                 $nuevafecha = date('Y-m-d', strtotime("+1 day", strtotime($fecha)));
                 $timestamp = strtotime($hora_llegada) + (60 *60 * 4);
                 $hora_llegada = date('H:i', $timestamp);
            }else if ($diasemana==5 && $hora_llegada<='10:00'){
                $nuevafecha = date('Y-m-d', strtotime("+1 day", strtotime($fecha)));

                return $nuevafecha.' 14:00';die(); //si es viernes 10 am se entrega sabado 14:00
            }else if ($diasemana==5 && $hora_llegada>'10:00'){
                $nuevafecha = date('Y-m-d', strtotime("+3 day", strtotime($fecha)));

                return $nuevafecha.' 08:00';die(); //si es viernes 10 am se entrega sabado 14:00
            }else{
               if($hora_llegada <="15:00"){
                    $nuevafecha = date('Y-m-d', strtotime("+1 day", strtotime($fecha)));
                    $timestamp = strtotime($hora_llegada) + (60 *60 * 4);
                    $hora_llegada = date('H:i', $timestamp);
               }else{
                    $nuevafecha = date('Y-m-d', strtotime("+2 day", strtotime($fecha)));
                    $hora_llegada = "08:00";
               }
            }
            return $nuevafecha.' '.$hora_llegada;
         }else{
            if($diasemana==6){
                $nuevafecha = date('Y-m-d', strtotime("+4 day", strtotime($fecha)));
                $hora_llegada = "14:00";
            }else if($diasemana==0){
                 $nuevafecha = date('Y-m-d', strtotime("+3 day", strtotime($fecha)));
                 $hora_llegada = "14:00";
            }else if ($diasemana==5 && $hora_llegada<='10:00'){
                $nuevafecha = date('Y-m-d', strtotime("+4 day", strtotime($fecha)));
                return $nuevafecha.' 08:00';die();
            }if($diasemana==4){
                //jueves
                 $nuevafecha = date('Y-m-d', strtotime("+3 day", strtotime($fecha)));
                 $hora_llegada = "12:00";
            }else{
                $nuevafecha = date('Y-m-d', strtotime("+3 day", strtotime($fecha)));
               
            }
            return $nuevafecha.' '.$hora_llegada;
         }
    }
?>