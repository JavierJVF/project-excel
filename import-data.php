<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">


  <title>Import data</title>

  <link rel="stylesheet" href="public/alertifyjs/css/alertify.min.css" />
  <link rel="stylesheet" href="public/alertifyjs/css/themes/default.min.css" />
  <link rel="stylesheet" href="public/bootstrap/css/bootstrap.min.css" />

  <!-- STYLES -->
  <link rel="stylesheet" href="public/css/main.css" />

  <script src="public/alertifyjs/alertify.min.js"></script>
  <script src="public/js/funciones.js"></script>
  

</head>


<body>

    <div class='container text-center espacio-hotizontal-100px'>
        <h1>Formulario importar excel</h1>
    </div>  

    <div class='d-flex justify-content-center espacio-hotizontal-100px'>
        <div class='box-form rounded'>
            <form id='form_excel_import' enctype="multipart/form-data" method='POST'>
                <div class="py-1">
                    <label for="nameFile" class="form-label">Tipo de reporte</label>
                    <select class='form-select w-50' name='type_import' id='type_import_id'>
                        <option value='mensual'>Reporte mensual</option>
                        <option value='evento'>Reporte de Evento</option>
                    </select>
                </div>
                <div class="py-1">
                    <label for="nameImport" class="form-label">Nombre del importe</label>
                    <input type="text" name='nameImport' class="form-control" placeholder='Ingrece el nombre del importe'>
                </div>
                <div class="py-1">
                    <label for="excelFile" class="form-label">Archivo Excel</label>
                    <input type="file" name='excelFile' class="form-control">
                    <div id="notaArchivoIndicidual" class="form-text">Ingrese solo un archivo a la vez</div>
                </div>

                <div class="d-flex justify-content-center row pt-2">
                    <button id="buttonsend" type='submit' class='btn btn-success col-md-6'>Enviar</button>
                    
                </div>
            </form>
        </div>
    </div>

    <footer class="">
    
    </footer>


    <!-- PLUGINS JS -->
    <script src="public/js/jquery-3.6.4.min.js"></script>
    <script src="public/bootstrap/js/bootstrap.min.js"></script>

    <!-- SCRIPT JS -->
    <script src="public/js/import-data.js"></script>

</body>


</html>