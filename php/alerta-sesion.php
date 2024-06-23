<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="icon" type="image/jpeg" href="../images/logoFletear.png" />
    <title>FleteAr</title>
</head>
<body>
    <script type="text/javascript">
        n = 1500

        var id = window.setInterval(function(){
            document.onmousemove = function(){
                n = 1500
            };
            document.onkeydown = function(){
                n = 1500
            };
            n--;
            if(n <= 0){
                alert("Inactividad: La sesión expiró");
                location.href="cerrar-sesion.php";
            }
        },1200);

    </script>
</body>
</html>