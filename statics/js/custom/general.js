﻿var site_url = "{{site_url()}}";
Number.prototype.padLeft = function (n, str) {
    return Array(n - String(this).length + 1).join(str || '0') + this;
}

function VentanaModal(opc, url, datos, metodo, callback) {
    ajaxLoad(url, datos, opcion, metodo, callback);
    $("#MyModal" + opc).modal("show");
}
var code400 = function () {
    console.log('entre 400');
    ErrorCustom('No tiene permisos de acceder!', "");
}
var code404 = function () {
    console.log('entre 404');
    ErrorCustom('La petición realizada no se encuentra, favor de intentarlo de nuevo mas tarde.', "");
}
var code500 = function () {
     console.log('entre 500');
    ErrorCustom('El servidor no se encuentra disponible, intenta de nuevo', function () {
        window.location.href = "";
    });
}
var code409 = function () {
    ErrorCustom('Sesión ha expirado por inactividad en el sistema', function () {
        window.location.href = site_url;
    });
}
var ValidarFecha = function () {
    $.validator.methods.date = function (value, element) {
        Globalize.culture("es-MX");
        return this.optional(element) || Globalize.parseDate(value) !== null;
    }
}
var returnAcciones = function (sourceActionId, propiedades, response) {
    if ($('#' + sourceActionId).length > 0) {
        var Acciones = _.template($('#' + sourceActionId).html());
        var js = jQuery.parseJSON(propiedades);
        _.map(js, function (value, key) {
            valor = eval(value);
            eval('js.' + key + ' = ' + value);
        });
        return Acciones(js);
    }
}
/*Peticiones: traer datos o views*/
var ajaxJson = function (url, data, metodo, asincrono, callback,mostrar_loading=true) {
    console.log(mostrar_loading);
    if(mostrar_loading){
      $.isLoading({ text: "Cargando..." });
    }
    if (metodo == "")
        metodo = "POST";
    jQuery.ajax({
        type: metodo,
        url: url,
        datatype: "JSON",
        async: asincrono,
        cache: false,
        data: data,
        statusCode: {
            200: function (result) {
                if(mostrar_loading){
                    $.isLoading( "hide" );
                }
                if (callback != "") {
                    var call = $.Callbacks();
                    call.add(callback);
                    call.fire(result);
                }
            },
            401: code400,
            404: code404,
            500: code500,
            409: code409
        }
    });

}

var ajaxSelect = function (url, data, metodo, asincrono, div, seleccion, callback) {
    if (metodo == "")
        metodo = "POST";
    $.ajax({
        type: metodo,
        datatype: "json",
        url: url,
        async: asincrono,
        data: data,
        cache: false,
        statusCode: {
            200: function (result) {
                if (callback != "") {
                    var call = $.Callbacks();
                    call.add(callback);
                    call.fire(result, div, seleccion);
                }
            },
            401: code400,
            404: code404,
            500: code500,
            409: code409
        }
    });
}

var ajaxLoad = function (url, data, div, metod, callback) {
    if (typeof metod === "undefined")
        metod = "POST";
    //$("#" + div).empty();
    //$("#" + div).isLoading({ position: "overlay" });
    $.isLoading({ text: "Cargando..." });
    $.ajax({
        type: metod,
        datatype: "html",
        url: url,
        data: data,
        cache: false,
        statusCode: {
            200: function (result) {
                 $.isLoading( "hide" );
                $("#" + div).empty();
                $("#" + div).html(result);
                if (callback != "") {
                    var call = $.Callbacks('memory once');
                    call.add(callback);
                    call.fire(result, div);
                }
                //$("#" + div).isLoading("hide");
            },
            401: code400,
            404: code404,
            500: code500,
            409: code409
        }
    });
}


