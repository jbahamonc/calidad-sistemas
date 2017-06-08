<!DOCTYPE html>
<html lang="es">
<head>
    <!--Metaetiqueta para el uso del conjunto de caracteres adecuado-->
    <meta charset="utf-8">
    <!--Metaetiqueta para corregir compatibilidad con navegador Microsft-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--Metaetiqueta para la correcta visualización en dispositivos moviles-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0">
    <title>Portal de Calidad | Programa Ingenieria de Sistemas</title>
    <!--Añada primero el estilo de la libreria (ufps.css o ufps.min.css) y luego sus estilos propios-->
    <link rel="stylesheet" href="../resource/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../resource/css/AdminLTE.min.css" >
    <link rel="stylesheet" href="../resource/css/font-awesome.min.css">
    <link rel="stylesheet" href="../resource/css/main.css">
    <!--Librerías para compatibilidad con versiones antiguas de Internet Explorer-->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body style="background-color: #ecf0f5;">
    <header>
        <div id="barra-superior" class="bg-red-ufps">
            <div class="blog-topbar">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-7 col-xs-7">
                            <ul class="topbar-list topbar-menu">
                                <li><a href="/universidad/perfiles/aspirantes/952"><i class="fa fa-users"></i> Aspirantes</a></li>
                                <li><a href="/universidad/perfiles/estudiantes/953"><i class="fa fa-user"></i> Estudiantes</a></li>
                                <li><a href="/universidad/perfiles/egresados/954"><i class="fa fa-graduation-cap"></i> Graduados</a></li>
                                <li><a href="https://docentes.ufps.edu.co/"><i class="fa fa-user-secret"></i> Docentes</a></li>
                                <li><a href="http://nomina.ufps.edu.co:9191/nominaufps"><i class="fa fa-briefcase"></i> Administrativos</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-5">
                            <ul class="topbar-list topbar-menu pull-right">
                                <li><a href="../login/"><i class="fa fa-sign-in"></i> Login</a></li>
                            </ul>
                        </div>
                    </div><!--/end row-->
                </div><!--/end container-->
            </div>
            <!-- End Topbar blog -->
        </div>
        <div class="bg-img-ufps">
            <div class="parallax">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-5">
                        <a href="../">
                            <img id="logo-header" src="../resource/img/logo_sistemas_top.png" alt="Logo Programa de Ingeniería de Sistemas" style="max-height:180px;">
                        </a>
                    </div>
                    <div class="col-md-2 col-ms-1 col-xs-2 pull-right">
                        <a href="http://www.ufps.edu.co/">
                            <img class="header-banner" src="../resource/img/logo_ufps.png" style="max-height:160px;" alt="Escudo de la Universidad Francisco de Paula Santander"></a>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar bg-nav-ufps">
            <div class="container">
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="../home/">Inicio </a></li> 
                        <?php if (!empty($categorias)) {
                            foreach ($categorias as $cat) { ?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php print($cat->getNombre()) ?><span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                <?php $subcat = $cat->getSubCategorias();
                                foreach ($subcat as $sub) { ?>
                                    <li><a href="../view/<?php print(str_replace(" ", "_", strtolower($sub[1]))); ?>/<?php print($sub[0]) ?>"><?php print($sub[1]) ?> </a></li>
                                    <li class="divider"></li>
                                <?php } ?>
                                    </ul>
                                </li>
                        <?php }}?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container">
        	algo sobre la pagina principal
        	
        </div>
    </main>
	<footer>
    <div class="footer-cont">
        <div class="container">
            <div class="row">
                <!-- About -->
                <div class="col-md-3 col-sm-4 md-margin-bottom-40">
                  <div class="footer-main">
                    <a href="http://ingsistemas@ufps.edu.co"><img width="200" id="logo-footer" class="img-responsive" src="../resource/img/logo_ingsistemas_vertical_invertido.png" alt="Logo Pie de Página"></a>
                  </div>
                </div><!--/col-md-3-->
                <!-- End About -->
                <!-- Latest -->
            <div class="col-md-3 col-sm-4 md-margin-bottom-40">
              <div class="posts">
                <div class="headline"><h2>Visitantes</h2></div>
                <ul class="list-unstyled latest-list">
                  <li style="color:#fff">
                    Hoy: 152                  </li>
                  <li style="color:#fff">
                    Último mes: 4.273                  </li>
                  <li style="color:#fff">
                    Desde el principio: 18.084                  </li>
                </ul>
              </div>
            </div><!--/col-md-3-->
            <!-- End Latest -->
            <!-- Link List -->
            <div class="col-md-3 col-sm-4  md-margin-bottom-40">
              <div class="headline"><h2>Enlaces de Interés</h2></div>
              <ul class="list-unstyled latest-list">
                <li><a href="javascript:;">Sitio Web-Departamento de Sistemas</a></li>
                <li><a href="http://biblioteca.ufps.edu.co" target="_blank">Biblioteca Eduardo Cote Lamus</a></li>
                <li><a href="http://200.93.148.47/bienestar/" target="_blank">Vicerrectoría de Bienestar Universitario</a></li>
                <li><a href="./index.php?id=27">Cronograma del Comité Curricular</a></li>
                <li><a href="http://php.net/" target="_blank">Recursos PHP</a></li>
                <li><a href="https://www.facebook.com/IngSistUFPS/?fref=ts">Facebook</a></li>
                <li><a href="http://200.93.148.29/">Ir a versión Anterior</a></li>
              </ul>
            </div><!--/col-md-3-->
            <!-- End Link List -->
            <!-- Address -->
            <div class="col-md-3 col-sm-4  map-img md-margin-bottom-40">
              <div class="headline" style="border-bottom: #272727;"><h2>Contactos</h2></div>
              <address class="md-margin-bottom-40">
                Programa de Ingeniería de Sistemas de la Universidad Francisco de Paula Santander<br>Acreditación de alta calidad según resolución No. 15757 del Ministerio de Educación Nacional<br>Avenida Gran Colombia No. 12E-96 Barrio Colsag, Cúcuta, Colombia<br>Teléfono (57) 7 5776655 Extensiones 201 y 203<br>Correo electrónico: ingsistemas@ufps.edu.co              </address>
            </div><!--/col-md-3-->
            <!-- End Address -->
          </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                  <p>
                    2016 © All Rights Reserved.
                    Desarrollado por: <a href="#">Jefferson Bahamon - Andres Parra - Wilermer Gelves - Jhon Ibarra</a>
                  </p>
                </div>
                <!-- Social Links -->
                <div class="col-md-4">
                  <ul class="list-inline dark-social pull-right space-bottom-0">
                    <li>
                      <a href="https://www.facebook.com/UFPS-C%C3%BAcuta-553833261409690" target="_blank"><i class="fa fa-facebook" style="color:#fff;"></i></a>
                    </li>
                    <li>
                      <a href="https://twitter.com/UFPSCUCUTA" target="_blank"><i class="fa fa-twitter" style="color:#fff;"></i></a>
                    </li>
                    <li>
                      <a href="https://www.youtube.com/channel/UCgPz-qqaAk4lbHfr0XH3k2" target="_blank"><i class="fa fa-youtube" style="color:#fff;"></i></a>
                    </li>
                    <li>
                      <a href="https://www.instagram.com/ufpscucuta/" target="_blank"><i class="fa fa-instagram" style="color:#fff;"></i></a>
                    </li>
                  </ul>
                </div>
                <!-- End Social Links -->
            </div>
        </div>
  </div>
</footer>
<script src="../resource/js/jquery-2.2.3.min.js"></script>
<script src="../resource/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>