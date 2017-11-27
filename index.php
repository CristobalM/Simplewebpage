<?php
//error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL);
ini_set('display_errors', 1);
/**
 * Created by IntelliJ IDEA.
 * User: cristobal
 * Date: 26-11-17
 * Time: 13:53
 */
include_once ("queries.php");
include_once ("globals.php");
$_yearsMinMax = queryGetMaxMinYear();
$minYear = $_yearsMinMax[0];
$maxYear = $_yearsMinMax[1];

$months = ["Enero", "Febrero", "Marzo", "Abril",
    "Mayo", "Junio", "Julio", "Agosto",
    "Septiembre", "Octubre", "Noviembre", "Diciembre"];


$queryNames = [$GASTOS_CATEGORIA,
    $PROYECTOS_NOCOBRADOS,
    $CUOTAS_PPFECHA,
    $GASTOS_FECHAS,
    $PAGOS_ANHO,
    $GASTOS_ANHO,
    $INSERCION_CATEGORIA,
    $INSERCION_EMPRESA,
    $INSERCION_PROYECTO,
    $INSERCION_PAGO,
    $INSERCION_SERVICIOPRODUCTO,
    $INSERCION_TIENE];
$queryDescs = [$GASTOS_CATEGORIA_DESC,
    $PROYECTOS_NOCOBRADOS_DESC,
    $CUOTAS_PPFECHA_DESC,
    $GASTOS_FECHAS_DESC,
    $PAGOS_ANHO_DESC,
    $GASTOS_ANHO_DESC,
    $INSERCION_CATEGORIA_DESC,
    $INSERCION_EMPRESA_DESC,
    $INSERCION_PROYECTO_DESC,
    $INSERCION_PAGO_DESC,
    $INSERCION_SERVICIOPRODUCTO_DESC,
    $INSERCION_TIENE_DESC];

function yearOption($id, $which){
    global $minYear, $maxYear, $months;
    $yearId = $id . "_" . $which . "_year";

    echo "Año: ";
    echo "<select id=\"$yearId\">";

    for($i = $minYear; $i <= $maxYear; $i++){
        echo "<option>$i</option>\n";
    }

    echo "</select>";
}

function dateOptions($id, $which){
    global $minYear, $maxYear, $months;

    $dayId = $id . "_" .$which . "_day";
    $monthId = $id . "_" . $which . "_month";
    $yearId = $id . "_" . $which . "_year";

    echo "Dia:";
    echo "<select id=\"$dayId\">";
    for($i = 1; $i <= 31; $i++){
        echo "<option>$i</option>\n";
    }
    echo "</select>";


    echo "Mes: ";
    echo "<select id=\"$monthId\">";
    foreach($months as $month){
        echo "<option>$month</option>\n";
    }
    echo "</select>";


    echo "Año: ";
    echo "<select id=\"$yearId\">";

    for($i = $minYear; $i <= $maxYear; $i++){
        echo "<option>$i</option>\n";
    }

    echo "</select>";

}

function selectQuery($name){

}


?>

<html>
<head>
    <script src="jquery-3.2.1.min.js"></script>

</head>
<body>

Consulta:
<select id="change_query_select" onchange="changeQuery()">
    <?php
        for($i = 0; $i < sizeof($queryNames); $i++){
            echo "<option value=$queryNames[$i]>$queryDescs[$i] </option>\n";
        }
    ?>
</select>
<form id="<?php echo $GASTOS_CATEGORIA; ?>">
    <?php echo $GASTOS_CATEGORIA_DESC; ?> <br>
    Nombre categoria: <input type="text" id="_nombre_categoria"/>
    <button type="button" onclick="gastosCategoria(); return false;">Consultar</button>
</form>
<form id="<?php echo $PROYECTOS_NOCOBRADOS; ?>">
    <?php echo $PROYECTOS_NOCOBRADOS_DESC; ?><br>
    <button type="button" onclick="return proyectosNoCobrados();">Consultar</button>
