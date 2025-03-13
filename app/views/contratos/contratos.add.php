<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Contrato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <h2 class="text-center text-primary mb-4">Agregar Nuevo Contrato</h2>
            <form id="contratoForm" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">ID Asesor</label>
                        <input type="number" class="form-control" name="idasesor" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">ID Inversionista</label>
                        <input type="number" class="form-control" name="idinversionista" required>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="form-label">ID Cónyuge</label>
                        <input type="number" class="form-control" name="idconyuge">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" name="fechainicio" required>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Duración (meses)</label>
                        <input type="number" class="form-control" name="duracionmeses" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Moneda</label>
                        <select class="form-select" name="moneda">
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                            <option value="PEN">PEN</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Día de Pago</label>
                        <input type="number" class="form-control" name="diapago" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Interés (%)</label>
                        <input type="number" class="form-control" name="interes" step="0.01" required>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Capital</label>
                        <input type="number" class="form-control" name="capital" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tipo de retorno</label>
                        <select class="form-select" name="tiporetorno">
                            <option value="USD">Fijo</option>
                            <option value="EUR">Por partes</option>
                            
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Periodo de Pago</label>
                        <input type="text" class="form-control" name="periodopago" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Impuesto Renta (%)</label>
                        <input type="number" class="form-control" name="impuestorenta" step="0.01" required>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="form-label">Observación</label>
                        <textarea class="form-control" name="observacion" rows="2"></textarea>
                    </div>
                </div>
                <div class="row mt-3">
                <div class="col-md-6">
                    <label class="form-label">Tolerancia de Días</label>
                    <input type="number" class="form-control" name="toleranciadias" required>
                </div>
            </div>
                    <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-4">Guardar Contrato</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
  
    <script>

        document.getElementById("contratoForm").addEventListener("submit", function(event) {
            event.preventDefault(); 
            
            let formData = new FormData(this);
            
            fetch("../../controllers/Contrato.controller.php", {

                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Contrato agregado exitosamente");
                    document.getElementById("contratoForm").reset();
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(error => console.error("Error en la petición:", error));
        });


    </script>
  </body>
</html>
