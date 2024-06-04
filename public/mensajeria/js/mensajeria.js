
function AbrirComposer(){
    $('.divcomposer').animate({height:(window.innerHeight*.9)},300);
    $('#card-composer').animate({height:(window.innerHeight*.9)},0);
    var tamaxotext=(window.innerHeight*.9)-$('#grupo1').height()-$('#grupo2').height()-$('#grupo4').height()-100;
    $('#grupo3').css('height', tamaxotext);    
}

function CerrarBuscarClientes(){ 
    $('#clientes').removeClass('show');
    $('.dropdown').removeClass('show');
     
}

function AbrirBuscarClientes(){ 
    $('#clientes').addClass('show');
    $('.dropdown').addClass('show');
     
}


function CerrarComposer(){
    $('.divcomposer').animate({height:0},600);
}

function BuscarClientes(_this){
    var nombres=$(_this).val(),html="";
    console.log(nombres);  
    $.ajax({
        method:'post',
        url: "api/Clientes",
        data:{nombres:nombres},
        context: document.body
    }).done(function(clientes) {
        console.log(clientes);      
        AbrirBuscarClientes();
        for(var i in clientes){
            html+='<a class="dropdown-item" onclick="CerrarBuscarClientes();AgregarCliente(this);" href="#" data-id="'+clientes[i].id+'">'+clientes[i].nombres+''+clientes[i].apellidos+'</a>';                
        }

        
 
        $('#clientes').html(html);
    });
}

function AgregarCliente(_this){
    $('#to').val($(_this).html());
    $('#to').data('id',$(_this).data('id'));
}