</form>
<form id="<?php echo $CUOTAS_PPFECHA; ?>">
    <?php echo $CUOTAS_PPFECHA_DESC; ?><br>
    Fecha Inicial: <?php dateOptions($CUOTAS_PPFECHA, 0); ?>
    Fecha Final: <?php dateOptions($CUOTAS_PPFECHA, 1); ?>
    <button type="button" onclick="return cuotasPPFecha();">Consultar</button>
</form>
<form id="<?php echo $GASTOS_FECHAS; ?>">
    <?php echo $GASTOS_FECHAS_DESC; ?><br>
    Fecha Inicial: <?php dateOptions($GASTOS_FECHAS, 0); ?>
    Fecha Final: <?php dateOptions($GASTOS_FECHAS, 1); ?>
    <button type="button" onclick="return gastosFechas();"> Consultar</button>
</form>
<form id="<?php echo $PAGOS_ANHO; ?>">
    <?php echo $PAGOS_ANHO_DESC; ?> <br>
    <?php echo yearOption($PAGOS_ANHO, 0)?>
    <button type="button" onclick="return pagosAnho();">Consultar</button>
</form>
<form id="<?php echo $GASTOS_ANHO; ?>">
    <?php echo $GASTOS_ANHO_DESC; ?> <br>
    <?php echo yearOption($GASTOS_ANHO, 0)?>
    <button type="button" onclick="return gastosAnho();">Consultar</button>
</form>
<!-- Insert -->
<form id="<?php echo $INSERCION_CATEGORIA; ?>">
    <?php echo $INSERCION_CATEGORIA_DESC; ?> <br>
    Nombre: <input type="text" id="_ins_nombre_categoria"/>
    <button type="button" onclick="return insertarCategoria();">Insertar</button>
</form>
<form id="<?php echo $INSERCION_EMPRESA; ?>">
    <?php echo $INSERCION_EMPRESA_DESC; ?> <br>
    Nombre: <input type="text" id="_ins_nombre_empresa"/>
    <button type="button" onclick="return insertarEmpresa();">Insertar</button>
</form>
<form id="<?php echo $INSERCION_PROYECTO; ?>">
    <?php echo $INSERCION_PROYECTO_DESC; ?> <br>
    Nombre Proyecto: <input type="text" id="_ins_nombre_proyecto"/> <br>
    Nombre Empresa: <input type="text" id="_ins_nombre_empresa_proyecto"/> <br>
    Fecha de emisión de presupuesto:
    <?php echo dateOptions($INSERCION_PROYECTO, 0) ?><br>
    Cobrado: <select id="_ins_cobrado_proyecto">
    <option value="true">Si</option>
    <option value="false">No</option>
    </select>
    <br>
    Monto Bruto: <input type="text" id="_ins_mbruto_proyecto"/> <br>
    Monto Líquido: <input type="text" id="_ins_mliquido_proyecto"/> <br>
    Numero de cuotas: <input type="text" id="_ins_ncuotas_proyecto"/> <br>

    <button type="button" onclick="return insertarProyecto();">Insertar</button>
</form>
<form id="<?php echo $INSERCION_PAGO; ?>">
    <?php echo $INSERCION_PAGO_DESC; ?> <br>
    Nombre Empresa: <input type="text" id="_ins_nombre_empresa_pago"/> <br>
    Nombre Proyecto: <input type="text" id="_ins_nombre_proyecto_pago"/> <br>
    Fecha de emisión de presupuesto:  <?php echo dateOptions($INSERCION_PAGO, 0) ?> <br>
    Numero de cuota: <input type="text" id="_ins_ncuota_pago"/> <br>
    Cobrado: <select id="_ins_cobrado_pago"/>
    <option value="true">Si</option>
    <option value="false">No</option>
    <br>
    Tipo: <select id="_ins_tipo_pago"/>
        <option value="Boleta">Boleta</option>
        <option value="Factura">Factura</option>
    <br>
    Monto Líquido: <input type="text" id="_ins_mliquido_pago"/> <br>
    Monto Neto: <input type="text" id="_ins_mneto_pago"/> <br>
    Fecha <?php echo dateOptions($INSERCION_PAGO, 1) ?> <br>

    <button type="button" onclick="return insertarPago();">Insertar</button>
