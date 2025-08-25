<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Proyecto MIG</title>

  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

  <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./css/index.css">

  <!-- Scroll suave -->
  <style>
    html {
      scroll-behavior: smooth;
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-body-tertiary sticky">
    <div class="container d-flex justify-content-between align-items-center">

      <!-- Logo y nombre del grupo -->
      <a class="navbar-brand d-flex align-items-center" href="#">
  <img src="assets/logo-negro.png" alt="Logo" width="50" height="50" class="me-2 logo-svg">
  <strong>Grupo MIG</strong>
</a>

      <!-- Botón colapsable para pantallas pequeñas -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menú de navegación y buscador -->
      <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="#">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#servicios">Servicios</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contacto">Contacto</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#accordionSobreNosotros">Sobre nosotros</a>
          </li>
        </ul>

        <!-- Barra de búsqueda -->
        <form class="d-flex" role="search" onsubmit="redireccionarBusqueda(); return false;">
          <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar" id="buscador">
          <button class="nav-link btn p-0" type="submit" style="background: none; border: none;">Buscar</button>
        </form>

        <!-- Botón separado -->
        <a class="nav-link" href="pages/pages_login/login.php">Iniciar como administrador</a>
        <a class="nav-link" href="MIG-dayana/index.php">Iniciar como usuario</a>

      </div>

    </div>
  </nav>

  <!-- Carousel -->
  <div id="carouselExampleCaptions" class="carousel slide">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
        aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
        aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
        aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="assets/imagen1.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h5>Bienvenidos a GRUPO MIG</h5>
          <p>Proveemos soluciones tecnológicas innovadoras.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/imagen2.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h5>Transforma tu negocio</h5>
          <p>Con nuestras herramientas tecnológicas de vanguardia.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/imagen3.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h5>Tu socio estratégico</h5>
          <p>En el camino hacia el éxito.</p>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
      data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
      data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <!-- Servicios -->
  <section id="servicios" class="container my-5">
    <h2 class="text-center mb-4">Nuestros Servicios</h2>
    <div class="row g-4 justify-content-center text-center">
      <div class="col-md-4">
        <div class="card h-100 shadow-sm servicio-card">
          <div class="card-body">
            <h5 class="card-title">Gestión de Productos y Menú</h5>
            <p class="card-text">Administra fácilmente los platos, bebidas o productos del restaurante...</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm servicio-card">
          <div class="card-body">
            <h5 class="card-title">Control de existencias</h5>
            <p class="card-text">Lleva un control preciso de las existencias en tu stock...</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm servicio-card">
          <div class="card-body">
            <h5 class="card-title">Registro de las ventas</h5>
            <p class="card-text">Gestiona tus pedidos y ventas...</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Accordion (Productos) -->
  <section id="productos" class="container mt-5">
    <h2 class="faq-title">Preguntas Frecuentes</h2>
    <br>
    <div class="accordion" id="accordionExample">
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
            aria-expanded="true" aria-controls="collapseOne">
            ¿Qué servicios ofrecemos?
          </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Ofrecemos soluciones tecnológicas, desarrollo web y consultoría IT.
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            ¿Cómo podemos ayudarte?
          </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Ayudamos a las empresas a mejorar sus procesos a través de la automatización y optimización de recursos.
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contacto -->
<section id="contacto" class="container mt-5">
    <h2 class="faq-title">Contacto</h2>
    <form action="controladores/controlador_contacto/enviar_contacto.php" method="POST">
      <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="name" name="nombre" placeholder="Tu nombre" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" id="email" name="correo" placeholder="Tu correo" required>
      </div>
      <div class="mb-3">
        <label for="message" class="form-label">Mensaje</label>
        <textarea class="form-control" id="message" name="mensaje" rows="4" placeholder="Tu mensaje" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
    <br>
    <br>
    <br>

      <!-- Sobre Nosotros -->
  <div class="accordion" id="accordionSobreNosotros">
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Sobre Nosotros
        </button>
      </h2>
      <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionSobreNosotros">
        <div class="accordion-body">
          Somos estudiantes del SENA del Centro de Diseño y Metrología, desarrollando este proyecto POS para restaurantes como parte de nuestro trabajo de grado...
        </div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header" id="headingTwo">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Nuestra Historia
        </button>
      </h2>
      <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionSobreNosotros">
        <div class="accordion-body">
          El proyecto nació de la inquietud por optimizar el servicio en los restaurantes, combinando nuestros conocimientos...
        </div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header" id="headingThree">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Misión y Visión
        </button>
      </h2>
      <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionSobreNosotros">
        <div class="accordion-body">
          <h5>Misión</h5>
          Ofrecer un sistema POS innovador...
          <h5>Visión</h5>
          Convertirnos en referentes en soluciones tecnológicas...
        </div>
      </div>
    </div>
  </div>
  <br>


<section id="nuestro-equipo" class="container mt-5">
  <h2 class="faq-title">Nuestro Equipo</h2>
  <div class="equipo-container">
    <div class="equipo-card">
      <img src="assets/perfiles2.jpg" alt="Arley Culma">
      <h3>Arley Culma</h3>
      <p>Desarrollador</p>
    </div>
    <div class="equipo-card">
      <img src="assets/dayis.jpeg" alt="Dayana Lopez">
      <h3>Dayana Lopez</h3>
      <p>Desarrollador</p>
    </div>
    <div class="equipo-card">
      <img src="assets/perfiles2.jpg" alt="Diego Gutierrez">
      <h3>Diego Gutierrez</h3>
      <p>Desarrollador</p>
    </div>
    <div class="equipo-card">
      <img src="assets/lina.jpeg" alt="Lina Bohorquez">
      <h3>Lina Bohorquez</h3>
      <p>Desarrollador</p>
    </div>
  </div>
</section>


  <br>
  <br>
<section>
  <section class="testimonios-caja">
  <h2 class="faq-title">Testimonios</h2>
  <blockquote>
    <p>"El sistema POS ha revolucionado la manera en que gestionamos nuestro restaurante, simplificando procesos y mejorando la atención al cliente."</p>
    <cite>— Cliente Satisfecho</cite>
  </blockquote>
  <blockquote>
    <p>"Un proyecto innovador y bien pensado, que combina lo mejor de la tecnología y el diseño para optimizar la experiencia en el sector gastronómico."</p>
    <cite>— Experto en Hostelería</cite>
  </blockquote>
  <div>
    <h2 class="faq-title">¿Quieres saber más?</h2>
    <p>
      Ponte en contacto con nosotros para conocer más sobre el proyecto y nuestras soluciones para restaurantes.
    </p>
    <div style="text-align: center; margin-top: 20px;">
  <a class="btn btn-primary" href="#contacto">Contáctanos</a>
</div>
  </div>
</section>
</section>
</div>
  </section> <!-- Aquí termina #sobre-nosotros -->
</section> <!-- Aquí termina #contacto -->

<!-- Footer fuera de cualquier section o container -->
<footer class="footer text-center mt-5 py-3">
  <p>© 2025 Proyecto POS. Todos los derechos reservados.</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

<!-- Script del buscador -->
<script>
  function redireccionarBusqueda() {
    const termino = document.getElementById("buscador").value.toLowerCase().trim();

    if (termino.includes("servicio")) {
      location.href = "#servicios";
    } else if (termino.includes("contacto")) {
      location.href = "#contacto";
    } else if (termino.includes("inicio")) {
      location.href = "#";
    } else if (termino.includes("sobre nosotros") || termino.includes("nosotros")) {
      location.href = "#sobre-nosotros";
    } else {
      alert("No se encontró ningún resultado relacionado.");
    }
  }
</script>
</body>

</html>