/*modales: Mensajes al cliente*/
/// <summary>
/// Mensaje de exito en un Dialog
/// </summary>
/// <param name="mensaje">Texto a mostrar, si no manda nada se coloca uno genérico</param>
/// <param name="callback">funcion a ejecutar al cerrar el mensaje, mandar "" si no se quiere que haga nada</param>
/// <returns></returns>
var ExitoCustom = function (mensaje, callback,nombre_boton='') {
    if(nombre_boton==''){
        var cerrar = 'Cerrar';
    }else{
        cerrar = nombre_boton;
    }
    if (mensaje == "" || mensaje == undefined)
        mensaje = '<span>Los datos han sido guardados con éxito</span>';
    else
        mensaje = "<span>" + mensaje + "</span>";
    bootbox.dialog({
        message: mensaje,
        closeButton: false,
        buttons:
        {
            "success":
            {
                "label": "<i class='icon-remove'></i> "+cerrar,
                "className": "btn-sm btn-success",
                "callback": function () {
                    if (callback != "") {
                        var call = $.Callbacks();
                        call.add(callback);
                        call.fire();
                    }
                }
            }
        }
    });
}

var ErrorCustom = function (mensaje, callback) {
    if (mensaje == "" || mensaje == undefined)
        mensaje = '<span>Ocurrió un error al procesar la petición</span>';
    else
        mensaje = "<span>" + mensaje + "</span>";
    bootbox.dialog({
        message: mensaje,
        closeButton: false,
        buttons:
        {
            "danger":
            {
                "label": "<i class='icon-remove'></i> Cerrar",
                "className": "btn-sm btn-danger",
                "callback": function () {
                    if (callback != "") {
                        var call = $.Callbacks();
                        call.add(callback);
                        call.fire();
                    }
                }
            }
        }
    });
}

var ConfirmCustom = function (mensaje, callbackOk, callbackCancel, TxtBtnOk, TxtBtnFail) {
    if (TxtBtnOk == "" || TxtBtnOk == undefined)
        TxtBtnOk = "Aceptar";
    if (TxtBtnFail == "" || TxtBtnFail == undefined)
        TxtBtnFail = "Cancelar";
    bootbox.dialog({
        message: mensaje,
        closeButton: false,
        buttons:
        {
            "success":
            {
                "label": TxtBtnOk,
                "className": "btn-sm btn-success",
                "callback": function () {
                    if (callbackOk != "") {
                        var call = $.Callbacks();
                        call.add(callbackOk);
                        call.fire();
                    }
                }
            },
            "danger":
            {
                "label": TxtBtnFail,
                "className": "btn-sm btn-danger",
                "callback": function () {
                    if (callbackCancel != "") {
                        var call = $.Callbacks();
                        call.add(callbackCancel);
                        call.fire();
                    }
                }
            }
        }
    });
}

