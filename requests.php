<?php
//error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once ("queries.php");
include_once ("globals.php");

global $GASTOS_CATEGORIA,
       $PROYECTOS_NOCOBRADOS,
       $CUOTAS_PPFECHA,
       $GASTOS_FECHAS,
       $PAGOS_ANHO,
       $GASTOS_ANHO,
       $GASTOS_CATEGORIA_DESC,
       $PROYECTOS_NOCOBRADOS_DESC,
       $CUOTAS_PPFECHA_DESC,
       $GASTOS_FECHAS_DESC,
       $PAGOS_ANHO_DESC,
       $GASTOS_ANHO_DESC;


function gatherResults($result){
    $output = [];
    while($row = $result->fetch()){
        $aux = [];
        if(!isset($row)){
            continue;
        }
        for($i = 0; $i < sizeof($row); $i++){
            if(!isset($row[$i]) || $row[$i] == null){
                break;
            }
            array_push($aux, $row[$i]);
        }
        array_push($output, $aux);
    }
    return $output;
}

$qname = $_GET['query'];
if ($qname == $GASTOS_CATEGORIA){
    $result = queryCategoria($_GET['name']);
    $output = gatherResults($result);
    echo json_encode($output);
}
else if($qname == $PROYECTOS_NOCOBRADOS){
    $result = queryProyectoNoCobrado();
    $output = gatherResults($result);
    echo json_encode($output);
}
else if($qname == $CUOTAS_PPFECHA){
    $dateI = $_GET['dateI'];
    $dateF = $_GET['dateF'];
    $result = queryCuotasEntreFechas($dateI, $dateF);
    //print_r($result);
    //print_r($result->fetch()[0]);
    //print_r($result->fetch()[0]);
    $output = gatherResults($result);
    $encoded = json_encode($output);
    //print_r($output);
    echo $encoded;
}
else if($qname == $GASTOS_FECHAS){
    $dateI = $_GET['dateI'];
    $dateF = $_GET['dateF'];
    $result = queryGastosEntreFechas($dateI, $dateF);
    $output = gatherResults($result);
    $encoded = json_encode($output);
    echo $encoded;
}
else if($qname == $PAGOS_ANHO){
    $year = $_GET['year'];
    $result = queryMontoPagosAnho($year);
    $output = gatherResults($result);
    $encoded = json_encode($output);
    echo $encoded;
}
else if($qname == $GASTOS_ANHO){
    $year = $_GET['year'];
    $result = queryGastosAnho($year);
    $output = gatherResults($result);
    $encoded = json_encode($output);
    echo $encoded;
}
else if($qname == $INSERCION_CATEGORIA){
    $categoria = $_GET['name'];
    $result = qInsertCategoria($categoria);
    if($result){
        echo "Se inserto la categoria $categoria";
    }
    else{
        echo "Hubo un error";
    }
}
else if ($qname == $INSERCION_EMPRESA){
    $empresa = $_GET['name'];
    $result = qInsertEmpresa($empresa);
    if($result){
        echo "Se inserto la empresa $empresa";
    }
    else{
        echo "Hubo un error";
    }
}
else if($qname == $INSERCION_PROYECTO){
    $nombre_proyecto = $_GET['nombre_proyecto'];
    $nombre_empresa = $_GET['nombre_empresa'];
    $fpresupuesto =  $_GET['fpresupuesto'];
    $cobrado = $_GET['cobrado'];
    $mbruto = $_GET['mbruto'];
    $mliquido = $_GET['mliquido'];
    $ncuotas = $_GET['ncuotas'];
    $result = qInsertarProyecto($nombre_proyecto, $nombre_empresa,
        $fpresupuesto, $cobrado, $mbruto, $mliquido, $ncuotas);
    if($result){
        echo "Se inserto el proyecto $nombre_proyecto";
    }
    else{
        echo "Hubo un error";
    }
}