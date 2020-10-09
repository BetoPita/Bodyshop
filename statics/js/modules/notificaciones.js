/**
 * FILE THAT NEED FOR CHECK THE VALUES
 * ABOUT THE SEND THE NOTIFICATIONS
 * AND CAN SEE THE VALIDATIONS OF THE
 * VALUES
 **/

/**
 * Event to make events to the final user and
 * can see the information for can create and
 * action with the platform to the user admin
 *
 * @return void
 * @author blackfoxgdl <ruben.alonso21@gmail.com>
 **/
$(document).ready(function(){

    /**
     * Section where load the form library and the
     * option to show the notifications menu
     **/
    $("#options_notifications").show();
    baseUrl = getBaseUrl();
   // $.getScript(baseUrl+'/statics/js/libraries/form.js');

    /**
     * Event that will show the dialog form and can
     * notify to the user that need to confirm if really
     * want to delete the information or not. This value act
     * depending the desition taked by the user
     *
     * @return void
     * @author blackfoxgdl <ruben.alonso21@gmail.com>
     **/
    $(".eliminar").click(function(event){
        event.preventDefault();
        $.confirm({
                    'title'     : 'Eliminar Notificaciones',
                    'message'   : 'Desea eliminar la notificacion seleccionada?',
                    'buttons'   : {
                                    'Eliminar' : {
                                        'class' : 'blue',
                                        'action': function(){
                                            id = $(event.currentTarget).attr('flag');
                                            url = $("#delete"+id).attr('href');
                                            $("#eliminar"+id).slideUp();
                                            $.get(url);
                                        }
                                    },
                                    'Cancelar' : {
                                        'class' : 'gray',
                                        'action': function(){} //do nothing
                                    }
                                  }
                  });
    });

    /**
     * Event which the user will execute once press the
     * button and the system will send the data to check
     * if pass the check process so will show a success
     * message
     *
     * @return void
     * @author blackfoxgdl <ruben.alonso21@gmail.com>
     **/
    $("#new_notification").submit(function(){
        var band = 0;

        if($("#notification_text").val() == ''){
            $("#notification_text").css('border', '1px solid #FF0000');
            band++;
        }
        else{
            $("#notification_text").css('border', '1px solid #ADA9A5');
        }

        if(band != 0)
        {
            $("#errorMessage").text("Por favor, verifique los campos marcados.").show();
            return false;
        }
        else{
            $("#errorMessage").hide();
            var opt = {
                success : newNotification
            }
            $(this).ajaxSubmit(opt);
            return false;
        }
    });
	
	
	
	
});

function exito(responseText)
{
    $("#notification_text").val('');
    $("#successMessage").fadeIn(1500);
    $("#successMessage").fadeOut(3500);

   
}


/**
 * Function will execute once pass the next
 * step of the values and can show the
 * information message
 *
 * @return void
 * @author blackfoxgdl <ruben.alonso21@gmail.com>
 **/
function newNotification(responseText)
{
    $("#notification_text").val('');
    $("#successMessage").fadeIn(1500);
    $("#successMessage").fadeOut(3500);

    url = "http://zavordigital.com/patologia_diagnostica/notificaciones/gcm.php?id="+responseText;
	
	 url2 = "http://zavordigital.com/patologia_diagnostica/notificaciones/msgios.php?id="+responseText;
    $.get(url);
	$.get(url2);
}
