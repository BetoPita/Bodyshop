<?php
/**
 * Helper that needs for can return all the values where the
 * system can check the functions for the mobiles module.This
 * data will send once the system calls some function container
 * here
 *
 * @platformName Applebees
 * @createsAt July 03, 2013
 * @author blackfoxgdl <ruben.alonso21@gmail.com>
 * @package Helpers
 **/

/**
 * Helper that needs to for use the information where the
 * users can see the data and can check the values once
 * request data of the team
 *
 * @param int idTeam
 * @return array mixedData
 * @author blackfoxgdl <ruben.alonso21@gmail.com>
 **/
function get_data_teams($id){
    $CI =& get_instance();
    $CI->db->select('*')
           ->from('equipos')
           ->where('equiposId', $id);
    $data = $CI->db->get();
    return $data->row();
}

/**
 * Helper that returns the name of the journey once
 * the user request the values from the mobiles to
 * the server and the server responses the requet
 * did
 *
 * @param int idJourney
 * @param int idTournament
 *
 * @return array mixedData
 * @author blackfoxgdl <ruben.alonso21@gmail.com>
 **/
function get_data_journey($id, $idT){
    $CI =& get_instance();
    $CI->db->select('*')
           ->from('semanas_jornadas')
           ->where('semanasJornadasId', $id)
           ->where('semanasJornadasIdDeporte', $idT);
    $data = $CI->db->get();
    return $data->row();
}
