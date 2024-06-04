function EscalaVerdes(){
    return ['#7AFE76','#6FF171','#65DA65','#59C359','#50AF52','#489C47','#338D33','#2C7D2E','#2A6F2C','#43F59D','#3FE795','#39CD84'];
}

function EscalaRojos(){
    return ['#FF9056','#FE783F','#F5692B','#DB5E2A','#C75422','#B04D1E','#9F4118','#8F3C16','#813717','#FEC652','#FFB330','#F99F1E'];
}
function Url(){
    if(window.location.origin.includes('localhost') || window.location.origin.includes('192.168')){
        return window.location.origin+'/recitrack/public/';
    }else{
       return window.location.origin+'/';
    }
}

function AppKey(){
    return 'cefa31fdcb2e11ec81768030496e73b5';
}

function desbloqueaclick(boton){    
    $(boton).prop('disabled', false);
}

function bloqueaclick(boton){    
    $(boton).prop('disabled', true);
}

function MostrarModalAlerta(alerta){
    $('#AlertaBody').html(alerta);
    $('#BotonModalAlerta').click();
}


$(document).ready(function(){
    
    Altura();
    $( ".borrar" ).click(function( event ) {
        if(!confirm($(this).data('texto'))){
            event.preventDefault();
        }
      
      
    });


    $( ".unsoloclick" ).click(function(){
        $(this).prop('disabled', true);
    });

    //Confirma el submite de los botones a los formularios y carga el mensaje 

    $( ".confirmarclick" ).click(function( event ) {
        var texto=$(this).data('texto').replaceAll('<br>','\n');
        if(!confirm(texto)){
            event.preventDefault();
        }
      
      
    });
});

function MunicipiosApi(_this,opcion){
    var entidad=$(_this).val();
    console.log(entidad);
    $.ajax({
            
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/MunicipiosApi",
        data:{entidad:entidad},
        context: document.body
    }).done(function(data) {
        //console.log(data);
        var html='<option value="">--Municipio--</option><optgroup></optgroup>';
        for(var i in data){
            switch(opcion){
                case 1:
                     html+='<option value="'+data[i].municipio+'">'+data[i].municipio+'</option>';
                break;
                case 2:
                     html+='<option value="'+data[i].id+'">'+data[i].municipio+'</option>';
                break;
            }
           
        }
        //console.log($('#municipio'));
        $('#municipio').html(html);
    });
}

function Altura(){
    var altura=($(window).height()-174)+'px'
    //console.log(altura);
    $('.Altura').css('height',altura);
}

function CorreoExiste(_this){
    _this=$(_this);
    var mail=_this.val();
    if(mail.includes(".") && mail.includes("@")){        
        
        $.ajax({
            
            headers: { "APP-KEY": AppKey() },
                method:'post',
                url: Url()+"api/CorreoExiste",
                data:{mail:mail},
                context: document.body
            }).done(function(data) {
            
            if(data==1){
                _this.removeClass('is-invalid');
                _this.addClass('is-valid');
                $('#helpertext').html('¡Correcto!');
                $('#enviar').show();
            }else{
                _this.removeClass('is-valid');
                _this.addClass('is-invalid');                
                $('#helpertext').html('Correo no registrado!');
                $('#enviar').hide();
            }
        });
    }
    
}

function CorreoExisteAdmin(_this){
    _this=$(_this);
    var mail=_this.val();
    if(mail.includes(".") && mail.includes("@")){        
        
        $.ajax({
            
        headers: { "APP-KEY": AppKey() },
            method:'post',
            url: Url()+"api/CorreoExisteAdmin",
            data:{mail:mail},
            context: document.body
        }).done(function(data) {
            
            if(data==1){
                _this.removeClass('is-invalid');
                _this.addClass('is-valid');
                $('#helpertext').html('¡Correcto!');
                $('#enviar').show();
            }else{
                _this.removeClass('is-valid');
                _this.addClass('is-invalid');                
                $('#helpertext').html('Correo no registrado!');
                $('#enviar').hide();
            }
        });
    }
    
}


function Submite(form,_this){
    if(EsValido(form)){
        if(confirm($(_this).data('texto'))){ 
            bloqueaclick(_this);       
            $('#'+form).submit();
        }
    }
    
}
function HtmltoJson(string){
    string=string.replaceAll(/[\r\n]/g, "");
    return JSON.parse($('<textarea/>').html(string).text());
}
function HtmltoArray(string){
    
    string=string.replaceAll(/[\r\n]/g, "");
    return ($('<textarea/>').html(string).text());
}
function AbrirModalFechas(){
    $('#fechas').modal('show');
}


function AbrirModal(modal){
    $('#'+modal).modal('show');
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


function ValidarPass(){
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

function CalcularCosto(){
    var precio=$('#material').find(':selected').data('precio');
    var cantidad=$('#cantidad').val();
    $('#calculo').val((precio*cantidad).toFixed(2));
}

function CalcularCostorev(){
    var precio=$('#precio').val();
    var cantidad=$('#cantidad').val();
    $('#calculo').val((precio*cantidad).toFixed(2));
}

var bandera=true;




/**
 * 
 * Apis
 */
function GetGeneradorDatos(_this){

    var id=$(_this).val();

    var planta=$('#'+$(_this).attr('id')+' option:selected').data('planta');
    $('#pplanta').val(planta);
    $('#pplanta').attr('title',planta);
    console.log(planta);
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/GetGeneradorDatos",
        data:{id:id},
        context: document.body
    }).done(function(data) {
        data=JSON.parse(data);
        $('#pidcliente').val(data.id_cliente);
        $('#pnombre').val(data.nombre);
        $('#pdireccion').val(data.direccion);
        $('#pcp').val(data.cp);
        $('#pmunicipio').val(data.municipio);
        $('#pentidad').val(data.entidad);
    });
}




/**
 * Muestra el formulario de registro de generadores.
 */

var numeroformulario=1;
var transicion=1000;

function EsValido(seccion){
    var error=0;
    $( '#'+seccion ).children().find(':input[type=text],:input[type=password],:input[type=checkbox],:input[type=date],:input[type=datetime-local],:input[type=file],:input[type=number],select,textarea').each(function(  ) {
        console.log($(this).prop('id'));
        $(this).removeClass('is-invalid');
        if(!$(this).val().trim() && !$(this).data('invalido')){
           //console.log($(this).prop('id'));
            $(this).focus();
            $(this).addClass('is-invalid');

            error++;
            return false;
            
        }
        
        
    });
    if(error==0)
    return true;
    
   
}
function RecorreFormularioAdelante(){
    switch(numeroformulario){
        case 1:
           if(!EsValido('fiscales')){
               break; 
           }
           $('#anterior').fadeIn(transicion); 
            
           if($('#fisicaomoral').val().includes('Moral')){
                $('#fiscales').fadeOut(transicion,function(){
                    $('#representante').fadeIn(transicion);
                });
                numeroformulario++;

            }else if($('#fisicaomoral').val().includes('Física')){

                $('#siguiente').fadeOut(transicion,function(){
                    $('#guardar').fadeIn(transicion);
                });

                $('#fiscales').fadeOut(transicion,function(){                   
                    $('#fisica').fadeIn(transicion);
                   
                });
                numeroformulario++;
            }
           
        break;

        case 2:
            if(!EsValido('representante')){
                break; 
            }
            $('#siguiente').fadeOut(transicion,function(){
                $('#guardar').fadeIn(transicion);
            });

            $('#representante').fadeOut(transicion,function(){                   
                $('#empresa').fadeIn(transicion);
            });
            numeroformulario++;
        break;

       
    }
}

function RecorreFormularioAtras(){
    switch(numeroformulario){
        

        case 2:
            $('#anterior').fadeOut(transicion); 
            if($('#fisicaomoral').val().includes('Moral')){
                
                $('#representante').fadeOut(transicion,function(){
                    $('#fiscales').fadeIn(transicion);                   
                });               
                 numeroformulario--;
            }else if($('#fisicaomoral').val().includes('Física')){
                $('#guardar').fadeOut(transicion,function(){                   
                    $('#siguiente').fadeIn(transicion);                   
                    
                });

                $('#fisica').fadeOut(transicion,function(){
                    $('#fiscales').fadeIn(transicion);
                });                
                numeroformulario--;                 
            }
        break;

        case 3:
            
            $('#guardar').fadeOut(transicion,function(){
                $('#siguiente').fadeIn(transicion);
               
            });
            $('#empresa').fadeOut(transicion,function(){
                $('#representante').fadeIn(transicion);
               
            });
            numeroformulario--;
        break;
    }
}

function RecorreFormularioAdelante2(){
    switch(numeroformulario){
        case 1:
           if(!EsValido('fiscales')){
               break; 
           }
           $('#anterior').fadeIn(transicion); 
            
           if($('#fisicaomoral').val().includes('Moral')){
                $('#fiscales').fadeOut(transicion,function(){
                    $('#representante').fadeIn(transicion);
                });
                numeroformulario++;

            }else if($('#fisicaomoral').val().includes('Física')){

                $('#siguiente').fadeOut(transicion,function(){
                    $('#guardar').fadeIn(transicion);
                });

                $('#fiscales').fadeOut(transicion,function(){                   
                    $('#fisica').fadeIn(transicion);
                    $('#cliente').fadeIn(transicion);
                   
                });
                numeroformulario++;
            }
           
        break;

        case 2:
            if(!EsValido('representante')){
                break; 
            }
            $('#siguiente').fadeOut(transicion,function(){
                $('#guardar').fadeIn(transicion);
            });

            $('#representante').fadeOut(transicion,function(){                   
                $('#empresa').fadeIn(transicion);
                $('#cliente').fadeIn(transicion);
            });
            numeroformulario++;
        break;

       
    }
}

function RecorreFormularioAtras2(){
    switch(numeroformulario){
        

        case 2:
            $('#anterior').fadeOut(transicion); 
            if($('#fisicaomoral').val().includes('Moral')){
                
                $('#representante').fadeOut(transicion,function(){
                    $('#fiscales').fadeIn(transicion);                   
                });               
                 numeroformulario--;
            }else if($('#fisicaomoral').val().includes('Física')){
                $('#guardar').fadeOut(transicion,function(){                   
                    $('#siguiente').fadeIn(transicion);                   
                    
                });

                $('#fisica').fadeOut(transicion,function(){
                    $('#fiscales').fadeIn(transicion);
                });  
                $('#cliente').fadeOut(transicion);              
                numeroformulario--;                 
            }
        break;

        case 3:
            
            $('#guardar').fadeOut(transicion,function(){
                $('#siguiente').fadeIn(transicion);
               
            });
            $('#empresa').fadeOut(transicion,function(){
                $('#representante').fadeIn(transicion);
               
            });
            $('#cliente').fadeOut(transicion);
            numeroformulario--;
        break;
    }
}

function GuardarGenerador(){
    
    if($('#fisicaomoral').val().includes('Moral')){
        if(!EsValido('empresa')){
            return false;
        }
    }else if($('#fisicaomoral').val().includes('Física')){
        if(!EsValido('fisica')){
            return false; 
        }
    }
    if(ValidacionFinal())
    $('#formgenerador').submit();

}

function GuardarObra(_this){
    

    if(!EsValido('formobra')){
        return false;
    }


    $('#formobra').submit();
    bloqueaclick(_this);

}

function GuardarNegocio(){
    

    if(!EsValido('formnegocio')){
        return false;
    }

    /*if(! $('#acepto').prop('checked') ) {
        alert('1.-Leer términos y condiciones.\n2.-Debes aceptar términos y condiciones');
        return false;
    }*/


    $('#formnegocio').submit();
    

}

function ValidarCita(id,_this){
    bloqueaclick(_this);

    
    if($('#draw-dataUrl').val().length==0){
        alert('Por favor pedirle al transportista que firme la entrega.');
        desbloqueaclick(_this);
        return false;
    }

    
    if(!EsValido('formcita')){
        
        
        desbloqueaclick(_this);
        return false;
    }
    
    var cantidad=$('#cantidad').val();
    var precio=$('#precio').val();
    var saldo=false;
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        async:false,
        method:'post',
        url:  Url()+"api/SaldoNegativo",
        data:{id:id,monto:cantidad*precio}
    }).done(function(data) {
        if(data=='0'){
            if(!confirm('Si continua con esta modificación el cliente tendrá un saldo pendiente con la planta.')){
                return false;
            }            
        }

        //Esta poarte sube las fotos en caso de que tengan cambios 
        if(cambio){
            for(var i=0; i<fotos.length;i++){
                if(fotos[i]!='' && fotos[i]!=1 && fotos[i]!=0){
                    var arrayfoto=fotos[i].match(/.{1,500000}/g);
                    var index=0;
                    while(index<arrayfoto.length){
                        
                        $.ajax({
                            headers: { "APP-KEY": AppKey() },
                            async:false,
                            method:'post',
                            url:  Url()+"api/CargarFoto",
                            data:{id:id,foto:i,parte:arrayfoto[index],index:(index == (arrayfoto.length-1) ? -1 : index) }
                        }).done(function(data) {
                            
                            index++;
                        }).fail(function() {
                            index++;
                            
                        });
                    }
                    
                }else if(fotos[i]==''){
                    
                    $.ajax({
                        
        headers: { "APP-KEY": AppKey() },
                        async:false,
                        method:'post',
                        url:  Url()+"api/BorrarFoto",
                        data:{id:id,foto:i}
                    }).done(function(data) {
                        
                    });
                }
                
            }
        
        }
        

        $('#formcita').submit();
    });
      

}

function GuardarEditarObra(_this){
    

    if(!EsValido('formobra')){
        return false;
    }
    if(confirm($(_this).data('texto').replaceAll('<br>','\n'))){
        $('#formobra').submit();
    }

    

    
    

}

