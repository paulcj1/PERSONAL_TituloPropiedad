<?php 
 /* Llamamos al archivo de Conexion.php */
 require_once("../../config/conexion.php");
 if(isset($_SESSION["usua_id"])){

?>
<!DOCTYPE html>
<html lang="es">
  <head>
 
  <?php require_once("../../view/html/MainHead.php"); ?>
    <title>Certificados</title>
  </head>

  <body>
  <?php require_once("../../view/html/MainMenu.php"); ?>
  <?php require_once("../../view/html/MainHeader.php"); ?>
    
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="#">Certificados</a>
            </nav>
        </div><!-- br-pageheader -->
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5">Certificados</h4>
            <p class="mg-b-0">Pantalla Certificados</p>
        <!-- En este div va el contenido de la pagina que va a cambiar -->
            <div class="br-pagebody">
                <div class="br-section-wrapper">
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Certificados</h6>
                    <p class="mg-b-30 tx-gray-600">Listado de Certificados</p>
                    <div id="mantenimiento">
                        <div role="document">
                            <form method="post" id="certificados_form">
                                <input type="hidden" name="cert_id" id="cert_id"/>
                                <input type="hidden" name="insp_id" id="insp_id"/>
                                <div class="form-layout form-layout-1">
                                    <div class="row mg-b-20">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                            <label class="form-control-label">Ubicacion: <span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="cert_ubicacion" id="cert_ubicacion" placeholder="Ubicacion" required>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-1">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Manzana: <span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="cert_manzana" id="cert_manzana" placeholder="Manzana" required>
                                            </div>
                                        </div><!-- col-8 -->
                                        <div class="col-lg-1">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Lote: <span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="cert_lote" id="cert_lote" placeholder="Lote" required>
                                            </div>
                                        </div><!-- col-8 -->
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-control-label">Distrito: <span class="tx-danger">*</span></label>
                                                <select class="form-control select2" name="dist_id" id="dist_id" data-placeholder="Seleccione">
                                                    <option label="Seleccione"></option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Tipo Pobl. :<span class="tx-danger">*</span></label>
                                            <select class="form-control select2" name="cert_tipopobl" id="cert_tipopobl" data-placeholder="Seleccione">
                                                <option label="Seleccione"></option>
                                                <option value="PP. JJ.">Pueblo Joven</option>
                                                <option value="Urb.">Urbanizacion</option>
                                            </select>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-1">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Poblado :<span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="cert_nompobl" id="cert_nompobl" placeholder="Poblado" required>
                                            </div>
                                        </div><!-- col-8 -->
                                        <div class="col-lg-1">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Uso :<span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="cert_uso" id="cert_uso" placeholder="Uso" required>
                                            </div>
                                        </div><!-- col-8 -->
                                        <div class="col-lg-1">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Perimetro :<span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="cert_perimetro" id="cert_perimetro" placeholder="Perimetro" required>
                                            </div>
                                        </div><!-- col-8 -->
                                        <div class="col-lg-1">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Area :<span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="cert_area" id="cert_area" placeholder="Area" required>
                                            </div>
                                        </div><!-- col-8 -->
                                        <div class="col-lg-4">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Frente :<span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="cert_frente" id="cert_frente" placeholder="Frente" required>
                                            </div>
                                        </div><!-- col-8 -->
                                        <div class="col-lg-4">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Derecha :<span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="cert_derecha" id="cert_derecha" placeholder="Derecha" required>
                                            </div>
                                        </div><!-- col-8 -->
                                        <div class="col-lg-4">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Izquierda :<span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="cert_izquierda" id="cert_izquierda" placeholder="Izquierda" required>
                                            </div>
                                        </div><!-- col-8 -->
                                        <div class="col-lg-4">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Fondo :<span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="cert_fondo" id="cert_fondo" placeholder="Fondo" required>
                                        </div>
                                        
                                        </div><!-- col-8 -->
                                        <div class="col-lg-1">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Num. cert. :<span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="cert_numcert" id="cert_numcert" placeholder="Num. Cert." required>
                                            </div>
                                        </div><!-- col-8 -->
                                        <div class="col-lg-1">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Reg. Nº :<span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="cert_numregdoc" id="cert_numregdoc" placeholder="Reg. Doc." required>
                                            </div>
                                        </div><!-- col-8 -->
                                        <div class="col-lg-1">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Expe. Nº :<span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="cert_numexpe" id="cert_numexpe" placeholder="Nº Expe" required>
                                            </div>
                                        </div><!-- col-8 -->
                                        <div class="col-lg-1">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Inf Tec. Nº :<span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="cert_tecinf" id="cert_tecinf" placeholder="Inf. Tec." required>
                                            </div>
                                        </div><!-- col-8 -->
                                        <div class="col-lg-2">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Num. Acta :<span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="cert_numactainsp" id="cert_numactainsp" placeholder="Num. Acta." required>
                                            </div>
                                        </div><!-- col-8 -->


                                    </div><!-- row -->

                                    <div class="form-layout-footer">
                                        <button class="btn btn-secondary">Atras</button>
                                        <button class="btn btn-info">Guardar</button>
                                        <button class="btn btn-secondary">Siguiente</button>
                                    </div><!-- form-layout-footer -->
                                </div><!-- form-layout -->
                            </form>
                        </div>
                    </div>


                    <p></p>

                    <div class="table-wrapper"></div>
                        <table id="certificados_data" class="table display" style="display:block; width: 100%; max-width: 1600px; overflow-x: auto">
                        <thead>
                            <tr>
                            <th class="wd-10p">Cert. id</th>
                            <th class="wd-10p">Area</th>
                            <th class="wd-10p">Perimetro</th>
                            <th class="wd-10p">Direccion</th>
                            <th class="wd-10p">Uso</th>
                            <th class="wd-10p">Frente</th>
                            <th class="wd-10p">Derecha</th>
                            <th class="wd-10p">Izquierda</th>
                            <th class="wd-10p">Fondo</th>
                            <th class="wd-10p">Num. Reg. Doc.</th>
                            <th class="wd-10p">Num. Expe.</th>
                            <th class="wd-10p">Tec. Inf.</th>
                            <th class="wd-10p">Num. Cert.</th>
                            <th class="wd-10p">Num. Acta</th>
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
    <script type="text/javascript" src="adminmntcertificado.js"></script>
  </body>
</html>
<?php 
 }else{
    /* Si no a iniciado sesion se redireccionada a la ventana principal */
    header("Location:".Conectar::ruta()."view/404/");

 }
?>