</form>
<form id="<?php echo $INSERCION_SERVICIOPRODUCTO; ?>">
    <?php echo $INSERCION_SERVICIOPRODUCTO_DESC; ?> <br>
    Nombre Empresa: <input type="text" id="_ins_nombre_empresa_sp"/> <br>
    Numero de documento: <input type="text" id="_ins_ndoc_sp"/> <br>
    Tipo: <select id="_ins_tipo_sp">
    <option value="Boleta">Boleta</option>
    <option value="Factura">Factura</option>
    </select><br>
    Fecha: <?php echo dateOptions($INSERCION_SERVICIOPRODUCTO, 0) ?> <br>
    Monto: <input type="text" id="_ins_monto_sp"/> <br>
    Nombre de categoria: <input type="text" id="_ins_ncategoria_sp"/> <br>

    <button type="button" onclick="return insertarSP();">Insertar</button>
</form>

<form id="<?php echo $INSERCION_TIENE; ?>">
    <?php echo $INSERCION_TIENE_DESC; ?> <br>
    Nombre Empresa: <input type="text" id="_ins_nombre_empresa_tiene"/> <br>
    Nombre Proyecto: <input type="text" id="_ins_nombre_proyecto_tiene"/> <br>
    Fecha de emisión de presupuesto:
    <?php echo dateOptions($INSERCION_TIENE, 0) ?><br>
    Nombre Contacto: <input type="text" id="_ins_ncontacto_tiene"/> <br>
    Apellido Contacto: <input type="text" id="_ins_acontacto_tiene"/> <br>


    <button type="button" onclick="return insertarTiene();">Insertar</button>
</form>


<hr>

<div id="result">
</div>

