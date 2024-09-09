<?php
    class Certificado extends Conectar{
        
        public function insert_certificado_propietario($cert_id, $prop_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO sc_titulopropiedad.td_certificado_propietario (cert_id, prop_id, usua_id, cepr_fecharegistro, est) VALUES (?,?,'1',now(),'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->bindValue(2, $prop_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_certificado_propietario($cepr_id, $cert_id, $prop_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.td_certificado_propietario
            SET
                cert_id =?,
                prop_id = ?
            WHERE
                cepr_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->bindValue(2, $prop_id);
            $sql->bindValue(3, $cepr_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function delete_certificado_propietario($cert_id, $prop_id){
            $conectar = parent::conexion();
            parent::set_names();
            
            // Paso 1: Obtener el cepr_id basado en cert_id y prop_id
            $sql = "SELECT cepr_id FROM sc_titulopropiedad.td_certificado_propietario
                    WHERE cert_id = ? AND prop_id = ?
                    LIMIT 1";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $cert_id, PDO::PARAM_INT);
            $sql->bindValue(2, $prop_id, PDO::PARAM_INT);
            $sql->execute();
            
            $result = $sql->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                $cepr_id = $result['cepr_id'];
                
                // Paso 2: Eliminar el registro usando cepr_id
                $sql_delete = "DELETE FROM sc_titulopropiedad.td_certificado_propietario 
                               WHERE cepr_id = ?";
                $sql_delete = $conectar->prepare($sql_delete);
                $sql_delete->bindValue(1, $cepr_id, PDO::PARAM_INT);
                $sql_delete->execute();
                
                return $sql_delete->rowCount(); // Debería retornar 1 si la eliminación fue exitosa
            } else {
                return 0; // No se encontró ningún registro con ese cert_id y prop_id
            }
        }

        public function insert_certificado( $insp_id,$tivi_id,$tiur_id,$cert_area,$cert_perimetro,$cert_uso,$cert_frente,$cert_derecha,$cert_izquierda,$cert_fondo,$cert_medfrente,$cert_medderecha,$cert_medizquierda,$cert_medfondo,$cert_manzana,$cert_lote,$cert_etapa,$cert_numregdoc,$cert_tecinf,$cert_numactainsp,$cert_nomtipourb,$cert_nomtipovia,$cert_numrecibo_derinsp){
            $conectar= parent::conexion();
            parent::set_names();
            // Obtener el año actual
            $currentYear = date('Y');
            
            // Obtener el año de la última fecha de creación para el mismo tipo de certificado
            $sql = "SELECT EXTRACT(YEAR FROM MAX(cert_fechcrea)) as last_year FROM sc_titulopropiedad.tb_certificado";
            $stmt = $conectar->prepare($sql);
            $stmt->execute();
            $lastYear = $stmt->fetchColumn();
            
            // Reiniciar el contador numcert si el año actual es mayor por 1
            if ($currentYear > $lastYear) {
                $sql = "ALTER SEQUENCE sc_titulopropiedad.seq_cert_numcert RESTART WITH 1;";
                $stmt = $conectar->prepare($sql);
                $stmt->execute();
            }
            $sql="INSERT INTO sc_titulopropiedad.tb_certificado (insp_id,tivi_id,tiur_id,cert_area,cert_perimetro,cert_uso,cert_frente,cert_derecha,cert_izquierda,cert_fondo,cert_medfrente,cert_medderecha,cert_medizquierda,cert_medfondo,cert_manzana,cert_lote,cert_etapa,cert_numregdoc,cert_tecinf,cert_numactainsp,cert_nomtipourb,cert_nomtipovia,cert_numrecibo_derinsp,cert_numexpe,cert_fechcrea,cert_estadj,cert_estfirma,est,cert_estimp,cert_est,cert_estent,cert_esttitu) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,'673632',now(),'0','0','1','0','0','0','0') RETURNING cert_id;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $insp_id);
            $sql->bindValue(2, $tivi_id);
            $sql->bindValue(3, $tiur_id);
            $sql->bindValue(4, $cert_area);
            $sql->bindValue(5, $cert_perimetro);
            $sql->bindValue(6, $cert_uso);
            $sql->bindValue(7, $cert_frente);
            $sql->bindValue(8, $cert_derecha);
            $sql->bindValue(9, $cert_izquierda);
            $sql->bindValue(10, $cert_fondo);
            $sql->bindValue(11, $cert_medfrente);
            $sql->bindValue(12, $cert_medderecha);
            $sql->bindValue(13, $cert_medizquierda);
            $sql->bindValue(14, $cert_medfondo);
            $sql->bindValue(15, $cert_manzana);
            $sql->bindValue(16, $cert_lote);
            $sql->bindValue(17, $cert_etapa);
            $sql->bindValue(18, $cert_numregdoc);
            $sql->bindValue(19, $cert_tecinf);
            $sql->bindValue(20, $cert_numactainsp);
            $sql->bindValue(21, $cert_nomtipourb);
            $sql->bindValue(22, $cert_nomtipovia);
            $sql->bindValue(23, $cert_numrecibo_derinsp);
            $sql->execute();
            $cert_id = $sql->fetchColumn();
            return $cert_id;
        }
      
        
        public function update_certificado($cert_id,$insp_id,$tivi_id,$tiur_id,$cert_area,$cert_perimetro,$cert_uso,$cert_frente,$cert_derecha,$cert_izquierda,$cert_fondo,$cert_medfrente,$cert_medderecha,$cert_medizquierda,$cert_medfondo,$cert_manzana,$cert_lote,$cert_etapa,$cert_numregdoc,$cert_tecinf,$cert_numactainsp,$cert_nomtipourb,$cert_nomtipovia,$cert_numrecibo_derinsp){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_certificado
                SET

                    insp_id =?,
                    tivi_id =?,
                    tiur_id =?,
                    cert_area = ?,
                    cert_perimetro = ?,
                    cert_uso = ?,
                    cert_frente = ?,
                    cert_derecha = ?,
                    cert_izquierda = ?,
                    cert_fondo = ?,
                    cert_medfrente = ?,
                    cert_medderecha = ?,
                    cert_medizquierda = ?,
                    cert_medfondo = ?,
                    cert_manzana = ?,
                    cert_lote = ?,
                    cert_etapa = ?,
                    cert_numregdoc = ?,
                    cert_tecinf = ?,
                    cert_numactainsp = ?,
                    cert_nomtipourb = ?,
                    cert_nomtipovia = ?,
                    cert_numrecibo_derinsp = ?
                WHERE
                    cert_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $insp_id);
            $sql->bindValue(2, $tivi_id);
            $sql->bindValue(3, $tiur_id);
            $sql->bindValue(4, $cert_area);
            $sql->bindValue(5, $cert_perimetro);
            $sql->bindValue(6, $cert_uso);
            $sql->bindValue(7, $cert_frente);
            $sql->bindValue(8, $cert_derecha);
            $sql->bindValue(9, $cert_izquierda);
            $sql->bindValue(10, $cert_fondo);
            $sql->bindValue(11, $cert_medfrente);
            $sql->bindValue(12, $cert_medderecha);
            $sql->bindValue(13, $cert_medizquierda);
            $sql->bindValue(14, $cert_medfondo);
            $sql->bindValue(15, $cert_manzana);
            $sql->bindValue(16, $cert_lote);
            $sql->bindValue(17, $cert_etapa);
            $sql->bindValue(18, $cert_numregdoc);
            $sql->bindValue(19, $cert_tecinf);
            $sql->bindValue(20, $cert_numactainsp);
            $sql->bindValue(21, $cert_nomtipourb);
            $sql->bindValue(22, $cert_nomtipovia);
            $sql->bindValue(23, $cert_numrecibo_derinsp);
            $sql->bindValue(24, $cert_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
            
        }
        
        public function delete_certificado($cert_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_certificado
                SET
                    est = 0
                WHERE
                    cert_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function cambiarestado_entrega($cert_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_certificado
                SET
                    cert_estent = 1
                WHERE
                    cert_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function cambiarestado_impreso($cert_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_certificado
                SET
                    cert_estimp = 1
                WHERE
                    cert_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function cambiarestado_noimpreso($cert_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_certificado
                SET
                    cert_estimp = 0
                WHERE
                    cert_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function cambiarestado_completo($cert_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_certificado
                SET
                    cert_est = 1
                WHERE
                    cert_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        
        public function cambiarestado_titulado($cert_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_certificado
                SET
                    cert_esttitu = 1
                WHERE
                    cert_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function cambiarestado_notitulado($cert_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_certificado
                SET
                    cert_esttitu = 0
                WHERE
                    cert_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function cambiarestado_adjuntado($cert_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_certificado
                SET
                    cert_estadj = 1
                WHERE
                    cert_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function cambiarestado_noadjuntado($cert_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_certificado
                SET
                    cert_estadj = 0
                WHERE
                    cert_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function cambiarestado_firmado($cert_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_certificado
                SET
                    cert_estfirma = 1
                WHERE
                    cert_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function cambiarestado_firmado2($cert_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_certificado
                SET
                    cert_estfirma = 2
                WHERE
                    cert_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function cambiarestado_firmado3($cert_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_certificado
                SET
                    cert_estfirma = 3
                WHERE
                    cert_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function get_certificado(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        STRING_AGG(
                                p.prop_dni,
                            ' , '
                        ) AS DatosPropietarios,
                        c.cert_id,
                        MAX(c.cert_area) AS cert_area,
                        MAX(c.cert_perimetro) AS cert_perimetro,
						MAX(tu.tiur_abr) AS tiur_abr,
						MAX(c.cert_nomtipourb) AS cert_nomtipourb,
						MAX(tv.tivi_abr) AS tivi_abr,
						MAX(c.cert_nomtipovia) AS cert_nomtipovia,
                        MAX(c.cert_uso) AS cert_uso,
                        MAX(c.cert_manzana) AS cert_manzana,
                        MAX(c.cert_lote) AS cert_lote,
                        MAX(c.cert_numregdoc) AS cert_numregdoc,
                        MAX(c.cert_numexpe) AS cert_numexpe,
                        MAX(c.cert_tecinf) AS cert_tecinf,
                        MAX(c.cert_numcert) AS cert_numcert,
                        MAX(c.cert_estimp) AS cert_estimp,
                        MAX(c.cert_numactainsp) AS cert_numactainsp,
                        MAX(c.cert_firmapdf) AS cert_firmapdf,
                        MAX(c.cert_esttitu) AS cert_esttitu,
                        MAX(c.cert_estent) AS cert_estent,
                        MAX(c.cert_estfirma) AS cert_estfirma,
                        MAX(c.cert_estadj) AS cert_estadj,
                        MAX(c.cert_est) AS cert_est,
                        MAX(i.insp_id) AS insp_id,
                        MAX(i.insp_nombre) AS insp_nombre,
                        MAX(i.insp_apep) AS insp_apep,
                        MAX(i.insp_apem) AS insp_apem,
                        MAX(i.insp_dni) AS insp_dni
                        FROM
                                sc_titulopropiedad.td_certificado_propietario cp 
                        INNER JOIN sc_titulopropiedad.tb_certificado c ON cp.cert_id = c.cert_id 
                        INNER JOIN sc_titulopropiedad.tb_propietario p ON cp.prop_id = p.prop_id 
                        INNER JOIN sc_titulopropiedad.tb_inspector i ON c.insp_id = i.insp_id 
                        INNER JOIN sc_titulopropiedad.tb_tipo_urbanizacion tu ON tu.tiur_id = c.tiur_id
                        INNER JOIN sc_titulopropiedad.tb_tipo_via tv ON tv.tivi_id = c.tivi_id
                        WHERE 
                                c.est = 1 
                        GROUP BY
                    
                        c.cert_id;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_certificado_($fecha = '', $completo = '', $urb = '') {
            $conectar = parent::conexion();
            parent::set_names();
        
            // Base de la consulta
            $sql = "SELECT 
                        
                        u.tiur_abr, 
						c.cert_nomtipourb,
                        c.cert_manzana,
                        c.cert_lote,
						c.cert_etapa,
                        p1.prop_nombre as prop_nombre1,
						p1.prop_apep as prop_apep1,
						p1.prop_apem as prop_apem1,
                        p1.prop_dni AS prop_dni1,
                        p1.prop_estadocivil AS prop_estadocivil1,
                        COALESCE(p2.prop_nombre , '') as prop_nombre2,
						COALESCE(p2.prop_apep , '') AS prop_apep2,
						COALESCE(p2.prop_apem , '') AS prop_apem2,
                        COALESCE(p2.prop_dni , '') AS prop_dni2,
                        COALESCE(p2.prop_estadocivil , '') AS prop_estadocivil2,
                        c.cert_area,
                        c.cert_perimetro,
                        c.cert_frente,
						c.cert_medfrente,
                        c.cert_derecha,
						c.cert_medderecha,
                        c.cert_izquierda,
						c.cert_medizquierda,
                        c.cert_fondo,
						c.cert_medfondo,
						c.cert_numregdoc,
						c.cert_numexpe,
						c.cert_tecinf,
						c.cert_numactainsp,
						i.insp_nombre,
						i.insp_apep,
						i.insp_apem,
						i.insp_dni
                        
                    FROM 
                        sc_titulopropiedad.td_certificado_propietario d1
                    JOIN 
                        sc_titulopropiedad.tb_propietario p1 ON d1.prop_id = p1.prop_id
                    LEFT JOIN 
                        sc_titulopropiedad.td_certificado_propietario d2 ON d1.cert_id = d2.cert_id AND d1.prop_id != d2.prop_id
                    LEFT JOIN 
                        sc_titulopropiedad.tb_propietario p2 ON d2.prop_id = p2.prop_id
                    JOIN 
                        sc_titulopropiedad.tb_certificado c ON d1.cert_id = c.cert_id
					 JOIN 
					sc_titulopropiedad.tb_inspector i ON c.insp_id = i.insp_id
                    JOIN 
                        sc_titulopropiedad.tb_tipo_urbanizacion u ON c.tiur_id = u.tiur_id
                    JOIN 
                        sc_titulopropiedad.tb_tipo_via v ON c.tivi_id = v.tivi_id
                    WHERE 
                        d1.cert_id = c.cert_id AND c.est = 1";
        
            // Agregar filtros
            if ($fecha) {
                $sql .= " AND EXTRACT(YEAR FROM c.cert_fechcrea) = :fecha";
            }
            if ($completo !== '') {
                $sql .= " AND c.cert_est = :completo";
            }
            if ($urb) {
                $sql .= " AND c.cert_nomtipourb = :urb";
            }
        
            $sql .= " ORDER BY 
                    c.cert_numcert, p1.prop_nombre, p2.prop_nombre;";
        
            $stmt = $conectar->prepare($sql);
        
            // Vincular parámetros
            if ($fecha) {
                $stmt->bindValue(':fecha', $fecha, PDO::PARAM_INT);
            }
            if ($completo !== '') {
                $stmt->bindValue(':completo', $completo, PDO::PARAM_INT);
            }
            if ($urb) {
                $stmt->bindValue(':urb', $urb, PDO::PARAM_STR);
            }
        
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

            
        
        }
        public function get_propietarios_by_certificado($cert_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        p.prop_id
                        
						FROM
                        sc_titulopropiedad.td_certificado_propietario cp INNER JOIN
                        sc_titulopropiedad.tb_certificado c ON cp.cert_id = c.cert_id INNER JOIN
                        sc_titulopropiedad.tb_propietario p ON cp.prop_id = p.prop_id INNER JOIN
                        sc_titulopropiedad.tb_inspector i ON c.insp_id = i.insp_id 
                    WHERE  
                        c.est = 1 AND c.cert_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        
        public function get_certificado_detalle_subgerente_pendiente(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        STRING_AGG(
                                p.prop_dni,
                            ' , '
                        ) AS DatosPropietarios,
                        c.cert_id,
                        MAX(c.cert_area) AS cert_area,
                        MAX(c.cert_perimetro) AS cert_perimetro,
						MAX(tu.tiur_abr) AS tiur_abr,
						MAX(c.cert_nomtipourb) AS cert_nomtipourb,
						MAX(tv.tivi_abr) AS tivi_abr,
						MAX(c.cert_nomtipovia) AS cert_nomtipovia,
                        MAX(c.cert_uso) AS cert_uso,
                        MAX(c.cert_manzana) AS cert_manzana,
                        MAX(c.cert_lote) AS cert_lote,
                        MAX(c.cert_numregdoc) AS cert_numregdoc,
                        MAX(c.cert_numexpe) AS cert_numexpe,
                        MAX(c.cert_tecinf) AS cert_tecinf,
                        MAX(c.cert_numcert) AS cert_numcert,
                        MAX(c.cert_estimp) AS cert_estimp,
                        MAX(c.cert_numactainsp) AS cert_numactainsp,
                        MAX(c.cert_firmapdf) AS cert_firmapdf,
                        MAX(c.cert_esttitu) AS cert_esttitu,
                        MAX(c.cert_estent) AS cert_estent,
                        MAX(c.cert_estfirma) AS cert_estfirma,
                        MAX(c.cert_estadj) AS cert_estadj,
                        MAX(c.cert_est) AS cert_est,
                        MAX(i.insp_id) AS insp_id,
                        MAX(i.insp_nombre) AS insp_nombre,
                        MAX(i.insp_apep) AS insp_apep,
                        MAX(i.insp_apem) AS insp_apem,
                        MAX(i.insp_dni) AS insp_dni
                        FROM
                                sc_titulopropiedad.td_certificado_propietario cp 
                        INNER JOIN sc_titulopropiedad.tb_certificado c ON cp.cert_id = c.cert_id 
                        INNER JOIN sc_titulopropiedad.tb_propietario p ON cp.prop_id = p.prop_id 
                        INNER JOIN sc_titulopropiedad.tb_inspector i ON c.insp_id = i.insp_id 
                        INNER JOIN sc_titulopropiedad.tb_tipo_urbanizacion tu ON tu.tiur_id = c.tiur_id
                        INNER JOIN sc_titulopropiedad.tb_tipo_via tv ON tv.tivi_id = c.tivi_id
                        WHERE 
                                c.est = 1 AND c.cert_estfirma = 1
                        GROUP BY
                    
                        c.cert_id;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
            
            
        }
        public function get_certificado_id_abrir($cert_id) {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT cert_firmapdf FROM sc_titulopropiedad.tb_certificado WHERE cert_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->execute();
            return $sql->fetch(PDO::FETCH_ASSOC); // Devuelve un solo registro asociativo
        }
        
        public function get_certificado_id($cert_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                    *
                    FROM 
                    sc_titulopropiedad.tb_certificado   
                    WHERE est = 1 AND cert_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function combo_fechcrea() {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT DISTINCT EXTRACT(YEAR FROM cert_fechcrea) 
                    FROM sc_titulopropiedad.tb_certificado 
                    WHERE est = 1;";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_COLUMN, 0);
        }

        public function combo_completo() {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT DISTINCT cert_est 
                    FROM sc_titulopropiedad.tb_certificado 
                    WHERE est = 1;";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_COLUMN, 0);
        }
       
        public function combo_urb() {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT DISTINCT cert_nomtipourb
                    FROM sc_titulopropiedad.tb_certificado 
                    WHERE est = 1;";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_COLUMN, 0);
        }
        public function get_certificado_detalle_gerente_pendiente(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        STRING_AGG(
                                p.prop_dni,
                            ' , '
                        ) AS DatosPropietarios,
                        c.cert_id,
                        MAX(c.cert_area) AS cert_area,
                        MAX(c.cert_perimetro) AS cert_perimetro,
						MAX(tu.tiur_abr) AS tiur_abr,
						MAX(c.cert_nomtipourb) AS cert_nomtipourb,
						MAX(tv.tivi_abr) AS tivi_abr,
						MAX(c.cert_nomtipovia) AS cert_nomtipovia,
                        MAX(c.cert_uso) AS cert_uso,
                        MAX(c.cert_manzana) AS cert_manzana,
                        MAX(c.cert_lote) AS cert_lote,
                        MAX(c.cert_numregdoc) AS cert_numregdoc,
                        MAX(c.cert_numexpe) AS cert_numexpe,
                        MAX(c.cert_tecinf) AS cert_tecinf,
                        MAX(c.cert_numcert) AS cert_numcert,
                        MAX(c.cert_estimp) AS cert_estimp,
                        MAX(c.cert_numactainsp) AS cert_numactainsp,
                        MAX(c.cert_esttitu) AS cert_esttitu,
                        MAX(c.cert_estent) AS cert_estent,
                        MAX(c.cert_estfirma) AS cert_estfirma,
                        MAX(c.cert_estadj) AS cert_estadj,
                        MAX(c.cert_est) AS cert_est,
                        MAX(i.insp_id) AS insp_id,
                        MAX(i.insp_nombre) AS insp_nombre,
                        MAX(i.insp_apep) AS insp_apep,
                        MAX(i.insp_apem) AS insp_apem,
                        MAX(i.insp_dni) AS insp_dni
                        FROM
                                sc_titulopropiedad.td_certificado_propietario cp 
                        INNER JOIN sc_titulopropiedad.tb_certificado c ON cp.cert_id = c.cert_id 
                        INNER JOIN sc_titulopropiedad.tb_propietario p ON cp.prop_id = p.prop_id 
                        INNER JOIN sc_titulopropiedad.tb_inspector i ON c.insp_id = i.insp_id 
                        INNER JOIN sc_titulopropiedad.tb_tipo_urbanizacion tu ON tu.tiur_id = c.tiur_id
                        INNER JOIN sc_titulopropiedad.tb_tipo_via tv ON tv.tivi_id = c.tivi_id
                        WHERE 
                                c.est = 1 AND c.cert_estfirma = 2
                        GROUP BY
                    
                        c.cert_id;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
            
            
        }
        public function get_certificado_detalle($fecha = '', $completo = '') {
            $conectar = parent::conexion();
            parent::set_names();
        
            $sql = "SELECT 
                        STRING_AGG(p.prop_dni, ' , ') AS DatosPropietarios,
                        c.cert_id,
                        MAX(c.cert_area) AS cert_area,
                        MAX(c.cert_perimetro) AS cert_perimetro,
                        MAX(tu.tiur_abr) AS tiur_abr,
                        MAX(c.cert_nomtipourb) AS cert_nomtipourb,
                        MAX(tv.tivi_abr) AS tivi_abr,
                        MAX(c.cert_nomtipovia) AS cert_nomtipovia,
                        MAX(c.cert_uso) AS cert_uso,
                        MAX(c.cert_manzana) AS cert_manzana,
                        MAX(c.cert_lote) AS cert_lote,
                        MAX(c.cert_numregdoc) AS cert_numregdoc,
                        MAX(c.cert_numexpe) AS cert_numexpe,
                        MAX(c.cert_tecinf) AS cert_tecinf,
                        MAX(LPAD(c.cert_numcert::text, 6, '0')) AS cert_numcert,  -- Añadido LPAD para el formato de cert_numcert
                        MAX(c.cert_estimp) AS cert_estimp,
                        MAX(c.cert_numactainsp) AS cert_numactainsp,
                        MAX(c.cert_esttitu) AS cert_esttitu,
                        MAX(c.cert_estent) AS cert_estent,
                        MAX(c.cert_estfirma) AS cert_estfirma,
                        MAX(c.cert_estadj) AS cert_estadj,
                        MAX(c.cert_est) AS cert_est,
                        MAX(i.insp_id) AS insp_id,
                        MAX(i.insp_nombre) AS insp_nombre,
                        MAX(i.insp_apep) AS insp_apep,
                        MAX(i.insp_apem) AS insp_apem,
                        MAX(i.insp_dni) AS insp_dni
                    FROM
                        sc_titulopropiedad.td_certificado_propietario cp 
                        INNER JOIN sc_titulopropiedad.tb_certificado c ON cp.cert_id = c.cert_id 
                        INNER JOIN sc_titulopropiedad.tb_propietario p ON cp.prop_id = p.prop_id 
                        INNER JOIN sc_titulopropiedad.tb_inspector i ON c.insp_id = i.insp_id 
                        INNER JOIN sc_titulopropiedad.tb_tipo_urbanizacion tu ON tu.tiur_id = c.tiur_id
                        INNER JOIN sc_titulopropiedad.tb_tipo_via tv ON tv.tivi_id = c.tivi_id
                    WHERE 
                        c.est = 1 AND (c.cert_estfirma = 0 OR c.cert_estfirma = 3)";
            
            // Condición adicional de año
            if ($fecha) {
                $sql .= " AND EXTRACT(YEAR FROM c.cert_fechcrea) = :fecha";
            }
            
            // Condición adicional de estado
            if ($completo !== '') {
                $sql .= " AND c.cert_est = :completo";
            }
        
            // Agrupar por cert_id
            $sql .= " GROUP BY c.cert_id;";
            
            // Preparar y ejecutar la consulta
            $stmt = $conectar->prepare($sql);
        
            // Vincular parámetros
            if ($fecha) {
                $stmt->bindValue(':fecha', $fecha, PDO::PARAM_INT);
            }
            if ($completo !== '') {
                $stmt->bindValue(':completo', $completo, PDO::PARAM_INT);
            }
        
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_certificado_detalle_completado(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        STRING_AGG(
                                p.prop_dni,
                            ' , '
                        ) AS DatosPropietarios,
                        c.cert_id,
                        MAX(c.cert_area) AS cert_area,
                        MAX(c.cert_perimetro) AS cert_perimetro,
						MAX(tu.tiur_abr) AS tiur_abr,
						MAX(c.cert_nomtipourb) AS cert_nomtipourb,
						MAX(tv.tivi_abr) AS tivi_abr,
						MAX(c.cert_nomtipovia) AS cert_nomtipovia,
                        MAX(c.cert_uso) AS cert_uso,
                        MAX(c.cert_manzana) AS cert_manzana,
                        MAX(c.cert_lote) AS cert_lote,
                        MAX(c.cert_distrito) AS cert_distrito,
                        MAX(c.cert_provincia) AS cert_provincia,
                        MAX(c.cert_departamento) AS cert_departamento,
                        MAX(c.cert_numregdoc) AS cert_numregdoc,
                        MAX(c.cert_numexpe) AS cert_numexpe,
                        MAX(c.cert_tecinf) AS cert_tecinf,
                        MAX(c.cert_numcert) AS cert_numcert,
                        MAX(c.cert_estimp) AS cert_estimp,
                        MAX(c.cert_numactainsp) AS cert_numactainsp,
                        MAX(c.cert_esttitu) AS cert_esttitu,
                        MAX(i.insp_id) AS insp_id,
                        MAX(i.insp_nombre) AS insp_nombre,
                        MAX(i.insp_apep) AS insp_apep,
                        MAX(i.insp_apem) AS insp_apem,
                        MAX(i.insp_dni) AS insp_dni
                        FROM
                                sc_titulopropiedad.td_certificado_propietario cp 
                        INNER JOIN sc_titulopropiedad.tb_certificado c ON cp.cert_id = c.cert_id 
                        INNER JOIN sc_titulopropiedad.tb_propietario p ON cp.prop_id = p.prop_id 
                        INNER JOIN sc_titulopropiedad.tb_inspector i ON c.insp_id = i.insp_id 
                        INNER JOIN sc_titulopropiedad.tb_tipo_urbanizacion tu ON tu.tiur_id = c.tiur_id
                        INNER JOIN sc_titulopropiedad.tb_tipo_via tv ON tv.tivi_id = c.tivi_id
                        WHERE 
                                c.est = 1 AND c.cert_est = 1
                        GROUP BY
                    
                        c.cert_id;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_propietarios_x_id_certificado($cert_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        p.prop_id,
                        p.prop_nombre,
                        p.prop_apep,
                        p.prop_apem,
                        p.prop_estadocivil,
                        p.prop_dni,
                        p.prop_tipo,
                        c.cert_id,
                        c.cert_area,
                        c.cert_perimetro,
                        c.cert_nomtipourb,
                        c.cert_nomtipovia,
                        c.cert_uso,
                        c.cert_frente,
                        c.cert_derecha,
                        c.cert_izquierda,
                        c.cert_fondo,
                        c.cert_medfrente,
                        c.cert_medderecha,
                        c.cert_medizquierda,
                        c.cert_medfondo,
                        c.cert_manzana,
                        c.cert_lote,
                        c.cert_etapa,
                        c.cert_numregdoc,
                        c.cert_numexpe,
                        c.cert_tecinf,
                        c.cert_numcert,
                        c.cert_estimp,
                        c.cert_numactainsp,
                        TO_CHAR(c.cert_fechcrea, 'DD Mon YYYY') AS cert_fechcrea,
                        i.insp_id,
                        i.insp_nombre,
                        i.insp_apep,
                        i.insp_apem,
                        i.insp_dni
                    FROM
                        sc_titulopropiedad.td_certificado_propietario cp INNER JOIN
                        sc_titulopropiedad.tb_certificado c ON cp.cert_id = c.cert_id INNER JOIN
                        sc_titulopropiedad.tb_propietario p ON cp.prop_id = p.prop_id INNER JOIN
                        sc_titulopropiedad.tb_inspector i ON c.insp_id = i.insp_id 
                    WHERE 
                        c.cert_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_datoscertificado_x_id_certificado($cert_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        c.cert_id,
                        c.cert_area,
                        c.cert_perimetro,
						tu.tiur_descripcion,
						tu.tiur_abr,
						c.cert_nomtipourb,
                        tv.tivi_descripcion,
						tv.tivi_abr,
						c.cert_nomtipovia,
                        c.cert_uso,
                        c.cert_frente,
                        c.cert_derecha,
                        c.cert_izquierda,
                        c.cert_fondo,
                         c.cert_medfrente,
                        c.cert_medderecha,
                        c.cert_medizquierda,
                        c.cert_medfondo,
                        c.cert_manzana,
                        c.cert_lote,
                        c.cert_etapa,
                        c.cert_numregdoc,
                        c.cert_numexpe,
                        c.cert_tecinf,
                        LPAD(cert_numcert::text, 6, '0') AS cert_numcert,
                        c.cert_estimp,
                        c.cert_numactainsp,
                        TO_CHAR(c.cert_fechcrea, 'DD Mon YYYY') AS cert_fechcrea,
                        EXTRACT(YEAR FROM c.cert_fechcrea) AS cert_fechcrea_año,
                        i.insp_id,
                        i.insp_nombre,
                        i.insp_apep,
                        i.insp_apem,
                        i.insp_dni
                    FROM
                        sc_titulopropiedad.tb_certificado c INNER JOIN
                        sc_titulopropiedad.tb_inspector i ON c.insp_id = i.insp_id INNER JOIN
						sc_titulopropiedad.tb_tipo_urbanizacion tu ON tu.tiur_id = c.tiur_id INNER JOIN
				 		sc_titulopropiedad.tb_tipo_via tv ON tv.tivi_id = c.tivi_id
                    WHERE 
                        c.cert_id = ?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_certificado_x_id_titulo($titu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        c.cert_fondo,
                        c.cert_manzana,
                        c.cert_lote,
                        c.cert_distrito,
                        c.cert_provincia,
                        c.cert_departamento,
                        c.cert_numregdoc,
                        c.cert_numexpe,
                        c.cert_tecinf,
                        c.cert_numcert,
                        c.cert_estimp,
                        c.cert_numactainsp,
                        TO_CHAR(c.cert_fechcrea, 'DD Mon YYYY') AS cert_fechcrea,
                        i.insp_id,
                        i.insp_nombre,
                        i.insp_apep,
                        i.insp_apem,
                        i.insp_dni
                    FROM
                        sc_titulopropiedad.td_certificado_propietario cp INNER JOIN
                        sc_titulopropiedad.tb_certificado c ON cp.cert_id = c.cert_id INNER JOIN
                        sc_titulopropiedad.tb_propietario p ON cp.prop_id = p.prop_id INNER JOIN
                        sc_titulopropiedad.tb_inspector i ON c.insp_id = i.insp_id 
                    WHERE 
                        c.cert_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_certificado_x_estimp(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                    cert_id
                    FROM 
                    sc_titulopropiedad.tb_certificado 
                    WHERE 
                    cert_estfirma = 0 AND cert_estimp = 0 AND est = 1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_certificado_x_firm1(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                    cert_id
                    FROM 
                    sc_titulopropiedad.tb_certificado 
                    WHERE 
                    cert_estfirma = 1 AND cert_estimp = 0 AND  est = 1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_certificado_x_firm2(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                    cert_id
                    FROM 
                    sc_titulopropiedad.tb_certificado 
                    WHERE 
                    cert_estfirma = 2 AND cert_estimp = 0 AND  est = 1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_certificado_x_firm3(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                    cert_id
                    FROM 
                    sc_titulopropiedad.tb_certificado 
                    WHERE 
                    cert_estfirma = 3 AND cert_estimp = 0 AND  est = 1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_numcertificado_reiniciar(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_certificado
            SET ";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        
        public function get_pdf_x_id_certificado($cert_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                    cert_firmapdf
                    FROM 
                    sc_titulopropiedad.tb_certificado 
                    WHERE 
                    est = 1 AND cert_id = ?;";
             $sql=$conectar->prepare($sql);
             $sql->bindValue(1, $cert_id);
             $sql->execute();
             return $resultado=$sql->fetch();
        }
        public function get_pdf_x_id_certificado_vista($cert_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                    cert_firmapdf
                    FROM 
                    sc_titulopropiedad.tb_certificado 
                    WHERE 
                    est = 1 AND cert_id = ?;";
             $sql=$conectar->prepare($sql);
             $sql->bindValue(1, $cert_id);
             $sql->execute();
             return $resultado=$sql->fetch();
        }
      
    
        
        public function get_total_certificados_registrados(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        count(cert_id) AS registrados
                  FROM 
                        sc_titulopropiedad.tb_certificado
                  WHERE 
                        est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_total_certificados_pendientes(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        COUNT(cert_id) AS pendientes
                  FROM  
                        sc_titulopropiedad.tb_certificado
                  WHERE 
                        cert_estimp = 0 AND est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function get_total_certificados_completados(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        COUNT(cert_id) AS completados
                  FROM  
                        sc_titulopropiedad.tb_certificado
                  WHERE 
                        cert_est = 1 AND est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_total_certificados_pendientes_subgerente(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        COUNT(cert_id) AS pendientes
                  FROM  
                        sc_titulopropiedad.tb_certificado
                  WHERE 
                        cert_estfirma = 1 AND est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_total_certificados_pendientes_gerente(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        COUNT(cert_id) AS pendientes
                  FROM  
                        sc_titulopropiedad.tb_certificado
                  WHERE 
                        cert_estfirma = 2 AND est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        
        
        public function get_total_certificados_descargables_subgerente(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        COUNT(cert_id) AS descargables
                  FROM  
                        sc_titulopropiedad.tb_certificado
                  WHERE 
                        cert_estfirma = 1 AND est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_total_certificados_descargables_gerente(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        COUNT(cert_id) AS descargables
                  FROM  
                        sc_titulopropiedad.tb_certificado
                  WHERE 
                       cert_estfirma = 2 AND cert_estimp = 0 AND est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function reiniciar_numcert(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="ALTER SEQUENCE 
                    sc_titulopropiedad.seq_cert_numcert 
                    RESTART WITH 1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_resumen_certificado(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        cert_nomtipourb AS  nombrepoblacion,
                        SUM(CASE WHEN c.est = 1 THEN 1 ELSE 0 END) AS registrados,
                        SUM(CASE WHEN c.cert_estimp = 1 AND c.est = 1 THEN 1 ELSE 0 END) AS pendientes,
                        SUM(CASE WHEN c.cert_estimp = 0 AND c.est = 1 THEN 1 ELSE 0 END) AS descargados
                  FROM 
                        sc_titulopropiedad.tb_certificado c
                  GROUP BY 
                        cert_nomtipourb;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function update_pdf($cert_id, $cert_firmapdf){
            $conectar = parent::conexion();
            parent::set_names();
        
            require_once("Certificado.php");
            $curx = new Certificado();
        
            // Inicializar la variable para la nueva cadena base64 del archivo
            $cert_firmapdf = '';
        
            // Verificar si se ha subido un nuevo archivo
            if (isset($_FILES["cert_firmapdf"]) && $_FILES["cert_firmapdf"]["error"] == UPLOAD_ERR_OK) {
                // Subimos el nuevo archivo y lo codificamos en base64
                $cert_firmapdf = $curx->upload_file();
            } else {
                // Si no se ha subido un nuevo archivo, mantenemos el valor actual
                // (puedes ajustar esto según cómo desees manejar la ausencia de archivo)
                $cert_firmapdf = ''; // Cambiar a un valor por defecto si es necesario
            }
        
            // Actualizamos la base de datos con la nueva cadena base64 del archivo
            $sql = "UPDATE sc_titulopropiedad.tb_certificado
                    SET cert_firmapdf = ?
                    WHERE cert_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $cert_firmapdf);
            $sql->bindValue(2, $cert_id);
            $sql->execute();
    
            return $resultado = $sql->fetchAll();
        }
    
        public function upload_file(){
            if(isset($_FILES["cert_firmapdf"])){
                $extension = pathinfo($_FILES['cert_firmapdf']['name'], PATHINFO_EXTENSION);
                $allowed_extensions = array("pdf"); // Permitir solo archivos PDF
    
                if(in_array(strtolower($extension), $allowed_extensions)){
                    $file_content = file_get_contents($_FILES['cert_firmapdf']['tmp_name']);
                    if($file_content === false) {
                        throw new Exception("Error al leer el archivo.");
                    }
                    $encoded_file = base64_encode($file_content);
                    return $encoded_file;
                } else {
                    throw new Exception("Extensión de archivo no permitida.");
                }
            } else {
                throw new Exception("No se ha subido ningún archivo.");
            }
        }
    }
       
    