function ValidacionFinal(){
    var error=0;
    if($('#fisicaomoral').val().includes('Moral')){        
        $( '#fiscales' ).children().find(':input[type=text],:input[type=date],:input[type=file],select').each(function(  ) {
            
            if(!$(this).val().trim()){
                error++;              
            }            
            
        });

        $( '#representante' ).children().find(':input[type=text],:input[type=date],:input[type=file],select').each(function(  ) {
                
            if(!$(this).val().trim()){
                error++;              
            }                
                
        });
        $( '#empresa' ).children().find(':input[type=text],:input[type=date],:input[type=file],select').each(function(  ) {
                
            if(!$(this).val().trim()){
                error++;              
            }                
                
        });
    }else if($('#fisicaomoral').val().includes('Física')){
         
        $( '#fiscales' ).children().find(':input[type=text],:input[type=date],:input[type=file],select').each(function(  ) {            
            
            if(!$(this).val().trim()){
                error++;               
            }
            
            
        });
         
        $( '#fisica' ).children().find(':input[type=text],:input[type=date],:input[type=file],select').each(function(  ) {            
            
            if(!$(this).val().trim()){
                error++;
            }
            
            
        });
    }else{
        return false;
    }
    if(error==0){
        return true;
    }else{
        return false;
    }
    
}

    
    
  

function TerminosyCondiciones(){
    
    var calle=$('#calle').val();
    var numeroext=$('#numeroext').val();
    var colonia=$('#colonia').val();
    var municipio=$('#municipio').val();
    var cp=$('#cp').val();
    var entidad=$('#entidad').val();
    var fechainicio=$('#fechainicio').val();
    var fechafin=$('#fechafin').val();
    var generador=$('#generador option:selected').html();
    var direccion=calle+", "+numeroext+", "+colonia+", "+municipio+", C.P. "+cp+", "+entidad;
    var total=$('#total').val();
    if(!EsValido('formobra')){
        return false;
        
    }

   
    window.open("terminos/"+direccion+"/"+fechainicio+"/"+fechafin+"/"+generador+"/"+total);
    $('#acepto').removeAttr('disabled');
    
}


/**
 * Cargo varios inputs y cargo categoria de materiales para el prmer input
 * 
 */
var rowsmateriales=1;
var opcionescategoriamaterial="";
function MasMaterialesYano(){
    if($('#planta').val().length==0){
        alert('Seleccione una planta de reciclaje primero');
        $('#planta').focus();
        return false;
    }
    var html='';
    html+='<div style="border:solid #cccccc 1px; border-radius:5px; margin-top:10px;">';
        html+='<div class="float-right">'; 
            html+='<button type="button" class="btn btn-outline-danger btn-sm" onclick="QuitarFila(this);" id="quitar" name="quitar">';
                html+='<i class="fas fa-times"></i>';
            html+='</button>'; 
        html+='</div>'; 
        html+='<div class="row">';
        html+='<div class="col-md-5">';
            html+='<div class="form-group">';
                html+='<label for="categoria">Categoría</label>';
                html+='<select class="form-control" name="categoria[]" id="categoria'+rowsmateriales+'" onchange="GetMateriales('+rowsmateriales+');">';
                   
                html+='</select>';
            html+='</div>';
        html+='</div>';
        html+='<div class="col-md-5">';
            html+='<div class="form-group">';
                html+='<label for="material">Material</label>';
                html+='<select class="form-control" name="material[]" id="material'+rowsmateriales+'" onchange="CalcularCostoPorMaterialObra('+rowsmateriales+'); PonerPrecio('+rowsmateriales+')" disabled>';
                    
                html+='</select>';
            html+='</div>';
        html+='</div>  ';
        html+='<div class="col-md-2">';
            html+='<div class="form-group">';
                html+='<label for="cantidad">Volumen</label>';
                html+='<div class="input-group">';
                    html+='<input required type="number" min=".00" step=".01" name="cantidad[],cantidadm" class="form-control" id="cantidad'+rowsmateriales+'" placeholder="Volumen" aria-invalid="true" onchange="CalcularCostoPorMaterialObra('+rowsmateriales+');">';
                    html+='<div class="input-group-append">';
                        html+='<span class="input-group-text">m<sup>3</sup></span>';
                    html+='</div>';
                html+='</div>';
            html+='</div>';
        html+='</div>';

        /*
        html+='<div class="col-md-2">';
            html+='<div class="form-group">';
                html+='<label for="precio'+rowsmateriales+'">Precio unitario</label>';
                html+='<div class="input-group">';
                    html+='<div class="input-group-prepend">';
                        html+='<span class="input-group-text">$</span>';
                    html+='</div>';
                    html+='<input  type="text" min="1" name="precio[]" class="form-control" id="precio'+rowsmateriales+'" placeholder="Precio" aria-invalid="true" onchange="CalcularCostoPorMaterialObra('+rowsmateriales+');" onclick="editar(this);" readonly >';
                html+='</div>';
            html+='</div>';
        html+='</div>';

        html+='<div class="col-md-2">';
            html+='<div class="form-group">';
                html+='<label for="costo">Importe</label>';
                html+='<div class="input-group">';
                    html+='<div class="input-group-prepend">';
                        html+='<span class="input-group-text">$</span>';
                    html+='</div>';
                        html+='<input  type="number" min=".01" step=".01" name="costo" class="form-control" id="costo'+rowsmateriales+'" placeholder="Importe" aria-invalid="true" readonly >';
                    html+='</div>';
                    
                html+='</div>';
            html+='</div>';*/
        html+='</div>';

        
    html+='</div>';
    $('#contenedor').append(html);
    CargarCategoriaMaterial('categoria'+rowsmateriales);
    
    rowsmateriales++;
}
function MenosMaterialesYano(){
    if(rowsmateriales>1){
        $('#contenedor').children().last().remove();
        rowsmateriales--;
    }
    
}


function GetMaterialesPlanta(){
    if($('#planta').val().length==0){
        alert('Seleccione una planta de reciclaje primero');
        $('#planta').focus();
        return false;
    }

    var id_planta=$('#planta').val();
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'get',
        url:  Url()+"api/GetMaterialesPlanta/"+id_planta,
        context: document.body
    }).done(function(data) {

    
        console.log(data);
        
        $('#contenedor').append(html);
        for(var i in data){
            
            var html='';
            html+='<div style=" margin-top:10px;">';
                html+='<div class="row" style="border-bottom:solid #cccccc 1px;">';
                    html+='<div class="col-md-5">';
                        html+='<div class="form-group">';
                            html+='<label for="categoria">Categoría</label>';
                            
                            html+='<select class="form-control" name="categoria[]" id="categoria'+rowsmateriales+'" >';
                                html+='<option value="'+data[i].categoria+'" >'+data[i].categoria+'</option>';
                            html+='</select>';
                        html+='</div>';
                    html+='</div>';
                    html+='<div class="col-md-5">';
                        html+='<div class="form-group">';
                            html+='<label for="material">Material</label>';
                            html+='<select class="form-control" name="material[]" id="material'+rowsmateriales+'" onchange="CalcularCostoPorMaterialObra('+rowsmateriales+'); PonerPrecio('+rowsmateriales+')">';
                                html+='<option value="'+data[i].id+'" >'+data[i].material+'</option>';
                            html+='</select>';
                        html+='</div>';
                    html+='</div>  ';
                    html+='<div class="col-md-2">';
                        html+='<div class="form-group">';
                            html+='<label for="cantidad">Volumen</label>';
                            html+='<div class="input-group">';
                                html+='<input required type="number" min=".01" step=".01" name="cantidad[],cantidadm" class="form-control" id="cantidad'+rowsmateriales+'" placeholder="Volumen" aria-invalid="true" onchange="CalcularCostoPorMaterialObra('+rowsmateriales+');" value="0">';
                                html+='<div class="input-group-append">';
                                    html+='<span class="input-group-text">m<sup>3</sup></span>';
                                html+='</div>';
                            html+='</div>';
                        html+='</div>';
                    html+='</div>';

                    /*
                    html+='<div class="col-md-2">';
                        html+='<div class="form-group">';
                            html+='<label for="precio'+rowsmateriales+'">Precio unitario</label>';
                            html+='<div class="input-group">';
                                html+='<div class="input-group-prepend">';
                                    html+='<span class="input-group-text">$</span>';
                                html+='</div>';
                                html+='<input  type="text" min="1" name="precio[]" class="form-control" id="precio'+rowsmateriales+'" placeholder="Precio" aria-invalid="true" onchange="CalcularCostoPorMaterialObra('+rowsmateriales+');" onclick="editar(this);" readonly >';
                            html+='</div>';
                        html+='</div>';
                    html+='</div>';

                    html+='<div class="col-md-2">';
                        html+='<div class="form-group">';
                            html+='<label for="costo">Importe</label>';
                            html+='<div class="input-group">';
                                html+='<div class="input-group-prepend">';
                                    html+='<span class="input-group-text">$</span>';
                                html+='</div>';
                                    html+='<input  type="number" min=".01" step=".01" name="costo" class="form-control" id="costo'+rowsmateriales+'" placeholder="Importe" aria-invalid="true" readonly >';
                                html+='</div>';
                                
                            html+='</div>';
                        html+='</div>';*/
                    html+='</div>';

                    
                html+='</div>';
            html+='</div>';
            $('#contenedor').append(html);
        }
        
        //CargarCategoriaMaterial('categoria'+rowsmateriales);
        
        rowsmateriales++;
    });

    
}

function ReiniciaMateriales(){
    $('button[name="quitar"]').each(function(){
        $(this).click();
    });
    $('#mas').click();
}


function CargarCategoriaMaterial(select){
    var id_planta=$('#planta').val();
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'get',
        url:  Url()+"api/GetCategoriasMaterial/"+id_planta,
        context: document.body
    }).done(function(categoria) {

    
        var option='<option value="">--Categoría--</option>';
        for(var i in categoria){
            option+='<option value="'+categoria[i].categoria+'">'+categoria[i].categoria+'</option>';
            
        }
        
        opcionescategoriamaterial=option;
        $('#'+select).html(option);
    });


}


/**
 * Obtiene los materiales en base a la categoria
 */

 function GetMateriales(row){
     

    var id_categoriamaterial=$('#categoria'+row).val();
    var id_planta=$('#planta').val();
    $('#material').prop( "disabled", true );
   $.ajax({
       
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/GetMateriales",
        data:{id_categoriamaterial:id_categoriamaterial,id_planta:id_planta},
        context: document.body
   }).done(function(data) {
    
       var option='<option value="">--Material--</option>';
       for(var i in data){
           option+='<option value="'+data[i].id+'" data-precio="'+data[i].precio+'">'+data[i].material+'</option>';
           
       }

       $('#material'+row).html(option);
       $('#material'+row).prop( "disabled", false );
   });
  
}

function QuitarFila(_this){
    $(_this).parent().parent().remove();
    SacarTotalObra();
}


function MaterialesEstados(_this){
    _this = $(_this);
    
    $('.materiales').each(function(){
        $(this).hide();
    });
    //return;
    
    if($('#'+_this.val()).length){
        $('#0').hide();
        $('#'+_this.val()).show();
        $('#contenedor').html('');
    }else{
        $('#0').show();
    }
}



/**
 * obtiene los materiales segun los declaro al registrar la obra
 */
function MaterialesObra(){
    var id_obra=$('#obra').val();
    var option="";
    var api='';
    if($('#todos').prop('checked')){
        api='MaterialesObraTodos';
    }else{
        api='MaterialesObraDeclarados';
    }
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/"+api,
        data:{id_obra:id_obra},
        context: document.body
    }).done(function(data) {
        option+='<option value="" data-precio="0">--Material--</option>';
        var categorias=[];
        for(var i in data){
            if(!categorias.includes(data[i].categoriamaterial)){
                categorias.push(data[i].categoriamaterial);
                option+='<optgroup label="'+data[i].categoriamaterial+'">';
                for(var j in data){
                    if(data[i].categoriamaterial.includes(data[j].categoriamaterial)){
                        option+='<option value="'+data[j].id+'">'+data[j].material+'</option>';                
                    }
                    
                } 
            }
            
        }
            
 
        $('#material').html(option);
    });
}

/**
 * Obtiene los subtipos de obra para el select 
 */
 function SubTipoObra(_this){
    var id_tipoobra=$(_this).val();
    var option="";
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: "api/SubTipoObra",
        data:{id_tipoobra:id_tipoobra},
        context: document.body
    }).done(function(data) {
        option+='<option value="" data-precio="0">--Seleccionar Subtipo--</option>';
        for(var i in data){
            option+='<option value="'+data[i].id+'">'+data[i].subtipoobra+'</option>';                
        }      
 
        $('#subtipoobra').html(option);
    });
}


/**
 * Elimina todos los marcadores de un mapa
 */
function DeleteMarkers() {
    //Loop through all the markers and remove
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
    }
    markers = [];
}


/**
 * Bucar placas y desplegar lista 
 */


function CerrarDropMenu(menu){ 
    $('#'+menu).removeClass('show');
    $('.dropdown').removeClass('show');
     
}

function AbrirDropMenu(menu){ 
    $('#'+menu).addClass('show');
    $('.dropdown').addClass('show');
     
}


