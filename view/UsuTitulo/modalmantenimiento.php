<div id="modalmantenimiento" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0">
            <div class="modal-header pd-y-20 pd-x-25">
                <h6 id="lbltitulo" class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"></h6>
            </div>
            <form method="post" id="titulos_form">
                <div id="wizard4">
                    <h3>Titulos</h3>
                    <section>
                        <div id="mantenimientotitulo">
                            <div role="document">
                                <h4>Titulo</h4>
                                <input type="hidden" name="titu_id" id="titu_id"/>
                                <input  name="cert_id" id="cert_id"/>
                                <input type="hidden" name="alca_id" id="alca_id"/>
                                <div class="form-layout form-layout-1">
                                    <div class="row mg-b-10">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="form-control-label">Part. Elec.: <span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="titu_partelec" id="titu_partelec" placeholder="Part. Elec." required data-only-numbers/>
                                                <small id="titu_partelec_error" class="form-text text-danger" style="display:none;"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="form-control-label">Part. Lote: <span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="titu_partlote" id="titu_partlote" placeholder="Part. Lote" required data-only-numbers/>
                                                <small id="titu_partlote_error" class="form-text text-danger" style="display:none;"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="form-control-label">Asiento: <span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="titu_asiento" id="titu_asiento" placeholder="Asiento" required/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="form-control-label">Serie: <span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="titu_serie" id="titu_serie" placeholder="Serie" required/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group mg-b-10-force">
                                                <label class="form-control-label">Tipo Titulo: <span class="tx-danger">*</span></label>
                                                <select class="form-control" style="width:100%" name="titu_tipo" id="titu_tipo" data-placeholder="Selecciona" required>
                                                    <option label="Seleccione"></option>
                                                    <option value="Gratuito">Gratuito</option>
                                                    <option value="Oneroso">Oneroso</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="form-control-label">Tazacion: <span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="titu_tazacion" id="titu_tazacion" placeholder="Tazacion" required data-only-numbers/>
                                                <small id="titu_tazacion_error" class="form-text text-danger" style="display:none;"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group mg-b-10-force">
                                                <label class="form-control-label">Emp: <span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="titu_emp" id="titu_emp" placeholder="Emp." required data-only-numbers/>
                                                <small id="titu_emp_error" class="form-text text-danger" style="display:none;"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group mg-b-10-force">
                                                <label class="form-control-label">Sector: <span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="titu_sector" id="titu_sector" placeholder="Sector" required/>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <hr><!-- Línea divisoria -->
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Num. Resolucion: <span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="titu_numresolucion" id="titu_numresolucion" placeholder="Num. Reso." required data-only-numbers/>
                                                <small id="titu_numresolucion_error" class="form-text text-danger" style="display:none;"></small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Fech. Resolucion: <span class="tx-danger">*</span></label>
                                                <input class="form-control" type="date" name="titu_fecharesolucion" id="titu_fecharesolucion" placeholder="Fech. Reso." required/>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Fech. Emision: <span class="tx-danger">*</span></label>
                                                <input class="form-control" type="date" name="titu_fechaemision" id="titu_fechaemision" placeholder="Fech. Emision" required/>
                                            </div>
                                        </div>
                                    </div><!-- row -->
                                </div><!-- form-layout -->
                                <br>
                            </div>
                        </div>
                    </section>
                </div><!-- wizard4 -->

                <div class="modal-footer">
                    <button type="submit" id="btnGuardar" name="action" value="add" class="btn btn-outline-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">
                        <i class="fa fa-check"></i> Guardar
                    </button>
                    <button type="reset" class="btn btn-outline-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" aria-label="Close" aria-hidden="true" data-dismiss="modal">
                        <i class="fa fa-close"></i> Cancelar
                    </button>
                </div><!-- modal-footer -->
            </form><!-- wizard_form -->
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modalmantenimiento -->
