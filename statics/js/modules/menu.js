/**
 * FILE USED FOR CHECK ALL THE VALUES
 * OF OPTIONS TO THE ADMIN MENU AND CAN
 * KNOW WHAT IS THE DATA REQUIRED
 *
 * @createdAt May 24, 2013
 * @author blackfoxgdl <ruben.alonso21@gmail.com>
 **/

/**
 * Event where the document can check the values
 * of the menu and know if the system show of hide
 * the values once click in the main option
 *
 * @return void
 * @author blackfoxgdl <ruben.alonso21@gmail.com>
 **/
$(document).ready(function(){

    /**
     * Event that will execute once click in the part
     * of the values and can know what is the data will
     * need to check for show or hide the menu
     **/
    $("#link_torneos").click(function(event){
        event.preventDefault();
        $("#optionsTeams").slideUp('slow');
        $("#options_notifications").slideUp('slow');
        $("#options_jornadas").slideUp('slow');
        $("#options_name_jornadas").slideUp('slow');
        $("#options_news").slideUp('slow');
        $("#options_sports").slideUp('slow');
        $("#options_promotions").slideUp('slow');
		$("#options_encuestas").slideUp('slow');
		$("#options_tips").slideUp('slow');
        $("#options_tournament").toggle('slow');
    });

    $("#link_notificaciones").click(function(event){
        event.preventDefault();
        $("#options_tournament").slideUp('slow');
        $("#options_teams").slideUp('slow');
        $("#options_jornadas").slideUp();
        $("#options_name_jornadas").slideUp('slow');
        $("#options_news").slideUp('slow');
        $("#options_sports").slideUp('slow');
        $("#options_promotions").slideUp('slow');
		$("#options_encuestas").slideUp('slow');
		$("#options_agenda").slideUp('slow');
		$("#options_albums").slideUp('slow');
		$("#options_tips").slideUp('slow');
		$("#options_producto").slideUp('slow');
		$("#options_mezcla").slideUp('slow');
        $("#options_notifications").toggle('slow');
    });
	
	$("#link_producto").click(function(event){
        event.preventDefault();
        $("#options_tournament").slideUp('slow');
        $("#options_teams").slideUp('slow');
        $("#options_jornadas").slideUp();
        $("#options_name_jornadas").slideUp('slow');
        $("#options_news").slideUp('slow');
        $("#options_sports").slideUp('slow');
        $("#options_promotions").slideUp('slow');
		$("#options_encuestas").slideUp('slow');
		$("#options_agenda").slideUp('slow');
		$("#options_albums").slideUp('slow');
		$("#options_tips").slideUp('slow');
        $("#options_notifications").slideUp('slow');
		$("#options_mezcla").slideUp('slow');
		$("#options_producto").toggle('slow');
    });
	
	$("#link_mezcla").click(function(event){
        event.preventDefault();
        $("#options_tournament").slideUp('slow');
        $("#options_teams").slideUp('slow');
        $("#options_jornadas").slideUp();
        $("#options_name_jornadas").slideUp('slow');
        $("#options_news").slideUp('slow');
        $("#options_sports").slideUp('slow');
        $("#options_promotions").slideUp('slow');
		$("#options_encuestas").slideUp('slow');
		$("#options_agenda").slideUp('slow');
		$("#options_albums").slideUp('slow');
		$("#options_tips").slideUp('slow');
        $("#options_notifications").slideUp('slow');
		$("#options_producto").slideUp('slow');
		$("#options_eventos").slideUp('slow');
		$("#options_mezcla").toggle('slow');
    });
	
	
	
	$("#link_agenda").click(function(event){
        event.preventDefault();
        $("#options_tournament").slideUp('slow');
        $("#options_teams").slideUp('slow');
        $("#options_jornadas").slideUp();
        $("#options_name_jornadas").slideUp('slow');
        $("#options_news").slideUp('slow');
        $("#options_sports").slideUp('slow');
        $("#options_promotions").slideUp('slow');
		$("#options_encuestas").slideUp('slow');
        $("#options_notifications").slideUp('slow');
		$("#options_eventos").slideUp('slow');
		$("#options_albums").slideUp('slow');
		$("#options_tips").slideUp('slow');
		$("#options_producto").slideUp('slow');
		$("#options_mezcla").slideUp('slow');
		$("#options_agenda").toggle('slow');
		
    });
	
	$("#link_tips").click(function(event){
        event.preventDefault();
        $("#options_tournament").slideUp('slow');
        $("#options_teams").slideUp('slow');
        $("#options_jornadas").slideUp();
        $("#options_name_jornadas").slideUp('slow');
        $("#options_news").slideUp('slow');
        $("#options_sports").slideUp('slow');
        $("#options_promotions").slideUp('slow');
		$("#options_encuestas").slideUp('slow');
        $("#options_notifications").slideUp('slow');
		$("#options_eventos").slideUp('slow');
		$("#options_albums").slideUp('slow');
		$("#options_agenda").slideUp('slow');
		$("#options_producto").slideUp('slow');
		$("#options_mezcla").slideUp('slow');
		$("#options_tips").toggle('slow');
    });
	
    $("#link_equipos").click(function(event){
        event.preventDefault();
        $("#options_tournament").slideUp('slow');
        $("#options_notifications").slideUp('slow');
        $("#options_jornadas").slideUp('slow');
        $("#options_name_jornadas").slideUp('slow');
        $("#options_news").slideUp('slow');
        $("#options_sports").slideUp('slow');
        $("#options_promotions").slideUp('slow');
        $("#options_teams").toggle('slow');
    });

    $("#link_jornadas").click(function(event){
        event.preventDefault();
        $("#options_tournament").slideUp('slow');
        $("#options_notifications").slideUp('slow');
        $("#options_teams").slideUp('slow');
        $("#options_name_jornadas").slideUp('slow');
        $("#options_news").slideUp('slow');
        $("#options_sports").slideUp('slow');
        $("#options_promotions").slideUp('slow');
        $("#options_jornadas").toggle('slow');
    });

    $("#link_fechas").click(function(event){
        event.preventDefault();
        $("#options_tournament").slideUp('slow');
        $("#options_notifications").slideUp('slow');
        $("#options_teams").slideUp('slow');
        $("#options_jornadas").slideUp('slow');
        $("#options_news").slideUp('slow');
        $("#options_sports").slideUp('slow');
        $("#options_promotions").slideUp('slow');
        $("#options_name_jornadas").toggle('slow');
    });

    $("#link_noticias").click(function(event){
        event.preventDefault();
        $("#options_tournament").slideUp('slow');
        $("#options_notifications").slideUp('slow');
        $("#options_teams").slideUp('slow');
        $("#options_jornadas").slideUp('slow');
        $("#options_name_jornadas").slideUp('slow');
        $("#options_sports").slideUp('slow');
        $("#options_promotions").slideUp('slow');
		$("#options_encuestas").slideUp('slow');
		$("#options_eventos").slideUp('slow');
		$("#options_agenda").slideUp('slow');
		$("#options_albums").slideUp('slow');
		$("#options_tips").slideUp('slow');
		$("#options_producto").slideUp('slow');
		$("#options_mezcla").slideUp('slow');
        $("#options_news").toggle('slow');
    });
	
	$("#link_eventos").click(function(event){
        event.preventDefault();
        $("#options_tournament").slideUp('slow');
        $("#options_notifications").slideUp('slow');
        $("#options_teams").slideUp('slow');
        $("#options_jornadas").slideUp('slow');
        $("#options_name_jornadas").slideUp('slow');
        $("#options_sports").slideUp('slow');
        $("#options_promotions").slideUp('slow');
		$("#options_encuestas").slideUp('slow');
		$("#options_agenda").slideUp('slow');
		 $("#options_news").slideUp('slow');
		 $("#options_tips").slideUp('slow');
		 $("#options_producto").slideUp('slow');
		 $("#options_mezcla").slideUp('slow');
		 $("#options_albums").slideUp('slow');
        $("#options_eventos").toggle('slow');
    });
	$("#link_encuestas").click(function(event){
        event.preventDefault();
        $("#options_tournament").slideUp('slow');
        $("#options_notifications").slideUp('slow');
        $("#options_teams").slideUp('slow');
        $("#options_jornadas").slideUp('slow');
        $("#options_name_jornadas").slideUp('slow');
        $("#options_sports").slideUp('slow');
        $("#options_promotions").slideUp('slow');
		$("#options_eventos").slideUp('slow');
		$("#options_agenda").slideUp('slow');
		$("#options_albums").slideUp('slow');
		$("#options_tips").slideUp('slow');
		$("#options_producto").slideUp('slow');
		$("#options_mezcla").slideUp('slow');
        $("#options_encuestas").toggle('slow');
    });
	
	$("#link_albums").click(function(event){
        event.preventDefault();
        $("#options_tournament").slideUp('slow');
        $("#options_notifications").slideUp('slow');
        $("#options_teams").slideUp('slow');
        $("#options_jornadas").slideUp('slow');
        $("#options_name_jornadas").slideUp('slow');
        $("#options_sports").slideUp('slow');
        $("#options_promotions").slideUp('slow');
		$("#options_eventos").slideUp('slow');
		$("#options_agenda").slideUp('slow');
		$("#options_encuestas").slideUp('slow');
		$("#options_tips").slideUp('slow');
		$("#options_producto").slideUp('slow');
		$("#options_mezcla").slideUp('slow');
        $("#options_albums").toggle('slow');
    });

    $("#link_deportes").click(function(event){
        event.preventDefault();
        $("#options_tournament").slideUp('slow');
        $("#options_notifications").slideUp('slow');
        $("#options_teams").slideUp('slow');
        $("#options_jornadas").slideUp('slow');
        $("#options_name_jornadas").slideUp('slow');
        $("#options_news").slideUp('slow');
        $("#options_promotions").slideUp('slow');
        $("#options_sports").toggle('slow');
    });

    $("#link_promotions").click(function(event){
        event.preventDefault();
        $("#options_tournament").slideUp('slow');
        $("#options_notifications").slideUp('slow');
        $("#options_teams").slideUp('slow');
        $("#options_jornadas").slideUp('slow');
        $("#options_name_jornadas").slideUp('slow');
        $("#options_news").slideUp('slow');        
        $("#options_sports").slideUp('slow');
        $("#options_promotions").toggle('slow');
    });
});
