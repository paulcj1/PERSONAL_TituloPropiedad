<?php 
 /* Llamamos al archivo de Conexion.php */
 require_once("../../config/conexion.php");
 if(isset($_SESSION["usua_id"])){

?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php require_once("../../view/html/MainHead.php"); ?>
    <title>Home</title>
  </head>

  <body>
    <?php require_once("../../view/html/MainMenu.php"); ?>
    <?php require_once("../../view/html/MainHeader.php"); ?>

    <div class="br-mainpanel">
        

        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5">Home</h4>
            <p class="mg-b-0">Pantalla Home</p>
        </div>

        <!-- En este div va el contenido de la pagina que va a cambiar -->
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <p class="mg-b-30 tx-gray-600">Resumen de Certificados</p>
                <div class="form-layout form-layout-1">
                <div class="row justify-content-center">
                        <div class="col-lg-3">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Filtro Fecha: <span class="tx-danger">*</span></label>
                                <select class="form-control" style="width:100%" name="combo_fecha_certificado" id="combo_fecha_certificado" data-placeholder="Selecciona">
                                    <option label="Seleccione"></option>
                                </select>
                            </div>
                        </div><!-- col-3 -->
                        <div class="col-lg-3">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Filtro Completados: <span class="tx-danger">*</span></label>
                                <select class="form-control" style="width:100%" name="combo_completo_certificado" id="combo_completo_certificado" data-placeholder="Selecciona">
                                    <option label="Seleccione"></option>
                                </select>
                            </div>
                        </div><!-- col-3 -->
                        <div class="col-lg-3">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Filtro Urb: <span class="tx-danger">*</span></label>
                                <select class="form-control" style="width:100%" name="combo_urb_certificado" id="combo_urb_certificado" data-placeholder="Selecciona">
                                    <option label="Seleccione"></option>
                                </select>
                            </div>
                        </div><!-- col-3 -->
                    </div><!-- row -->
                    
                    <div class="row mg-b-20 justify-content-center">
                        <div class="col-lg-3 ">
                            <button id="generate_report_certificado" class="btn btn-primary w-100">Generar Reporte</button>
                        </div>
                    </div>

                    
                    <div class="row mg-b-20">
                        <div class="table-wrapper "  style="max-width: 1200px; margin: 0 auto;" >
                            <table id="home_data_certificados" style="display:block; width: 100%; max-width: 1200px; overflow-x: auto;" class="table display responsive nowrap">
                                <thead>
                                    <tr>
                                    
                                        <th class="wd-10p">TIPO DE URBANIZACION</th>    
                                        <th class="wd-10p">Mz.</th>    
                                        <th class="wd-10p">LOTE</th>   
                                        <th class="wd-10p">ETAPA</th>  
                                        <th class="wd-10p">PROPIETARIO (1)</th>    
                                        <th class="wd-10p">DNI (1)</th>    
                                        <th class="wd-10p">ESTADO CIVIL (1)</th>    
                                        <th class="wd-10p">PROPIETARIO (2)</th>   
                                        <th class="wd-10p">DNI (2)</th>    
                                        <th class="wd-10p">ESTADO CIVIL (2)</th>    
                                        <th class="wd-10p">AREA</th>    
                                        <th class="wd-10p">PERIMETRO</th>   
                                        <th class="wd-10p">POR EL FRENTE</th>    
                                        <th class="wd-10p">POR LA DERECHA ENTRANDO</th>    
                                        <th class="wd-10p">POR LA IZQUIERDA ENTRANDO</th>    
                                        <th class="wd-10p">POR FONDO</th>    
                                        <th class="wd-10p">NUM. REG. DOC.</th>    
                                        <th class="wd-10p">NUM. EXPE</th>    
                                        <th class="wd-10p">TEC. INF.</th>    
                                        <th class="wd-10p">NUM. ACTA INSP.</th>    
                                        <th class="wd-10p">INSP. NOMBRE</th>  
                                        <th class="wd-10p">INSP. AP. PATERNO</th>
                                        <th class="wd-10p">INSP. AP. MATERNO</th>  
                                        <th class="wd-10p">INSP. DNI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="br-section-wrapper">
                <p class="mg-b-30 tx-gray-600">Resumen de Titulos</p>
                <div class="form-layout form-layout-1">
                <div class="row justify-content-center">
                        <div class="col-lg-3">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Filtro Fecha: <span class="tx-danger">*</span></label>
                                <select class="form-control" style="width:100%" name="combo_fecha_titulo" id="combo_fecha_titulo" data-placeholder="Selecciona">
                                    <option label="Seleccione"></option>
                                </select>
                            </div>
                        </div><!-- col-3 -->
                        <div class="col-lg-3">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Filtro Completados: <span class="tx-danger">*</span></label>
                                <select class="form-control" style="width:100%" name="combo_completo_titulo" id="combo_completo_titulo" data-placeholder="Selecciona">
                                    <option label="Seleccione"></option>
                                </select>
                            </div>
                        </div><!-- col-3 -->
                        <div class="col-lg-3">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Filtro urb: <span class="tx-danger">*</span></label>
                                <select class="form-control" style="width:100%" name="combo_urb_titulo" id="combo_urb_titulo" data-placeholder="Selecciona">
                                    <option label="Seleccione"></option>
                                </select>
                            </div>
                        </div><!-- col-3 -->
                    </div><!-- row -->

                    <div class="row mg-b-20 justify-content-center" >
                        <div class="col-lg-3">
                            <button id="generate_report_titulo" class="btn btn-primary w-100">Generar Reporte</button>
                        </div>
                    </div>

                    <div class="row mg-b-20">
                        <div class="table-wrapper" style="max-width: 1200px; margin: 0 auto;">
                            <table id="home_data_titulos" style="display:block; width: 100%; max-width: 1200px; overflow-x: auto;" class="table display responsive nowrap">
                                <thead>
                                    <tr>
                                        <th class="wd-10p">PARTIDA ELECTRONICA</th>    
                                        <th class="wd-10p">SERIE</th>    
                                        <th class="wd-10p">Nº DE TITULO DE PROPIEDAD</th>    
                                        <th class="wd-10p">TIPO DE URBANIZACION</th>    
                                        <th class="wd-10p">Mz.</th>    
                                        <th class="wd-10p">LOTE</th>    
                                        <th class="wd-10p">EMPADRON.</th>    
                                        <th class="wd-10p">ASIENTO</th>    
                                        <th class="wd-10p">PROPIETARIO (1)</th>    
                                        <th class="wd-10p">DNI (1)</th>    
                                        <th class="wd-10p">ESTADO CIVIL (1)</th>    
                                        <th class="wd-10p">PROPIETARIO (2)</th>   
                                        <th class="wd-10p">DNI (2)</th>    
                                        <th class="wd-10p">ESTADO CIVIL (2)</th>    
                                        <th class="wd-10p">PARTIDA ELECTRONICA DE LOTE</th>    
                                        <th class="wd-10p">AREA</th>    
                                        <th class="wd-10p">POR EL FRENTE</th>    
                                        <th class="wd-10p">POR LA DERECHA ENTRANDO</th>    
                                        <th class="wd-10p">POR LA IZQUIERDA ENTRANDO</th>    
                                        <th class="wd-10p">POR FONDO</th>    
                                        <th class="wd-10p">TIPO DE TITULO</th>    
                                        <th class="wd-10p">RESOLUCION GERENCIAL</th>    
                                        <th class="wd-10p">FECHA DE EMISION RESOLUCION</th>    
                                        <th class="wd-10p">FECHA DE EMISION DE TITULO</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- ########## END: MAIN PANEL ########## -->

    <?php require_once("../../view/html/MainJs.php"); ?>
    <script type="text/javascript" src="usuhome.js"></script>
  </body>
</html>
<?php 
 }else{
    /* Si no ha iniciado sesión se redirecciona a la ventana principal */
    header("Location:".Conectar::ruta()."view/404/");
 }
?>