function BuscarPlaca(este){
    
    CerrarDropMenu('menu');
    var matricula=$(este).val();
    var html ="";
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/Matricula",
        data:{matricula:matricula},
        context: document.body
    }).done(function(vehiculo) {
        AbrirDropMenu('menu');
        for(var i in vehiculo){
            html+='<a class="dropdown-item" onclick="CerrarDropMenu(\'menu\');PasarId(this); $(\'#vehiculo\').change();" href="#" data-id="'+vehiculo[i].id+'" data-ramir="'+vehiculo[i].ramir+'">'+vehiculo[i].matricula+'</a>';                
        }

        html+='<a onclick="AbrirModal(\'modalvehiculo\');" class="dropdown-item" href="#"><i class="fa fa-truck" aria-hidden="true"></i>&nbsp;&nbsp;Agregar Vehículo</a>';
 
        $('#menu').html(html);
    });
}
function PasarId(este){
    $('#vehiculo').val($(este).data('id'));
    $('#ramir').html('RAMIR: '+$(este).data('ramir'));
    $('#bmatricula').val($(este).html());
}
function BuscarRazon(este){   
    
    CerrarDropMenu('menurazon');
    var html ="";
    var razon=$(este).val();
    AbrirDropMenu('menurazon');
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/Razon",
        data:{razon:razon},
        context: document.body
    }).done(function(data) {

        for(var i in data){
            html+='<a class="dropdown-item" onclick="CerrarDropMenu(\'menurazon\');PasarIdRazon(this);" href="#" data-id="'+data[i].id+'">'+data[i].razonsocial+'</a>';                
        }     
        $('#menurazon').html(html);
    });
    
    
}

function PasarIdRazon(este){
    $('#razonsocial').val($(este).data('id'));

    $('#buscarrazon').val($(este).html());
}






$(document).ready(function(){
    if($( "#formvehiculo" )){
        $( "#formvehiculo" ).on('submit',function( event ) {
            event.preventDefault();
            //alert( "Handler for .submit() called." );
            var data = new FormData( this );

            $.ajax({
                
        headers: { "APP-KEY": AppKey() },
                method:'post',
                url: Url()+"api/GuardarVehiculo",
                data:data,
                context: document.body,
                cache:false,
                processData: false,
                contentType: false
            }).done(function(vehiculo) {

                $('#modalvehiculo').modal('toggle');
                alert( "Se guardo exitosamente el vehículo" );
            
            });
            
        });
    }
});


/**
 * Cambia el material que llega de la cita
 * 
 */

                                            
function CambiaMaterial(este){
    $('#material').val($(este).data('material'));
    $('#precio').val($(este).data('precio'));
    $('#materialtemp').val($(este).html());
    CalcularCostorev();
}


/**
 * Grafica de barras para gastos y saldo
 * 
 */

function GraficarDepositosGastos(depositos,agregados,transportes,gastos) {
    
     /**
      * No quitar por que es un string y no parsea a json
      */
    

    var deposito=[0,0,0,0,0,0,0,0,0,0,0,0];
    var agregado=[0,0,0,0,0,0,0,0,0,0,0,0];
    var transporte=[0,0,0,0,0,0,0,0,0,0,0,0];
    var gasto=[0,0,0,0,0,0,0,0,0,0,0,0];
    for(var i in depositos)
    {
        if(depositos[i].monto!=null)
        deposito[depositos[i].month-1]=depositos[i].monto*1;
    }
    for(var i in agregados)
    {
        if(agregados[i].monto!=null)
        agregado[agregados[i].month-1]+=agregados[i].monto*1;
    }
    for(var i in transportes)
    {
        if(transportes[i].monto!=null)
        transporte[transportes[i].month-1]+=transportes[i].monto*1;
    }

    for(var i in gastos)
    {
        if(gastos[i].monto!=null)
        gasto[gastos[i].month-1]+=gastos[i].monto*1;
    }

    
   
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------
    $('.pagos').html('<canvas id="pagos" style="min-height: 250px; height: 350px; max-height: 350px; max-width: 100%; display: block; width: 100%;" class="chartjs-render-monitor"></canvas>');

    var areaChartData = {
      labels  : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
      datasets: [
        {
            label               : 'Depositos',
            backgroundColor     : '#28A745',
            borderColor         : 'rgba(60,141,188,0.8)',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : deposito
        },{
            label               : 'Reciclaje',
            backgroundColor     : '#FFC107',
            borderColor         : 'rgba(210, 214, 222, 1)',
            pointRadius         : false,
            pointColor          : 'rgba(210, 214, 222, 1)',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data                : gasto
        },{
            label               : 'Agregados',
            backgroundColor     : '#007ACC',
            borderColor         : 'rgba(210, 214, 222, 1)',
            pointRadius         : false,
            pointColor          : 'rgba(210, 214, 222, 1)',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data                : agregado
        },{
            label               : 'Transporte',
            backgroundColor     : '#DC3545',
            borderColor         : 'rgba(210, 214, 222, 1)',
            pointRadius         : false,
            pointColor          : 'rgba(210, 214, 222, 1)',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data                : transporte
        }
       
      ]
    }


    var barChartCanvas = $('#pagos').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    var temp2 = areaChartData.datasets[2]
    var temp3 = areaChartData.datasets[3]
    barChartData.datasets[0] = temp0
    barChartData.datasets[1] = temp1    
    barChartData.datasets[2] = temp2 
    barChartData.datasets[3] = temp3

    var barChartOptions = {
        responsive              : true,
        maintainAspectRatio     : false,
        datasetFill             : false,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })

}


function GraficasRegistrosObras(registros,piniciar,iniciadas) {
    
    /**
     * No quitar por que es un string y no parsea a json
     */
   

   var registro=[0,0,0,0,0,0,0,0,0,0,0,0];
   var iniciar=[0,0,0,0,0,0,0,0,0,0,0,0];
   var iniciada=[0,0,0,0,0,0,0,0,0,0,0,0];

   for(var i in registros)
   {
       if(registros[i].registros!=null)
       registro[registros[i].mes-1]=registros[i].registros*1;

   }

   
   for(var i in piniciar)
   {
       if(piniciar[i].iniciar!=null)
       iniciar[piniciar[i].mes-1]=piniciar[i].iniciar*1;       
   }


   for(var i in iniciadas)
   {
       if(iniciadas[i].iniciada!=null)
       iniciada[iniciadas[i].mes-1]=iniciadas[i].iniciada*1;       
   }


   
  
   /* ChartJS
    * -------
    * Here we will create a few charts using ChartJS
    */

   //--------------
   //- AREA CHART -
   //--------------
   $('.registros').html('<canvas id="registros" style="min-height: 250px; height: 350px; max-height: 350px; max-width: 100%; display: block; width: 100%;" class="chartjs-render-monitor"></canvas>');

   var areaChartData = {
     labels  : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
     datasets: [
       {
        label               : 'Registros',
        backgroundColor     : '#17A2B8',
        borderColor         : 'rgba(210, 214, 222, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(210, 214, 222, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
        data                : registro
       },{
        label               : 'Por Iniciar',
        backgroundColor     : '#FFC107',
        borderColor         : 'rgba(210, 214, 222, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(210, 214, 222, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
        data                : iniciar
    },{
        label               : 'Iniciadas',
        backgroundColor     : '#28A745',
        borderColor         : 'rgba(210, 214, 222, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(210, 214, 222, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
        data                : iniciada
    }
      
     ]
   }


   var barChartCanvas = $('#registros').get(0).getContext('2d')
   var barChartData = $.extend(true, {}, areaChartData)
   var temp0 = areaChartData.datasets[0]
   var temp1 = areaChartData.datasets[1]
   var temp2 = areaChartData.datasets[2]
   barChartData.datasets[0] = temp0
   barChartData.datasets[1] = temp1
   barChartData.datasets[2] = temp2

   var barChartOptions = {
       responsive              : true,
       maintainAspectRatio     : false,
       datasetFill             : false,
       scales: {
           yAxes: [{
               ticks: {
                   beginAtZero: true
               }
           }]
       }
   }

   new Chart(barChartCanvas, {
     type: 'bar',
     data: barChartData,
     options: barChartOptions
   })

 }


  /**
   * Calcular costo de cada material en la obra 
   */
  function PonerPrecio(row){
    var precio=$('#material'+row).find(':selected').data('precio');
    $('#precio'+row).val(precio);
  }
  function CalcularCostoPorMaterialObra(row){
    var precio=$('#precio'+row).val();
    var cantidad=$('#cantidad'+row).val();3
    var total=(precio*cantidad).toFixed(2);
    var totalcondescuento=total;
    $('#costo'+row).val(totalcondescuento);  
    SacarTotalObra();    
    SacarTotalMaterial();
  }

  function SacarTotalMaterial(){
    var total=0;
    $("input[name*=cantidadm]").each(function(){
      var valor= $(this).val()*1;
      total=total+valor;
    });
    total=total.toFixed(2);

    if(total>0){
        $('#superficie').val(total);
        $("input[name*=cantidadm]").each(function(){
            
            $(this).removeClass('is-invalid');
        });
    }else{
        
        $('#superficie').val('');
        $("input[name*=cantidadm]").each(function(){
            
            $(this).addClass('is-invalid');
        });
    }
  }

  function SacarTotalObra(){
      var subtotal=0;
      var total=0;
      var iva=$('#iva').val();
      $("input[name=costo]").each(function(){
        var valor= $(this).val()*1;
        
        subtotal=subtotal+valor;
      });
      subtotal=subtotal;

      var formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
      
        // These options are needed to round to whole numbers if that's what you want.
        //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
      });      
       
      $('#subtotal').val(FormateaNumero(subtotal));
      var pretotal=subtotal+(subtotal*iva/100);
      var descuento=($('#descuento').val()==undefined) ? 0 : $('#descuento').val();
      total=pretotal-(pretotal*(descuento/100));
      $('#total').val(FormateaNumero(total));
  }



  





function GraficarSaldosPlantas(gastos) {
    
    console.log(gastos);
  
    var labels=[];
    
    var dataset=[];
    var Verdes=EscalaVerdes();
    var Rojos=EscalaRojos();
    for(var i in gastos){
      

        labels[i]=gastos[i].planta;
        var data=Redondea(Redondea(gastos[i].pago)-(Redondea(gastos[i].reciclaje)+Redondea(gastos[i].pedidos)));
        if(data<0){
            var colores=Rojos;
        }else{
            var colores=Verdes;
        }
        dataset[i]=
        {
            label               : gastos[i].siglas,
            backgroundColor     : colores[i],
            borderColor         : 'rgba(210, 214, 222, 1)',
            pointRadius         : false,
            pointColor          : 'rgba(210, 214, 222, 1)',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data                : [data]
        };
    }

   /* ChartJS
    * -------
    * Here we will create a few charts using ChartJS
    */

   //--------------
   //- AREA CHART -
   //--------------
   $('.pagos').html('<canvas id="pagos" style="min-height: 250px; height: 350px; max-height: 350px; max-width: 100%; display: block; width: 100%;" class="chartjs-render-monitor"></canvas>');

   var areaChartData = {
     labels  : labels,
     datasets: dataset
   }


   var barChartCanvas = $('#pagos').get(0).getContext('2d')
   var barChartData = $.extend(true, {}, areaChartData)
   
   for(var i in areaChartData.datasets){
      
        barChartData.datasets[i] = areaChartData.datasets[i];
    }
  

   var barChartOptions = {
       responsive              : true,
       maintainAspectRatio     : false,
       datasetFill             : false,
       scales: {
        xAxes: [{
            display: false //this will remove all the x-axis grid lines
        }],
           yAxes: [{
               ticks: {
                   beginAtZero: true
               }
           }]
       }
   }

   new Chart(barChartCanvas, {
     type: 'bar',
     data: barChartData,
     options: barChartOptions
   })

 }



 




 /**
  * Calcular costo de cada material en la obra 
  */
 function PonerPrecio(row){
   var precio=$('#material'+row).find(':selected').data('precio');
   $('#precio'+row).val(precio);
 }
 function CalcularCostoPorMaterialObra(row){
   var precio=$('#precio'+row).val();
   var cantidad=$('#cantidad'+row).val();3
   var total=(precio*cantidad).toFixed(2);
   var totalcondescuento=total;
   $('#costo'+row).val(totalcondescuento);  
   SacarTotalObra();    
   SacarTotalMaterial();
 }

 function SacarTotalMaterial(){
   var total=0;
   $("input[name*=cantidadm]").each(function(){
     var valor= $(this).val()*1;
     total=total+valor;
   });
   total=total.toFixed(2);

   if(total>0){
       $('#superficie').val(total);
       $("input[name*=cantidadm]").each(function(){
           
           $(this).removeClass('is-invalid');
       });
   }else{
       
       $('#superficie').val('');
       $("input[name*=cantidadm]").each(function(){
           
           $(this).addClass('is-invalid');
       });
   }
 }

 function SacarTotalObra(){
     var subtotal=0;
     var total=0;
     var iva=$('#iva').val();
     $("input[name=costo]").each(function(){
       var valor= $(this).val()*1;
       
       subtotal=subtotal+valor;
     });
     subtotal=subtotal;

     var formatter = new Intl.NumberFormat('en-US', {
       style: 'currency',
       currency: 'USD',
     
       // These options are needed to round to whole numbers if that's what you want.
       //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
       //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
     });      
      
     $('#subtotal').val(FormateaNumero(subtotal));
     var pretotal=subtotal+(subtotal*iva/100);
     var descuento=($('#descuento').val()==undefined) ? 0 : $('#descuento').val();
     total=pretotal-(pretotal*(descuento/100));
     $('#total').val(FormateaNumero(total));
 }

  /**
   * Onbtiene la fecha del datepiker
   */

  function Seleccionado(_this){
      $('.calendar__item__selected').each(function(){
          $(this).removeClass('calendar__item__selected');
          $(this).addClass('calendar__item');
          
      });
      $(_this).removeClass('calendar__item');
      $(_this).addClass('calendar__item__selected');
  } 

  function TomarFecha(_this){
      $('#fechacita').val($(_this).data('date'));
      Seleccionado(_this);
      GetHoras2();
  }



  function GetHoras2(){
    $('#horacita').html(''); 
    var fecha =$('#fechacita').val();    
    var obra =$('#obra').val();
    if(obra.length==0){
        alert('¡Debe seleccionar una obra primero!');
        return null;
    }
    var fechap =new Date(fecha);
    var day = new Date(fecha).getUTCDay();

   

    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: "api/GetHoras",
        data:{fecha:fecha,obra:obra},
        context: document.body
    }).done(function(data) {
        var option='';
        for(var i in data){
            option+='<option href="#horarios" style="cursor:pointer;" onclick="PonerHora(this);" data-hora="'+data[i]+'">'+data[i]+'</option>';                
        }

        $('#horacita').append(option);
    });
    
    
}

