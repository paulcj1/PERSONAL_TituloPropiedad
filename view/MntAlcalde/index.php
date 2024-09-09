<?php 
 /* Llamamos al archivo de Conexion.php */
 require_once("../../config/conexion.php");
 if(isset($_SESSION["usua_id"])){

?>
<!DOCTYPE html>
<html lang="es">
  <head>
 
  <?php require_once("../../view/html/MainHead.php"); ?>
    <title>Alcaldes</title>
  </head>

  <body>
  <?php require_once("../../view/html/MainMenu.php"); ?>
  <?php require_once("../../view/html/MainHeader.php"); ?>
    
    <div class="br-mainpanel">
        
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5">Alcaldes</h4>
            <p class="mg-b-0">Pantalla Alcaldes</p>
        <!-- En este div va el contenido de la pagina que va a cambiar -->
            <div class="br-pagebody">
                <div class="br-section-wrapper">
                    
                    <div id="mantenimiento">
                        <div role="document">
                            <form method="post" id="alcaldes_form">
                                <input type="hidden" name="alca_id" id="alca_id"/>
                                <div class="form-layout form-layout-1">
                                    <div class="row mg-b-10">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="form-control-label">Nombre: <span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="alca_nom" id= "alca_nom" placeholder="Nombre" required/>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="form-control-label">Apellido Paterno: <span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="alca_apep" id= "alca_apep" placeholder="Apellido Paterno" required/>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="form-control-label">Apellido Materno: <span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="alca_apem" id= "alca_apem" placeholder="Apellido Materno" required/>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="form-control-label">DNI: <span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="alca_dni" id= "alca_dni" placeholder="DNI" required/>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Fech. Inicio: <span class="tx-danger">*</span></label>
                                                <input class="form-control" type="date" name="alca_fechini" id="alca_fechini" placeholder="Fech. Inicio" required/>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Fech. Fin: <span class="tx-danger">*</span></label>
                                                <input class="form-control" type="date" name="alca_fechfin" id="alca_fechfin" placeholder="Fech. Fin" required/>
                                            </div>
                                        </div>
                                        

                                    </div><!-- row -->

                                    <div class="form-layout-footer">
                                        <button type="submit" name="action" value="add" class="btn btn-outline-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium"><i class="fa fa-check"></i> Guardar</button>
                                        <button href='../AdminMntCertificado' class="btn btn-secondary">Siguiente</button>
                                    </div><!-- form-layout-footer -->
                                </div><!-- form-layout -->
                            </form>
                        </div>
                    </div>
                    
                    <br>

                    <p></p>

                    <div class="table-wrapper"></div>
                        <table id="alcaldes_data" class="table display responsive nowrap">
                        <thead>
                            <tr>
                            <th class="wd-10p">Estado</th>
                            <th class="wd-30p">Nombre Completo</th>
                            <th class="wd-10p">DNI</th>
                            <th class="wd-10p">Fech. Inicio</th>
                            <th class="wd-10p">Fech. Fin.</th>
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
    <script type="text/javascript" src="mntalcalde.js"></script>

    
  </body>
</html>
<?php 
 }else{
    /* Si no a iniciado sesion se redireccionada a la ventana principal */
    header("Location:".Conectar::ruta()."view/404/");

 }
?>