var customHTMLModal = function (html, size, callbackOk, callbackCancel, txtBtnOk, txtBtnCancel, txtTitulo, idModal) {
    var btns = {};
    if (txtBtnOk != "") {
        btns.success = {
            "label": txtBtnOk,
            "className": "btn-sm btn-success",
            "callback": function () {
                if (callbackOk != "") {
                    var call = $.Callbacks();
                    call.add(callbackOk);
                    call.fire();
                    return false;
                }
            }
        };
    }
    if (txtBtnCancel != "") {
        btns.danger = {
            "label": txtBtnCancel,
            "className": "btn-sm btn-danger",
            "callback": function () {
                if (callbackCancel != "") {
                    var call = $.Callbacks();
                    call.add(callbackCancel);
                    call.fire();
                }
            }
        };
    }
    bootbox.dialog({
        message: html,
        closeButton: true,
        title: txtTitulo,
        className: idModal,
        buttons: btns
    });
    if (size != "")
        $("." + idModal).children().addClass("modal-" + size);
}
totalModal=0;
var customModal = function (url, data, metodo, size, callbackOk, callbackCancel, txtBtnOk, txtBtnCancel, txtTitulo, idModal) {
    totalModal++;
    var btns = {};
    if (txtBtnOk != "") {
        btns.success = {
            "label": txtBtnOk,
            "className": "btn btn-primary",
            "callback": function () {
                if (callbackOk != "") {
                    var call = $.Callbacks();
                    call.add(callbackOk);
                    call.fire();
                    return false;
                }
            }
        };
    }
    if (txtBtnCancel != "") {
        btns.danger = {
            "label": txtBtnCancel,
            "className": "btn btn-secundario",
            "callback": function () {
                totalModal--;
                if (callbackCancel != "") {
                    var call = $.Callbacks();
                    call.add(callbackCancel);
                    call.fire();
                }
                if (totalModal > 0) {
                    setTimeout(function () { $("body").addClass("modal-open") }, 500);
                }
            }
        };
    }
    $.ajax({
        url: url,
        type: metodo,
        data: data,
        datatype: "html",
        cache: false,
        statusCode: {
            200: function (response) {
                if (typeof response == "string") {
                    bootbox.dialog({
                        message: response,
                        closeButton: true,
                        title: txtTitulo,
                        className: idModal,
                        buttons: btns
                    });
                    if (size != "")
                        $("." + idModal).children().addClass("modal-" + size);
                }
                else {
                    if (response.Exito == false) {
                        ErrorCustom(response.Mensaje, "");
                    }
                    else {
                        llamarMaestro(response.Url, response.Parametros);
                    }
                }
            },
            401: code400,
            404: code404,
            500: code500,
            409: code409
        }
    });
}

var llamarMaestro = function (frm, parametros) {
    if (typeof parametros != "undefined") {
        $.each(parametros, function (key, value) {
            if (typeof value != "object") {
                $("#" + frm).append('<input type="hidden" name="' + key + '" value="' + value + '" />');
            }
            else {
                $("#" + frm).append("<input type='hidden' name='" + key + "' value='" + JSON.stringify(value) + "' />");
            }
        });
        $("#" + frm).submit();
    }
}

var ConstruirTabla = function (div, mensaje, busquedaIndividual, scrollX) {
    if (mensaje == undefined || mensaje == "")
        mensaje = "No hay registros a mostrar";
    var totalColumnas = $("#" + div + " > tbody").find("> tr:first > td").length;
    if (typeof busquedaIndividual == "undefined")
        busquedaIndividual = 1;
    if (typeof scrollX == "undefined")
        scrollX = false;
    else
        scrollX = true;
    var tfootCount = $("#" + div + " > tfoot").length;
    if (busquedaIndividual == 1) {
        if (tfootCount == 0) 
            $("#" + div).append("<tfoot><tr class='tfootClass'></tr></tfoot>");
        else {
            $("#" + div + " > tfoot").append("<tr class='tfootClass'></tr>");
        }
        for (i = 0; i < totalColumnas; i++) {
            $("#" + div + " > tfoot").find(".tfootClass").append("<th></th>");
        }
        $('#' + div + ' tfoot th').each(function () {
            var titulo = $('#' + div + ' thead th').eq($(this).index()).text();
            if (titulo.toLowerCase() == "acciones")
                totalColumnas -= 1;
            titulo = "Buscar " + titulo.trim();
            if ($(this).index() < totalColumnas) {
                $(this).html('<input type="text" class="form-control" placeholder=""/>');
            } else  
                $(this).html('<label class="fa fa-search"> Búsqueda específica</label>');
        });
    }
    var tabla = $("#" + div).dataTable({
        "sPaginationType": "full_numbers",
        "scrollX": true,
        "oLanguage": {
            "oPaginate": {
                "sPrevious": "Anterior",
                "sNext": "Siguiente",
                "sLast": "Última",
                "sFirst": "Primera"
            },
            "sLengthMenu": '<div id="combo_datatable">Mostrar <select>' +
            '<option value="5">5</option>' +
            '<option value="10">10</option>' +
            '<option value="20">20</option>' +
            '<option value="30">30</option>' +
            '<option value="40">40</option>' +
            '<option value="50">50</option>' +
            '<option value="-1">Todos</option>' +
            '</select> registros',
            "sInfo": "Mostrando del _START_ a _END_ (Total: _TOTAL_ resultados)",
            "sInfoFiltered": " - filtrados de _MAX_ registros",
            "sInfoEmpty": "No hay resultados de búsqueda",
            "sZeroRecords": mensaje,
            "sProcessing": "Espere, por favor...",
            "sSearch": "Buscar:"
        },
    });
    if (busquedaIndividual == 1) {
        $("#" + div).DataTable().columns().eq(0).each(function (colIdx) {
            $('input', $("#" + div).DataTable().column(colIdx).footer()).on('keyup change', function () {
                $("#" + div).DataTable()
                    .column(colIdx)
                    .search(this.value)
                    .draw();
            });
        });
    }
    return tabla;
}

