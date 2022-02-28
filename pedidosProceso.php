<?php
require_once("phpClasses/connect.php");
if (!function_exists('str_contains')) {
    function str_contains ($haystack,$needle)
    {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}

function str_starts_with ( $haystack, $needle ) {
    return strpos( $haystack , $needle ) === 0;
  }

function str_ends_with($haystack, $needle) {
    $length = strlen($needle);
    return $length > 0 ? substr($haystack, -$length) === $needle : true;
}
?>
<html>

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Estilos-->
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/stylesDropdown.css">

   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
    

</head>
<body>
    <section id="global">
        <header>
            <div id="logo">
                <img src="img/logo-header.png" alt="">
            </div>
            <div class="clearfix"></div>
            <nav id="menu">
                <ul>
                    <li><a href="inventario.php">Inventario</a></li>
                    <li><a  href="ventas.php">Ventas</a></li>
                    <li><a class="active" href="pedidosProceso.php">Pedidos en proceso</a></li>
                    <li><a href="pedidos.php">Pedidos</a></li>
                    
                </ul>
            </nav>
        </header>

        <div id="sidebar">

        </div>
        <div id="posts">

        </div>
    </section>
   

</body>


</html>