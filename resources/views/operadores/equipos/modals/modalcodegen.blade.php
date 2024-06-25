<!-- Modal -->
<div class="modal fade" id="modalcodegen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"> <i class="fa fa-terminal" aria-hidden="true"></i> Generar Código</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @csrf                        
        <div class="form-group">              
          <label for="codent">Código Entrada</label>
          <center><input type="text" class="form-control" id="codent" name="codent"></center>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-check">
              <input class="form-check-input" type="radio" value="1" name="opcion" checked="">
              <label class="form-check-label">Activar Motor</label>
            </div>
          </div>
        
          <div class="col-md-6">
            <div class="form-check">
              <input class="form-check-input" type="radio" value="2" name="opcion" >
              <label class="form-check-label">Chapa</label>
            </div>
          </div>
       
          <div class="col-md-6">
            <div class="form-check">
              <input class="form-check-input" type="radio" value="3" name="opcion" >
              <label class="form-check-label">Reset</label>
            </div>
          </div>
       
          <div class="col-md-6">
            <div class="form-check">
              <input class="form-check-input" type="radio" value="4" name="opcion" >
              <label class="form-check-label">Apertura Chapa</label>
            </div>
          </div>
        
         
        </div>
        <center><h2><b><div id="codsal">-----</div></b></h2></center>
        
      </div>
      <div class="modal-footer">
          <button data-id="0" id="" onclick="GenerarCodigo(this);" class="btn btn-warning btn-block bgenerar" data-id_operador="{{GetId();}}"><i class="fa fa-recycle" aria-hidden="true"><span> Generar</span></i></button>
      </div>
    
    </div>
  </div>
</div>