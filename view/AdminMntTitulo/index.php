<?php 
 /* Llamamos al archivo de Conexion.php */
 require_once("../../config/conexion.php");
 if(isset($_SESSION["usua_id"])){

?>
<!DOCTYPE html>
<html lang="es">
  <head>
 
  <?php require_once("../../view/html/MainHead.php"); ?>
    <title>Titulos</title>
  </head>

  <body>
  <?php require_once("../../view/html/MainMenu.php"); ?>
  <?php require_once("../../view/html/MainHeader.php"); ?>
    
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="#">Titulos</a>
            </nav>
        </div><!-- br-pageheader -->
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5">Titulos</h4>
            <p class="mg-b-0">Titulos</p>
        <!-- En este div va el contenido de la pagina que va a cambiar -->
            <div class="br-pagebody">
                <div class="br-section-wrapper">
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Titulos</h6>
                    <p class="mg-b-30 tx-gray-600">Listado de Titulos</p>
                    <div id="mantenimiento">
                        <div role="document">
                            <form method="post" id="titulos_form">
                                <input type="hidden" name="titu_id" id="titu_id"/>
                                <input type="hidden" name="cert_id" id="cert_id"/>
                                <input type="hidden" name="alca_id" id="alca_id"/>
                                <div class="form-layout form-layout-1">
                                    <div class="row mg-b-20">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                            <label class="form-control-label">Partida Electronica: <span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="titu_partelec" id="titu_partelec" placeholder="Partida Elec.">
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                            <label class="form-control-label">Num. Titulo: <span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="titu_numtitulo" id="titu_numtitulo" placeholder="Num. Titulo">
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                            <label class="form-control-label">Part. Lote: <span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="titu_partlote" id="titu_partlote" placeholder="Partida Lote">
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-1">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Asiento: <span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="titu_asiento" id="titu_asiento" placeholder="Asiento">
                                            </div>
                                        </div><!-- col-8 -->
                                        <div class="col-lg-1">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Serie: <span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="titu_serie" id="titu_serie" placeholder="Enter address">
                                            </div>
                                        </div><!-- col-8 -->
                                        <div class="col-lg-2">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Tipo Titulo: <span class="tx-danger">*</span></label>
                                            <select class="form-control select2" name="titu_tipo" id="titu_tipo">
                                            <option label="Seleccione"></option>
                                                    <option value="Gratuito">Gratuito</option>
                                                    <option value="Oneroso">Oneroso</option>
                                            </select>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-1">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Tazacion: </label>
                                            <input class="form-control" type="text" name="titu_tazacion" id="titu_tazacion" placeholder="Tazacion">
                                            </div>
                                        </div><!-- col-8 -->
                                        <div class="col-lg-3">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Resolucion GDU: <span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="titu_numresolucion" id="titu_numresolucion" placeholder="Num. Resolucion">
                                            </div>
                                        </div><!-- col-8 -->
                                        <div class="col-lg-2">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Fecha Resolucion: <span class="tx-danger">*</span></label>
                                            <input class="form-control" id="titu_fecharesolucion" type="date" name="titu_fecharesolucion" placeholder="Fecha Resolucion">
                                            </div>
                                        </div><!-- col-8 -->
                                        <div class="col-lg-2">
                                            <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Fecha Emision: <span class="tx-danger">*</span></label>
                                            <input class="form-control" id="titu_fechaemision" type="date" name="titu_fechaemision" placeholder="Fecha Emision">
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
                    
                    <br>

                   

                    <p></p>

                    <div class="table-wrapper"></div>
                        <table id="titulos_data" class="table display responsive nowrap">
                        <thead>
                            <tr>
                            <th class="wd-10p">Titu. ID</th>
                            <th class="wd-10p">Part. Elec.</th>
                            <th class="wd-10p">Num. Titulo</th>
                            <th class="wd-10p">Part. Lote</th>
                            <th class="wd-10p">Asiento.</th>
                            <th class="wd-10p">Serie</th>
                            <th class="wd-10p">Tipo</th>
                            <th class="wd-10p">Tazacion</th>
                            <th class="wd-10p">Num. Resolucion</th>
                            <th class="wd-10p">Fecha Resolucion</th>
                            <th class="wd-10p">Fecha Emision</th>
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
    <script type="text/javascript" src="adminmnttitulo.js"></script>
  </body>
</html>
<?php 
 }else{
    /* Si no a iniciado sesion se redireccionada a la ventana principal */
    header("Location:".Conectar::ruta()."view/404/");

 }
?>