<script>

    var queryNames = <?php echo json_encode($queryNames); ?>;


    function changeQuery(){
        var index = $("#change_query_select")[0].selectedIndex;
        for(var i = 0; i < queryNames.length; i++){
            if(i === index){
                $("#"+queryNames[i]).show();
            }
            else{
                $("#"+queryNames[i]).hide();
            }
        }
        $("#result").html("");
    }
    changeQuery();

    function makeQuery(data, onResponse){
        $.ajax({
           type: "GET",
            url: "requests.php",
            data: data,
            success: onResponse
        });
    }

    function gastosCategoria(){
        var categoria = $("#_nombre_categoria").val();
        makeQuery({query: "<?php echo $GASTOS_CATEGORIA; ?>",
            name: categoria}, function(response){
            var result = JSON.parse(response);
            var output = "";
            output += "<table>";
            output += "<tr>";
            output += "<th>Nombre de Empresa</th>";
            output += "<th>Numero de Documento</th>";
            output += "<th>Tipo</th>";
            output += "<th>Fecha</th>";
            output += "<th>Monto</th>";
            output += "<th>Nombre de categoria</th>";
            output += "</tr>";


            result.forEach(function(row){
                output += "<tr>";
                row.forEach(function (value) {
                    output += "<td>" + value + "</td>";
                });
                output += "</tr>";
            });

            output += "</table>";
            $("#result").html(output);
        });

        return false;
    }

    function proyectosNoCobrados(){
        makeQuery({query:"<?php echo $PROYECTOS_NOCOBRADOS; ?>" },
        function (response) {
            var result = JSON.parse(response);
            var output = "";
            output += "<table>";
            output += "<tr>";
            output += "<th>Nombre de Empresa</th>";
            output += "<th>Nombre</th>";
            output += "<th>Fecha de emisión de presupuesto</th>";
            output += "<th>Monto Bruto</th>";
            output += "<th>Monto Liquido</th>";
            output += "<th>Numero de cuotas</th>";
            output += "</tr>";


            result.forEach(function(row){
                output += "<tr>";
                row.forEach(function (value) {
                    output += "<td>" + value + "</td>";
                });
                output += "</tr>";
            });

            output += "</table>";
            $("#result").html(output);
        });

        return false;
    }


    function cuotasPPFecha(){
        var dayI = $("#<?php echo $CUOTAS_PPFECHA ?>_0_day").find(":selected").text();
        var monthI = $("#<?php echo $CUOTAS_PPFECHA ?>_0_month")[0].selectedIndex + 1;
        var yearI = $("#<?php echo $CUOTAS_PPFECHA ?>_0_year").find(":selected").text();
        var selectedDateI = yearI + "-" + monthI + "-" + dayI;
        var dayF = $("#<?php echo $CUOTAS_PPFECHA ?>_1_day").find(":selected").text();
        var monthF = $("#<?php echo $CUOTAS_PPFECHA ?>_1_month")[0].selectedIndex + 1;
        var yearF = $("#<?php echo $CUOTAS_PPFECHA ?>_1_year").find(":selected").text();
        var selectedDateF = yearF + "-" + monthF + "-" + dayF;
        makeQuery({query:"<?php echo $CUOTAS_PPFECHA; ?>", dateI: selectedDateI, dateF: selectedDateF },
            function (response) {

                var result = JSON.parse(response);
                var output = "";
                output += "<table>";
                output += "<tr>";
                output += "<th>Nombre de Empresa</th>";
                output += "<th>Nombre de Proyecto</th>";
                output += "<th>Fecha de emisión de presupuesto</th>";
                output += "<th>Monto Neto</th>";
                output += "<th>Monto Liquido</th>";
                output += "<th>Numero de cuota</th>";
                output += "<th>Cobrado</th>";
                output += "<th>Fecha</th>";
                output += "</tr>";


                result.forEach(function(row){
                    output += "<tr>";
                    row.forEach(function (value) {
                        output += "<td>" + value + "</td>";
                    });
                    output += "</tr>";
                });

                output += "</table>";

                $("#result").html(output);
            });

        return false;
    }

    function gastosFechas() {
        var dayI = $("#<?php echo $GASTOS_FECHAS ?>_0_day").find(":selected").text();
        var monthI = $("#<?php echo $GASTOS_FECHAS ?>_0_month")[0].selectedIndex + 1;
        var yearI = $("#<?php echo $GASTOS_FECHAS ?>_0_year").find(":selected").text();
        var selectedDateI = yearI + "-" + monthI + "-" + dayI;
        var dayF = $("#<?php echo $GASTOS_FECHAS ?>_1_day").find(":selected").text();
        var monthF = $("#<?php echo $GASTOS_FECHAS ?>_1_month")[0].selectedIndex + 1;
        var yearF = $("#<?php echo $GASTOS_FECHAS ?>_1_year").find(":selected").text();
        var selectedDateF = yearF + "-" + monthF + "-" + dayF;
        makeQuery({query:"<?php echo $GASTOS_FECHAS; ?>", dateI: selectedDateI, dateF: selectedDateF },
            function (response) {

                var result = JSON.parse(response);
                var output = "";
                output += "<table>";
                output += "<tr>";
                output += "<th>Nombre de Empresa</th>";
                output += "<th>Numero de documento</th>";
                output += "<th>Tipo</th>";
                output += "<th>Fecha</th>";
                output += "<th>Monto</th>";
                output += "<th>Nombre de categoria</th>";
                output += "</tr>";


                result.forEach(function(row){
                    output += "<tr>";
                    row.forEach(function (value) {
                        output += "<td>" + value + "</td>";
                    });
                    output += "</tr>";
                });

                output += "</table>";

                $("#result").html(output);
            });

        return false;
    }

    function pagosAnho() {
        var year = $("#<?php echo $PAGOS_ANHO ?>_0_year").find(":selected").text();
        makeQuery({query:"<?php echo $PAGOS_ANHO; ?>", year: year },
            function (response) {

                var result = JSON.parse(response);
                var output = "";
                output += "<table>";
                output += "<tr>";
                output += "<th>Suma de Pagos</th>"
                output += "</tr>";

                result.forEach(function(row){
                    output += "<tr>";
                    row.forEach(function (value) {
                        output += "<td>" + value + "</td>";
                    });
                    output += "</tr>";
                });

                output += "</table>";

                $("#result").html(output);
            });

        return false;
    }

    function gastosAnho() {
        var year = $("#<?php echo $GASTOS_ANHO ?>_0_year").find(":selected").text();
        makeQuery({query:"<?php echo $GASTOS_ANHO; ?>", year: year },
            function (response) {

                var result = JSON.parse(response);
                var output = "";
                output += "<table>";
                output += "<tr>";
                output += "<th>Suma de Gastos</th>"
                output += "</tr>";

                result.forEach(function(row){
                    output += "<tr>";
                    row.forEach(function (value) {
                        output += "<td>" + value + "</td>";
                    });
                    output += "</tr>";
                });

                output += "</table>";

                $("#result").html(output);
            });

        return false;
    }
    function insertarCategoria() {
        var categoria = $("#_ins_nombre_categoria").val();

        makeQuery({query: "<?php echo $INSERCION_CATEGORIA; ?>",
            name: categoria}, function(response){

            $("#result").html(response);
        });

        return false;
    }
    function insertarEmpresa(){
        var empresa = $("#_ins_nombre_empresa").val();
        makeQuery({query: "<?php echo $INSERCION_EMPRESA; ?>",
            name: empresa}, function(response){

            $("#result").html(response);
        });

        return false;
    }

    function insertarProyecto(){
        var nombre_proyecto = $("#_ins_nombre_proyecto").val();
        var nombre_empresa = $("#_ins_nombre_empresa_proyecto").val();
        var dayI = $("#<?php echo $INSERCION_PROYECTO ?>_0_day").find(":selected").text();
        var monthI = $("#<?php echo $INSERCION_PROYECTO ?>_0_month")[0].selectedIndex + 1;
        var yearI = $("#<?php echo $INSERCION_PROYECTO ?>_0_year").find(":selected").text();
        var fpresupuesto = yearI + "-" + monthI + "-" + dayI;

        var cobrado = $("#_ins_cobrado_proyecto").val();
        var mbruto = $("#_ins_mbruto_proyecto").val();
        var mliquido = $("#_ins_mliquido_proyecto").val();
        var ncuotas = $("#_ins_ncuotas_proyecto").val();


        makeQuery({query:"<?php echo $INSERCION_PROYECTO; ?>",
            nombre_proyecto: nombre_proyecto,
            nombre_empresa: nombre_empresa,
            fpresupuesto: fpresupuesto,
            cobrado: cobrado,
            mbruto: mbruto,
            mliquido: mliquido,
            ncuotas: ncuotas

        }, function(response){
            $("#result").html(response);
        });


        return false;
    }

    function insertarPago(){
        var nombre_empresa = $("#_ins_nombre_empresa_pago").val();
        var nombre_proyecto = $("#_ins_nombre_proyecto_pago").val();
        var dayI = $("#<?php echo $INSERCION_PAGO ?>_0_day").find(":selected").text();
        var monthI = $("#<?php echo $INSERCION_PAGO ?>_0_month")[0].selectedIndex + 1;
        var yearI = $("#<?php echo $INSERCION_PAGO ?>_0_year").find(":selected").text();
        var dayF = $("#<?php echo $INSERCION_PAGO ?>_1_day").find(":selected").text();
        var monthF = $("#<?php echo $INSERCION_PAGO ?>_1_month")[0].selectedIndex + 1;
        var yearF = $("#<?php echo $INSERCION_PAGO ?>_1_year").find(":selected").text();

        var fpresupuesto = yearI + "-" + monthI + "-" + dayI;
        var fecha = yearF + "-" + monthF + "-" + dayF;

        var cobrado = $("#_ins_cobrado_pago").val();
        var tipo = $("#_ins_tipo_pago").val();
        var mneto = $("#_ins_mneto_pago").val();
        var mliquido = $("#_ins_mliquido_pago").val();
        var ncuota = $("#_ins_ncuota_pago").val();


        makeQuery({query:"<?php echo $INSERCION_PAGO; ?>",
            nombre_proyecto: nombre_proyecto,
            nombre_empresa: nombre_empresa,
            fpresupuesto: fpresupuesto,
            fecha: fecha,
            cobrado: cobrado,
            tipo: tipo,
            mneto: mneto,
            mliquido: mliquido,
            ncuota: ncuota

        }, function(response){
            $("#result").html(response);
        });


        return false;
    }

    function insertarSP() {
        var nombre_empresa = $("#_ins_nombre_empresa_sp").val();
        var numero_documento = $("#_ins_ndoc_sp").val();
        var dayI = $("#<?php echo $INSERCION_SERVICIOPRODUCTO ?>_0_day").find(":selected").text();
        var monthI = $("#<?php echo $INSERCION_SERVICIOPRODUCTO ?>_0_month")[0].selectedIndex + 1;
        var yearI = $("#<?php echo $INSERCION_SERVICIOPRODUCTO ?>_0_year").find(":selected").text();

        var fecha = yearI + "-" + monthI + "-" + dayI;

        var tipo = $("#_ins_tipo_sp").val();
        var monto = $("#_ins_monto_sp").val();
        var categoria_nombre = $("#_ins_ncategoria_sp").val();


        makeQuery({query:"<?php echo $INSERCION_SERVICIOPRODUCTO; ?>",
            nombre_empresa: nombre_empresa,
            numero_documento: numero_documento,
            fecha: fecha,
            tipo: tipo,
            monto:monto,
            categoria_nombre : categoria_nombre,

        }, function(response){
            $("#result").html(response);
        });


        return false;
    }

    function insertarTiene(){
        var nombre_empresa = $("#_ins_nombre_empresa_tiene").val();
        var nombre_proyecto = $("#_ins_nombre_proyecto_tiene").val();
        var dayI = $("#<?php echo $INSERCION_TIENE ?>_0_day").find(":selected").text();
        var monthI = $("#<?php echo $INSERCION_TIENE ?>_0_month")[0].selectedIndex + 1;
        var yearI = $("#<?php echo $INSERCION_TIENE ?>_0_year").find(":selected").text();

        var fpresupuesto = yearI + "-" + monthI + "-" + dayI;

        var ncontacto = $("#_ins_ncontacto_tiene").val();
        var acontacto = $("#_ins_acontacto_tiene").val();


        makeQuery({query:"<?php echo $INSERCION_TIENE; ?>",
            nombre_empresa: nombre_empresa,
            nombre_proyecto: nombre_proyecto,
            fpresupuesto: fpresupuesto,
            ncontacto: ncontacto,
            acontacto: acontacto

        }, function(response){
            $("#result").html(response);
        });

        return false;

    }

    function onlyNumbers(id){
        $("#"+id).keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl/cmd+A
                (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: Ctrl/cmd+C
                (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: Ctrl/cmd+X
                (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
    }

    $(document).ready(function() {
        onlyNumbers("_ins_mbruto_proyecto");
        onlyNumbers("_ins_mliquido_proyecto");
        onlyNumbers("_ins_ncuotas_proyecto");
        onlyNumbers("_ins_mneto_pago");
        onlyNumbers("_ins_ndoc_sp");
        onlyNumbers("_ins_monto_sp");
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                var index = $("#change_query_select")[0].selectedIndex;
                switch(index){
                    case 0:
                        gastosCategoria();
                        break;
                    case 1:
                        proyectosNoCobrados();
                        break;
                    case 2:
                        cuotasPPFecha();
                        break;
                    case 3:
                        gastosFechas();
                        break;
                    case 4:
                        pagosAnho();
                        break;
                    case 5:
                        gastosAnho();
                        break;
                    case 6:
                        insertarCategoria();
                        break;


                }
                return false;
            }
        });
    });



</script>
</body>
</html>
