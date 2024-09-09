<div id="modalfile" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0">
            <div class="modal-header pd-y-20 pd-x-25">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Seleccione Archivo PDF</h6>
            </div>

            <form method="post" id="adjuntar_form" enctype="multipart/form-data">
                <input type="hidden" name="certx_idx" id="certx_idx"/>

                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <input type="file" id="cert_firmapdf" name="cert_firmapdf" accept=".pdf" required data-parsley-required-message="Por favor, adjunte un archivo PDF."/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnGuardarPDF" name="action" value="add" class="btn btn-outline-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">
                        <i class="fa fa-check"></i> Guardar
                    </button>
                    <button type="reset" class="btn btn-outline-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" aria-label="Close" aria-hidden="true" data-dismiss="modal">
                        <i class="fa fa-close"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>