<?php
  /* Llamamos al archivo de conexion.php */
  require_once("../../config/conexion.php");
  if(isset($_SESSION["usua_id"])){
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php require_once("../../view/html/MainHead.php"); ?>
    
    <title>Empresa::Perfil</title>
  </head>

  <body>

    <?php require_once("../../view/html/MainMenu.php"); ?>

    <?php require_once("../../view/html/MainHeader.php"); ?>

    <div class="br-mainpanel">
      <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="#">Perfil</a>
        </nav>
      </div>
      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Perfil</h4>
        <p class="mg-b-0">Pantalla Perfil</p>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Perfil</h6>
          <p class="mg-b-30 tx-gray-600">Actualize sus datos</p>

          <div class="form-layout form-layout-1">
            <div class="row mg-b-25">
            <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">DNI: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="number" name="usua_dni" id="usua_dni" readonly>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Nombre: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="usua_nom" id="usua_nom" placeholder="Nombre" readonly>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Apellido Paterno: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="usua_apep" id="usua_apep" placeholder="Apellido Paterno" readonly>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Apellido Materno: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="usua_apem" id="usua_apem" placeholder="Apellido Materno" readonly>
                </div>
              </div>
              
              <div class="col-lg-7">
                <div class="form-group">
                  <label class="form-control-label">Contraseña: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="password" name="usua_pass" id="usua_pass" placeholder="Ingrese Contraseña" >
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">Nueva Contraseña: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="password" name="usua_pass_nueva" id="usua_pass_nueva" placeholder="Ingrese Contraseña">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">Confirma Contraseña: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="password" name="usua_pass_nueva_val" id="usua_pass_nueva_val" placeholder="Ingrese Contraseña">
                </div>
              </div>
            </div>

            <div class="form-layout-footer">
              <button class="btn btn-info" id="btnactualizar">Actualizar</button>
            </div>
          </div>

        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <?php require_once("../../view/html/MainJs.php"); ?>
    
    <script type="text/javascript" src="usuperfil.js"></script>
    
  </body>
</html>
<?php
  }else{
    /* Si no a iniciado sesion se redireccionada a la ventana principal */
    header("Location:".Conectar::ruta()."view/404/");
  }
?>



