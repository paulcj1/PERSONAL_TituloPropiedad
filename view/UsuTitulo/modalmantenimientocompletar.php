<div id="modalmantenimientocompletar" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0">
            <div class="modal-header pd-y-20 pd-x-25">
                <h6 id="lbltitulo" class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"></h6>
            </div>
            <form method="post" id="titulos_completar_form">
                <div id="wizard4">
                    <h3>Titulo</h3>
                    <section>
                        <div id="mantenimientocompletar">
                        <input  name="titu_id_completar" id="titu_id_completar"/>
                            <div class="form-layout form-layout-1">
                                <div id="infopropietarioContainer">
                                    <!-- Aquí podrías incluir elementos adicionales según sea necesario -->
                                </div>
                                <div class="row mg-b-10">
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <label class="form-control-label">Num. Recibo: <span class="tx-danger">*</span></label>
                                            <input class="form-control" type="text" name="titu_numrecibo" id="titu_numrecibo" placeholder="Num. Recibo" required data-parsley-required-message="Por favor, adjunte un numero de recibo."/>
                                        </div>
                                    </div>
                                </div><!-- row -->
                            </div><!-- form-layout -->
                        </div>
                    </section>
                </div><!-- wizard4 -->

                <div class="modal-footer">
                    <button type="submit" id="btnGuardarRecibo" name="action" value="add" class="btn btn-outline-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">
                        <i class="fa fa-check"></i> Guardar
                    </button>
                    <button type="reset" class="btn btn-outline-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" aria-label="Close" aria-hidden="true" data-dismiss="modal">
                        <i class="fa fa-close"></i> Cancelar
                    </button>
                </div><!-- modal-footer -->
            </form><!-- titulos_completar_form -->
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modalmantenimientocompletar -->