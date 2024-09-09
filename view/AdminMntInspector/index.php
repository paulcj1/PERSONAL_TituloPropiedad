<?php 
 /* Llamamos al archivo de Conexion.php */
 require_once("../../config/conexion.php");
 if(isset($_SESSION["usua_id"])){

?>
<!DOCTYPE html>
<html lang="es">
  <head>
 
  <?php require_once("../../view/html/MainHead.php"); ?>
    <title>Inspector</title>
  </head>

  <body>
  <?php require_once("../../view/html/MainMenu.php"); ?>
  <?php require_once("../../view/html/MainHeader.php"); ?>
    
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="#">Inspector</a>
            </nav>
        </div><!-- br-pageheader -->
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5">Inspector</h4>
            <p class="mg-b-0">Pantalla Inspector</p>
        <!-- En este div va el contenido de la pagina que va a cambiar -->
            <div class="br-pagebody">
                <div class="br-section-wrapper">
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Inspectores</h6>
                    <p class="mg-b-30 tx-gray-600">Listado de Inspectores</p>
                    <div id="mantenimiento">
                        <div role="document">
                            <form method="post" id="inspectores_form">
                                <input type="hidden" name="insp_id" id="insp_id"/>
                                <div class="form-layout form-layout-1">
                                    <div class="row mg-b-20">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                            <label class="form-control-label">Nombre Insp. : <span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="insp_nombre" id= "insp_nombre" placeholder="Nombre">
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-2">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Apellido P. : <span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="insp_apep" id= "insp_apep" placeholder="Apellido Paterno">
                                            </div>
                                        </div><!-- col-8 -->
                                        <div class="col-lg-2">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Apellido M. : <span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="insp_apem" id= "insp_apem" placeholder="Apellido Materno">
                                            </div>
                                        </div><!-- col-8 -->
                                        <div class="col-lg-1">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">DNI: <span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="insp_dni" id= "insp_dni" placeholder="DNI">
                                            </div>
                                        </div><!-- col-8 -->
                                    </div><!-- row -->

                                    <div class="form-layout-footer">
                                    <button type="submit" name="action" value="add" class="btn btn-outline-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium"><i class="fa fa-check"></i> Guardar</button>
                                        <button class="btn btn-secondary">Siguiente</button>
                                        </div><!-- form-layout-footer -->
                                    </div><!-- form-layout -->
                                    </form>
                        </div>
                    </div>
                    <br>
                    <button class="btn btn-outline-primary" id="add_button" onclick="nuevo()"><i class="fa fa-plus-square mg-r-10"></i> Nuevo Registro</button>

                    <p></p>

                    <div class="table-wrapper"></div>
                        <table id="inspectores_data" class="table display responsive nowrap">
                        <thead>
                            <tr>
                            <th class="wd-10p">Certificado ID</th>
                            <th class="wd-20p">Nombre Completo</th>
                            <th class="wd-10p">DNI</th>
                            <th class="wd-10p"></th>
                            <th class="wd-10p"></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        </table>
                    </div>

                </div>




            </div>
        </div>
    
    <!-- ########## END: MAIN PANEL ########## -->

    <?php require_once("../../view/html/MainJs.php"); ?>
    <script type="text/javascript" src="adminmntinspector.js"></script>
  </body>
</html>
<?php 
 }else{
    /* Si no a iniciado sesion se redireccionada a la ventana principal */
    header("Location:".Conectar::ruta()."view/404/");

 }
?>