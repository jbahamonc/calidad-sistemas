<?php include VIEWSPATH . DS .'admin'. DS .'includes'. DS .'section-top.php'; ?>

<section class="content-header no-index">
    <div class="info-box p-rel">
    	<span class="info-box-icon"><i class="fa fa-user-circle-o"></i></span>
    	<div class="info-box-content">
          	<h2 class="info-box-text"><b>Gestión de Recursos</b></h2>
          	<span class="info-box-number">A continuación podra ver el listado de todo el personal registrado en el sistema</span>
        </div>
        
    </div>
</section>
<!-- Main content -->
<section class="content">
<!-- Your Page Content Here -->
<div class="box box-widget">
    <div class="box-header with-border">
      	<h3 class="box-title"><b>Listado de Personal</b></h3>
    </div><!-- /.box-header -->
    <div class="box-body">
    	<!-- box teacher -->            
        <?php 
        $data = json_decode($personal);
        if (!empty($data)) {
            foreach ($data as $per) {?>
              	<div class="col-md-4" id="<?php print("person-".$per->id) ?>">
                  <!-- Widget: user widget style 1 -->
                  <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-red"></div>
                    <div class="widget-user-image">
                      <img class="img-circle" src="../../uploads/personal/avatar/<?php print($per->imagen) ?>" alt="User Avatar">
                    </div>
                    <div class="box-footer">
                      	<div class="">		              		
        		            <h4 class="widget-user-username text-center"><b><?php print($per->nombre." ".$per->apellidos) ?></b></h4>
        		            <h5 class="widget-user-desc text-center"><?php print($per->cargo) ?></h5>
                      	</div>
                      	<div>
                      		<ul class="list-group data-teacher" style="list-style: none;">
                      			<li>
        							<div class="icon-list-data">
        								<i class="fa fa-address-card-o"></i>
        							</div>
                      				<div class="list-content">
                      					<h4 class="no-margin"><b>Indentificación</b></h4>
                      					<span><?php print(number_format($per->identificacion)) ?></span>
                      				</div>
                      			</li>		              				
                      			<li>
        							<div class="icon-list-data">
        								<i class="fa fa-volume-control-phone"></i>
        							</div>
                      				<div class="list-content">
                      					<h4 class="no-margin"><b>Telefono</b></h4>
                      					<span><?php print($per->telefono) ?></span>
                      				</div>
                      			</li>
                      			<li>
        							<div class="icon-list-data">
        								<i class="fa fa-envelope-o"></i>
        							</div>
                      				<div class="list-content">
                      					<h4 class="no-margin"><b>Email</b></h4>
                      					<span><?php print($per->email) ?></span>
                      				</div>
                      			</li>
                      		</ul>
                      	</div>
                      	<div class="text-center">
                      		<a href="#" class="btn btn-danger btn-sm btn-delete-person" data-id="<?php print($per->id) ?>"><i class="fa fa-trash"></i></a>
                      		<a href="../../personal/info/<?php print($per->id) ?>" class="btn btn-danger btn-sm"><i class="fa fa-eye"></i></a>
                      	</div>
                      	<!-- /.row -->
                    </div>
                  </div>
                  <!-- /.widget-user -->
                </div>
            <?php } ?>
        <?php } else {?>
            <h3 class="text-center">No hay personal registrado</h3>
        <?php } ?>
        <!-- /.box teacher -->
    </div><!-- /.box-body -->
</div>    	
</section>
<!-- /.content -->
<!-- Modal register person -->
<div class="modal fade modal-danger" id="add-person-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Formulario de Registro de Personal</h4>
          </div>
          <div class="modal-body">
           		<form class="form-horizontal" type="post" enctype="multipart/form-data" id="form-person">
                    <input type="hidden" name="MAX_FILE_SIZE" value="5000000">
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Identificación</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="id" placeholder="Identificación">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">Nombre</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="nombre" placeholder="Nombre">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Apellidos</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="apellidos" placeholder="Apellidos">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Telefono</label>
                        <div class="col-sm-10">
                          <input type="tel" class="form-control" name="telefono" placeholder="Telefono">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputSkills" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" name="email" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputSkills" class="col-sm-2 control-label">Cargo</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="cargo" placeholder="Cargo">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputSkills" class="col-sm-2 control-label">Dirección Laboral</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="dir_lab" placeholder="Direccion laboral">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">URL CV</label>
                        <div class="col-sm-10">
                            <input type="url" class="form-control" name="url" placeholder="URL CV-LAC">   
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Imagen</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control btn btn-danger" name="avatar">               
                        </div>
                      </div>
                    </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="btn-save-person">Guardar Información</button>
          </div>
        </div>
    </div>
</div>
<!-- BTN floating modal -->
<a href="../../actores/show/" class="btn btn-danger pull-right btn-fixed add-person"><i class="fa fa-plus" style="vertical-align: bottom;"></i></a>

<?php include VIEWSPATH . DS .'admin'. DS .'includes'. DS .'section-footer.php'; ?>