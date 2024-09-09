<?php
    class Titulo extends Conectar{

        public function insert_titulo($cert_id,$alca_id,$titu_partelec,$titu_partlote,$titu_asiento,$titu_serie,$titu_tipo,$titu_tazacion,$titu_emp,$titu_sector,$titu_numresolucion,$titu_fecharesolucion,$titu_fechaemision){
            $conectar= parent::conexion();
            parent::set_names();

            // Obtener el año actual
            $currentYear = date('Y');
            
            // Obtener el año de la última fecha de creación para el mismo tipo de certificado
            $sql = "SELECT EXTRACT(YEAR FROM MAX(titu_fechcrea)) as last_year FROM sc_titulopropiedad.tb_titulo";
            $stmt = $conectar->prepare($sql);
            $stmt->execute();
            $lastYear = $stmt->fetchColumn();
            
            // Reiniciar el contador numcert si el año actual es mayor por 1
            if ($currentYear > $lastYear) {
                $sql = "ALTER SEQUENCE sc_titulopropiedad.seq_titu_numtitulo RESTART WITH 1;";
                $stmt = $conectar->prepare($sql);
                $stmt->execute();
            }

            $sql="INSERT INTO sc_titulopropiedad.tb_titulo (cert_id, alca_id, titu_partelec, titu_partlote, titu_asiento, titu_serie, titu_tipo, titu_tazacion, titu_emp, titu_sector, titu_numresolucion,titu_fecharesolucion, titu_fechaemision, titu_fechcrea, titu_estadj, titu_estfirma, est, titu_estimp,titu_est,titu_estent,titu_estrecibo) VALUES (? , ? , ? , ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), '0','0', '1', '0','0','0','0');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->bindValue(2, $alca_id);
            $sql->bindValue(3, $titu_partelec);
            $sql->bindValue(4, $titu_partlote);
            $sql->bindValue(5, $titu_asiento);
            $sql->bindValue(6, $titu_serie);
            $sql->bindValue(7, $titu_tipo);
            $sql->bindValue(8, $titu_tazacion);
            $sql->bindValue(9, $titu_emp);
            $sql->bindValue(10, $titu_sector);
            $sql->bindValue(11, $titu_numresolucion);
            $sql->bindValue(12, $titu_fecharesolucion);
            $sql->bindValue(13, $titu_fechaemision);
            $sql->execute();
            return $resultado=$sql->fetchAll();
            
        }   
        public function update_titulo($titu_id,$cert_id,$alca_id,$titu_partelec,$titu_numtitulo,$titu_partlote,$titu_asiento,$titu_serie,$titu_tipo,$titu_tazacion,$titu_emp,$titu_sector,$titu_numresolucion,$titu_fecharesolucion,$titu_fechaemision){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_titulo
                SET
                    cert_id =?,
                    alca_id = ?,
                    titu_partelec = ?,
                    titu_numtitulo = ?,
                    titu_partlote = ?,
                    titu_asiento = ?,
                    titu_serie = ?,
                    titu_tipo = ?,
                    titu_tazacion = ?,
                    titu_emp = ?,
                    titu_sector = ?,
                    titu_numresolucion = ?,
                    titu_fecharesolucion = ?,
                    titu_fechaemision = ?
                WHERE
                    titu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cert_id);
            $sql->bindValue(2, $alca_id);
            $sql->bindValue(3, $titu_partelec);
            $sql->bindValue(4, $titu_numtitulo);
            $sql->bindValue(5, $titu_partlote);
            $sql->bindValue(6, $titu_asiento);
            $sql->bindValue(7, $titu_serie);
            $sql->bindValue(8, $titu_tipo);
            $sql->bindValue(9, $titu_tazacion);
            $sql->bindValue(10, $titu_emp);
            $sql->bindValue(11, $titu_sector);
            $sql->bindValue(12, $titu_numresolucion);
            $sql->bindValue(13, $titu_fecharesolucion);
            $sql->bindValue(14, $titu_fechaemision);
            $sql->bindValue(15, $titu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function update_recibo($titu_id,$titu_numrecibo){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_titulo
                SET
                    titu_numrecibo = ?
                    
                WHERE
                    titu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $titu_numrecibo);
            $sql->bindValue(2, $titu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
            
        }   
        public function delete_titulo($titu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_titulo
                SET
                    est = 0
                WHERE
                    titu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $titu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        
        
        public function get_titulo(){
                    $conectar= parent::conexion();
                    parent::set_names();
                    $sql="SELECT 
                        STRING_AGG(
                            p.prop_dni,
                            ' , '
                        ) AS DatosPropietarios,
                        c.cert_id,
                        t.titu_id,
                        MAX(t.titu_partelec) AS titu_partelec,
                        MAX(t.titu_numtitulo) AS titu_numtitulo,
                        MAX(t.titu_partlote) AS titu_partlote,
                        MAX(t.titu_asiento) AS titu_asiento,
                        MAX(t.titu_serie) AS titu_serie,
                        MAX(t.titu_tipo) AS titu_tipo,
                        MAX(t.titu_tazacion) AS titu_tazacion,
                        MAX(t.titu_estimp) AS titu_estimp,
                        MAX(t.titu_numresolucion) AS titu_numresolucion,
                        MAX(t.titu_fecharesolucion) AS titu_fecharesolucion,
                        MAX(t.titu_fechaemision) AS titu_fechaemision,
                        MAX(t.titu_fechcrea) AS titu_fechcrea,
						MAX(t.titu_est) AS titu_est,
                        MAX(t.titu_estent) AS titu_estent,
                        MAX(t.titu_estfirma) AS titu_estfirma,
                        MAX(t.titu_estadj) AS titu_estadj
                    FROM
                        sc_titulopropiedad.td_certificado_propietario cp INNER JOIN 
                        sc_titulopropiedad.tb_certificado c ON cp.cert_id = c.cert_id INNER JOIN
                        sc_titulopropiedad.tb_propietario p ON cp.prop_id = p.prop_id INNER JOIN
                        sc_titulopropiedad.tb_titulo t ON c.cert_id = t.cert_id 
                    WHERE 
                        t.est = 1 AND (t.titu_estfirma = 0 OR t.titu_estfirma = 4)
                    GROUP BY
                        t.titu_id,
                        c.cert_id;";
                    $sql=$conectar->prepare($sql);
                    $sql->execute();
                    return $resultado=$sql->fetchAll();
        }
        public function get_titulo_resumen($fecha = '', $completo = '', $urb = '') {
            $conectar = parent::conexion();
            parent::set_names();
        
            // Base de la consulta
            $sql = "SELECT 
                        t.titu_partelec,
                        t.titu_serie,
                        t.titu_numtitulo,
                        u.tiur_abr, 
						c.cert_nomtipourb,
                        c.cert_manzana,
                        c.cert_lote,
                        t.titu_emp,
                        t.titu_asiento,
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
                        t.titu_partlote,
                        c.cert_area,
                        c.cert_frente,
						c.cert_medfrente,
                        c.cert_derecha,
						c.cert_medderecha,
                        c.cert_izquierda,
						c.cert_medizquierda,
                        c.cert_fondo,
						c.cert_medfondo,
                        t.titu_tipo,
                        t.titu_numresolucion,
                        t.titu_fecharesolucion,
                        t.titu_fechaemision
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
                        sc_titulopropiedad.tb_titulo t ON c.cert_id = t.cert_id
                    JOIN 
                        sc_titulopropiedad.tb_tipo_urbanizacion u ON c.tiur_id = u.tiur_id
                    JOIN 
                        sc_titulopropiedad.tb_tipo_via v ON c.tivi_id = v.tivi_id
                    WHERE 
                        d1.cert_id = c.cert_id AND t.est = 1";
        
            // Agregar filtros
            if ($fecha) {
                $sql .= " AND EXTRACT(YEAR FROM t.titu_fechcrea) = :fecha";
            }
            if ($completo !== '') {
                $sql .= " AND t.titu_est = :completo";
            }
            if ($urb) {
                $sql .= " AND c.cert_nomtipourb = :urb";
            }
        
            $sql .= " ORDER BY 
                    t.titu_numtitulo, p1.prop_nombre, p2.prop_nombre;";
        
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
        public function get_titulo_id_abrir($titu_id) {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT titu_firmapdf FROM sc_titulopropiedad.tb_titulo WHERE titu_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $titu_id);
            $sql->execute();
            return $sql->fetch(PDO::FETCH_ASSOC); // Devuelve un solo registro asociativo
        }
        public function get_titulo_id($titu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                    *
                    FROM 
                    sc_titulopropiedad.tb_titulo
                    WHERE tb_titulo.est = 1 AND titu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $titu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_titulo_x_estimp(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                    titu_id
                    FROM 
                    sc_titulopropiedad.tb_titulo 
                    WHERE 
                    est = 1 AND titu_estimp = 0;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
}
            
        public function get_titulo_detalle($fecha = '', $completo = ''){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT 
                        STRING_AGG(p.prop_dni, ' , ') AS DatosPropietarios,
                        c.cert_id,
                        t.titu_id,
                        MAX(t.titu_partelec) AS titu_partelec,
                        MAX(t.titu_numtitulo) AS titu_numtitulo,
                        MAX(t.titu_partlote) AS titu_partlote,
                        MAX(t.titu_asiento) AS titu_asiento,
                        MAX(t.titu_serie) AS titu_serie,
                        MAX(t.titu_tipo) AS titu_tipo,
                        MAX(t.titu_tazacion) AS titu_tazacion,
                        MAX(t.titu_estimp) AS titu_estimp,
                        MAX(t.titu_numresolucion) AS titu_numresolucion,
                        MAX(t.titu_fecharesolucion) AS titu_fecharesolucion,
                        MAX(t.titu_fechaemision) AS titu_fechaemision,
                        MAX(t.titu_fechcrea) AS titu_fechcrea,
                        MAX(t.titu_est) AS titu_est,
                        MAX(t.titu_estent) AS titu_estent,
                        MAX(t.titu_estfirma) AS titu_estfirma,
                        MAX(t.titu_estadj) AS titu_estadj,
                        MAX(t.titu_estrecibo) AS titu_estrecibo
                    FROM
                        sc_titulopropiedad.td_certificado_propietario cp 
                        INNER JOIN sc_titulopropiedad.tb_certificado c ON cp.cert_id = c.cert_id 
                        INNER JOIN sc_titulopropiedad.tb_propietario p ON cp.prop_id = p.prop_id 
                        INNER JOIN sc_titulopropiedad.tb_titulo t ON c.cert_id = t.cert_id 
                    WHERE 
                        t.est = 1 
                        AND (t.titu_estfirma = 0 OR t.titu_estfirma = 4)";

            if ($fecha) {
                $sql .= " AND EXTRACT(YEAR FROM t.titu_fechcrea) = :fecha";
            }

            if ($completo !== '') {
                $sql .= " AND t.titu_est = :completo";
            }

            $sql .= " GROUP BY t.titu_id, c.cert_id;";
            
            $stmt = $conectar->prepare($sql);
            
            if ($fecha) {
                $stmt->bindValue(':fecha', $fecha, PDO::PARAM_INT);
            }
            if ($completo !== '') {
                $stmt->bindValue(':completo', $completo, PDO::PARAM_INT);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

           

        public function get_titulo_detalle_subgerente_pendiente(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        STRING_AGG(
                            p.prop_dni,
                            ' , '
                        ) AS DatosPropietarios,
                        c.cert_id,
                        t.titu_id,
                        MAX(t.titu_partelec) AS titu_partelec,
                        MAX(t.titu_numtitulo) AS titu_numtitulo,
                        MAX(t.titu_partlote) AS titu_partlote,
                        MAX(t.titu_asiento) AS titu_asiento,
                        MAX(t.titu_serie) AS titu_serie,
                        MAX(t.titu_tipo) AS titu_tipo,
                        MAX(t.titu_tazacion) AS titu_tazacion,
                        MAX(t.titu_estimp) AS titu_estimp,
                        MAX(t.titu_numresolucion) AS titu_numresolucion,
                        MAX(t.titu_fecharesolucion) AS titu_fecharesolucion,
                        MAX(t.titu_fechaemision) AS titu_fechaemision,
                        MAX(t.titu_fechcrea) AS titu_fechcrea,
						MAX(t.titu_est) AS titu_est,
                        MAX(t.titu_estent) AS titu_estent,
                        MAX(t.titu_estfirma) AS titu_estfirma,
                        MAX(t.titu_estadj) AS titu_estadj
                    FROM
                        sc_titulopropiedad.td_certificado_propietario cp INNER JOIN 
                        sc_titulopropiedad.tb_certificado c ON cp.cert_id = c.cert_id INNER JOIN
                        sc_titulopropiedad.tb_propietario p ON cp.prop_id = p.prop_id INNER JOIN
                        sc_titulopropiedad.tb_titulo t ON c.cert_id = t.cert_id 
                    WHERE 
                        t.est = 1 AND t.titu_estfirma = 1
                    GROUP BY
                        t.titu_id,
                        c.cert_id;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
            
            
        }
        public function get_titulo_detalle_gerente_pendiente(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        STRING_AGG(
                            p.prop_dni,
                            ' , '
                        ) AS DatosPropietarios,
                        c.cert_id,
                        t.titu_id,
                        MAX(t.titu_partelec) AS titu_partelec,
                        MAX(t.titu_numtitulo) AS titu_numtitulo,
                        MAX(t.titu_partlote) AS titu_partlote,
                        MAX(t.titu_asiento) AS titu_asiento,
                        MAX(t.titu_serie) AS titu_serie,
                        MAX(t.titu_tipo) AS titu_tipo,
                        MAX(t.titu_tazacion) AS titu_tazacion,
                        MAX(t.titu_estimp) AS titu_estimp,
                        MAX(t.titu_numresolucion) AS titu_numresolucion,
                        MAX(t.titu_fecharesolucion) AS titu_fecharesolucion,
                        MAX(t.titu_fechaemision) AS titu_fechaemision,
                        MAX(t.titu_fechcrea) AS titu_fechcrea,
						MAX(t.titu_est) AS titu_est,
                        MAX(t.titu_estent) AS titu_estent,
                        MAX(t.titu_estfirma) AS titu_estfirma,
                        MAX(t.titu_estadj) AS titu_estadj
                    FROM
                        sc_titulopropiedad.td_certificado_propietario cp INNER JOIN 
                        sc_titulopropiedad.tb_certificado c ON cp.cert_id = c.cert_id INNER JOIN
                        sc_titulopropiedad.tb_propietario p ON cp.prop_id = p.prop_id INNER JOIN
                        sc_titulopropiedad.tb_titulo t ON c.cert_id = t.cert_id 
                    WHERE 
                        t.est = 1 AND t.titu_estfirma = 2
                    GROUP BY
                        t.titu_id,
                        c.cert_id;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
            
            
        }
        public function get_titulo_detalle_alcalde_pendiente(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        STRING_AGG(
                            p.prop_dni,
                            ' , '
                        ) AS DatosPropietarios,
                        c.cert_id,
                        t.titu_id,
                        MAX(t.titu_partelec) AS titu_partelec,
                        MAX(t.titu_numtitulo) AS titu_numtitulo,
                        MAX(t.titu_partlote) AS titu_partlote,
                        MAX(t.titu_asiento) AS titu_asiento,
                        MAX(t.titu_serie) AS titu_serie,
                        MAX(t.titu_tipo) AS titu_tipo,
                        MAX(t.titu_tazacion) AS titu_tazacion,
                        MAX(t.titu_estimp) AS titu_estimp,
                        MAX(t.titu_numresolucion) AS titu_numresolucion,
                        MAX(t.titu_fecharesolucion) AS titu_fecharesolucion,
                        MAX(t.titu_fechaemision) AS titu_fechaemision,
                        MAX(t.titu_fechcrea) AS titu_fechcrea,
						MAX(t.titu_est) AS titu_est,
                        MAX(t.titu_estent) AS titu_estent,
                        MAX(t.titu_estfirma) AS titu_estfirma,
                        MAX(t.titu_estadj) AS titu_estadj
                    FROM
                        sc_titulopropiedad.td_certificado_propietario cp INNER JOIN 
                        sc_titulopropiedad.tb_certificado c ON cp.cert_id = c.cert_id INNER JOIN
                        sc_titulopropiedad.tb_propietario p ON cp.prop_id = p.prop_id INNER JOIN
                        sc_titulopropiedad.tb_titulo t ON c.cert_id = t.cert_id 
                    WHERE 
                        t.est = 1 AND t.titu_estfirma = 3
                    GROUP BY
                        t.titu_id,
                        c.cert_id;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
            
            
        }
        public function get_titulo_detalle_completado(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        STRING_AGG(
                            p.prop_dni,
                            ' , '
                        ) AS DatosPropietarios,
                        c.cert_id,
                        MAX(c.cert_provincia) AS cert_provincia,
                        MAX(c.cert_departamento) AS cert_departamento,
                        t.titu_id,
                        MAX(t.titu_partelec) AS titu_partelec,
                        MAX(t.titu_numtitulo) AS titu_numtitulo,
                        MAX(t.titu_partlote) AS titu_partlote,
                        MAX(t.titu_asiento) AS titu_asiento,
                        MAX(t.titu_serie) AS titu_serie,
                        MAX(t.titu_tipo) AS titu_tipo,
                        MAX(t.titu_tazacion) AS titu_tazacion,
                        MAX(t.titu_estimp) AS titu_estimp,
                        MAX(t.titu_numresolucion) AS titu_numresolucion,
                        MAX(t.titu_fecharesolucion) AS titu_fecharesolucion,
                        MAX(t.titu_fechaemision) AS titu_fechaemision,
                        MAX(t.titu_fechcrea) AS titu_fechcrea,
						MAX(t.titu_est) AS titu_est
                    FROM
                        sc_titulopropiedad.td_certificado_propietario cp INNER JOIN 
                        sc_titulopropiedad.tb_certificado c ON cp.cert_id = c.cert_id INNER JOIN
                        sc_titulopropiedad.tb_propietario p ON cp.prop_id = p.prop_id INNER JOIN
                        sc_titulopropiedad.tb_titulo t ON c.cert_id = t.cert_id 
                    WHERE 
                        t.est = 1 
                    GROUP BY
                        t.titu_id,
                        c.cert_id;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_prueba(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                    tb_certificado.cert_id,
                    STRING_AGG(
                        CONCAT(
                            '| Nombre Completo: ', tb_propietario.prop_nombre, ' ', tb_propietario.prop_apep, ' ', tb_propietario.prop_apem, ' ',
                            '| Estado Civil: ', tb_propietario.prop_estadocivil, ' ',
                            '| DNI/RUC: ', tb_propietario.prop_dni, ' ',
                            '| Tipo: ', tb_propietario.prop_tipo, ' ',
                            '| Emp: ', tb_propietario.prop_empadronamientos
                        ),
                        ', '
                    ) AS DatosPropietarios,
                    tb_titulo.titu_id
                FROM
                    sc_titulopropiedad.td_certificado_propietario
                INNER JOIN
                    sc_titulopropiedad.tb_propietario ON td_certificado_propietario.prop_id = tb_propietario.prop_id
                INNER JOIN
                    sc_titulopropiedad.tb_certificado ON td_certificado_propietario.cert_id = tb_certificado.cert_id
                INNER JOIN
                    sc_titulopropiedad.tb_titulo ON tb_certificado.cert_id = tb_titulo.cert_id
                GROUP BY
                    tb_certificado.cert_id,
                    tb_titulo.titu_id;";
                    $sql=$conectar->prepare($sql);
                    $sql->execute();
                    return $resultado=$sql->fetchAll();
}
        
        public function get_datostitulo_x_id_titulo($titu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        t.titu_id,
                        t.titu_partelec,
                        t.titu_numtitulo,
                        t.titu_partlote,
                        t.titu_asiento,
                        t.titu_serie,
                        t.titu_tipo,
                        t.titu_tazacion,
                        t.titu_sector,
                        t.titu_numresolucion,
                        t.titu_fecharesolucion,
                        t.titu_fechaemision,
                        TO_CHAR(t.titu_fechcrea, 'DD Mon YYYY') AS titu_fechcrea,
                        c.cert_id,
                        c.cert_area,
                        tv.tivi_abr,
                        tv.tivi_descripcion,
                        c.cert_nomtipovia,
                        tu.tiur_abr,
                        tu.tiur_descripcion,
                        c.cert_nomtipourb,
                        c.cert_frente,
                        c.cert_derecha,
                        c.cert_izquierda,
                        c.cert_fondo,
                        c.cert_manzana,
                        c.cert_lote
				
						
                    FROM
                        sc_titulopropiedad.tb_titulo t 
                    INNER JOIN
                        sc_titulopropiedad.tb_certificado c ON t.cert_id = c.cert_id 
                    INNER JOIN
                        sc_titulopropiedad.tb_alcalde a ON t.alca_id = a.alca_id 
                    INNER JOIN 
                        sc_titulopropiedad.tb_tipo_urbanizacion tu ON tu.tiur_id = c.tiur_id 
                    INNER JOIN 
                        sc_titulopropiedad.tb_tipo_via tv ON tv.tivi_id = c.tivi_id
                    WHERE 
                        t.est = 1 AND t.titu_id = ?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $titu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        
        }
        public function get_pdf_x_id_titulo_vista($titu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                    titu_firmapdf
                    FROM 
                    sc_titulopropiedad.tb_titulo
                    WHERE 
                    est = 1 AND titu_id = ?;";
             $sql=$conectar->prepare($sql);
             $sql->bindValue(1, $titu_id);
             $sql->execute();
             return $resultado=$sql->fetch();
        }
        public function get_pdf_x_id_titulo($titu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                    titu_firmapdf
                    FROM 
                    sc_titulopropiedad.tb_titulo 
                    WHERE 
                    est = 1 AND titu_id = ?;";
             $sql=$conectar->prepare($sql);
             $sql->bindValue(1, $titu_id);
             $sql->execute();
             return $resultado=$sql->fetch();
        }
        public function get_titulo_x_firm1(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                    titu_id
                    FROM 
                    sc_titulopropiedad.tb_titulo 
                    WHERE 
                    titu_estfirma = 1 AND titu_estimp = 0 AND  est = 1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_titulo_x_firm2(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                    titu_id
                    FROM 
                    sc_titulopropiedad.tb_titulo 
                    WHERE 
                    titu_estfirma = 2 AND titu_estimp = 0 AND  est = 1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_titulo_x_firm3(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                    titu_id
                    FROM 
                    sc_titulopropiedad.tb_titulo 
                    WHERE 
                    titu_estfirma = 3 AND titu_estimp = 0 AND  est = 1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function cambiarestado_impreso($titu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_titulo
                SET
                    titu_estimp = 1
                WHERE
                    titu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $titu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function cambiarestado_noimpreso($titu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_titulo
                SET
                    titu_estimp = 0
                WHERE
                    titu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $titu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function cambiarestado_completo($titu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_titulo
                SET
                    titu_est = 1
                WHERE
                    titu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $titu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function cambiarestado_entrega($titu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_titulo
                SET
                    titu_estent = 1
                WHERE
                    titu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $titu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function cambiarestado_adjuntado($titu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_titulo
                SET
                    titu_estadj = 1
                WHERE
                    titu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $titu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function cambiarestado_noadjuntado($titu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_titulo
                SET
                    titu_estadj = 0
                WHERE
                    titu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $titu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function cambiarestado_firmado($titu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_titulo
                SET
                    titu_estfirma = 1
                WHERE
                    titu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $titu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function cambiarestado_firmado2($titu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_titulo
                SET
                    titu_estfirma = 2
                WHERE
                    titu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $titu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function cambiarestado_firmado3($titu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_titulo
                SET
                    titu_estfirma = 3
                WHERE
                    titu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $titu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function cambiarestado_firmado4($titu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_titulo
                SET
                    titu_estfirma = 4
                WHERE
                    titu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $titu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function cambiarestado_recibo($titu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_titulopropiedad.tb_titulo
                SET
                    titu_estrecibo = 1
                WHERE
                    titu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $titu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
        public function get_total_titulos_registrados(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        count(titu_id) AS registrados
                  FROM 
                        sc_titulopropiedad.tb_titulo
                  WHERE 
                        est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_total_titulos_pendientes(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        COUNT(titu_id) AS pendientes
                  FROM  
                        sc_titulopropiedad.tb_titulo
                  WHERE 
                        titu_estimp = 0 AND est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_total_titulos_completados(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        COUNT(titu_id) AS completados
                  FROM  
                        sc_titulopropiedad.tb_titulo
                  WHERE 
                        titu_est = 1 AND est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_total_titulos_pendientes_subgerente(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        COUNT(titu_id) AS pendientes
                  FROM  
                        sc_titulopropiedad.tb_titulo
                  WHERE 
                        titu_estfirma = 1 AND est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_total_titulos_pendientes_gerente(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        COUNT(titu_id) AS pendientes
                  FROM  
                        sc_titulopropiedad.tb_titulo
                  WHERE 
                        titu_estfirma = 2 AND est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_total_titulos_pendientes_alcalde(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        COUNT(titu_id) AS pendientes
                  FROM  
                        sc_titulopropiedad.tb_titulo
                  WHERE 
                        titu_estfirma = 3 AND est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_total_titulos_descargables_subgerente(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        COUNT(titu_id) AS descargables
                  FROM  
                        sc_titulopropiedad.tb_titulo
                  WHERE 
                        titu_estfirma = 1 AND titu_estimp = 0 AND est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_total_titulos_descargables_gerente(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        COUNT(titu_id) AS descargables
                  FROM  
                        sc_titulopropiedad.tb_titulo
                  WHERE 
                       titu_estfirma = 2 AND titu_estimp = 0 AND est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_total_titulos_descargables_alcalde(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                        COUNT(titu_id) AS descargables
                  FROM  
                        sc_titulopropiedad.tb_titulo
                  WHERE 
                       titu_estfirma = 3 AND titu_estimp = 0 AND est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_resumen_titulo(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                            c.cert_nomtipourb nombrepoblacion,
                            SUM(CASE WHEN t.est = 1 THEN 1 ELSE 0 END) AS registrados,
                            SUM(CASE WHEN t.titu_estimp = 0 AND t.est = 1  THEN 1 ELSE 0 END) AS pendientes,
                            SUM(CASE WHEN t.titu_estimp = 1 AND t.est = 1 THEN 1 ELSE 0 END) AS completados
                    FROM 
                            sc_titulopropiedad.tb_certificado c INNER JOIN
                            sc_titulopropiedad.tb_titulo t ON c.cert_id = t.cert_id
                    GROUP BY 
                            c.cert_nomtipourb;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
    
        public function combo_fechcrea() {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT DISTINCT EXTRACT(YEAR FROM titu_fechcrea) 
                    FROM sc_titulopropiedad.tb_titulo 
                    WHERE est = 1;";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_COLUMN, 0);
        }

        public function combo_completo() {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT DISTINCT titu_est 
                    FROM sc_titulopropiedad.tb_titulo 
                    WHERE est = 1;";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_COLUMN, 0);
        }
       
        public function combo_urb() {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT DISTINCT c.cert_nomtipourb
                    FROM sc_titulopropiedad.tb_titulo t INNER JOIN
                    sc_titulopropiedad.tb_certificado c ON t.cert_id = c.cert_id 
                    WHERE t.est = 1;";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_COLUMN, 0);
        }
        public function update_pdf($titu_id, $titu_firmapdf){
            $conectar = parent::conexion();
            parent::set_names();
        
            require_once("Titulo.php");
            $curx = new Titulo();
        
            // Inicializar la variable para la nueva cadena base64 del archivo
            $titu_firmapdf = '';
        
            // Verificar si se ha subido un nuevo archivo
            if (isset($_FILES["titu_firmapdf"]) && $_FILES["titu_firmapdf"]["error"] == UPLOAD_ERR_OK) {
                // Subimos el nuevo archivo y lo codificamos en base64
                $titu_firmapdf = $curx->upload_file();
            } else {
                // Si no se ha subido un nuevo archivo, mantenemos el valor actual
                // (puedes ajustar esto según cómo desees manejar la ausencia de archivo)
                $titu_firmapdf = ''; // Cambiar a un valor por defecto si es necesario
            }
        
            // Actualizamos la base de datos con la nueva cadena base64 del archivo
            $sql = "UPDATE sc_titulopropiedad.tb_titulo
                    SET titu_firmapdf = ?
                    WHERE titu_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $titu_firmapdf);
            $sql->bindValue(2, $titu_id);
            $sql->execute();
    
            return $resultado = $sql->fetchAll();
        }
    
        public function upload_file(){
            if(isset($_FILES["titu_firmapdf"])){
                $extension = pathinfo($_FILES['titu_firmapdf']['name'], PATHINFO_EXTENSION);
                $allowed_extensions = array("pdf"); // Permitir solo archivos PDF
    
                if(in_array(strtolower($extension), $allowed_extensions)){
                    $file_content = file_get_contents($_FILES['titu_firmapdf']['tmp_name']);
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