var callBackLlenarSelect = function (result, dr) {
    var selected = 0;
    $("#" + dr).empty();
    if (result.length != 0) {
        $("#" + dr).append("<option value=''>--Selecciona una opción--</option>");
        $.each(result, function (i, item) {
            selected = item.Value;
            if (item.Selected == true) {
                
                $("#" + dr).append("<option selected='true' value='" + item.Value + "'>" + item.Text + "</option>");
                //$("#" + dr).trigger('change');
            }

            else
                $("#" + dr).append("<option value='" + item.Value + "'>" + item.Text + "</option>");
        });
        //$("#selectbox option[value=3]").attr("selected", true);   
        if (result.length == 1) {
            $("#" + dr).val(selected);
            //$("#" + dr).trigger('change');
        }

    }
    else {
        $("#" + dr).append("<option value=''>--Sin Resultados--</option>");
    }
}
var abrirModal = function (id) {
    $(id).modal({ backdrop: 'static' });
    $(id).modal("show");
    $(id + " .modal-title").text($(id + " .TituloModal").data("title"));
    $(id + " .js_btnOk").text($(id + " .btnOk").data("text"));
    $(id + " .js_btnCancel").text($(id + " .btnCancel").data("text"));
    $(id).modal("show");
}

var openModal = function (data) {
    if (typeof data === "string") {
        data = {};
        data.Modal = "MyModal1";
    }
    $("#" + data.Modal).modal({ backdrop: 'static' });
    if (typeof data.Size != "undefined")
        $("#" + data.Modal + " .modal-dialog").addClass("modal-" + data.Size);
    $("#" + data.Modal).modal("show");
    $("#" + data.Modal + " .modal-title").text($("#" + data.Modal + " .TituloModal").data("title"));
    $("#" + data.Modal + " .js_btnOk").text($("#" + data.Modal + " .btnOk").data("text"));
    $("#" + data.Modal + " .js_btnCancel").text($("#" + data.Modal + " .btnCancel").data("text"));

}
var closeModal = function (data) {
    if (typeof data === "undefined") {
        data = {};
        data.Modal = "MyModal1";
    }
    $("#" + data.Modal + " .modal-body").empty();
    $("#" + data.Modal).modal("hide");
    $("#" + data.Modal).removeClass("modal-lg modal-sm");
    $("." + data.Modal).empty();
    $("." + data.Modal).modal("hide");
    $("." + data.Modal).removeClass("modal-lg modal-sm");
}


var AddTbl = function (response, tabla) {
    var Datos = [];
    var accionesPosicion = -1;
    var myDate = "";
    $.each($("#" + tabla + " th"), function (key, value) {
        if (typeof ($(value).data("title")) != "undefined") {
            var x = "response." + $(value).data("title");
            x = eval(x);
            if (typeof x === "boolean") {
                if (x == true)
                    x = "SI";
                else
                    x = "NO";
            }
            if ($(value).data("title") == "Acciones")
                accionesPosicion = key;
            if ($(value).data("title").indexOf("Fecha") > -1 || $(value).data("title").indexOf("fecha") > -1) {
                myDate = new Date(parseInt(new String(x).replace(/\/+Date\(([\d+-]+)\)\/+/, '$1')));
                x = myDate.getDate() + "/" + (myDate.getMonth() + 1).padLeft(2) + "/" + myDate.getFullYear();
            }
            Datos[key] = x;
        }
    });
    var tbl = $("#" + tabla).dataTable();
    var a = tbl.fnAddData(Datos);
    var nTr = tbl.fnSettings().aoData[a[0]].nTr;
    $('td', nTr)[accionesPosicion].setAttribute('class', 'acciones');
    aPos = -1;
}

