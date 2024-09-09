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
       
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5">Certificados</h4>
            <p class="mg-b-0">Pantalla Certificados</p>
            <!-- En este div va el contenido de la pagina que va a cambiar -->
            <div class="br-pagebody">
                <div class="br-section-wrapper">
                    

                    <div class="br-pagebody mg-t-5 pd-x-30">
                        <div class="row row-sm justify-content-center">
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-primary rounded overflow-hidden">
                                    <div class="pd-25 d-flex align-items-center">
                                        <i class="ion ion-document tx-60 lh-0 tx-white op-7"></i>
                                        <div class="mg-l-20">
                                            <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Pendientes</p>
                                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1" id="lblpendientes" name="lblpendientes"></p>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- col-3 -->
                            <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
                                <div class="bg-danger rounded overflow-hidden">
                                    <div class="pd-25 d-flex align-items-center">
                                        <i class="ion ion-close tx-60 lh-0 tx-white op-7"></i>
                                        <div class="mg-l-20">
                                            <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Descargables</p>
                                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1" id="lbldescargables" name="lbldescargables"></p>
                                        </div>
                                        <a href="#" class="btn btn-outline-white btn-icon mg-r-5" style="margin-left:30px;" onclick="imp_masivo()"><div><i class="fa fa-download"></i></div></a>
                                    </div>
                                </div>
                            </div><!-- col-3 -->
                        </div><!-- row -->
                        <br>
                        

                

                        <div class="table-wrapper">
                            <table id="certificados_data" class="table display">
                                <thead>
                                    <tr>
                                        <th class="wd-10p"></th>
                                        <th class="wd-10p">Datos Propietarios</th>
                                        <th class="wd-10p">Area</th>
                                        <th class="wd-10p">Perimetro</th>
                                        <th class="wd-10p">Direccion</th>
                                        <th class="wd-10p">Uso</th>
                                        <th class="wd-10p">Num. Reg. Doc.</th>
                                        <th class="wd-10p">Num. Expediente</th>
                                        <th class="wd-10p">Inf. Tec.</th>
                                        <th class="wd-10p">Num. Cert.</th>
                                        <th class="wd-10p">Num. Acta Insp.</th>
                                        <th class="wd-10p">Insp. Nom.</th>
                                        <th class="wd-10p">Insp. DNI</th>
                                        <th class="wd-10p"></th>
                                        <th class="wd-10p"></th>
                                        <th class="wd-10p"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div><!-- table-wrapper -->

                    </div><!-- br-pagebody -->
                </div><!-- br-section-wrapper -->
            </div><!-- br-pagebody -->
        </div><!-- pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30 -->
    </div><!-- br-mainpanel -->

    <!-- ########## END: MAIN PANEL ########## -->
    <?php require_once("modalfile.php"); ?>
    <?php require_once("../../view/html/MainJs.php"); ?>
    <script type="text/javascript" src="subgerentecertificado.js"></script>
</body>
</html>
<?php 
}else{
    /* Si no ha iniciado sesión se redireccionada a la ventana principal */
    header("Location:".Conectar::ruta()."view/404/");
}
?>
