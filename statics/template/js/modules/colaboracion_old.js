$(document).ready(function(){

$.section('#colaboracion',function(){



  $(document).on('click','#colaboracion .fa-edit',function(){
    var id_alianza = $(this).data('id'),
      elemento = $(this).closest('.item');
    $.ajaxData({
      url: 'index.php/empresas/obtener_colaboracion',
      data:{id:id_alianza},
      method: 'post'
    },function(data){
      if(data.resp){
        $('#col-id').val(data.datos.id);
        $('#col-nombre').val(data.datos.titulo);
        $('#col-desc').val(data.datos.descripcion);
        $('#col-tipo option[value='+data.datos.tipo+']').attr('selected','selected');
        $('#col-meta').val(data.datos.meta);
        $('#col-imagen').attr('src',data.datos.imagen);

        $('#modal-editar-colaboracion').modal('show');
        $('#form-editar-colabo').off('submit');
        $('#form-editar-colabo').submit(function(event){
          event.preventDefault();
          //if($.requerido('#ale-nombre') && $.requerido('#ale-desc')){
            $.ajaxFormData($(this),function(data){
              if(data.resp){

                $('#modal-editar-colaboracion').modal('hide');
                swal(data.titulo, data.mensaje, "success");
                location.reload();
              }else{
                swal(data.titulo, data.mensaje, "warning");
              }
            });
          //}
        });
      }else{
        swal(data.titulo, data.mensaje, "warning");
      }
    });
  });


  $(document).on('change','#colaboracion input[type="checkbox"]',function(){
    var id_alianza = $(this).data('id');
    //alert(id_alianza);
    $.ajaxData({
      url: 'index.php/empresas/status_colaboracion',
      data:{id:id_alianza},
      method: 'post'
    },function(data){
      if(data.resp){
        swal(data.titulo, data.mensaje, "success");
      }else{
        swal(data.titulo, data.mensaje, "warning");
        check.prop('checked',true);
      }
    });

  });

  $(document).on('click','#colaboracion .fa-trash',function(){
    var id_insumo = $(this).data('id'),
      elemento = $(this).closest('.item');
    swal({
      title: '¿Estas seguro de eliminar la colaboración?',
      text: '',
      type: "warning",
      showCancelButton: true,
      cancelButtonText: "No",
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Si, eliminar",
      closeOnConfirm: true
    }, function(){
      $.ajaxData({
        url: 'index.php/empresas/eliminar_colaboracion',
        data:{id:id_insumo},
        method: 'post'
      },function(data){
        if(data.resp){
          swal(data.titulo, data.mensaje, "success");
          elemento.remove();
        }else{
          swal(data.titulo, data.mensaje, "warning");
        }
      });
    });
  });






  $('.patrocinar').click(function(){
    var id_patrocinar = $(this).data('id');
    $.ajaxData({
      url: 'index.php/colaboracion/registra_usuario',
      data:{id:1},
      method: 'post'
    },function(data){
      //if(data.resp){
        //$('#prop-nombre').text(data.datos.nombre);
        //$('#prop-espec').text(data.datos.especificacion);
        //$('#prop-id').val(data.datos.id);
        $('#modal-colaboracion').modal('show');
        $('#form-propuesta-colaboracion').off('submit');
        $('#form-agregar-colaboracion').submit(function(event){
          event.preventDefault();
          //if($.requerido('#prop-propuesta')){
            $.ajaxSerialize($(this),function(data){
              if(data.resp){
                $('#modal-colaboracion').modal('hide');
                swal(data.titulo, data.mensaje, "success");
                location.reload();
              }else{
                swal(data.titulo, data.mensaje, "warning");
              }
            });
          //}
        });
      /*}else{
        swal(data.titulo, data.mensaje, "warning");
      }*/

    });

  });

/*
*crear
*/
$('#form-crear').submit(function(event){
  event.preventDefault();
  $.ajaxFormData($(this),function(data){
    //if(data.resp){
      //$('#prop-nombre').text(data.datos.nombre);
      //$('#prop-espec').text(data.datos.especificacion);
      //$('#prop-id').val(data.datos.id);
      // $('#modal-crear').modal('show');
      // $('#form-crear').off('submit');
      // $('#form-crear').submit(function(event){
        // event.preventDefault();
        //if($.requerido('#prop-propuesta')){
          // $.ajaxSerialize($(this),function(data){
            if(data.resp){
              $('#modal-crear').modal('hide');
              swal(data.titulo, data.mensaje, "success");
              location.reload();
            }else{
              swal(data.titulo, data.mensaje, "warning");
            }
          // });
        //}
      // });
    /*}else{
      swal(data.titulo, data.mensaje, "warning");
    }*/

  });

});
$('.crear').click(function(){
  $('#modal-crear').modal('show');
});

$('#btn-logo').click(function(){
  $('#logo').click();
});
$("#logo").change(function(){
  if (this.files && this.files[0]) {
    if(this.files[0].size < 2*1048576){
      var reader = new FileReader();
      reader.onload = function (e) {
        $('.portada > img').attr('src', e.target.result);
      }
      reader.readAsDataURL(this.files[0]);
    }else{
      $("#logo").val('');
      swal('Imagen muy grande', 'La imagen no debe de ser mayor a 2 MB', "warning");
    }
  }
});







});

});
function sendId(id){
  $('#idColaboracion').val(id);
}
