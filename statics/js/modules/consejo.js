$(document).ready(function(){

    
    $("#options_producto").show();
	$(".eliminar").click(function(event){
        event.preventDefault();
        $.confirm({
                    'title'     : 'Eliminar Consejo',
                    'message'   : 'Desea eliminar el consejo seleccionado?',
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
	
 });	