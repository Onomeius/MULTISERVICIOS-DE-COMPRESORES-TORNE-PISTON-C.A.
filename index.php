<?php
// Configura la conexión a la base de datos
$host = "localhost";
$usuario = "root";
$password = "";
$base_de_datos = "compresores_bd";

$conn = new mysqli($host, $usuario, $password, $base_de_datos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


// Consulta para obtener los datos del equipo
$sql = "SELECT nombre_equipo, foto_equipo, cargo FROM equipos";
$result = $conn->query($sql);

// Generar HTML dinámicamente
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
<style>#team {
    background-color: #f8f9fa; /* Fondo claro */
    padding: 60px 0; /* Espaciado arriba y abajo */
}

#team h2 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 2.5rem; /* Tamaño de fuente */
    color: #333; /* Color del texto */
}

.team_wrapper {
    display: flex;
    flex-wrap: wrap; /* Permitir que los elementos se envuelvan */
    justify-content: center; /* Centrar elementos */
}

.team_member {
    background: #fff; /* Fondo blanco para cada miembro */
    border: 1px solid #ddd; /* Borde ligero */
    border-radius: 10px; /* Bordes redondeados */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra */
    text-align: center; /* Centrar texto */
    margin: 15px; /* Espaciado entre miembros */
    padding: 20px; /* Espaciado interno */
    transition: transform 0.3s; /* Transición suave */
}

.team_member img {
    width: 100%; /* Imagen ocupando todo el ancho */
    border-radius: 10px; /* Bordes redondeados para la imagen */
    height: auto; /* Mantener la proporción */
}

.team_member h3 {
    margin: 15px 0 10px; /* Margen superior e inferior */
    font-size: 1.5rem; /* Tamaño de fuente para nombre */
    color: #007bff; /* Color del nombre */
}

.team_member p {
    font-size: 1rem; /* Tamaño de fuente para cargo */
    color: #666; /* Color del texto del cargo */
}

.team_member:hover {
    transform: scale(1.05); /* Aumentar ligeramente en hover */
}

/* Responsivo para dispositivos móviles */
@media (max-width: 768px) {
    .team_member {
        margin: 10px; /* Menor margen en pantallas pequeñas */
    }

    #team h2 {
        font-size: 2rem; /* Tamaño de fuente más pequeño en pantallas pequeñas */
    }
}

#faq {
    padding: 60px 0;
    background-color: #f8f9fa;
}

#faq h2 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 2.5rem; /* Tamaño de fuente */
    color: #333; /* Color del texto */
}

.faq-wrapper {
    max-width: 800px; /* Ancho máximo */
    margin: 0 auto; /* Centrar */
}

.faq-item {
    background: #fff; /* Fondo blanco */
    border: 1px solid #ddd; /* Borde ligero */
    border-radius: 5px; /* Bordes redondeados */
    margin-bottom: 15px; /* Margen inferior */
    padding: 15px; /* Espaciado interno */
    transition: background-color 0.3s; /* Transición suave */
}

.faq-item:hover {
    background-color: #f1f1f1; /* Fondo gris claro al pasar el mouse */
}

.faq-item h4 {
    cursor: pointer; /* Indicar que es clickeable */
    margin: 0; /* Sin margen */
}

/* Responsivo para dispositivos móviles */
@media (max-width: 768px) {
    .team_member {
        margin: 10px; /* Menor margen en pantallas pequeñas */
    }

    #team h2, #faq h2 {
        font-size: 2rem; /* Tamaño de fuente más pequeño en pantallas pequeñas */
    }
}
</style>

 
<!--[if lt IE 9]>
    <script src="js/respond-1.1.0.min.js"></script>
    <script src="js/html5shiv.js"></script>
    <script src="js/html5element.js"></script>
<![endif]-->
 
</head>
<body>

<!--Header_section-->
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
                <li><a href="#aboutUs" class="scroll-link" style="font-size: 10;">Sobre nosotros</a></li>
                <li><a href="servicios_section.php" class="scroll-link" style="font-size: 10;">Servicios</a></li>
                <li><a href="#map-section" class="scroll-link" style="font-size: 10;">Ubicación</a></li>
                <li><a href="#team" class="scroll-link" style="font-size: 10;">Equipo</a></li>
                <li><a href="#contact" class="scroll-link" style="font-size: 10;">Contacto</a></li>
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
<!--Header_section--> 

