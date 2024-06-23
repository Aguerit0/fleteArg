<?php
// SDK de Mercado Pago
require 'vendor/autoload.php';
// Agrega credenciales
MercadoPago\SDK::setAccessToken('YOUR_ACCESS_TOKEN');


// Crea un objeto de preferencia
$preference = new MercadoPago\Preference();

// Crea un ítem en la preferencia
$item = new MercadoPago\Item();
$item->title = 'Mi producto';
$item->quantity = 1;
$item->unit_price = 75.56;
$item->currency_id = 'ARS';

$preference->items = array($item);
$preference->back_urls = array(
    "success" => "http://localhost/PROYECTOS/mp/captura.php",
    "failure" => "http://localhost/PROYECTOS/mp/fallo.php",
);
$preference->auto_return = "approved";
$preference->binary_mode = true;

$preference->save();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
     <div class="wallet_container" id="wallet_container"></div>
</body>

<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
    const mp = new MercadoPago('TEST-7fc885ba-08d5-438d-9cb4-6e53fa53d0d9',{
        locale: 'es-AR'
    });
        mp.checkout({
            preference: {
                id: '<?php echo $preference->id ;?>'
            },
            render: {
                container: '.wallet_container',
                label: 'Pagar con MP'
            }
        })



</script>

</html>