function PonerHora(este){
    $('#horacita').val($(este).data('hora'));
}

/**
 * Maneja la Trancicion de las citas
 */
function VistasCitas(tab){
    switch(tab){
        case'reciclaje':
            window.location.href = "reciclaje";
            
          ;
        break;
        case'recoleccion':
            window.location.href = "recoleccion";
            
           
        break;
        case'concreto':
            window.location.href = "concreto";
           
        break;
    }
}


/**
 * Muestra el avance de el material entregado en la grafia del dash board
 */
function AvanceEntregas(id_obra){
    //var id_obra=$(este).data('id');
    DetalleEntregas(id_obra);
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/AvanceEntregas",
        data:{id_obra:id_obra},
        context: document.body
    }).done(function(data) {
        GraficarAvanceVigencia(data.superficie[0].fechainicio,data.superficie[0].fechafin,data.entregasdiarias,data.superficie[0].superficie);      
        if(data.entregado.length){
            GraficarAvanceEntregas(data.superficie[0].superficie,data.entregado[0].entregado);     
        }else{
            GraficarAvanceEntregas(data.superficie[0].superficie,0);   
        }

        $('#detalle').html('<a href="reporteobra/'+id_obra+'" target="_blank"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</a>&nbsp;&nbsp;&nbsp;');
        //$('#detalle').append('<a href="manifiestos/'+id_obra+'" class="" target="_blank"><i class="fa fa-download" aria-hidden="true"></i> Descargar</a>');
    });
}


function AvanceEntregasSedema(id_obra){
    //var id_obra=$(este).data('id');
    DetalleEntregas(id_obra);
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/AvanceEntregasSedema",
        data:{id_obra:id_obra},
        context: document.body
    }).done(function(data) {
        
        GraficarAvanceVigencia(data.superficie[0].fechainicio,data.superficie[0].fechafin,data.entregasdiarias,data.superficie[0].superficie);      
        if(data.entregado.length){
            GraficarAvanceEntregas(data.superficie[0].superficie,data.entregado[0].entregado);     
        }else{
            GraficarAvanceEntregas(data.superficie[0].superficie,0);   
        }

        $('#detalle').html('<a href="reporteobra/'+id_obra+'" target="_blank"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</a>');
    });
}


function GraficarAvanceEntregas(superf,entrega) {
        
    $('.avancematerial').html('<canvas id="avancematerial" style="min-height: 250px; height: 350px; max-height: 350px; max-width: 100%; display: block; width: 487px;" width="487" height="250" class="chartjs-render-monitor"></canvas>');
    var superficie=[superf*1];
    var entregado=[entrega*1];
    
   
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------
    var porcentajeentregado=Redondea((entregado/superficie)*100);

    var areaChartData = {
      labels  : ['Material'],
      datasets: [
      {
          label               : 'Entregado a sitio de reciclaje '+porcentajeentregado+'%',
          backgroundColor     : '#28A745',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : entregado
        },{
            label               : 'Volumen',
            backgroundColor     : '#17A2B8',
            borderColor         : 'rgba(210, 214, 222, 1)',
            pointRadius         : false,
            pointColor          : 'rgba(210, 214, 222, 1)',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data                : superficie
        },
       
      ]
    }


    var barChartCanvas = $('#avancematerial').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
        animation: {
            duration: 0,
        },
        responsive              : true,
        maintainAspectRatio     : false,
        datasetFill             : false,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })

}

function GraficarAvanceVigencia(fechaini,fechafin,entregasdiarias,superficie){

    $('.avance').html('<canvas id="avance" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 487px;" width="487" height="250" class="chartjs-render-monitor"></canvas>');
    var fecha = new Date(fechaini+"T00:00:00");
    var dias=DiferienciaDias(fechaini,fechafin);
    if(dias<0)
    {
        alert('Error, la fecha de final es anterior a la fecha de inicio.');
    }else{
        var arraydiastotales=[];
        var arraysuperficie=[];
        var superficiepordia=0;
        var arrayentregas=[];
        var entregatotal=0;
        var diastranscurridos=0;
        var diastotales=0;
        var fechahoy= new Date();
        var aniohoy = fechahoy.getFullYear();
        var meshoy = (fechahoy.getMonth()+1) < 10 ? '0' + (fechahoy.getMonth()+1) : (fechahoy.getMonth()+1);
        var diahoy =  fechahoy.getDate() < 10 ? '0' + fechahoy.getDate() : fechahoy.getDate();
        var hoy=aniohoy+'-'+meshoy+'-'+diahoy;
        var fechacal;
        var mes='';
        var anio='';
        var dia='';
        var conter=1;
        while(true){
            arraydiastotales.push(conter);
            fecha.setDate(fecha.getDate() + 1);
            mes = (fecha.getMonth()+1)<10 ? '0' + (fecha.getMonth()+1) : (fecha.getMonth()+1);
            anio = fecha.getFullYear();
            dia =  fecha.getDate() < 10 ? '0' + fecha.getDate() : fecha.getDate();//doy formato a dia para que sea de 2 dígitos "01", "05", "10", etc.
            
            fechacal=anio+'-'+mes+'-'+dia;
            /**
             * Reviso si ya es el dia de hoy para segir asignando las entregas de las citas por fecha del dia, 
             * si pasa de hoy no agregar ceros para que la grafica no se vaya a cero y se ve como va subiendo al diaa actual
             * utilizo  diastranscurridos==0 esto por que abajo cuando se recorren las fechas al dia de hoy cambia de valer cero a valer mas de 0 de golpe y ya no llena mas valores
             */
            if(diastranscurridos==0){
                for(var j in entregasdiarias){
                    if(fechacal==entregasdiarias[j].fecha){

                        entregatotal+=(entregasdiarias[j].entregado)*1;                       
                    }
                    
                }
                arrayentregas.push(entregatotal);
            }
            

            if(fechacal==hoy){
                diastranscurridos=conter;
            }

            
            
            if(fechacal==fechafin){
                diastotales=conter;
                break;
            }
            conter++;
        }
        /**
         * Saco la grafica objetivo de entragas 
         */
        superficiepordia=superficie/arraydiastotales.length;
        var superficietotal=0;


        for(var i in arraydiastotales){
            superficietotal+=superficiepordia;
            arraysuperficie.push(Redondea(superficietotal))
        }


        var areaChartData = {
            labels  : arraydiastotales,
            datasets: [
              {
                label               : 'Entregas',
                backgroundColor     : 'rgba(60,141,188,0.4)',
                borderColor         : 'rgba(60,141,188,0.8)',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : arrayentregas
              },
              {
                label               : 'Objetivo',
                backgroundColor     : '#B2CFEB',
                borderColor         : '#AAAAAA',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : arraysuperficie
              },
            ]
          }
    
        var areaChartOptions = {
            maintainAspectRatio : false,
            responsive : true,
            legend: {
              display: false
            },
            scales: {
              xAxes: [{
                gridLines : {
                  display : false,
                }
              }],
              yAxes: [{
                gridLines : {
                  display : false,
                }
              }]
            }
          }
      
        
       
        //-------------
        //- LINE CHART -
        //--------------
        var lineChartCanvas = $('#avance').get(0).getContext('2d')
        var lineChartOptions = $.extend(true, {}, areaChartOptions)
        var lineChartData = $.extend(true, {}, areaChartData)
        lineChartData.datasets[0].fill = false;
        lineChartData.datasets[1].fill = false;
        lineChartOptions.datasetFill = false
    
        var lineChart = new Chart(lineChartCanvas, {
          type: 'line',
          data: lineChartData,
          options: lineChartOptions
        })
    }
    

    
}


/**
 * Carga la informacion en el modal de material y la action del form  para la edicion del material y regresa el modal a su estado de antes
 */

 

function CargarInfoMaterial(_this){
    var id=$(_this).data('id');
    var categoriamaterial=$(_this).data('categoriamaterial');
    var material=$(_this).data('material');
    var precio=$(_this).data('precio');
    $('#categoriamaterial option[value="'+categoriamaterial+'"]').prop('selected', true);
    
    $('#material').val(material);
    $('#precio').val(precio);
    
    $('#formmaterial').attr('action','actualizamaterial/'+id);
    $('#formmaterial').prepend('<input required="" id="_method" name="_method" type="hidden" value="PUT">');


}

function LimpiarInfoMaterial(){
    $('#formmaterial').attr('action','guardarmaterial');
    $('#_method').remove();
    $('#formmaterial').trigger("reset");
}

function CargarInfoCategoriaMaterialAdmin(_this){
    var id=$(_this).data('id');
    var categoriamaterial=$(_this).data('categoriamaterial');
    $('#categoriamaterial').val(categoriamaterial);
    $('#formcategoriamaterial').attr('action','actualizacategoriamaterialadm/'+id);
    $('#formcategoriamaterial').prepend('<input required="" id="_methodcm" name="_method" type="hidden" value="PUT">');
 }

function CargarInfoMaterialAdmin(este){
    var id=$(este).data('id');
    var categoriamaterial=$(este).data('categoriamaterial');
    var material=$(este).data('material');
    var precio=$(este).data('precio');

    $('#categoriamaterial option[value="'+categoriamaterial+'"]').prop('selected', true);
    
    $('#material').val(material);
    $('#precio').val(precio);
    
    $('#formmaterial').attr('action','actualizamaterialadm/'+id);
    $('#formmaterial').prepend('<input required="" id="_methodm" name="_method" type="hidden" value="PUT">');


}

function LimpiarInfoCategoriaMaterialAdmin(){
    $('#formcategoriamaterial').attr('action','guardarcategoriamaterialadm');
    $('#_methodcm').remove();
    $('#formcategoriamaterial').trigger("reset");
}

function LimpiarInfoMaterialAdmin(){
    $('#formmaterial').attr('action','guardarmaterialadm');
    $('#_methodm').remove();
    $('#formmaterial').trigger("reset");
}

/**
 * Obteniendo la cantids de dias entre dos fechas para lo que sea
 */

function DiferienciaDias(fechaini,fechafin){
    
    fechaini=moment(fechaini);
    fechafin=moment(fechafin);
    return fechafin.diff(fechaini, 'days');
}

function ObtenerAvancePorcentaje(id,fechainicio,fechafin,fechahoy,superficie,entregado,filtros){

    var arrayfiltros=filtros.split(',');
    var arrayborrar=[0,0,0];
    if(filtros.includes('on')){
        for(var i in arrayfiltros){
            if(!arrayfiltros[i].includes('on')){
                //arrayfiltros.splice(i);
                arrayborrar[i]=1;
            }
    
        }
    }
    
    var diastotales=DiferienciaDias(fechainicio,fechafin);
    var diasfaltantes=DiferienciaDias(fechahoy,fechafin);
    var porcentajedias;
    if(diasfaltantes<=0){
        porcentajedias=100;
    }else{
        /**
         * Se obtiene el porcentaje de lo avanzado(Mientras menos diasfaltantes mas porcentaje)
         */
        porcentajedias=Redondea(((diasfaltantes/diastotales)*-100)+100);
    }
    var porcentajeentrega=Redondea((entregado/superficie)*100);
    //porcentajedias=60;
    //porcentajeentrega=100;


    var htmlestado="";
    
    
    var html="";
    html+='<div class="progress">';   


    

    if(porcentajedias-porcentajeentrega<10){
        if(+arrayborrar[0]){
            $('#estado_'+id).parent().remove();

        }
         htmlestado+='<span class=" badge bg-success">Al día</span>';

        html+='<div class="progress-bar bg-success progress-bar-striped" role="progressbar" aria-valuenow="'+porcentajeentrega+'" aria-valuemin="0" aria-valuemax="100" style="width: '+porcentajeentrega+'%">';
    }else if(porcentajedias-porcentajeentrega>=10 && porcentajedias-porcentajeentrega<=25){
        if(+arrayborrar[1]){
            $('#estado_'+id).parent().remove();

        }
         htmlestado+='<span class=" badge bg-warning">Atrasado</span>';


        html+='<div class="progress-bar bg-warning progress-bar-striped" role="progressbar" aria-valuenow="'+porcentajeentrega+'" aria-valuemin="0" aria-valuemax="100" style="width: '+porcentajeentrega+'%">';
    }else if(porcentajedias-porcentajeentrega>25 && porcentajedias-porcentajeentrega<=100){
        if(+arrayborrar[2]){
            $('#estado_'+id).parent().remove();

        }
         htmlestado+='<span class=" badge bg-danger">Muy atrasado</span>';


        html+='<div class="progress-bar bg-danger progress-bar-striped" role="progressbar" aria-valuenow="'+porcentajeentrega+'" aria-valuemin="0" aria-valuemax="100" style="width: '+porcentajeentrega+'%">';
    }

    
    html+='<span class="sr-only">'+porcentajeentrega+'% Complete (success)</span>';
    html+='</div>';
    html+='</div>';    
    html+='<p>'+porcentajeentrega+'%</p>';
    $('#estado_'+id).html(htmlestado);
    $('#avance_'+id).html(html);
    
}

/**
 * Borra las filas de la tabla por el filtro de obraspublicas
 */

function Borrarfila(_this){
    $(_this).parent().parent().remove();
}

