<?php 
    include './services/Servicios.php';
    $modulo = new Servicios();
    
    $cod_modulo = "";
    $nombre="";
    $estado="";
    $accion = "Agregar";
    $mensaje="Añadir Nuevo Modulo";
    
    if(isset($_POST['accionModulo']) && ($_POST['accionModulo']=='Agregar'))
    {
        $modulo->insertarModulo($_POST['cod_modulo'],$_POST['nombre'],$_POST['estado']);
    }
    else if(isset($_POST["accionModulo"]) && ($_POST["accionModulo"]=="Modificar"))
    {
        $modulo->modificarModulo($_POST['cod_modulo'],$_POST['nombre'],$_POST['estado'],$_POST['cod_modulo_comparar']);
    }
    else if(isset($_GET["update"]))
    {
        $result = $modulo->encontrarModulo($_GET['update']);
        if($result!=null)
        {
            $cod_modulo = $result['COD_MODULO'];
            $nombre = $result['NOMBRE'];
            $estado = $result['ESTADO'];
            $accion="Modificar";
            $mensaje = "Modificar Módulo";
        }
    }
    else if(isset($_GET['delete']))
    {
        $modulo->eliminarLogicoModulo($_GET['delete']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MODULO</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet"  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <script src="https://momentjs.com/downloads/moment.js"></script>
</head>
<body>

    <header style="background-color: #673AB7;">
        <h2 class="text-center text-light">MODULO</h2><br>
    </header><br><br>
    
    <!--INICIO TABLA-->
    <form action="modulo.php" name="forma" method="post" id="forma">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="tablaProductos" class="table table-striped table-bordered table-condensed" style="width: 100%;">
                        <thead class="text-center">
                            <tr>
                                <th>Código Módulo</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $result = $modulo->mostrarModulos(); 
                                        
                                if ($result->num_rows > 0) 
                                {
                                    while($row = $result->fetch_assoc()) 
                                    { 
                            ?>
                            <tr>
                                <td><?php echo $row ["COD_MODULO"];?></td>
                                <td><?php echo $row ["NOMBRE"];?></td>
                                <td><?php echo $row ["ESTADO"];?></td>
                                <td>
                                    <div class="text-center">
                                        <div class="btn-group">
                                            <a href="Modulo.php?update=<?php echo $row ["COD_MODULO"];?>#editar" type="button" class="btn btn-primary">Editar</a>
                                            <a href="Modulo.php?delete=<?php echo $row ["COD_MODULO"];?>" type="button" class="btn btn-danger">Eliminar</a>
                                            
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
                                    }
                                }
                                else
                                {
                            ?>
                            <tr>
                                <td>No hay datos en la tabla</td>
                            </tr>
                            <?php
                                } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><br>
    <!--FIN TABLA-->
    <div class="container">
        <div class="card">
            <div class="card-body"  style="background-color: #673AB7;">
            <h2 class="text-center text-light"><?php echo $mensaje ?></h2>
            </div>
        </div>
        <div>
            <div class="card-body">
                <!--<form action="index.php" name="forma" method="post" id="forma">-->
                    <input type="hidden" name="cod_modulo_comparar" value="<?php echo $cod_modulo ?>">
                    <div class="form-group row" id="editar">
                        <label for="cod_modulo" id="lblCodigo" class="col-sm-2 col-form-label">Código del Módulo</label>
                        <div class="col-sm-4">
                            <input type="text" name="cod_modulo" value="<?php echo $cod_modulo ?>" require class="form-control">
                        </div>
                    </div>
                    <div class="form-group row" id="editar">
                        <label for="nombre" id="lblNombre" class="col-sm-2 col-form-label">Nombre</label>
                        <div class="col-sm-4">
                            <input type="text" name="nombre" value="<?php echo $nombre ?>" require class="form-control">
                        </div>
                    </div>
                    <div class="form-group row" id="editar">
                        <label for="estado" id="lblEstado" class="col-sm-2 col-form-label">Estado</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="estado">
                                <option value="ACT">ACTIVO</option>
                                <option value="INA">INACTIVO</option>
                            </select>
                        </div>
                    </div>
                    <input type="submit" name="accionModulo" value="<?php echo $accion ?>" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</body>
</html>