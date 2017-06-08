<?php include VIEWSPATH . DS .'admin'. DS .'includes'. DS .'section-top.php'; ?>

<section class="content-header no-index">
    <div class="info-box p-rel">
    	<span class="info-box-icon"><i class="fa fa-book"></i></span>
    	<div class="info-box-content">
          	<h2 class="info-box-text"><b>Panel de Administracion de Categorias</b></h2>
          	<span class="info-box-number">A continuación podra gestionar las categorias existentes o agregar nuevas</span>
        </div>
    </div>
</section>
<section class="content">
	<!-- Your Page Content Here -->
	<div class="box box-danger">
		<div class="box-header with-border text-center">
			<h3 class="box-title"><b>Listado de documentos</b></h3>
		</div>
		<div class="box-body">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Categoria</th>
						<th>Subcategoria</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php  
						if (!empty($categorias)) {
							foreach ($categorias as $c) {
								foreach ($c->getSubCategorias() as $sub) {
									print('
										<tr>
											<td>'.$c->getNombre().'</td>
											<td>'.$sub[1].'</td>
											<td style="width:30px;" class="text-center"><button id="btn-delete-categorias" data-id="'.$sub[0].'" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>
										</tr>');
								}
							}
						}

					?>
				</tbody>
			</table>
		</div>
	</div>
</section>
<!-- Modal cargar archivos -->
<div class="modal fade modal-danger" id="modal-categorias" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Formulario para cargar documentos</h4>
      </div>
       	<form method="post" enctype="multipart/form-data" id="form-save-subcat">
	       	<input type="hidden" name="id_cat" value="">
      		<div class="modal-body">
  				<div class="form-group">
                  	<label for="titulo">Nueva subcategoria</label>
                  	<select name="id_categoria" id="" class="form-control">
                  		<?php 
                  			foreach ($categorias as $val) {
                  				print('<option value="'.$val->getId().'">'.$val->getNombre().'</option>');                  				
                  			}
                  		?>
                  	</select>
                </div>
  				<div class="form-group">
                  	<label for="titulo">Nueva subcategoria</label>
                  	<input type="text" class="form-control" name="sub_categoria" placeholder="Subcategoria">
                </div>
      		</div>
      		<div class="modal-footer">
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        	<button type="button" class="btn btn-primary" id="btn-subcategoria-save">Cargar Documento</button>
	      	</div>
  		</form>	      	
    </div>
  </div>
</div>
<!-- BTN floating modal -->
<button class="btn btn-danger btn-fixed" data-toggle="modal" data-target="#modal-categorias"><i class="fa fa-upload"></i></button>

<?php include VIEWSPATH . DS .'admin'. DS .'includes'. DS .'section-footer.php'; ?>