function Redondea(num){
    return Math.round(num*100)/100;
}


/**
 * Buscador en tabla
 */
function BuscaTabla(_this,tableid){
    // Write on keyup event of keyword input element
 // Show only matching TR, hide rest of them
    $.each($("#"+tableid+" tbody tr"), function() {
        if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
            $(this).hide();
        else
            $(this).show();
    });
}

function DropdownCustom(_class){
    $('.'+_class).animate({height:(window.innerHeight*.4)},600);
    $('.'+_class).show(100);
}

function GetClientes(_this){
    var nombre=$(_this).val(),html="";

    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/Clientes",
        data:{nombre:nombre},
        context: document.body
    }).done(function(data) {
        AbrirDropMenu('menu');

        for(var i in data){
            html+='<a class="dropdown-item" onclick="CargarCliente(this); CerrarDropMenu(\'menu\');" data-id="'+data[i].id+'">'+data[i].nombres+' '+data[i].apellidos+'</a>';
        }
        $('#menu').html(html);       
    });
}

function CargarCliente(_this){
    $('#cliente').val($(_this).data('id'));
    $('#nombre').val($(_this).html());
}

/**
 * Prepara el formulario para la cancelacion de pagos
 */

function PrepararCancelacion(_this,url){
    var id = $(_this).data('id');
    $('#id').val(id);
    $('#nombrec').html($(_this).data('nombre'));
    $('#montoc').html($(_this).data('monto'));
    $('#formcancelar').attr('action',url+'/'+id);
}

/**
 * Agregar materiales a pedido
 */
var rowsagregados=1;
function AgregarPedido(agregados){

    var html="";
    html+='<div class="row">';
        html+='<div class="col-md-3">';
            html+='<div class="form-group">';
                html+='<label for="agregado">Agregado</label>';
                html+='<select class="form-control" name="agregado[]" id="agregado'+rowsagregados+'" onchange="CalculaCosto('+rowsagregados+');">';
                    html+='<option value="">--Agregados--</option>';
                    for(var i in agregados){

                        html+='<option value="'+agregados[i].id+'" data-precio="'+agregados[i].precio+'">'+agregados[i].agregado+'</option>';
                    }
                    
                html+='</select>';
            html+='</div>';
        html+='</div>';
        html+='<div class="col-md-2">';
            html+='<div class="form-group">';
                html+='<label for="cantidad">Volumen</label>';
                html+='<input required type="number" min=".01" step=".01" name="cantidad[]" class="form-control" id="cantidad'+rowsagregados+'" placeholder="Volumen" aria-invalid="false" onchange="CalculaCosto('+rowsagregados+');">';
            html+='</div>';
        html+='</div>';

        html+='<div class="col-md-3">';
            html+='<div class="form-group">';
                html+='<label for="costo">Costo</label>';
                html+='<input  type="number" min=".01" step=".01" name="costo" class="form-control" id="costo'+rowsagregados+'" placeholder="Costo" aria-invalid="false" readonly >';
            html+='</div>';
        html+='</div>';       

        html+='<div class="col-md-1">';
            html+='<div class="form-group">';
            html+='<label for="quitar">Quitar</label>';
                html+='<button type="button" class="btn btn-outline-danger" onclick="QuitarFila(this);" id="quitar" name="quitar">';
                    html+='<i class="fas fa-times"></i>';
                html+='</button>';               
            html+='</div>';
        html+='</div>';
    html+='</div>';
    $('#pedido').append(html);
    rowsagregados++;
}

function QuitarPedido(_this){
    var value=$(_this).attr('id');
    var html=$(_this).html();
    $('#agregado').append(' <option selected onclick="AgregarPedido(this);" value="'+value+'">'+html+'</option>');
    $(_this).remove();
    Seleccionar('pedido');
}

function Seleccionar(select){
    $('#'+select+' option').each(function(){
        $(this).prop('selected', true);
    });
}

function CalculaCosto(){}


/**Correos
 * 
 */
function CorreoConfirmApi(id){
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/CorreoConfirmApi",
        data:{id:id},
        context: document.body,
        dataType: 'json'
    }).done(function(data) {
        //console.log(data);
        if(data.hasOwnProperty('success')){ 
        }else{
            alert(data.error);    
        }
    });
}



/**
 * Bloqueo de tiempo boton
 */
var tiempo;
var conteo=0;
var boton;

function BloquearTiempo(_this){
    boton = _this;
    $(_this).prop( "disabled", true );
    conteo=0;
    tiempo = setInterval(Timer, 1000);
    
    // Enable #x
    $( "#x" ).prop( "disabled", false );
}

function Timer(){
    if(conteo<61){
        $(boton).html( 'Reenviar Correo ('+conteo+')' );
        conteo++;
    }else{
        $(boton).prop( "disabled", false );
        $(boton).html( 'Reenviar Correo' );
        clearInterval(tiempo);
    }    
    

}


/**
 * Para el formato de montos
 */
function FormatNumber(_this)
{
    if(!$(_this).val().includes(',')){
        //Reemplaxamos la coma por un punto y le asignamos presicion de 2 decimales.
        var val = parseFloat($(_this).val().replace(",",".")).toFixed(2);
        
        //Aplicamos el formato deseado
        val = val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        //Actualizamos el valor
        $(_this).val(val);
    }


}

function VentanasTitulos(_this){
    $('#titulo').html($(_this).data('text'));
}

function ReportePagos(){
    var month=$('#mespago').val();
    var year=$('#aniopago').val();
    var id_planta=$('#id_planta').val();
    var html="";

    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/ReportePagos",
        data:{month:month,year:year,id_planta:id_planta},
        context: document.body
    }).done(function(data) {
        html+='<table class="table table-hover text-nowrap">';
        html+='<thead>';
          html+='<tr>';
          html+='<th>Generador</th>';
          html+='<th>Obra</th>';
          html+='<th>Monto</th>';
          html+='<th>Referencia</th>';
          html+='<th>Descripción</th>';   
          html+='<th>Fecha</th>';   
          html+='</tr>';
        html+='</thead>';
        html+='<tbody>';
        for(var i in data){
            html+='<tr>';
            html+='<td title="'+data[i].generador+'">';
            html+=data[i].generador.length > 30 ? data[i].generador.substring(0,29)+'...' :  data[i].generador;
            html+='</td>';
            html+='<td title="'+data[i].obra+'">';
            html+=data[i].obra.length > 30 ? data[i].obra.substring(0,29)+'...' :  data[i].obra;
            html+='</td>';
            html+='<td>$ ';
            html+=data[i].monto;
            html+='</td>';
            html+='<td>';
            html+=data[i].referencia;
            html+='</td>';            
            html+='<td>';
            html+=data[i].descripcion;
            html+='</td>'; 
            html+='<td>';
            html+=data[i].created_at;
            html+='</td>'; 
            html+='</tr>';

        }  
        $('#contenedorpagos').html(html); 
    });
}

function ReportePagosAdministracion(){
    var id_planta=$('#id_planta').val();
    var mes=$('#mespago').val();
    var anio=$('#aniopago').val();

    window.open('ReportePagosAdministracion/'+id_planta+'/'+mes+'/'+anio);
}


function ReportePagosFi(){
    var id_planta=$('#id_planta').val();
    var inipago=$('#inipago').val();
    var finpago=$('#finpago').val();
    var html="";

    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/ReportePagosFi",
        data:{inipago:inipago,finpago:finpago,id_planta:id_planta},
        context: document.body
    }).done(function(data) {
        html+='<table class="table table-hover text-nowrap">';
        html+='<thead>';
          html+='<tr>';
          html+='<th>Generador</th>';
          html+='<th>Obra</th>';
          html+='<th>Monto</th>';
          html+='<th>Referencia</th>';
          html+='<th>Descripción</th>';   
          html+='<th>Fecha</th>';   
          html+='</tr>';
        html+='</thead>';
        html+='<tbody>';
        for(var i in data){
            html+='<tr>';
            html+='<td title="'+data[i].generador+'">';
            html+=data[i].generador.length > 30 ? data[i].generador.substring(0,29)+'...' :  data[i].generador;
            html+='</td>';
            html+='<td title="'+data[i].obra+'">';
            html+=data[i].obra.length > 30 ? data[i].obra.substring(0,29)+'...' :  data[i].obra;
            html+='</td>';
            html+='<td>$ ';
            html+=data[i].monto;
            html+='</td>';
            html+='<td>';
            html+=data[i].referencia;
            html+='</td>';            
            html+='<td>';
            html+=data[i].descripcion;
            html+='</td>'; 
            html+='<td>';
            html+=data[i].created_at;
            html+='</td>'; 
            html+='</tr>';

        }  
        $('#contenedorpagos').html(html); 
    });
}

function ReportePagosFinanzas(){
    var id_planta=$('#id_planta').val();
    var inipago=$('#inipago').val();
    var finpago=$('#finpago').val();

    window.open('ReportePagosFinanzas/'+id_planta+'/'+inipago+'/'+finpago);
}

function FormateaNumero(number){
    var myNumeral = numeral (number);
    var currencyString = myNumeral.format('0,0.00');
    return currencyString;
}


var id_citas=[];
function ReporteCitas(){
    var obra=$('#obracita').val();
    var ini=$('#ini').val();    
    var fin=$('#fin').val();    
    var id_planta=$('#id_planta').val();
    var html="";

    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/ReporteCitas",
        data:{obra:obra,ini:ini+' 00:00:00',fin:fin+' 23:59:59',id_planta:id_planta},
        context: document.body
    }).done(function(data) {
        
        //console.log(data);
        html+='<table class="table table-hover text-nowrap">';
        html+='<thead>';
          html+='<tr>';
          html+='<th>Folio</th>';
          html+='<th>Matrícula</th>';
          html+='<th>Generador</th>';          
          html+='<th>Obra</th>';
          html+='<th>Material</th>';
          html+='<th>Volumen</th>';
          html+='<th>P.U.</th>';
          html+='<th>Subtotal</th>';
          html+='<th>Total</th>';
          html+='<th>Fecha</th>';  
          html+='<th coslpan="2">Fotos</th>';    
          html+='</tr>';
        html+='</thead>';
        html+='<tbody>';
        if(data.length==0){
            alert('Sin datos en este período.');
        }

        id_citas=[];

        for(var i in data){
            id_citas.push(data[i].id);
            html+='<tr>';
            html+='<td>';
            html+=data[i].folio;
            html+='</td>';
            html+='<td>';
            html+=data[i].matricula;
            html+='</td>';
            html+='<td title="'+data[i].razonsocial+'">';
            html+=data[i].razonsocial.length <= 30 ? data[i].razonsocial : data[i].razonsocial.substring(0,30);
            html+='</td>';
            html+='<td title="'+data[i].obra+'">';
            html+=data[i].obra.length <= 30 ? data[i].obra : data[i].obra.substring(0,30);
            html+='</td>';
            html+='<td>';
            html+=data[i].material;
            html+='</td>';
            html+='<td>';
            html+=FormateaNumero(data[i].cantidad)+' '+data[i].unidades;
            html+='</td>';    
            html+='<td>';
            html+='$ '+FormateaNumero(data[i].precio);
            html+='</td>';
            html+='<td>';
            html+='$ '+FormateaNumero((data[i].cantidad*data[i].precio));
            html+='</td>';  
            html+='<td>';
            html+='$ '+FormateaNumero((data[i].cantidad*data[i].precio)+((data[i].iva/100)*data[i].cantidad*data[i].precio));
            html+='</td>';         
            html+='<td>';
            html+=data[i].fechacita;
            html+='</td>'; 
            html+='<td>';
            html+='<img src="'+data[i].foto0+'" style="max-width:150px;">';
            html+='</td>'; 
            html+='<td>';
            html+='<img src="'+data[i].foto1+'" style="max-width:150px;">';
            html+='</td>'; 
            html+='</tr>';

        }  
        $('#contenedorcitas').html(html); 
    });
}

function DescargarBoletas(){
    if(id_citas.length==0){
        alert('Sin datos en este período.');
    }else{
        for(var i in id_citas){
            window.open(Url()+'boleta/'+id_citas[i], '_blank');
        }
        
    }
}


function DescargarManifiestos(){
    if(id_citas.length==0){
        alert('Sin datos en este período.');
    }else{
        for(var i in id_citas){
            window.open(Url()+'manifiestodescarga/'+id_citas[i], '_blank');
        }
        
    }
}

function ReporteCitasAdministracion(){
    var obra=$('#obracita').val();
    var ini=$('#ini').val();    
    var fin=$('#fin').val();
    var id_planta=$('#id_planta').val();
    var fotos = 0;
    if( $('#fotoscita').prop('checked')){
        fotos = 1;
    }
    

    window.open('ReporteCitasAdministracion/'+(obra.length==0 ? 0 : obra)+'/'+ini+' 00:00:00'+'/'+fin+' 23:59:59'+'/'+id_planta+'/'+fotos);
}


