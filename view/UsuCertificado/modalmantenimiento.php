<div id="modalmantenimiento" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0">
            <div class="modal-header pd-y-20 pd-x-25">
                <h6 id="lbltitulo" class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"></h6>
            </div>
            <!-- Formulario Mantenimiento -->
            
                <div id="wizard4">
                <h3>Propietarios</h3>
                    <section>
                        <div id="mantenimientopropietario">
                            <div role="document">
                                <form method="post" id="propietarios_form">
                                    <div id="propietariosContainer">
                                       
                                    </div><!-- propietariosContainer -->
                                    <br>
                                    <button type="button" class="btn btn-secondary" style="width:100%" id="addpropietario" onclick="addPropietario()">Añadir Otro Propietario</button>
                                </form>
                            </div><!-- role=document -->
                        </div><!-- mantenimientopropietario -->
                    </section>
                    
                    <h3>Certificado</h3>
                    <section>
                    <div id="mantenimientocertificado">
                            <div role="document">
                                <form method="post" id="certificados_form">
                                    <input type="hidden" name="cert_id" id="cert_id"/>
                                    <div class="form-layout form-layout-1" style ="background-color: white;">
                                        <div class="row mg-b-20">
                                            <div class="col-lg-3">
                                                <div class="form-group mg-b-10-force">
                                                <label class="form-control-label">Tipo Via. :<span class="tx-danger">*</span></label>
                                                <select class="form-control" style="width:100%" name="tivi_id" id="tivi_id" data-placeholder="Selecciona" required data-parsley-required-message="Este campo es obligatorio">
                                                    <option label="Selecciona"></option>
                                                    
                                                </select>
                                                </div>
                                            </div><!-- col-4 -->
                                            <div class="col-lg-3">
                                                <div class="form-group mg-b-10-force">
                                                <label class="form-control-label">Nombre Via: <span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="cert_nomtipovia" id="cert_nomtipovia" placeholder="Nombre via" required data-parsley-required-message="Este campo es obligatorio"> 
                                                
                                                </div>
                                            </div><!-- col-8 -->
                                            <div class="col-lg-2">
                                                <div class="form-group mg-b-10-force">
                                                <label class="form-control-label">Manzana: <span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="cert_manzana" id="cert_manzana" placeholder="Manzana" required data-parsley-required-message="Este campo es obligatorio" data-only-letters>
                                                <small id="cert_manzana_error" class="form-text text-danger" style="display:none;"></small>
                                                </div>
                                            </div><!-- col-8 -->
                                            <div class="col-lg-2">
                                                <div class="form-group mg-b-10-force">
                                                <label class="form-control-label">Lote: <span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="cert_lote" id="cert_lote" placeholder="Lote" required data-parsley-required-message="Este campo es obligatorio" data-only-numbers>
                                                <small id="cert_lote_error" class="form-text text-danger" style="display:none;"></small>
                                                </div>
                                            </div><!-- col-8 -->
                                            <div class="col-lg-2">
                                                <div class="form-group mg-b-10-force">
                                                <label class="form-control-label">Etapa: <span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="cert_etapa" id="cert_etapa" placeholder="Etapa" required data-parsley-required-message="Este campo es obligatorio">
                                                </div>
                                            </div><!-- col-8 -->
                                            
                                            <div class="col-lg-4">
                                                <div class="form-group mg-b-10-force">
                                                    <label class="form-control-label">Tipo Urb. :<span class="tx-danger">*</span></label>
                                                    <select class="form-control" style="width:100%" name="tiur_id" id="tiur_id" data-placeholder="Selecciona" required data-parsley-required-message="Este campo es obligatorio">
                                                        <option label="Selecciona"></option>
                                                        
                                                    </select>
                                                </div>
                                            </div><!-- col-4 -->
                                            <div class="col-lg-3">
                                                <div class="form-group mg-b-10-force">
                                                    <label class="form-control-label">Nombre Urb. :<span class="tx-danger">*</span></label>
                                                    <input class="form-control" type="text" name="cert_nomtipourb" id="cert_nomtipourb" placeholder="Nombre Urb." required data-parsley-required-message="Este campo es obligatorio">
                                                </div>
                                            </div><!-- col-8 -->
                                            <div class="col-lg-5">
                                                <div class="form-group mg-b-10-force">
                                                    <label class="form-control-label">Uso :<span class="tx-danger">*</span></label>
                                                    <input class="form-control" type="text" name="cert_uso" id="cert_uso" placeholder="Uso" required data-parsley-required-message="Este campo es obligatorio">
                                                </div>
                                            </div><!-- col-8 -->
                                            <div class="col-lg-12">
                                                <hr><!-- Línea divisoria -->
                                            </div><!-- col-4 -->
                                            <div class="col-lg-6">
                                                <div class="form-group mg-b-10-force">
                                                    <label class="form-control-label">Perimetro (ml):<span class="tx-danger">*</span></label>
                                                    <input class="form-control" type="text" name="cert_perimetro" id="cert_perimetro" placeholder="Perimetro" required data-parsley-required-message="Este campo es obligatorio" data-only-numbers>
                                                    <small id="cert_perimetro_error" class="form-text text-danger" style="display:none;"></small>
                                                </div>
                                            </div><!-- col-8 -->
                                            <div class="col-lg-6">
                                                <div class="form-group mg-b-10-force">
                                                    <label class="form-control-label">Area (m2):<span class="tx-danger">*</span></label>
                                                    <input class="form-control" type="text" name="cert_area" id="cert_area" placeholder="Area" required data-parsley-required-message="Este campo es obligatorio" data-only-numbers>
                                                    <small id="cert_area_error" class="form-text text-danger" style="display:none;"></small>
                                                </div>
                                            </div><!-- col-8 -->
                                            <div class="col-lg-4">
                                                <div class="form-group mg-b-10-force">
                                                <label class="form-control-label">Por el frente :<span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="cert_frente" id="cert_frente" placeholder="Frente" required data-parsley-required-message="Este campo es obligatorio">
                                                </div>
                                            </div><!-- col-8 -->
                                            <div class="col-lg-2">
                                                <div class="form-group mg-b-10-force">
                                                <label class="form-control-label">M. Frente:<span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="cert_medfrente" id="cert_medfrente" placeholder="Medida" required data-parsley-required-message="Este campo es obligatorio" data-only-numbers>
                                                <small id="cert_medfrente_error" class="form-text text-danger" style="display:none;"></small>
                                                </div>
                                            </div><!-- col-8 -->
                                            <div class="col-lg-4">
                                                <div class="form-group mg-b-10-force">
                                                <label class="form-control-label">Por la derecha :<span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="cert_derecha" id="cert_derecha" placeholder="Derecha" required data-parsley-required-message="Este campo es obligatorio">
                                                </div>
                                            </div><!-- col-8 -->
                                            <div class="col-lg-2">
                                                <div class="form-group mg-b-10-force">
                                                <label class="form-control-label">M. Derecha:<span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="cert_medderecha" id="cert_medderecha" placeholder="Medida" required data-parsley-required-message="Este campo es obligatorio" data-only-numbers>
                                                <small id="cert_medderecha_error" class="form-text text-danger" style="display:none;"></small>
                                                </div>
                                            </div><!-- col-8 -->
                                            <div class="col-lg-4">
                                                <div class="form-group mg-b-10-force">
                                                <label class="form-control-label">Por la izquierda :<span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="cert_izquierda" id="cert_izquierda" placeholder="Izquierda" required data-parsley-required-message="Este campo es obligatorio">
                                                </div>
                                            </div><!-- col-8 -->
                                            <div class="col-lg-2">
                                                <div class="form-group mg-b-10-force">
                                                <label class="form-control-label">M. Izq:<span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="cert_medizquierda" id="cert_medizquierda" placeholder="Medida" required data-parsley-required-message="Este campo es obligatorio" data-only-numbers>
                                                <small id="cert_medizquierda_error" class="form-text text-danger" style="display:none;"></small>
                                                </div>
                                            </div><!-- col-8 -->
                                            <div class="col-lg-4">
                                                <div class="form-group mg-b-10-force">
                                                    <label class="form-control-label">Por el fondo :<span class="tx-danger">*</span></label>
                                                    <input class="form-control" type="text" name="cert_fondo" id="cert_fondo" placeholder="Fondo" required data-parsley-required-message="Este campo es obligatorio">
                                                </div>
                                            </div><!-- col-8 -->
                                            <div class="col-lg-2">
                                                <div class="form-group mg-b-10-force">
                                                    <label class="form-control-label">M. Fondo :<span class="tx-danger">*</span></label>
                                                    <input class="form-control" type="text" name="cert_medfondo" id="cert_medfondo" placeholder="Medida" required data-parsley-required-message="Este campo es obligatorio" data-only-numbers>
                                                    <small id="cert_medfondo_error" class="form-text text-danger" style="display:none;"></small>
                                                </div>
                                            </div><!-- col-8 -->
                                            <div class="col-lg-12">
                                                <hr><!-- Línea divisoria -->
                                            </div><!-- col-4 -->
                                            <div class="col-lg-4">
                                                <div class="form-group mg-b-10-force">
                                                <label class="form-control-label">Reg. Nº :<span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="cert_numregdoc" id="cert_numregdoc" placeholder="Reg. Doc." required data-parsley-required-message="Este campo es obligatorio">
                                                </div>
                                            </div><!-- col-8 -->
                                            <div class="col-lg-4">
                                                <div class="form-group mg-b-10-force">
                                                <label class="form-control-label">Inf Tec. Nº :<span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="cert_tecinf" id="cert_tecinf" placeholder="Inf. Tec." required data-parsley-required-message="Este campo es obligatorio" data-only-numbers>
                                                <small id="cert_tecinf_error" class="form-text text-danger" style="display:none;"></small>
                                                </div>
                                            </div><!-- col-8 -->
                                            <div class="col-lg-4">
                                                <div class="form-group mg-b-10-force">
                                                <label class="form-control-label">Num. Acta :<span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="cert_numactainsp" id="cert_numactainsp" placeholder="Num. Acta." required data-parsley-required-message="Este campo es obligatorio" data-only-numbers>
                                                <small id="cert_numactainsp_error" class="form-text text-danger" style="display:none;"></small>
                                                </div>
                                            </div><!-- col-8 -->
                                            <div class="col-lg-6">
                                                <div class="form-group mg-b-10-force">
                                                <label class="form-control-label">Num. Recibo DI :<span class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="cert_numrecibo_derinsp" id="cert_numrecibo_derinsp" placeholder="Num. Recib." required data-parsley-required-message="Este campo es obligatorio" data-only-numbers>
                                                <small id="cert_numrecibo_derinsp_error" class="form-text text-danger" style="display:none;"></small>
                                                </div>
                                            </div><!-- col-8 -->
                                            <div class="col-lg-6">
                                                <div class="form-group mg-b-10-force">
                                                <label class="form-control-label">Inspector. :<span class="tx-danger">*</span></label>
                                                <select class="form-control" style="width:100%" name="insp_id" id="insp_id" data-placeholder="Selecciona" required data-parsley-required-message="Este campo es obligatorio">
                                                    <option label="Selecciona"></option>
                                                    
                                                </select>
                                                </div>
                                            </div><!-- col-4 -->
                                        </div><!-- row -->

                                        <div class="form-layout-footer">
                                            
                                        </div><!-- form-layout-footer -->
                                    </div><!-- form-layout -->
                                </form>
                            </div>
                        </div>
                    </section>
                    
                </div>
        
      
            <div class="modal-footer">
                <button id="btnGuardar" name="action" value="add" class="btn btn-outline-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">
                    <i class="fa fa-check"></i> Guardar
                </button>
                <button type="reset" class="btn btn-outline-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" aria-label="Close" aria-hidden="true" data-dismiss="modal">
                    <i class="fa fa-close"></i> Cancelar
                </button>
            </div>
            
        </div>
    </div>
</div>


