<!DOCTYPE html>
<html lang="es" class="pos-relative">
    <head>
        <?php require_once("../html/MainHead.php"); ?>
        <title>Titulo</title>
    </head>

  <body class="pos-relative">

    <div class="ht-100v d-flex align-items-center justify-content-center">
      <div class="wd-lg-70p wd-xl-50p tx-center pd-x-40">
        <h1 class="tx-100 tx-xs-140 tx-normal tx-inverse tx-roboto mg-b-0">

          <canvas id="canvas" height="900px" width="650px" class="img-fluid" alt="Responsive image"></canvas>

        </h1>
        <br>

        <div class="form-layout-footer">
            <button class="btn btn-outline-info" id="btnpng"><i class="fa fa-send mg-r-10"></i> PNG</button>
            <button class="btn btn-outline-success" id="btnpdf"><i class="fa fa-send mg-r-10"></i> PDF</button>
        </div>

      </div>
    </div>

    <?php require_once("../html/MainJs.php"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <script type="text/javascript" src="doctitulo.js"></script>
  </body>
</html>
