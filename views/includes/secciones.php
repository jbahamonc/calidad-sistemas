<div class="container-fluid">
    <section class="content-header no-index">
        <div class="info-box">
            <span class="info-box-icon"><i class="fa fa-address-book-o"></i></span>
            <div class="info-box-content">
                <h2 class="info-box-text"><b><?php print($titulo) ?></b></h2>
                <span class="info-box-number"><?php print($desc) ?></span>
            </div>
        </div>
    </section>
    <section class="content secciones">
        <div class="row" style="margin-bottom: 30px;">
            <div class="col-md-7">
            <?php if (!empty($seccion)) { ?>
                <div class="img-section">
                    <img class="img-responsive" src="../../uploads/<?php print($seccion['imagen']); ?>" alt="<?php print($seccion['desc_img']); ?>">
                </div>
                <p><?php print($seccion['texto']); ?></p>
            <?php } else { ?>
                <h3>No hay informacion registrada</h3>
            <?php } ?>
            </div>
            <div class="col-md-5">
                <div class="box box-danger">
                    <div class="box-header text-center with-border">
                        <h3 class="box-title"><b>Listado de Documentos</b></h3>                        
                    </div>
                    <div class="box-body">
                        <?php 
                        if (!empty($docs)) {?>
                        <ul class="products-list product-list-in-box">
                            <?php foreach ($docs as $d) {?>
                            <!-- item -->
                            <li class="item">
                                <div class="product-img">
                                    <img src="../../resource/img/docs.svg" alt="Product Image">
                                </div>
                                <div class="product-info">
                                    <p class="product-title text-red no-margin"><?php print($d['titulo']) ?>
                                        <a href="../../uploads/documentos/<?php print($d['documento']) ?>" class="btn btn-danger btn-sm pull-right"><i class="fa fa-download"></i></a>
                                    </p>
                                    <span class="product-description"><?php print($d['descripcion']) ?></span>
                                </div>
                            </li>
                            <!-- /.item -->
                            <?php } ?>
                        </ul>
                        <?php } else {?>
                            <h3 class="text-center">No hay documentos cargados</h3>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>            
    </section>
</div>



