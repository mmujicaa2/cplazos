<?php include "conexion.php"; ?>




<html>
    <head>
    <title>Control de plazos</title>
    
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8">

    <!-- Jquery --> 
    <script src="js/jquery.min.js"></script>
    <script src="js/eventos.js"></script>
     
    <!-- Viewport --> 
      <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <!-- Bootstrap -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!--Datepicker bootstrap-->
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/bootstrap-datepicker.es.min.js"></script>
    <link href="css/bootstrap-datepicker.css" rel="stylesheet"/>


    <!-- Fontawesome-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">



    </head>



    <body>

    <div class="container-fluid">
    
    <nav class="navbar navbar-nav  navbar-expand-lg bg-secondary  mb-2 mr-sm-2">
  <a style="color:#d9534f" class="navbar-text navbar-center text-light">Sistema de Control de Plazos</a>
  

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      
    </ul>
    <form class="form-inline my-2 my-lg-0 mb-2 mr-sm-2 needs-validation" action="logout.php" novalidate>
      <button class="btn btn-dark my-2 my-sm-0" type="submit"><i class="fa fa-sign-out"></i> Salir</a></button>
      <input type="hidden" name="Tribunal" value=1>
      <input type="hidden" name="Materia" value=1>
    </form>

  </div>
</nav>

      
      <form action="agendarplazo.php" method="post">
        <div class="form-group">
            <div class="input-group">
                <label class="control-lg-4  mb-2 mr-sm-2">RIT</label>
                <div class="col-lg-1">
                <input type="text" id="rit" required  class="form-inline form-control mb-2 mr-sm-2"  pattern="[0-9]{1,5}" maxlength="5" name="rit" />
                </div>
            </div>
        </div>


        <div class="form-group">
            <div class="input-group">
                <label class="control-lg-4 control-label mb-2 mr-sm-2">Año</label>
                <div class="col-lg-2">
                    <div class="form-group  input-group">
                        <input  id="datepicker2"  pattern="[0-9]{1,5}"  maxlength="5" onkeydown="return false" class="form-control form-group" name="era" placeholder="Año" required>
                        <label for="datepicker2">
                          <span class="input-group-text" id="basic-addon2" for="datepicker" >
                            <i class="fa fa-calendar " style="font-size:24px"></i>
                          </span>
                        </label>
                    </div>

                </div>
            </div>
        </div> 


        <div class="form-group">
            <div class="input-group">
                <label class="control-lg-4 control-label mb-2 mr-sm-2">Tipo de Documento</label>
                <div class="col-lg-6">
                    
                        <select name="tipodocumento" required class="form-control form-group mb-2 mr-sm-2 col-md-6" id="" >
                        <option value="">Seleccione</option>
                        <option value="doc1">Tipo doc1</option>
                        <option value="doc2">Tipo doc2</option>
                        <option value="doc3">Tipo doc3</option>
                        <option value="otro">Otro</option>
                        </select>
                    

                </div>
            </div>
        </div> 


        <div class="form-group">
            <div class="input-group">
                <label class="control-lg-4 control-label mb-2 mr-sm-2">Tipo de plazo</label>
                <div class="col-lg-6">

                      
                    
                        <select name="tipodocumento" required class="form-control form-group mb-2 mr-sm-2 col-md-6" id="" required>
                        <option value="">Seleccione</option>

                        <?php
                        $sqlplazos = "SELECT *  FROM plazos ";
                        $result = $conn->query($sqlplazos);

                        if ($result->num_rows > 0) {
                          
                          while($row = $result->fetch_assoc()) {

                            echo "<option value='".$row['id_plazo']."'>".$row['nmplazo']."</option>";

                            //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
                          }
                        } else {
                          echo "0 results";
                        }
                        //$conn->close();
                        ?>
                        <option value="personalizado">Personalizado</option>
                        </select>
                    

                </div>
            </div>
        </div> 


        <div class="form-group">
            <div class="input-group">
                <label class="control-lg-4 control-label mb-2 mr-sm-2">Plazo por fecha</label>
                <div class="col-lg-2">
                    <div class="form-group  input-group">
                        <input  id="datepicker"   onkeydown="return false" class="form-control form-group" name="era" placeholder="Año" required>
                        <label for="datepicker">
                          <span class="input-group-text" id="basic-addon2" for="datepicker" >
                            <i class="fa fa-calendar " style="font-size:24px"></i>
                          </span>
                        </label>
                    </div>

                </div>
            </div>
        </div> 
      

           <div class="form-group">
            <div class="input-group">
                <label class="control-lg-4 control-label mb-2 mr-sm-2">Notificar correo a unidad</label>
                <div class="col-lg-6">
                    
                        <select name="unidad" required class="form-control form-group mb-2 mr-sm-2 col-md-6" id="unidad" required>
                        <option value="">Seleccione</option>

                        <?php
                        $sqlunidad = "SELECT *  FROM unidad ";
                        $result = $conn->query($sqlunidad);

                        if ($result->num_rows > 0) {
                          
                          while($row = $result->fetch_assoc()) {

                            echo "<option value='".$row['id_unidad']."'>".$row['nunidad']."</option>";

                          }
                        } else {
                          echo "0 results";
                        }
                        $conn->close();
                        ?>
                        <option value="personalizado">Personalizado</option>
                        </select>
                    

                </div>
            </div>
        </div> 


        <div class="form-group">
            <div class="input-group">
                <label class="control-lg-4  mb-2 mr-sm-2">Otro correo</label>
                <div class="col-lg-4">
                    <input type="email"  class="form-control" id="driver_email" placeholder="Ingrese correo" name="driver_email" 
                    pattern="^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$" required="">
                  
                </div>
            </div>
        </div>



        <button id="Enviar6" type="button bnt btn-lg-2"  class="btn btn-primary btn col-lg-2 form-control form-group mb-2 mr-sm-2">Agendar</button>
        


    </form>

    
    </body>
</html>