function ConsultarReporteAgregados(){
    var obra=$('#aobra').val();
    var ini=$('#aini').val();    
    var fin=$('#afin').val();    
    var id_planta=$('#id_planta').val();
    var html="";

    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/ConsultarReporteAgregados",
        data:{obra:obra,ini:ini+' 00:00:00',fin:fin+' 23:59:59',id_planta:id_planta},
        context: document.body
    }).done(function(data) {
        //console.log(data);
        html+='<table class="table table-hover text-nowrap">';
        html+='<thead>';
          html+='<tr>';
          html+='<th>Generador</th>';
          html+='<th>Obra</th>';
          html+='<th>Detalle</th>';
          html+='<th>Fecha</th>';
          html+='<th>Subtotal</th>';          
          html+='<th>IVA</th>';
          html+='<th>Total</th>';
          html+='</tr>';
        html+='</thead>';
        html+='<tbody>';
        if(data.length==0){
            alert('Sin datos en este período.');
        }
        for(var i in data){
            html+='<tr>';
            html+='<td title="'+data[i].generador+'">';
            html+=data[i].generador.length <= 30 ? data[i].generador : data[i].generador.substring(0,30);
            html+='</td>';          
            html+='<td title="'+data[i].obra+'">';
            html+=data[i].obra.length <= 30 ? data[i].obra : data[i].obra.substring(0,30);
            html+='</td>';
            html+='<td>';
            html+=(data[i].detalle);
            html+='</td>';
            html+='<td>';
            html+=(data[i].created_at);
            html+='</td>'; 
            html+='<td>';
            html+='$ '+FormateaNumero(data[i].subtotal);
            html+='</td>';   
            html+='<td>';
            html+=FormateaNumero(data[i].iva)+'%';
            html+='</td>';    
            html+='<td>';
            html+='$ '+FormateaNumero(data[i].total);
            html+='</td>'; 
           
            html+='</tr>';

        }  
        $('#contenedoragregados').html(html); 
    });
}


function ReporteAgregados(){
    var obra=$('#aobra').val();
    var ini=$('#aini').val();    
    var fin=$('#afin').val();
    var id_planta=$('#id_planta').val();
    

    window.open('ReporteAgregados/'+(obra.length==0 ? 0 : obra)+'/'+ini+' 00:00:00'+'/'+fin+' 23:59:59'+'/'+id_planta);
}


function ConsultarReporteTransporte(){
    var obra=$('#tobra').val();
    var ini=$('#tini').val();    
    var fin=$('#tfin').val();    
    var id_planta=$('#id_planta').val();
    var html="";

    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/ConsultarReporteTransporte",
        data:{obra:obra,ini:ini+' 00:00:00',fin:fin+' 23:59:59',id_planta:id_planta},
        context: document.body
    }).done(function(data) {
        console.log(data);
        html+='<table class="table table-hover text-nowrap">';
        html+='<thead>';
          html+='<tr>';
          html+='<th>Generador</th>';
          html+='<th>Obra</th>';
          html+='<th>Detalle</th>';
          html+='<th>Fecha</th>';
          html+='<th>Subtotal</th>';          
          html+='<th>IVA</th>';
          html+='<th>Total</th>';
          html+='</tr>';
        html+='</thead>';
        html+='<tbody>';
        if(data.length==0){
            alert('Sin datos en este período.');
        }
        for(var i in data){
            html+='<tr>';
            html+='<td title="'+data[i].generador+'">';
            html+=data[i].generador.length <= 30 ? data[i].generador : data[i].generador.substring(0,30);
            html+='</td>';          
            html+='<td title="'+data[i].obra+'">';
            html+=data[i].obra.length <= 30 ? data[i].obra : data[i].obra.substring(0,30);
            html+='</td>';
            html+='<td>';
            html+=(data[i].detalle);
            html+='</td>';
            html+='<td>';
            html+=(data[i].created_at);
            html+='</td>'; 
            html+='<td>';
            html+='$ '+FormateaNumero(data[i].subtotal);
            html+='</td>';   
            html+='<td>';
            html+=FormateaNumero(data[i].iva)+'%';
            html+='</td>';    
            html+='<td>';
            html+='$ '+FormateaNumero(data[i].total);
            html+='</td>'; 
           
            html+='</tr>';

        }  
        $('#contenedortransporte').html(html); 
    });
}

function ReporteTransporte(){
    var obra=$('#tobra').val();
    var ini=$('#tini').val();    
    var fin=$('#tfin').val();
    var id_planta=$('#id_planta').val();
    

    window.open('ReporteTransporte/'+(obra.length==0 ? 0 : obra)+'/'+ini+' 00:00:00'+'/'+fin+' 23:59:59'+'/'+id_planta);
}


function ReporteMaterialesAnual(){
    var year=$('#year').val();
    

    window.open('ReporteMaterialesAnual/'+year);
}


function StatusObrasDirector(){
    
    var id_planta=$('#id_planta').val();
    //console.log(id_planta);
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/StatusObrasDirector",
        data:{id_planta:id_planta},
        context: document.body
    }).done(function(data) {
       
        html='<table class="table table-hover text-nowrap">';
        html+='    <thead>';
        html+='    <tr>';
        html+='        <th style="">Empresa</th>';
        html+='        <th style="">Obra</th>';
        html+='        <th style="">Inicio de Obra</th>';
        html+='        <th style="">Fin de Obra</th>            ';
        html+='        <th style="">Pospago</th>            ';
        html+='        <th style="">Monto</th>            ';
        html+='        <th style="">Descuento</th>            ';
        html+='        <th style="">Monto Total</th>';
        html+='        <th style="">Pagos</th>';
        html+='        <th style="">Status</th>';
        html+='        <th style="">Volumen Declarado</th>';
        html+='        <th style="">Volumen Entregado</th>';
        html+='    </tr>';
        html+='    </thead>';
        html+='    <tbody>';
        for(var i in data){
            html+='        <tr>';
            html+='            <th>'+data[i].razonsocial+' </th>';
            html+='            <td>'+data[i].obra+' </td>';
            html+='            <td>'+data[i].fechainicio+' </td>';
            html+='            <td>'+data[i].fechafin+' </td>';
            html+='            <td>'+(data[i].puedepospago==1 ? 'X' : '') +'</td>';
            html+='            <td>$ '+FormateaNumero(data[i].monto)+' </td>                ';
            html+='            <td>'+data[i].descuento+' %</td>                ';
            html+='            <td>$ '+FormateaNumero(data[i].montototal)+' </td>                ';
            html+='            <td>$ '+FormateaNumero(data[i].pagos)+' </td>';
            html+='            <td></td>';
            html+='            <td>'+data[i].superficie+' '+data[i].superunidades +'</td>                ';
            html+='            <td>'+data[i].entregado*1+' '+data[i].superunidades +'</td>';
            html+='        </tr>        ';
        }
        
        html+='    </tbody>    ';
        html+='</table>';
        $('#contenedorprereporteobras').html(html);
        
    });
}


function ReporteStatusObrasPre(){

    var url = Url()+'ReporteStatusObraAdministracion/'+$('#roini').val()+'/'+$('#rofin').val();
    //console.log(url);
    
    window.open(url);
    return;
    var id_planta=$('#id_planta').val();
    console.log(id_planta);
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/ReporteStatusObrasPre",
        data:{id_planta:id_planta},
        context: document.body
    }).done(function(data) {
        html='<table class="table table-hover text-nowrap">';
        html+='    <thead>';
        html+='    <tr>';
        html+='        <th style="">Empresa</th>';
        html+='        <th style="">Obra</th>';
        html+='        <th style="">Inicio de Obra</th>';
        html+='        <th style="">Fin de Obra</th>            ';
        html+='        <th style="">Pospago</th>            ';
        html+='        <th style="">Monto</th>            ';
        html+='        <th style="">Descuento</th>            ';
        html+='        <th style="">Monto Total</th>';
        html+='        <th style="">Pagos</th>';
        html+='        <th style="">Status</th>';
        html+='        <th style="">Volumen Declarado</th>';
        html+='        <th style="">Volumen Entregado</th>';
        html+='    </tr>';
        html+='    </thead>';
        html+='    <tbody>';
        for(var i in data){
            html+='        <tr>';
            html+='            <th>'+data[i].razonsocial+' </th>';
            html+='            <td>'+data[i].obra+' </td>';
            html+='            <td>'+data[i].fechainicio+' </td>';
            html+='            <td>'+data[i].fechafin+' </td>';
            html+='            <td>'+(data[i].puedepospago==1 ? 'X' : '') +' </td>';
            html+='            <td>$ '+FormateaNumero(data[i].monto)+' </td>                ';
            html+='            <td>'+data[i].descuento+' %</td>                ';
            html+='            <td>$ '+FormateaNumero(data[i].montototal)+' </td>                ';
            html+='            <td>$ '+FormateaNumero(data[i].pagos)+' </td>';
            html+='            <td></td>';
            html+='            <td>'+data[i].superficie+' '+data[i].superunidades +'</td>                ';
            html+='            <td>'+data[i].entregado*1+' '+data[i].superunidades +'</td>';
            html+='        </tr>        ';
        }
        
        html+='    </tbody>    ';
        html+='</table>';
        $('#contenedorprereporteobras').html(html);
        
    });
}


//Detalle de entregas para el cliente por obra en el dashboard
function DetalleEntregas(id){
    var html="";

    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/DetalleEntregas",
        data:{id:id},
        context: document.body
    }).done(function(data) {
        html+='<table class="table table-hover text-nowrap">';
        html+='<thead>';
          html+='<tr>';
          html+='<th>Folio</th>';
          html+='<th>Tipo</th>';
          html+='<th>Material</th>';
          html+='<th>Cantidad</th>';          
          html+='<th>Fecha</th>';  
          html+='<th coslpan="2">Opciones</th>';    
          html+='</tr>';
        html+='</thead>';
        html+='<tbody>';
        for(var i in data){
            html+='<tr>';
            html+='<td>';
            html+=data[i].folio;
            html+='</td>';
            html+='<td>';
            html+=data[i].tipo;
            html+='</td>';
            html+='<td>';
            html+=data[i].material;
            html+='</td>'; 
            html+='<td>';
            html+=data[i].cantidad+' '+data[i].unidades;
            html+='</td>';
            html+='<td>';
            html+=data[i].fechacita;
            html+='</td>'; 
            html+='<td>';
            html+='<a href="../../boleta/'+data[i].id+'" target="_blank" class="btn btn-info btn-sm d-inline p-2" title="Descargar boleta"><i class="fa fa-download" aria-hidden="true"></i> Boleta</a>';
            html+='</td>'; 
            html+='<td>';
            html+='<a href="../../manifiestodescarga/'+data[i].id+'" target="_blank" class="btn btn-info btn-sm d-inline p-2" title="Descargar manifiesto"><i class="fa fa-download" aria-hidden="true"></i> Manifiesto</a>';
            html+='</td>'; 
            html+='</tr>';

        }  
        $('#detalleentregas').html(html); 
    });
}

function GuardarFirma(){
    if(!EsValido('firmaform')){
        return false;
    }
    $('#firmaform').submit();
}


/**
 * obtiene los materiales segun los declaro al registrar la obra
 */

var htmlcatalogo='';
var contadorcatalogo=0;
function CatalogoObra(option){
   console.log(option);
    $('#buscarproducto').show();
    htmlcatalogo="";    
    $('#catalogo').html('');

    switch(option){
        case 0:
            CatalogoObraProducto();
            CatalogoObraTransporte();
            break;
        case 1:
            CatalogoObraProducto();
            break;
        case 2:
            CatalogoObraTransporte();
            break;
        
    }
    
}


function imgError(_this){
    $(_this).attr("src","https://cdn.pixabay.com/photo/2017/01/25/17/35/picture-2008484_960_720.png");
}


 function CatalogoObraProducto(){
    

    var id_obra=$('#obra').val();
    var html="";
    if(id_obra==''){
        return
    }
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        async:false,
        method:'post',
        url: Url()+"api/CatalogoObraProducto",
        data:{id_obra:id_obra},
        context: document.body
    }).done(function(catalogo) {
        var categoria='';
        var p=0;
        for(var i in catalogo){
            if(categoria!=catalogo[i].categoria){
                p++;
                html+='<div class="callout callout-info filtro" data-filtro="">';
                    html+='<h5>'+catalogo[i].categoria+'</h5>';
                html+='</div>';
                html+='<div class="row" id="divp'+p+'">';
                html+='</div>';
                $('#catalogo').append(html);
                html='';
                categoria=catalogo[i].categoria;
            }
            
            html+='<div class="col-md-4 filtro" data-filtro="'+catalogo[i].producto+catalogo[i].descripcion+'">';
                html+='<div class="card">';
                    html+='<div class="card-body">';
                        html+='<div class="row">';
                            html+='<div class="col-md-12">';
                            html+='<center><img id="portada'+contadorcatalogo+'" src="' +(catalogo[i].portada)+'" onerror="imgError(this)" style="max-height:150px;  border-radius:5px;" alt=""></center>';
                            html+='</div>';
                        html+='</div>';
                        html+='<div class="row">';
                            html+='<div class="col-md-12">';
                                html+='<center><h6><b>'+(catalogo[i].producto.length>35 ? catalogo[i].producto.substring(0,34)+'...' : catalogo[i].producto)+'</b></h6></center>';
                            html+='</div>';
                        html+='</div>';                        
                        html+='<div class="row">';
                            html+='<div class="col-md-12">';
                                html+='<center><h7>'+(catalogo[i].descripcion.length>35 ? catalogo[i].descripcion.substring(0,34)+'...' : catalogo[i].descripcion)+'</h7></center>';
                            html+='</div>';
                        html+='</div>';

                        html+='<div class="row">';
                            html+='<div class="col-md-12">';    
                                html+='<center><h7>$ '+catalogo[i].precio+'</h7></center>';                            
                                html+='<input disabled style="display:none;" class="form-control" type="text" value="'+catalogo[i].precio+'">';
                            html+='</div>';
                        html+='</div>';

                        html+='<div class="row">';
                            html+='<div class="col-md-12">';
                                html+='<div class="input-group">';
                                    html+='<input type="number" step="1" min="0" id="cantidad'+contadorcatalogo+'" name="cantidades[]" value="0" class="form-control">';
                                    html+='<div class="input-group-append">';
                                        html+='<span class="input-group-text">'+catalogo[i].unidades+'</span>';
                                    html+='</div>';
                                html+='</div>';
                            html+='</div>';
                        html+='</div>';

                        html+='<div class="row">';
                            html+='<div class="col-md-12">';
                                html+='<br><button style="width:100%;" class="btn btn-info" data-producto="'+catalogo[i].producto+'" data-orden="'+contadorcatalogo+'" data-id="'+catalogo[i].id+'" onclick="AgregarCarrito(this,1);" >Agregar <i class="fa fa-cart-plus" aria-hidden="true"></i></button>';
                            html+='</div>';
                        html+='</div>';                        
                    html+='</div>';
                html+='</div>';
            html+='</div>';
            $('#divp'+p).append(html);
            html='';
            contadorcatalogo++;
        }
        //htmlcatalogo+=(html);
    });

    
}

