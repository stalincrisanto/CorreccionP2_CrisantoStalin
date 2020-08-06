<?php 
    include './services/Servicios.php';
    $rol = new Servicios();
    error_reporting(0);
    //$nombre_rol="";
    $cod_modulo = "";
    $estado="";
    $url_principal="";
    $nombre="";
    $descripcion="";
    $accion = "Agregar";
    
    if(isset($_POST['accionRol']) && ($_POST['accionRol']=='Agregar'))
    {
        $rol->insertarModuloPorRol($_POST['rol'],$_POST['modulo']);
    }
    
    else if(isset($_POST["accionInfraestructura"]) && ($_POST["accionInfraestructura"]=="Modificar"))
    {
        $modulo->modificarModulo($_POST['cod_modulo'],$_POST['nombre'],$_POST['estado'],$_POST['cod_modulo_comparar']);
    }
    else if(isset($_GET["update"]))
    {
        $result = $modulo->encontrarModulo($_GET['update']);
        if($result!=null)
        {
            $url_principal = $result['URL_PRINCIPAL'];
            $nombre = $result['NOMBRE'];
            $descripcion = $result['DESCRIPCION'];
            $accion="Modificar";
        }
    }
    else if(isset($_GET['delete']))
    {
        $rol->eliminarModuloPorRol($_GET['delete'],$_GET['modulo']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ROL</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet"  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <script src="https://momentjs.com/downloads/moment.js"></script>
</head>
<body>
    <header style="background-color: #673AB7;">
        <h2 class="text-center text-light">ROL</h2><br>
    </header><br><br>
    
    <!--INICIO TABLA-->
    
    <div class="container">
        <div class="row">
            <div class="col">
                <h3>ROL</h3>
                <form action="" method="get">
                    <select class="form-control" name="rol" id="selectrol">
                        <option value="" disabled="" selected="">Selecciona un Rol</option>
                            <?php 
                                $result2 = $rol->mostrarRoles();
                                foreach($result2 as $opciones):
                            ?>
                        <option value="<?php echo $opciones['COD_ROL'] ?>"><?php echo $opciones['NOMBRE'] ?></option>
                            <?php endforeach ?>
                    </select><br>
                    <input type="submit" name="cod_rol" value="Aceptar" class="btn btn-primary">
                </form>
                <script type="text/javascript">
                        document.getElementById('selectrol').value = "<?php echo $_GET["rol"] ?>";
                </script>
                
                <?php
                    $nombre_rol=$_GET["rol"];
                ?>
            </div><br>
        
            <div class="col-lg-12"><br>
            <form action="" name="forma" method="post" id="forma">
                <div class="table-responsive">
                    <table id="tablaRoles" class="table table-striped table-bordered table-condensed" style="width: 100%;">
                        <thead class="text-center">
                            <tr>
                                <th>Modulos</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $result = $rol->mostrarModulosPorRol($nombre_rol);     
                                if ($result->num_rows > 0) 
                                {
                                    while($row = $result->fetch_assoc()) 
                                    { 
                            ?>
                            <input type="hidden" name="nombre_rol" value="<?php echo $row ["COD_ROL"];?>">
                            <tr>
                                <td><?php echo $row ["NOMBRE"];?></td>
                                <td>
                                    <div class="text-center">
                                        <div class="btn-group">
                                            <a href="Rol.php?delete=<?php echo $row ['COD_ROL'];?>&modulo=<?php echo $row['COD_MODULO'] ?>" type="button" class="btn btn-danger">Eliminar</a>   
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
            <h2 class="text-center text-light">Añadir Nuevo Rol</h2>
            </div>
        </div>
        <div>
            <div class="card-body">
                <!--<form action="index.php" name="forma" method="post" id="forma">-->
                    <div class="form-group row" id="editar">
                        <label for="url_principal" id="lblCodigo" class="col-sm-2 col-form-label">Rol</label>
                        <div class="col-sm-4">
                            <input type="text" name="rol" value="<?php echo $nombre_rol ?>" require class="form-control">
                        </div>
                    </div>
                    <div class="form-group row" id="editar">
                        <label for="url_principal" id="lblCodigo" class="col-sm-2 col-form-label">Módulo</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="modulo" id="selectmodulo">
                                <option value="" disabled="" selected="">Selecciona un Módulo</option>
                                    <?php 
                                        $result3 = $rol->mostrarModulos();
                                        foreach($result3 as $opciones):
                                    ?>
                                <option value="<?php echo $opciones['COD_MODULO'] ?>"><?php echo $opciones['NOMBRE'] ?></option>
                                    <?php endforeach ?>
                            </select>    
                        </div>
                        
                    </div>
                    <input type="submit" name="accionRol" value="<?php echo $accion ?>" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</body>
</html>