<!--Hero_Section-->
<section id="hero_section" class="top_cont_outer">
  <div class="hero_wrapper">
    <div class="container">
      <div class="hero_section">
        <div class="row">
          <div class="col-md-12">
            <div class="top_left_cont zoomIn wow animated"> 
              <br></br>  
              <h2>
                MULTISERVICIOS DE <strong>COMPRESORES TORNE PISTON, C.A.</strong>
              </h2>
              <p class="slogan">
                <strong>Mantenimiento eficiente para un ambiente óptimo.</strong><br/>
                Cuidamos tu frío, aseguramos tu éxito.
              </p>   
            </div>
          </div> 
        </div>
      </div>
    </div>
  </div>
</section>

<!--Hero_Section--> 

<section id="aboutUs"><!--Aboutus-->
<div class="inner_wrapper aboutUs-container fadeInLeft animated wow">
  <div class="container">
    <h2><strong>Sobre nosotros</strong></h2>
    <div class="inner_section">
 
	  <div class="row">
						<div class="col-lg-12 about-us">
							<div class="row">
								<div class="col-md-6">
									<h3>Lorem Ipsum is simply dummy</h3>
									<p>
                    Ser una empresa líder en soluciones de gestión de mantenimiento, liderizada por nuestra calidad de servicios y amplio sentido de responsabilidad. 
									</p>
									<ul class="about-us-list">
										<li class="points">Soluciones oportunas y acertadas en mantenimiento para pequeñas y grandes empresas.</li>
										<li class="points">Ahorros en adiestramiento y formación de personal, ya que se cuenta con el personal calificado para realizar dichos trabajos.</li>
										<li class="points">Incorporación de personal temporal destacado a petición de nuestros clientes.</li>
                                        <li class="points">Precios competitivos en el mercado.</li>
										<li class="points">Trabajo en equipo para asegurar la efectividad y calidad de servicios.</li>
									</ul><!-- /.about-us-list -->
								</div><!-- /.col-md-6 -->
								<div class="col-md-6"></div><!-- /.col-md-6 -->
							</div><!-- /.row -->	
						</div><!-- /.col-lg-12 -->
					</div>
      
    </div>
  </div> 
  </div>
</section>
<!--Aboutus--> 

<script>
  // Script para mostrar y ocultar respuestas
  const faqQuestions = document.querySelectorAll('.faq_question');
  faqQuestions.forEach(question => {
    question.addEventListener('click', () => {
      const answer = question.nextElementSibling;
      answer.style.display = answer.style.display === 'none' || answer.style.display === '' ? 'block' : 'none';
    });
  });
</script>

<!--Service-->

<section class="page_section" id="map-section"><!--page_section-->
  <h2><strong>Ubicación de la Empresa</strong></h2>
  <div class="map-container">
    <iframe 
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3923.523335006417!2d-66.86048547286435!3d10.459347796752635!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8c2a5886e3515c65%3A0x2d45c9a723b1ac8b!2sCentro%20Comercial%20Santa%20In%C3%A9s!5e0!3m2!1ses-419!2sve!4v1728239806948!5m2!1ses-419!2sve" 
      width="100%" 
      height="450" 
      style="border:0;" 
      allowfullscreen="" 
      loading="lazy" 
      referrerpolicy="no-referrer-when-downgrade">
    </iframe>
  </div>
  <div style="margin-top: 20px; text-align: center;">
    <p>SECTOR SANTA INES, CENTRO COMERCIAL SANTA INES, PISO 2 OFICINA 3</p>
  </div>
</section>



<!--client_logos-->

<!-- Team Section -->
<section id="team">
    <div class="container">
        <h2><strong>Nuestro equipo</strong></h2>
        <div class="team_wrapper">
            <div class="row">
                <?php
                if ($result->num_rows > 0) {
                    // Salida de datos de cada fila
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="col-md-4">';
                        echo '    <div class="team_member">';
                        echo '        <img src="' . $row["foto_equipo"] . '" alt="team member">';
                        echo '        <h3>' . $row["nombre_equipo"] . '</h3>';
                        echo '        <p>' . $row["cargo"] . '</p>';
                        echo '    </div>';
                        echo '</div>';
                    }
                } else {
                    echo "No hay miembros del equipo.";
                }
                ?>
            </div>
        </div>
    </div>
</section>


