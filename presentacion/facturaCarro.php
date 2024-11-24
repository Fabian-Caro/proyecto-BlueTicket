<?php
require_once(__DIR__ . '/../logica/Lugar.php');
require_once(__DIR__ . '/../logica/Evento.php');
require_once(__DIR__ . '/../logica/DetallesEvento.php');
require_once(__DIR__ . '/../logica/Factura.php');
require_once(__DIR__ . '/../logica/Boleta.php');
require_once(__DIR__ . '/../logica/Carro.php');

include 'navbar.php';
    
if (isset($_POST['items']) && isset($_POST['data'])) {
    // Los índices de los elementos seleccionados en el formulario
    $seleccionados = $_POST['items']; // Ejemplo: [0, 2, 3]

    // Todos los datos ocultos enviados en el formulario
    $datos = $_POST['data'];

    $valor_subtotal = isset($_POST['costo_total']) ? floatval($_POST['costo_total']) : 0;
    $ivaAgregado = $valor_subtotal*0.19;
    $valor_total = $valor_subtotal+$ivaAgregado;

    $fechaFactura = date("Y-m-d");
    $factura = new Factura();
    $factura -> insertar("'".$fechaFactura."'",$valor_subtotal,$valor_total,$idCliente);
    $idFactura = $factura -> ultimoId();
    $boleta = new  Boleta();
    $carro = new Carro();
    // Iterar sobre los elementos seleccionados
    foreach ($seleccionados as $indice) {
        // Obtener los datos del elemento seleccionado usando su índice
        $elementos = $datos[$indice];
        
        // Acceder a cada campo enviado
        $idCarro = $elementos['idsCarro'];
        $idDetalles = $elementos['idsDetalles'];
        $nombre = $elementos['nombres'];
        $lugar = $elementos['lugares'];
        $evento = $elementos['eventos'];
        $artista = $elementos['artistas'];
        $costo = $elementos['costos'];
        $boleta -> insertar("'".$nombre."'",$idFactura,$idDetalles);
        $carro -> eliminar($idCarro);
        echo "ID Detalles: " . $idDetalles . "<br>";
        echo "Nombre: " . $nombre . "<br>";
        echo "Lugar: " . $lugar . "<br>";
        echo "Evento: " . $evento . "<br>";
        echo "Artista: " . $artista . "<br>";
        echo "Costo: " . $costo . "<br><hr>";
    }

    echo "valor subtotal: ".$valor_subtotal. "<br>"; 
    echo "valor total: ".$valor_total. "<br>"; 
    echo "fecha: ".$fechaFactura. "<br>";
} else {
    // Si no se seleccionaron elementos o no llegaron datos
    echo "No se seleccionaron elementos para pagar.";
}
?>

<!-- <!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <div class="invoice-header">
            <h1>Factura</h1>
            <p>Fecha: <strong id="invoice-date"><?php echo $fechaFactura; ?></strong></p>
            <p>Nombre del Comprador: <strong id="buyer-name"><?php echo $cliente->getNombre() . " " . $cliente->getApellido(); ?></strong></p>
        </div>

        <div class="invoice-details">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $eventoData->getNombreEvento() ?></td>
                        <td><?php echo $cantidadEntradas ?></td>
                        <td>$<?php echo $detallesData->getCostoEvento() ?></td>
                        <td>$<?php echo $subTotal ?></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right">IVA (19%):</td>
                        <td>$<?php echo $ivaAgregado?></td>
                    </tr>
                    <tr class="total">
                        <td colspan="3" class="text-right">Total:</td>
                        <td>$<?php echo $total ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html> -->