var UpdateTbl = function (response, tabla, aPos) {
    var Datos = [];
    var accionesPosicion = -1;
    $.each($("#" + tabla + " th"), function (key, value) {
        if (typeof ($(value).data("title")) === "undefined") {
        }
        else {
            var x = "response." + $(value).data("title");
            x = eval(x);
            if (typeof x === "boolean") {
                if (x == true)
                    x = "SI";
                else
                    x = "NO";
            }
            if ($(value).data("title") == "Acciones")
                accionesPosicion = key;
            if ($(value).data("title").indexOf("Fecha") > -1 || $(value).data("title").indexOf("fecha") > -1) {
                myDate = new Date(parseInt(new String(x).replace(/\/+Date\(([\d+-]+)\)\/+/, '$1')));
                x = myDate.getDate() + "/" + (myDate.getMonth() + 1).padLeft(2) + "/" + myDate.getFullYear();
            }
            Datos[key] = x;
        }
    });
    var tbl = $("#" + tabla).dataTable();
    /*var a = tbl.fnAddData(Datos);
    var nTr = tbl.fnSettings().aoData[a[0]].nTr;
    $('td', nTr)[accionesPosicion].setAttribute('class', 'acciones');*/
    tbl.fnUpdate(Datos, aPos);
}

var llenarMaestro   = function (data, catalogo) {
    if (typeof catalogo === "undefined")
        catalogo = "";

    $.each(data, function (key, value) {
        switch (key.substring(0, 5)) {
            case "Fecha":
                if (value != null)
                    $("#" + key).val(value).toDate();
                break;
            case "Lista":
                if (value != null)
                    callBackLlenarSelect(value, key.substring(5, key.length), "");
                break;
            default:
                switch (key.substring(0, 3)) {
                    case "Ca_":
                        if (value != null)
                            llenarMaestro(value, key + "_");
                        break;
                    case "De_":
                        if (value != null && (!(value instanceof Array)))
                            llenarMaestro(value, key + "_");
                        break;
                    default:
                        if ($("#" + catalogo + key).attr("type") == "checkbox")
                            $("#" + catalogo + key).prop("checked", value);
                        else
                            $("#" + catalogo + key).val(value);
                        if ($("#" + key).hasClass("js_importe"))
                            $("#" + key).formatCurrency({ symbol: '' });
                        break;
                }
                break;
        }
    });
}
var getUrlVars = function () {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

var ConstruirTablaEmpty = function (div, mensaje) {
    if (mensaje == undefined || mensaje == "")
        mensaje = "No hay registros a mostrar";
    var tabla = $("#" + div).dataTable({
        "paging": false,
        "info": false,
        "bInfo": false,
        "bFilter": false,
        "oLanguage": {
            "sZeroRecords": mensaje
        }
    });
    return tabla;
}

var addButtons = function (params) {
    var buttons = [];
    $.each($("#menu-lateral ul li"), function (item, value) {
        buttons[item] = $(value).data("name");
    });
    buttons.pop();
    $.each(params, function (index, val) {
        if ($.inArray(val, buttons) == -1) {
            buttons.push(val);
        }
    });
    buttons.push("bSalir");
    recargarMenuLateral(buttons);
}
var createBotonera = function (botones) {
    botonera = [];
    $.each(botones, function (key, value) {
        botonera[key] = value;
    });
    recargarMenuLateral(botonera);
}

var GoHome = function () {
    window.location.href = "/Home/Index";
}