<!--/Team-->
<!-- Sección de Respuestas Rápidas -->
<section id="faq" style="padding: 60px 0; background-color: #f8f9fa;">
  <div class="container">
    <h2 class="text-center"><strong>Respuestas Rápidas</strong></h2>
    <div class="row">
      <div class="col-md-6">
        <div class="faq-item">
          <h4 class="faq-question">¿Qué servicios ofrecen?</h4>
          <p class="faq-answer">Ofrecemos mantenimiento a difusores, servicio técnico de cava cuartos, y mantenimiento de compresores de refrigeración, entre otros.</p>
        </div>
        <div class="faq-item">
          <h4 class="faq-question">¿Cómo puedo contactarlos?</h4>
          <p class="faq-answer">Puedes contactarnos a través de nuestra sección de contacto en la página o enviándonos un correo a contacto@tornepiston.com.</p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="faq-item">
          <h4 class="faq-question">¿Tienen servicio de emergencia?</h4>
          <p class="faq-answer">Sí, contamos con un servicio de emergencia 24/7 para atender cualquier inconveniente que pueda surgir.</p>
        </div>
        <div class="faq-item">
          <h4 class="faq-question">¿Dónde están ubicados?</h4>
          <p class="faq-answer">Estamos ubicados en la ciudad de Caracas, Venezuela. Consulta nuestra sección de ubicación para más detalles.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!--Footer-->
<footer class="footer_wrapper" id="contact">
  <div class="container">
    <section class="page_section contact" id="contact">
      <div class="contact_section">
        <h2 style="color: #333; font-weight: bold; font-size: 2.5rem; text-align: center; margin-bottom: 40px;">Contáctanos</h2>
        <div class="row">
          <div class="col-lg-4">
            <div class="contact_info">
              <div class="detail">
                <h4 style="color: #555; font-size: 1.5rem; margin-bottom: 10px;">Llámanos</h4>
                <p style="color: #777; font-size: 1.2rem;">0243-6714603 / 0414-4505566</p>
              </div>
              <div class="detail">
                <h4 style="color: #555; font-size: 1.5rem; margin-bottom: 10px;">Correo</h4>
                <p style="color: #777; font-size: 1.2rem;">support@sitename.com</p>
              </div>
            </div>
            <ul class="social_links" style="display: flex; gap: 10px; margin-top: 20px;">
              <li class="twitter animated bounceIn wow delay-02s"><a href="javascript:void(0)"><i class="fa fa-twitter" style="color: #1DA1F2; font-size: 1.5rem;"></i></a></li>
              <li class="facebook animated bounceIn wow delay-03s"><a href="javascript:void(0)"><i class="fa fa-facebook" style="color: #4267B2; font-size: 1.5rem;"></i></a></li>
              <li class="pinterest animated bounceIn wow delay-04s"><a href="javascript:void(0)"><i class="fa fa-pinterest" style="color: #E60023; font-size: 1.5rem;"></i></a></li>
              <li class="gplus animated bounceIn wow delay-05s"><a href="javascript:void(0)"><i class="fa fa-google-plus" style="color: #DB4437; font-size: 1.5rem;"></i></a></li>
            </ul>
          </div>

          <div class="col-lg-8 wow fadeInLeft delay-06s">
            <div class="form" style="background: #f9f9f9; padding: 30px; border-radius: 10px; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);">
              <form action="enviar_contacto.php" method="POST">
                <label for="nombre" style="color: #333; font-weight: bold;">Nombre:</label><br>
                <input type="text" id="nombre" name="nombre" required style="width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px; font-size: 1.1rem;"><br>

                <label for="email" style="color: #333; font-weight: bold;">Correo Electrónico:</label><br>
                <input type="email" id="email" name="email" required style="width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px; font-size: 1.1rem;"><br>

                <label for="asunto" style="color: #333; font-weight: bold;">Asunto:</label><br>
                <input type="text" id="asunto" name="asunto" required style="width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px; font-size: 1.1rem;"><br>

                <label for="mensaje" style="color: #333; font-weight: bold;">Mensaje:</label><br>
                <textarea id="mensaje" name="mensaje" rows="4" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; font-size: 1.1rem;"></textarea><br>

                <button type="submit" class="btn btn-primary" style="background-color: #007bff; border: none; padding: 12px 20px; color: white; font-size: 1.1rem; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">Enviar</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="container">
    <div class="footer_bottom" style="text-align: center; padding: 20px 0; color: #555;">
      <span>Copyright © 2024, Template by Pedro Perez C.I: 30.222.901</span>
    </div>
  </div>
</footer>

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