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

function GenerarPass(id){
    
    $.ajax({
        headers: {    },
        async:true,
        method:'post',
        url:  Url()+"api/GenerarPass",
        data:{id:id}
    }).done(function(data) {
        console.log(data);
        if(data.status==1){
            $('#temp').val(data[0].temp);            
        }else{
            alert('Error al generar la contraseña.');
        }
    }).fail(function() {
        
    });
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
