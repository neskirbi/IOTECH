function EscalaVerdes(){
    return ['#7AFE76','#6FF171','#65DA65','#59C359','#50AF52','#489C47','#338D33','#2C7D2E','#2A6F2C','#43F59D','#3FE795','#39CD84'];
}

function EscalaRojos(){
    return ['#FF9056','#FE783F','#F5692B','#DB5E2A','#C75422','#B04D1E','#9F4118','#8F3C16','#813717','#FEC652','#FFB330','#F99F1E'];
}


function Url(){
    if(window.location.origin.includes('localhost') || window.location.origin.includes('192.168')){
        return window.location.origin+'/IOTECH/public/';
    }else{
       return window.location.origin+'/';
    }
}

function Cambio(_this,nombre){
    _this = $(_this);    
    if(_this.data('valor').toUpperCase() == _this.val().toUpperCase()){        
        _this.removeAttr('name');
    }else{
        _this.attr('name',nombre);
    }
    
}

function GenerarPass(id) {
    console.log("Generando pass para ID:", id);
    
    // Si es nuevo, generar localmente
    if (id === 'nuevo') {
        var temp = generarPasswordLocal();
        $('#temp_nuevo').val(temp);
        
        // Muestra Toast de éxito centrada abajo
        showOiionToast('Contraseña generada: ' + temp, 'success');
        return;
    }
    
    // URL usando la función global Url() o ruta base
    var url = Url() + 'api/GenerarPass';
    
    $.ajax({
        url: url,
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: id
        }
    }).done(function(response) {
        console.log("Respuesta:", response);
        
        if (response.status == 1) {
            // Actualizar el campo de texto con la contraseña generada
            $('#temp_' + id).val(response.temp);
            
            // Toast de éxito mostrando la contraseña obtenida
            showOiionToast('Contraseña generada para ' + (response.nombre || 'usuario') + ': ' + response.temp, 'success');
        } else {
            // Toast de error devuelto por la API
            showOiionToast(response.message || 'Error al generar contraseña', 'error');
        }
    }).fail(function(xhr, status, error) {
        console.error("Error AJAX:", error);
        console.error("Status:", status);
        console.error("Response:", xhr.responseText);
        
        // Toast de falla de conexión
        showOiionToast('Error de conexión al servidor: ' + error, 'error');
    });
}

// Función para generar contraseña localmente (para nuevos usuarios)
function generarPasswordLocal() {
    var caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var temp = '';
    for (var i = 0; i < 8; i++) {
        temp += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
    }
    return temp;
}


function ValidarPassRegistro(){
    if($('#pass').val().length>0 && $('#pass2').val().length>0){
        if($('#pass').val()!=$('#pass2').val()){
            $('#pass').addClass('is-invalid');
            $('#pass2').addClass('is-invalid');
        } else{
            $('#pass').removeClass('is-invalid');
            $('#pass').addClass('is-valid');
            $('#pass2').removeClass('is-invalid');
            $('#pass2').addClass('is-valid');
        }
    }else{
        $('#pass').removeClass('is-invalid');
        $('#pass2').removeClass('is-invalid');

        $('#pass').removeClass('is-valid');
        $('#pass2').removeClass('is-valid');
    }
    
}


function PreCodigo(id,numeconomico){
    $('#codent').val('');    
    $('#codsal').html('-----');  
    $('.bgenerar').attr("data-id", id);
    $('.bgenerar').attr("data-numeconomico", numeconomico);
    
}



function GenerarCodigo(_this){
    var id = $(_this).data('id');
    var numeconomico = $(_this).data('numeconomico');
    var id_operador = $(_this).data('id_operador');
    var codent = $('#codent').val();
    var opcion=$('input[name="opcion"]:checked').val();
    
    
    if($('#codent').val().length==0){
        $('#codent').removeClass('is-valid');
        $('#codent').addClass('is-invalid');
        return ; 
    }else{
        
        $('#codent').removeClass('is-invalid');        
        $('#codent').addClass('is-valid');
    }
    $.ajax({
        headers: {    },
        async:true,
        method:'post',
        url:  Url()+"api/GenerarCodigo",
        data:{id:id,codent:codent,opcion:opcion,numeconomico:numeconomico,id_operador:id_operador}
    }).done(function(data) {
        
        if(data.status==1){
            $('#codsal').html(data.codigo);            
        }else{
            alert('Error al generar el código.');
        }
    }).fail(function() {
        
    });
}


function ToggleOperadorStatus(id, btnElement) {
    var url = Url() + 'api/ToggleOperadorStatus';

    $.ajax({
        url: url,
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: id
        }
    }).done(function(response) {
        if (response.status === 1) {
            showOiionToast(response.message, response.activo == 1 ? 'success' : 'warning');
            
            var $card = $('#card_operador_' + id);
            var $badge = $('#badge_estado_' + id);
            
            if (response.activo == 1) {
                // Estado ACTIVO (Verde con parpadeo)
                $card.removeClass('opacity-50');
                $badge.removeClass('offline').addClass('online');
                $badge.find('.badge-text').text('Activo');
                $(btnElement).html('<i class="fas fa-user-slash mr-2 text-warning"></i> Desactivar Operador');
            } else {
                // Estado INACTIVO (Rojo con parpadeo)
                $card.addClass('opacity-50');
                $badge.removeClass('online').addClass('offline');
                $badge.find('.badge-text').text('Inactivo');
                $(btnElement).html('<i class="fas fa-user-check mr-2 text-success"></i> Activar Operador');
            }
        } else {
            showOiionToast(response.message || 'Error al cambiar estado.', 'error');
        }
    }).fail(function(xhr, status, error) {
        console.error("Error AJAX:", error);
        showOiionToast('Error de conexión con el servidor.', 'error');
    });
}


function ConfirmarEliminarOperador(id, nombreCompleto) {
    // Definir la ruta de eliminación en el formulario del modal
    var actionUrl = Url() + 'operadores/' + id;
    $('#formEliminarOperador').attr('action', actionUrl);
    
    // Asignar el nombre del operador para confirmación visual
    $('#nombre_operador_eliminar').text(nombreCompleto);
    
    // Abrir el modal de Bootstrap
    $('#modalConfirmarEliminar').modal('show');
}