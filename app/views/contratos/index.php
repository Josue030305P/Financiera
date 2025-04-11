<?php session_start(); ?>


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

</head>

<body>

  <div class="container mt-5">


    <div class="card mb-5">
      <div class="card-header">
        Inversionista
      </div>


      <div class="card-body">

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" value="<?php echo $_SESSION['nombre']; ?>" disabled>
          </div>
          <div class="col-md-6">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" value="" disabled>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" value="" disabled>
          </div>
          <div class="col-md-6">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" disabled>
          </div>
        </div>

      </div>
    </div>


    <div class="card mb-5">
      <div class="card-header">
        Datos de inversión
      </div>
      <div class="card-body">

        <div class="row mb-3">
          <div class="col-md-3">
            <label for="nombre" class="form-label">Feha inicio</label>
            <input type="date" class="form-control" id="fechainicio" disabled>
          </div>
          <div class="col-md-3">
            <label for="meses" class="form-label">Meses</label>
            <input type="text" class="form-control" id="meses" value="">
          </div>
          <div class="col-md-3">
            <label for="moneda" class="form-label">Moneda</label>
            <input type="text" class="form-control" id="moneda" value="">
          </div>
          <div class="col-md-3">
            <label for="diapago" class="form-label">Día pago</label>
            <input type="text" class="form-control" id="diapago" value="">
          </div>
        </div>

        <div class="row mb-3">
          
          <div class="col-md-3">
            <label for="interes" class="form-label">Interés</label>
            <input type="text" class="form-control" id="interes" >
          </div>
          <div class="col-md-3">
            <label for="capital" class="form-label">Capital</label>
            <input type="text" class="form-control" id="capital" value="" >
          </div>
          <div class="col-md-3">
            <label for="tipo" class="form-label">Tipo</label>
            <input type="text" class="form-control" id="tipo" value="" >
          </div>
          <div class="col-md-3">
            <label for="periodo" class="form-label">Período</label>
            <input type="text" class="form-control" id="periodo" value="" >
          </div>
        </div>


        <div class="row mb-3">
          
          <div class="col-md-6">
            <label for="impuestorenta" class="form-label">Impuesto renta</label>
            <input type="text" class="form-control" id="impuestorenta" >
          </div>
          <div class="col-md-6">
            <label for="tolreancia" class="form-label">Tolerancia días</label>
            <input type="text" class="form-control" id="tolreancia" value="" >
          </div>
    

        </div>
        


      </div>
   





  </div>

  <script>
    const fechainicio = document.getElementById('fechainicio');
    const hoy = new Date();
    const yyyy = hoy.getFullYear();
    const mm = String(hoy.getMonth() + 1).padStart(2, '0');
    const dd = String(hoy.getDate()).padStart(2, '0');
    const fechaFormateada = `${yyyy}-${mm}-${dd}`;

    fechainicio.value = fechaFormateada;
  </script>


</body>