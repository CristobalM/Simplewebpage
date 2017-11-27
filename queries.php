<?php

$pdo = new PDO('pgsql:host=localhost;port=5432;dbname=datos1000;user=postgres;password=postgres');

function queryCategoria($categoria_nombre){
    global $pdo;
    $q = "SELECT nombre_empresa, numero_documento, tipo, fecha,
                monto, categoria_nombre 
          FROM serviciosproductos
          WHERE categoria_nombre = '$categoria_nombre'";


    $result = $pdo->query($q);
    return $result;
}

function queryProyectoNoCobrado(){
    global $pdo;
    $q = "SELECT P.Nombre_Empresa, P.Nombre, P.Fecha_Emision_Presupuesto, P.Monto_Bruto,
    P.Monto_Liquido, P.Numero_Cuotas
FROM Proyecto P
WHERE P.Cobrado = False";
    return $pdo->query($q);
}

function queryCuotasEntreFechas($fechaI, $fechaF){
    global $pdo;
    $q = "SELECT P.Nombre_Empresa, P.Nombre_Proyecto, P.Fecha_Emision_Presupuesto,
    P.Monto_Neto, P.Monto_Liquido, P.Numero_Cuota, P.Cobrado, P.Fecha
FROM Pago P
WHERE P.Fecha >= '$fechaI' AND P.Fecha <= '$fechaF'";
    return $pdo->query($q);
}

function queryGastosEntreFechas($fechaI, $fechaF){
    global $pdo;
    $q = "SELECT G.Nombre_Empresa, G.Numero_Documento, G.Tipo, G.Fecha, G.Monto, G.Categoria_Nombre
FROM Serviciosproductos G
WHERE Fecha >= '$fechaI' AND Fecha <= '$fechaF'";
    return $pdo->query($q);
}

function queryMontoPagosAnho($anho){
    global $pdo;
    $q = "SELECT SUM(RangoFecha.Monto_Neto) as Total_2017
FROM (SELECT P.Nombre_Empresa, P.Nombre_Proyecto, P.Fecha_Emision_Presupuesto,
    P.Monto_Neto, P.Monto_Liquido, P.Numero_Cuota, P.Cobrado, P.Fecha
	FROM Pago P
	WHERE P.Fecha >= '$anho-01-01' AND P.Fecha <= '$anho-12-31') as RangoFecha";
    return $pdo->query($q);
}

function queryGastosAnho($anho){
    global $pdo;
    $q = "SELECT SUM(RangoFecha.Monto) as Gastos_anho
FROM (SELECT S.Monto
	FROM ServiciosProductos S
	WHERE S.Fecha >= '$anho-01-01' AND S.Fecha <= '$anho-12-31') as RangoFecha";
    return $pdo->query($q);
}

// querys anexas

function singleQueryResult($q){
    global $pdo;
    return $pdo->query($q)->fetch()[0];
}

function extractFromQueriesMaxOrMin($arr, $isMax){
    if(count($arr) <= 0){
        return;
    }
    $aux = date_create(singleQueryResult($arr[0]));
    foreach($arr as $currentQ){
        $result = date_create(singleQueryResult($currentQ));
        if($isMax){
            if(date_diff($result, $aux)->d > 0){
                $aux = $result;
            }
        }
        else{
            if(date_diff($result, $aux)->d < 0){
                $aux = $result;
            }
        }
    }
    return $aux;
}

function queryGetMaxMinYear(){

    $q_minFecha_serviciosproductos  = "SELECT MIN(fecha) as minFecha FROM serviciosproductos";
    $q_maxFecha_serviciosproductos  = "SELECT MAX(fecha) as maxFecha FROM serviciosproductos";

    $q_minFecha_tiene = "SELECT MIN(fecha_emision_presupuesto) as minFecha FROM tiene";
    $q_maxFecha_tiene = "SELECT MAX(fecha_emision_presupuesto) as maxFecha FROM tiene";

    $q_minFecha_proyecto = "SELECT MIN(fecha_emision_presupuesto) as minFecha FROM proyecto";
    $q_maxFecha_proyecto = "SELECT MAX(fecha_emision_presupuesto) as maxFecha FROM proyecto";

    $q_minFecha_pago1 = "SELECT MIN(fecha_emision_presupuesto) as minFecha FROM pago";
    $q_maxFecha_pago1 = "SELECT MAX(fecha_emision_presupuesto) as maxFecha FROM pago";

    $q_minFecha_pago2 = "SELECT MIN(fecha) as minFecha FROM pago";
    $q_maxFecha_pago2 = "SELECT MAX(fecha) as maxFecha FROM pago";

    $min_arr = [$q_minFecha_serviciosproductos,
        $q_minFecha_tiene,
        $q_minFecha_proyecto,
        $q_minFecha_pago1,
        $q_minFecha_pago2];

    $max_arr = [$q_maxFecha_serviciosproductos,
        $q_maxFecha_tiene,
        $q_maxFecha_proyecto,
        $q_maxFecha_pago1,
        $q_maxFecha_pago2];

    $minYear = extractFromQueriesMaxOrMin($min_arr, false)->format('Y');
    $maxYear = extractFromQueriesMaxOrMin($max_arr, true)->format('Y');

    return [$minYear, $maxYear];
}


// insert


function qInsertCategoria($categoria){
    global $pdo;
    $q = "INSERT INTO categoria (nombre) values ('$categoria')";
    return $pdo->query($q);
}

function qInsertEmpresa($empresa){
    global $pdo;
    $q = "INSERT INTO empresa (nombre) values ('$empresa')";
    return $pdo->query($q);
}

function qInsertarProyecto($nombre_proyecto, $nombre_empresa,
                           $fpresupuesto, $cobrado, $mbruto, $mliquido, $ncuotas){
    global $pdo;

    $q = "INSERT INTO proyecto (nombre, nombre_empresa, fecha_emision_presupuesto,
cobrado, monto_bruto, monto_liquido, numero_cuotas) values
('$nombre_proyecto', '$nombre_empresa', '$fpresupuesto',  $cobrado, $mbruto, $mliquido, $ncuotas)";
    return $pdo->query($q);
}



?>