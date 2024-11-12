<?php
// Incluye el archivo de conexión a la base de datos
include 'conexion.php';

// Establece la cabecera HTML
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, maximum-scale=1">
<title>MULTISERVICIOS DE COMPRESORES TORNE PISTON, C.A.</title>
<link rel="icon" href="favicon.png" type="image/png">
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="js/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
<link href="css/style.css" rel="stylesheet" type="text/css"> 
<link href="css/font-awesome.css" rel="stylesheet" type="text/css"> 
<link href="css/animate.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<header id="header_wrapper">
    <div class="container">
        <div class="header_box">
            <div class="logo">
                <a href="index.php">
                    <img src="img/logo.png" alt="logo">
                </a>
            </div>
            <nav class="navbar navbar-inverse" role="navigation">
                <div class="navbar-header">
                    <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav"> 
                        <span class="sr-only">Toggle navigation</span> 
                        <span class="icon-bar"></span> 
                        <span class="icon-bar"></span> 
                        <span class="icon-bar"></span> 
                    </button>
                </div>
                <div id="main-nav" class="collapse navbar-collapse navStyle">
                <ul class="nav navbar-nav" id="mainNav">
                <li class="active"><a href="#hero_section" class="scroll-link" style="font-size: 10;">Inicio</a></li>
                <li><a href="index.php#aboutUs" class="scroll-link" style="font-size: 10;">Sobre nosotros</a></li>
                <li><a href="servicios_section.php" class="scroll-link" style="font-size: 10;">Servicios</a></li>
                <li><a href="index.php#map-section" class="scroll-link" style="font-size: 10;">Ubicación</a></li>
                <li><a href="index.php#team" class="scroll-link" style="font-size: 10;">Equipo</a></li>
                <li><a href="index.php#contact" class="scroll-link" style="font-size: 10;">Contacto</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="font-size: 10;">
                        Consultor <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="proveedor/Masterlogin.php" class="scroll-link" style="color: rgb(0, 0, 0); text-decoration: none;">Iniciar Sesión</a></li>
                      <li><a href="Registro/Registro.html" class="scroll-link" style="color: black; text-decoration: none;">Registro</a></li>                      
                    </ul>
                </li>
            </ul>
                </div>
            </nav>       
        </div>
    </div>
</header>

<!--Service-->
<section id="service">
  <div class="container">
    <h2><strong>Servicios</strong></h2>
    <div class="service_wrapper">
      <!-- Primera fila de servicios -->
      <div class="row">
        <?php
        // Consulta para obtener los servicios
        $sql = "SELECT nombre, descripcion, icono FROM servicios"; // Ajusta los nombres de las columnas según tu base de datos
        $result = $conn->query($sql);
        
        // Verifica si hay resultados y genera los bloques de servicio
        if ($result->num_rows > 0) {
            $count = 0; // Contador para las filas
            while ($row = $result->fetch_assoc()) {
                // Inicia una nueva fila cada 3 servicios
                if ($count % 3 == 0 && $count > 0) {
                    echo '</div><div class="row">'; // Cierra la fila anterior y abre una nueva
                }
                echo '<div class="col-lg-4">';
                echo '  <div class="service_block">';
                echo '    <div class="service_icon delay-03s animated wow zoomIn">';
                echo '      <span><i class="fa ' . htmlspecialchars($row['icono']) . '"></i></span>'; // Asegúrate de que icono contenga las clases de FontAwesome
                echo '    </div>';
                echo '    <h3 class="animated fadeInUp wow">' . htmlspecialchars($row['nombre']) . '</h3>';
                echo '    <p class="animated fadeInDown wow">' . htmlspecialchars($row['descripcion']) . '</p>';
                echo '  </div>';
                echo '</div>';
                $count++;
            }
        } else {
            echo '<p>No se encontraron servicios.</p>';
        }

        // Cierra la conexión
        $conn->close();
        ?>
      </div> <!-- Fin de la última fila -->
    </div>
  </div>
</section>
<!--Service-->
<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-scrolltofixed.js"></script>
<script type="text/javascript" src="js/jquery.nav.js"></script> 
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.isotope.js"></script>
<script src="js/fancybox/jquery.fancybox.pack.js" type="text/javascript"></script> 
<script type="text/javascript" src="js/wow.js"></script> 
<script type="text/javascript" src="js/custom.js"></script>

</body>
</html>