function CatalogoObraTransporte(){

   
    
    var id_obra=$('#obra').val();
    var html="";
    if(id_obra==''){
        return
    }
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        async:false,
        method:'post',
        url: Url()+"api/CatalogoObraTransporte",
        data:{id_obra:id_obra},
        context: document.body
    }).done(function(catalogo) {
        var categoria='';
        var t=0;
        for(var i in catalogo){
            
            if(categoria!=catalogo[i].categoria){
                t++;
                html+='<div class="callout callout-info filtro" data-filtro="">';
                    html+='<h5>'+catalogo[i].categoria+'</h5>';
                html+='</div>';
                html+='<div class="row" id="divt'+t+'">';
                html+='</div>';
                $('#catalogo').append(html);
                html='';
                categoria=catalogo[i].categoria;
                
            }
            html+='<div class="col-md-4 filtro" data-filtro="'+catalogo[i].producto+catalogo[i].descripcion+'">';
                html+='<div class="card">';
                    html+='<div class="card-body">';
                        html+='<div class="row">';
                            html+='<div class="col-md-12">';
                                html+='<center><img id="portada'+contadorcatalogo+'" src="' +(catalogo[i].portada)+'" onerror="imgError(this)" style="max-height:150px;  border-radius:5px;" alt=""></center>';
                            html+='</div>';
                        html+='</div>';
                        html+='<div class="row">';
                            html+='<div class="col-md-12">';
                            html+='<center><h6><b>'+(catalogo[i].producto.length>35 ? catalogo[i].producto.substring(0,34)+'...' : catalogo[i].producto)+'</b></h6></center>';
                            html+='</div>';
                        html+='</div>';                        
                        html+='<div class="row">';
                            html+='<div class="col-md-12">';
                                html+='<center><h7>'+catalogo[i].descripcion+'</h7></center>';
                            html+='</div>';
                        html+='</div>';

                        html+='<div class="row">';
                            html+='<div class="col-md-12">';    
                                html+='<center><h7>$ '+catalogo[i].precio+'</h7></center>';                            
                                html+='<input disabled style="display:none;" class="form-control" type="text" value="'+catalogo[i].precio+'">';
                            html+='</div>';
                        html+='</div>';

                        html+='<div class="row">';
                            html+='<div class="col-md-12">';
                                html+='<div class="input-group">';
                                    html+='<input type="number" step="1" min="0" id="cantidad'+contadorcatalogo+'" name="cantidades[]" value="0" class="form-control">';
                                    html+='<div class="input-group-append">';
                                        html+='<span class="input-group-text"><i class="fa fa-truck" aria-hidden="true"></i> Viaje</span>';
                                    html+='</div>';
                                html+='</div>';
                            html+='</div>';
                        html+='</div>';

                        html+='<div class="row">';
                            html+='<div class="col-md-12">';
                                html+='<br><button style="width:100%;" class="btn btn-info" data-producto="'+catalogo[i].producto+'" data-orden="'+contadorcatalogo+'" data-id="'+catalogo[i].id+'" onclick="AgregarCarrito(this,0);" >Agregar <i class="fa fa-cart-plus" aria-hidden="true"></i></button>';
                            html+='</div>';
                        html+='</div>';                        
                    html+='</div>';
                html+='</div>';
            html+='</div>';
            console.log();
            $('#divt'+t).append(html);
            html='';
            contadorcatalogo++;
        }
        //htmlcatalogo+=(html);
    });

    
}




function AgregarCarrito(_this,producto){
    _this=$(_this);
    var id_usuario=_this.data('id_usuario');
    if($('#'+_this.data('id')).val()!=0){ 
        if(confirm('¿Quiere agregar '+$('#'+_this.data('id')).val() +(producto == 1 ? ' m\xB3 '+' de ' : ' ')+_this.data('producto')+'?')){
            
            if(producto){
                var data = {id_producto:_this.data('id'),id_usuario:id_usuario,cantidad:$('#'+_this.data('id')).val(),transporte:0};
            }else{
                var data = {id_transporte:_this.data('id'),id_usuario:id_usuario,cantidad:$('#'+_this.data('id')).val(),transporte:0};
            }
            
           
        $.ajax({
                
        headers: { "APP-KEY": AppKey() },
            method:'post',
            url: Url()+"api/AgregarCarrito",
            data:data,
            context: document.body
        }).done(function(data) {
            if(data.hasOwnProperty('error')){
                alert(data.error);
            }

            if(data.hasOwnProperty('success')){
                $('#capacidad').html(data.carrito);
            }

        });
        
    }   

    }else{
        alert('No puede agregar un producto con cantidad 0.');
    }

    
}

/*function LLenaCarrito(_this,tag){
    var html='';
    html+='<div class="row">';
    html+='<div class="col-md-12">';
        html+='<div class="card">';           
            html+='<div class="card-body">';
            html+='<button type="button" class="btn btn-tool float-right" onclick="QuitarCarrito(\''+tag+'\');" data-card-widget="remove">  <i class="fas fa-times"></i>  </button>';
                html+='<font><b>'+_this.data('producto')+'</b></font><br>';
                html+='<font>'+$('#cantidad').val()+' m<sup>3</sup></font>';
            html+='</div>';
            html+='</div>';
        html+='</div>';
    html+='</div>';

    $('#carrito').append(html);
}*/

/*function QuitarCarrito(tag){
    for(var i in carrito){
        if(carrito[i].tag==tag){
            carrito.splice(i,1);
            //$('#pedidojson').html(JSON.stringify(carrito));
            document.cookie = "cart="+JSON.stringify(carrito)+"; expires="+sumarDias(new Date(), 1)+"; path=/";
            if(carrito.length==0){
                $('#carritocard').hide();
            }
            
            $('#capacidad').html(carrito.length);
            break;
        }
    }
}*/

function ValidarCantidad(form,_this){
    if(carrito.length){
        Submite(form,_this);
    }else{
        alert('No se puede generar pedido sin productos.');
    }
}


function SumarDias(fecha, dias){
    fecha.setDate(fecha.getDate() + dias);
    return fecha;
}

function CargarTiposObra(_this){
    var categoria=$(_this).val();
    $('#tag').html($(_this).find(':selected').data('tag'));
    if(categoria==0){
        $('#subtipoobra').prop( "disabled", true );
    }else{
        $('#subtipoobra').removeAttr('disabled');
    }
    
    $('#subtipoobra option').each(function(){
        
        if($(this).data('categoria')!==categoria && $(this).data('categoria') !=0){
            $(this).hide();
        }else{
            $(this).show();
        }
    });
}


function GraficaPagosGastosDirector(pagos,citas,pedidos,metros){

    var pago=[];
    var gasto=[];
    var metro=[];
    
    for(var i in pagos)
    {
        if(pagos[i].monto!=null){
            pago[pagos[i].month-1]=pagos[i].monto*1;
        }
    }

    for(var i in citas)
    {
        if(citas[i].monto!=null){
           gasto[citas[i].month-1]=citas[i].monto*1;
        }
       
    }

    for(var i in pedidos)
    {
        if(pedidos[i].monto!=null){            
            gasto[pedidos[i].month-1]+=pedidos[i].monto*1;
        }
    }

    console.log(metros);
    for(var i in metros)
    {
        if(metros[i].metros!=null)
        metro[metros[i].month-1]=metros[i].metros*1;
    }

    console.log(metro);

    $('.pagos').html('<canvas id="pagos" style="min-height: 250px; height: 350px; max-height: 350px; max-width: 100%; display: block; width: 100%;" class="chartjs-render-monitor"></canvas>');
   

    var areaChartData = {
        labels  : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        datasets: [
            {
            label               : 'Pagos $',
            backgroundColor     : '#17A2B8',
            borderColor         : '#17A2B8',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : pago
            },
            {
            label               : 'Consumo $',
            backgroundColor     : '#FFC107',
            borderColor         : '#FFC107',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : gasto
            },
            {
            label               : 'Volumen',
            backgroundColor     : '#000',
            borderColor         : '#000',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : metro
            },
        ]
        }

    var areaChartOptions = {
        maintainAspectRatio : false,
        responsive : true,
        legend: {
            display: true
        },
        scales: {
            xAxes: [{
            gridLines : {
                display : false,
            }
            }],
            yAxes: [{
            gridLines : {
                display : false,
            }
            }]
        }
        }
    
    
    
    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#pagos').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartData.datasets[2].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: lineChartData,
        options: lineChartOptions
    });
    
    

    
}

function GraficaVolumenSEDEMA(mcubicos){

    //-------------
    //- BAR CHART -
    //-------------

    console.log(mcubicos);
    
    var volumen=[];    
    for(var i in mcubicos)
    {
        if(mcubicos[i].volumen!=null)
        volumen[mcubicos[i].month-1]=mcubicos[i].volumen.replace(',','')*1;
    }
    

    $('.volumen').html('<canvas id="gvolumen" style="min-height: 250px; height: 350px; max-height: 350px; max-width: 100%; display: block; width: 100%;" class="chartjs-render-monitor"></canvas>');

    var areaChartData = {
        labels  : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        datasets: [
          {
            label               : 'Volumen m³',
            backgroundColor     : 'rgba(60,141,188,0.9)',
            borderColor         : 'rgba(60,141,188,0.8)',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : volumen
          },
        ]
      }
    
    var barChartCanvas = $('#gvolumen').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    barChartData.datasets[0] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })

    /*

    var volumen=[];
    //console.log(mcubicos);
    
    for(var i in mcubicos)
    {
        if(mcubicos[i].volumen!=null)
        volumen[mcubicos[i].month-1]=mcubicos[i].volumen.replace(',','')*1;
    }

   

    $('.volumen').html('<canvas id="gvolumen" style="min-height: 250px; height: 350px; max-height: 350px; max-width: 100%; display: block; width: 100%;" class="chartjs-render-monitor"></canvas>');
   

    var areaChartData = {
        labels  : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        datasets: [
            {
            label               : 'Volumen m³ ',
            backgroundColor     : '#17A2B8',
            borderColor         : '#17A2B8',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : volumen
            },
        ]
        }

    var areaChartOptions = {
        maintainAspectRatio : false,
        responsive : true,
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
            gridLines : {
                display : false,
            }
            }],
            yAxes: [{
            gridLines : {
                display : false,
            }
            }]
        }
    }
    
    
    
    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#gvolumen').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: lineChartData,
        options: lineChartOptions
    });
    
    */

    
}


function GraficaCitasDirector(citas,citasconfi,faltas){

    var cita=[];

    for(var i in citas)
    {
        if(citas[i].citas!=null){
            cita[citas[i].month-1]=citas[i].citas*1;
        }
       
    }

    var citaconfi=[];

    for(var i in citasconfi)
    {
        if(citasconfi[i].citas!=null){
            citaconfi[citasconfi[i].month-1]=citasconfi[i].citas*1;
        }
       
    }

    var falta=[];

    for(var i in faltas)
    {
        if(faltas[i].citas!=null){
            falta[faltas[i].month-1]=faltas[i].citas*1;
        }
       
    }

   
    $('.citas').html('<canvas id="citas" style="min-height: 250px; height: 350px; max-height: 350px; max-width: 100%; display: block; width: 487px;" width="487" height="250" class="chartjs-render-monitor"></canvas>');
    var areaChartData = {
        labels  : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        datasets: [
            {
            label               : 'Citas m³',
            backgroundColor     : 'rgba(60,141,188,0.4)',
            borderColor         : 'rgba(60,141,188,0.8)',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : cita
            },
            {
            label               : 'Asistencia m³',
            backgroundColor     : '#28A745',
            borderColor         : '#28A745',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : citaconfi
            },
            {
            label               : 'Faltas m³',
            backgroundColor     : '#DC3545',
            borderColor         : '#DC3545',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : falta
            },
        ]
        }

    var areaChartOptions = {
        maintainAspectRatio : false,
        responsive : true,
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
            gridLines : {
                display : false,
            }
            }],
            yAxes: [{
            gridLines : {
                display : false,
            }
            }]
        }
        }
    
    
    
    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#citas').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartData.datasets[2].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: lineChartData,
        options: lineChartOptions
    });
    
    

    
}

function GraficasMaterialMes(materiales){

  
   
    $('#citmaterialemes').html('<canvas id="gmateriales" width="400" height="400"></canvas>');
    const material=[];
    const cantidad=[];
    for(var i in materiales){
        material[i]=(materiales[i].material);
        cantidad[i]=(materiales[i].cantidad);
    }
    const data =  {
        labels: material,
        datasets: [{
            label: ['Materiales $'],
            data: cantidad,
            backgroundColor: ['rgba(255, 255, 0)','rgba(255, 204, 0 )','rgba(255, 153, 0 )','rgba(255, 102, 0 )','rgba(255, 51, 0)','rgba(255, 0, 0)','rgba(153, 0, 0 )','rgba(153, 51, 0)','rgba(153, 102, 0)',
            'rgba(153, 153, 0)','rgba(153, 204, 0)','rgba(153, 255, 0 )','rgba(51, 255, 0)','rgba(51, 204, 0)','rgba(51, 153, 0)','rgba(51, 51, 0)','rgba(51, 0, 0)'],
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    };

    const ctx = document.getElementById('gmateriales').getContext('2d');
    var barChartOptions = {
        legend: {
            display: false,
        },
        responsive              : true,
        maintainAspectRatio     : false,
        datasetFill             : false,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
    }
    var myChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: data,
        options: barChartOptions,
        legend: {
            display: false
        },
    
    });
    
    

    
}

