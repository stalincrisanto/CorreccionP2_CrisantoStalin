<?php 
    include './services/Servicios.php';
    $funcionalidad = new Servicios();
    error_reporting(0);
    $cod_modulo = "";
    $estado="";
    $url_principal="";
    $nombre="";
    $descripcion="";
    $accion = "Agregar";
    $mensaje="Añadir Nueva Funcionalidad";
    
    if(isset($_POST['accionInfraestructura']) && ($_POST['accionInfraestructura']=='Agregar'))
    {
        $funcionalidad->insertarFuncionalidad($_POST['url_principal'],$_POST['nombre'],
                                       $_POST['descripcion'],$_POST['cod_modulo_ingresar']);
    }
    else if(isset($_POST["accionInfraestructura"]) && ($_POST["accionInfraestructura"]=="Modificar"))
    {
        $funcionalidad->modificarFuncionalidad($_POST['cod_funcionalidad'],$_POST['url_principal'],$_POST['nombre'],$_POST['descripcion']);
    }
    else if(isset($_GET["update"]))
    {
        $result = $funcionalidad->encontrarFuncionalidad($_GET['update'],$_GET['modulo']);
        if($result!=null)
        {
            $url_principal = $result['URL_PRINCIPAL'];
            $nombre = $result['NOMBRE'];
            $descripcion = $result['DESCRIPCION'];
            $accion="Modificar";
            $mensaje="Modificar datos de la funcionalidad";
        }
    }
    else if(isset($_GET['delete']))
    {
        $funcionalidad->eliminarFuncionalidad($_GET['delete']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUNCIONALIDAD</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet"  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <script src="https://momentjs.com/downloads/moment.js"></script>
</head>
<body>
    <header style="background-color: #673AB7;">
        <h2 class="text-center text-light">FUNCIONALIDADES</h2><br>
    </header><br><br>
    
    <!--INICIO TABLA-->
    <div class="container">
        <div class="row">
            <div class="col">
                <h3>Funcionalidades</h3>
                <form action="" method="get">
                    <select class="form-control" name="modulo" id="selectmodulo">
                        <option value="" disabled="" selected="">Selecciona un Módulo</option>
                            <?php 
                                $result2 = $funcionalidad->mostrarModulos();
                                foreach($result2 as $opciones):
                            ?>
                        <option value="<?php echo $opciones['COD_MODULO'] ?>"><?php echo $opciones['NOMBRE'] ?></option>
                            <?php endforeach ?>
                    </select><br>
                    <input type="submit" name="cod_modulo" value="Aceptar" class="btn btn-primary">
                </form>
                <script type="text/javascript">
                        document.getElementById('selectmodulo').value = "<?php echo $_GET["modulo"] ?>";
                </script>
                
                <?php
                    $nombre_modulo=$_GET["modulo"];
                ?>
            <form action="" name="forma" method="post">
                <input type="hidden" name="nombre_modulo" value="<?php echo $nombre_modulo ?>">
            </div><br><br><br>
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="tablaProductos" class="table table-striped table-bordered table-condensed" style="width: 100%;">
                        <thead class="text-center">
                            <tr>
                                <th>Nombre</th>
                                <th>URL Principal</th>
                                <th>Descripcion</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $result = $funcionalidad->mostrarFuncionalidades($nombre_modulo);     
                                if ($result->num_rows > 0) 
                                {
                                    while($row = $result->fetch_assoc()) 
                                    { 
                            ?>
                            <input type="hidden" name="cod_funcionalidad" value="<?php echo $row ["COD_FUNCIONALIDAD"];?>">
                            <input type="hidden" name="cod_modulo" value="<?php echo $row ["COD_MODULO"];?>">
                            <tr>
                                <td><?php echo $row ["NOMBRE"];?></td>
                                <td><?php echo $row ["URL_PRINCIPAL"];?></td>
                                <td><?php echo $row ["DESCRIPCION"];?></td>
                                <td>
                                    <div class="text-center">
                                        <div class="btn-group">
                                            <a href="Funcionalidades.php?update=<?php echo $row ["COD_FUNCIONALIDAD"];?>&modulo=<?php echo $row ["COD_MODULO"];?>" type="button" class="btn btn-primary">Editar</a>
                                            <a href="Funcionalidades.php?delete=<?php echo $row ["COD_FUNCIONALIDAD"];?>&modulo=<?php echo $row ["COD_MODULO"];?>" type="button" class="btn btn-danger">Eliminar</a>   
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
                    <input type="hidden" name="cod_modulo_ingresar" value="<?php echo $nombre_modulo ?>">
                    <div class="form-group row" id="editar">
                        <label for="url_principal" id="lblCodigo" class="col-sm-2 col-form-label">URL</label>
                        <div class="col-sm-4">
                            <input type="text" name="url_principal" value="<?php echo $url_principal ?>" require class="form-control">
                        </div>
                    </div>
                    <div class="form-group row" id="editar">
                        <label for="nombre" id="lblNombre" class="col-sm-2 col-form-label">Nombre</label>
                        <div class="col-sm-4">
                            <input type="text" name="nombre" value="<?php echo $nombre ?>" require class="form-control">
                        </div>
                    </div>
                    <div class="form-group row" id="editar">
                        <label for="descripcion" id="lbldescripcion" class="col-sm-2 col-form-label">descripcion</label>
                        <div class="col-sm-4">
                            <input type="text" name="descripcion" value="<?php echo $descripcion ?>" require class="form-control">
                        </div>
                    </div>
                    <input type="submit" name="accionInfraestructura" value="<?php echo $accion ?>" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</body>
</html>