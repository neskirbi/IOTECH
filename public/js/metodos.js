function EscalaVerdes(){
    return ['#7AFE76','#6FF171','#65DA65','#59C359','#50AF52','#489C47','#338D33','#2C7D2E','#2A6F2C','#43F59D','#3FE795','#39CD84'];
}

function EscalaRojos(){
    return ['#FF9056','#FE783F','#F5692B','#DB5E2A','#C75422','#B04D1E','#9F4118','#8F3C16','#813717','#FEC652','#FFB330','#F99F1E'];
}
function Url(){
    if(window.location.origin.includes('localhost') || window.location.origin.includes('192.168')){
        return window.location.origin+'/iotech/public/';
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