function GraficasMaterialMesSEDEMA(materiales){

    console.log(materiales); 
   
    $('#citmaterialemes').html('<canvas id="gmateriales" width="400" height="1500"></canvas>');
    const material=[];
    const cantidad=[];
    const colores=[];
    for(var i in materiales){
        material[i]=(materiales[i].material);
        cantidad[i]=(materiales[i].cantidad);
        colores[i]='rgba('+(Math.floor(Math.random() * 256))+','+(Math.floor(Math.random() * 256))+','+(Math.floor(Math.random() * 256))+')';
    }
    //console.log(colores); 
    const data =  {
        labels: material,
        datasets: [{
            label: ['Materiales m³'],
            data: cantidad,
            backgroundColor: colores,
            //backgroundColor: ['rgba(255, 255, 0)','rgba(255, 204, 0 )','rgba(255, 153, 0 )','rgba(255, 102, 0 )','rgba(255, 51, 0)','rgba(255, 0, 0)','rgba(153, 0, 0 )','rgba(153, 51, 0)','rgba(153, 102, 0)',
            //'rgba(153, 153, 0)','rgba(153, 204, 0)','rgba(153, 255, 0 )','rgba(51, 255, 0)','rgba(51, 204, 0)','rgba(51, 153, 0)','rgba(51, 51, 0)','rgba(51, 0, 0)'],
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    };

    const ctx = document.getElementById('gmateriales').getContext('2d');
    var barChartOptions = {
        legend: {
            display: false,
        },
        responsive              : true,
        maintainAspectRatio     : false,
        datasetFill             : false,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
    }
    var myChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: data,
        options: barChartOptions,
        legend: {
            display: false
        },
    
    });
    
    

    
}


function GraficaContratosDirector(firmados,pendientes){
    var donutData        = {
      labels: [
          'Firmados: $'+firmados,
          'Pendientes: $'+pendientes,
      ],
      datasets: [
        {
          data: [firmados.replaceAll(',',''),pendientes.replaceAll(',','')],
          backgroundColor : ['#28A745', '#DC3545'],
        }
      ]
    }

    var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })

   

}


function Precio(){
    var precio=$("#precio" ).val();
    var cantidad=$('#cantidad').val();
    var subtotal=precio*cantidad;
    $('#subtotal').val(Math.round(subtotal*100)/100);
    var iva=$('#subtotal').val()*$('#iva').val()/100;
    $('#total').val(Math.round((subtotal+iva)*100)/100);
}

function CambiaCondicion(){
    var condicion=$("#condicionmaterial option:selected" ).text();
    $("#condicion" ).html(condicion);
}

function CargaPlantas(){

    var html="";
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/CargaPlantas",
        data:{},
        context: document.body
    }).done(function(data) {
        //console.log(data);
        for(var i in data){
            html+='<li class="nav-item">';
            html+='    <a href="'+Url()+'plantas/'+data[i].id+'" class="nav-link">';
            html+='        <i class="far fa-circle nav-icon"></i>';
            html+='        <p>'+data[i].siglas+'</p>';
            html+='    </a>';
            html+='</li>';
        }

        
    $('#contplantas').html(html);
    });

}


function CargarTipo(_this){
    _this=$(_this);
    if($('#tc'+_this.data('id')).is(":checked")){
        $('#si'+_this.data('id')).val('{"tipo":"'+$('#tc'+_this.data('id')).data('tipo')+'","volumen":"'+$('#v'+_this.data('id')).val()+'"}');
        
        $('#v'+_this.data('id')).data('invalido',false);
        $('#v'+_this.data('id')).prop('disabled',false);
        
    }else{
        $('#si'+_this.data('id')).val('');
        
        $('#v'+_this.data('id')).data('invalido',true);
        $('#v'+_this.data('id')).val('');
        $('#v'+_this.data('id')).prop('disabled',true);
    }
    VolumenTotal();
    
}



function CargarSubtipo(_this){
    _this=$(_this);
    if(_this.is(":checked")){
        $('#s'+_this.data('id')).val('{"subtipo":"'+_this.data('subtipo')+'"}');
    }else{
        $('#s'+_this.data('id')).val('');
    }
    
}

function VolumenTotal(){
    var total = 0 ;
    
    $('.volumen').each(function(index){ 
        total+=$('#v'+index).val()*1;
    });
    $('#cantidadobra').val(total);
}

function LlenarTipoObra(tipoobra){
    //console.log(tipoobra);
    $('.tipo').each(function(index){          
        if(tipoobra.tipo==$(this).data('tipo')){                
            $('#v'+index).val(tipoobra.volumen);
            $(this).click();
        }
    });
}
function LlenarSubtipoObra(subtipoobra){
$('.subtipo').each(function(index){
    if(subtipoobra.subtipo==$(this).data('subtipo')){
        console.log($(this).data('subtipo'));
        $(this).click();
    }
});       
}

function HabilitarDeshabilitar(id,option){
    if(confirm(option==1 ? 'Quiere deshabilitar la obra?' : 'Quiere habilitar la obra?')){
        $.ajax({
        
            headers: { "APP-KEY": AppKey() },
            method:'post',
            url: Url()+"api/HabilitarDeshabilitar",
            data:{id:id,option:option},
            context: document.body
        }).done(function(data) {
            location.reload();
     
        });
    }

    
}

function CargarFoto(orden,base64){
    var id=$('#id').val();
    if(base64!=''){
        var fotopart=base64.match(/.{1,500000}/g);
        var index=0;
        var listo=0;
        while(index<fotopart.length){
            if(index==fotopart.length-1){
                listo=1;
            }
            var data={id:id,foto:fotopart[index],orden:orden,index:index,listo:listo};
            console.log(data);
            $.ajax({
        
                headers: { "APP-KEY": AppKey() },
                async:false,
                method:'post',
                url:  Url()+"api/CargarFotoProducto",
                data:data
            }).done(function(data) {
                console.log(data);
                index++;
            }).fail(function() {
                console.log( "error" );
                index++;
                
            });
        }
    }
   
}

function BorrarProductoFoto(orden){
    var id=$('#id').val();
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        async:false,
        method:'post',
        url:  Url()+"api/BorrarProductoFoto",
        data:{id:id,orden:orden}
    }).done(function(data) {//https://cdn.pixabay.com/photo/2017/01/25/17/35/picture-2008484_960_720.png
        console.log(data);
        $('#borrar'+orden).hide();
        $('#imagen'+orden).hide();
        $('#imagent'+orden).show();
    }).fail(function() {
        console.log( "error" );
        
        
    });
}


function GetVehiculoInfo(_this){
    _this=$(_this);
    var matricula=$('#'+_this.attr('id')).val();
    console.log(matricula);
    
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/GetVehiculoInfo",
        data:{matricula:matricula},
        context: document.body
    }).done(function(vehiculo) {
        console.log(vehiculo);
        $('#vehi').val(vehiculo.vehiculo);
        $('#marca').val(vehiculo.marca);
        $('#combustible').val(vehiculo.combustible);
        $('#modelo').val(vehiculo.modelo);
        $('#detalle').val(vehiculo.detalle);

        
    });
}



function TodosMateriale(_this){
    if($(_this).is(':checked')){
        $(".mat").each(function(){            
            $(this).show();
        });
    }else{
        $(".mat").each(function(){  
            if(($(this).data('cantidad')*1)==0)          
            $(this).hide();
        });

    }
}

function ActivarPlanta(_this){
    _this=$(_this);
    var checked=_this.prop("checked") ? 1 : 0;
    var id_planta=_this.data('id_planta');
    var id_usuario=_this.data('id_usuario');
    
    var data={id_usuario:id_usuario,id_planta:id_planta,checked:checked};
    console.log(data);
    $.ajax({
            
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/ActivarPlanta",
        data:{id_usuario:id_usuario,id_planta:id_planta,checked:checked},
        context: document.body
    }).done(function(data) {
        if(data!=1){
            _this.prop('checked', false);
        }
        
    }).fail(function() {
        _this.prop('checked', false);
        
        
    });
}


function CargarComprobante(_this){
    $('#pidcom').val($(_this).data('pid'));
}

function EnviarCodigo(_this){
    if(!confirm('¿El número de teléfono es correcto?. Se enviará un código de verificación al teléfono.')){
        return;
    }
    var telefono=$('#telefono').val();
    var confirmacion=$('#confirmacion');    
    if(telefono.length!= 10){
        alert('El numero debe ser de 10 digitos.');
        return;
    }
    
    BloquearT(_this);
    var data={telefono:telefono};
    $.ajax({
            
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/EnviarCodigo",
        data:data,
        context: document.body
    }).done(function(data) {
       
        console.log(data);
        if (data==3){
            alert('El teléfono ya fue registrado anteriormente');
        }
        if(data==1){
            alert('Se ha enviado un mensajes al numero con el codigo de verificación.');
        }
    }).fail(function(xhr, status, error) {
        console.log(error);
        
    });
}


function GetDatosObra(_this){

    var id=$(_this).val();

    console.log(id);
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/GetDatosObra",
        data:{id:id},
        context: document.body
    }).done(function(data) {
        console.log(data.razonsocial);
        $('#obra').val(data.obra);
        $('#razonsocial').val(data.razonsocial);
        $('#repre').val(data.repre);
        $('#calle').val(data.calle);
        $('#numeroext').val(data.numeroext);
        $('#numeroint').val(data.numeroint);
        $('#colonia').val(data.colonia);
        $('#municipio').val(data.municipio);
        $('#entidad').val(data.entidad);
        $('#fechainicio').val(data.fechainicio);
        $('#fechafin').val(data.fechafin);
    });
}


function EnviarCorreoPRC(id){
    window.open(
        Url()+'PolizaRC/'+id,
        '_blank' // <- This is what makes it open in a new window.
      );
}

function EnviarCorreoRC(_this){
    var id=$(_this).data('id');
    console.log(id);
    $(_this).attr('disabled','disabled');
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/EnviarCorreoRC",
        data:{id:id},
        context: document.body,
        dataType: 'json'
    }).done(function(data) {
        console.log(data);
        if(data){ 
            alert("Correo Enviado.");    
        }else{
            alert("Error de server.");    
        }

        $(_this).removeAttr('disabled');
    }).fail( function() {

        alert( 'Error!!' );
        $(_this).removeAttr('disabled');
    
    });
}


function GetObrasPagosFin(_this){
    _this=$(_this);
    
    $('#pnombre').val('');
    $('#pplanta').val('');
    $('#pdireccion').val('');
    $('#pcp').val('');
    $('#pmunicipio').val('');
    $('#pentidad').val('');


    var generador= _this.data('generador');

    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/GetObrasPagosFin",
        data:{generador:generador},
        context: document.body,
        dataType: 'json'
    }).done(function(data) {

        var html='<option value="0">--Obra--</option>';
        for( var i in data){
            html+='<option value="'+data[i].id+'" title="'+data[i].obra+'" data-planta="'+data[i].planta+'">'+data[i].obra+'</option>';
        }
        $('#pobra').html(html);
    }).fail( function() {

        alert( 'Error!!' );
        $(_this).removeAttr('disabled');
    
    });
}


var disponible=0;
  function CargarDatosRemision(_this){
    _this=$(_this);
    disponible=_this.data('disponible')*1;
    $('#remisionform').attr('action',Url()+'GenerarRemision/'+_this.data('id'));
    $('#orden').html((_this.data('orden')+1)+'/');
    $('#producto').html('<b>'+_this.data('producto')+'</b>');
    $('#descripcion').html(_this.data('descripcion'));
    $('#disponible').val(_this.data('disponible'));
    $('#unidades').html(_this.data('unidades'));
    $('#unidades2').html(_this.data('unidades'));
  }

  function CalcularDisponible(_this){
    _this=$(_this);
    var total = disponible-_this.val();
    if(total<0){
      $(_this).addClass('is-invalid');
      $(_this).removeClass('is-valid');
       $('.aceptar').prop( "disabled", true );
    }else if(_this.val()==0) {
      $(_this).addClass('is-invalid');
      $(_this).removeClass('is-valid');
      $('.aceptar').prop( "disabled", true );
      
    }else{
      $(_this).addClass('is-valid');
      $(_this).removeClass('is-invalid');
      $('.aceptar').prop( "disabled", false );
    }
    $('#disponible').val(total);
  }


function EnviaCorreoGenerador(id){
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/EnviaCorreoGenerador",
        data:{id:id},
        context: document.body,
        dataType: 'text'
    }).done(function(data) {
        console.log(data);
       
    }).fail(function( jqXHR, textStatus, errorThrown ) {
        console.log( jqXHR+' '+textStatus+' '+errorThrown);
    });
}



function EnviaCorreoObraNueva(id){
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/EnviaCorreoObraNueva",
        data:{id:id},
        context: document.body,
        dataType: 'text'
    }).done(function(data) {
        console.log(data);
       
    }).fail(function( jqXHR, textStatus, errorThrown ) {
        console.log( jqXHR+' '+textStatus+' '+errorThrown);
    });
}


function MailRecuperar(mail){
    $.ajax({
        
        headers: { "APP-KEY": AppKey() },
        method:'post',
        url: Url()+"api/MailRecuperar",
        data:{mail:mail},
        context: document.body,
        dataType: 'text'
    }).done(function(data) {
        console.log(data);
       
    }).fail(function( jqXHR, textStatus, errorThrown ) {
        console.log( jqXHR+' '+textStatus+' '+errorThrown);
    });
}