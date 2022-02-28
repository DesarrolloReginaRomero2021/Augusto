<?php
require_once("phpClasses/connect.php");
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
    <script language="javascript" >
			$(document).ready(function(){
				$("#categoria").change(function () {					
					$("#categoria option:selected").each(function () {
						categoria = $(this).val();
						$.get("phpClasses/getModeloInventario.php", { categoria: categoria }, function(data){
							$("#modelo").html(data);
						});            
					});
				})
                $("#modelo").change(function () {					
					$("#modelo option:selected").each(function () {
						modelo = $(this).val();
						$.get("phpClasses/getColorInventario.php", { modelo: modelo }, function(data){
							$("#color").html(data);
						});

					});
				})
                $("#modelo").change(function () {					
					$("#modelo option:selected").each(function () {
						modelo = $(this).val();
						$.get("phpClasses/getTallaInventario.php", { modelo: modelo }, function(data){
							$("#talla").html(data);
						});
                        
					});
				})


			});
	</script>
</head>

<body>
 
    <section id="global">
        <!--cABEZERA-->
        <header>
            <div id="logo">
                <img src="img/logo-header.png" alt="">
            </div>
            <div class="clearfix"></div>
            <nav id="menu">
                <ul>
                    <li><a class="active" href="inventario.php">Inventario</a></li>
                    <li><a href="ventas.php">Ventas</a></li>
                    <li><a href="pedidosProceso.php">Pedidos en proceso</a></li>
                    <li><a href="pedidos.php">Pedidos</a></li>
                    
                </ul>
            </nav>
        </header>
        <!--Contenido-->
        <section id="content">
            <?php
                include 'phpClasses/inventario.php';
                $inventario = new Inventario();	
            ?>	
            <div id="sidebar">
                <form action="" method="GET">
                    <button class="btn"><i class="fa fa-search"></i> Generar Reporte</button>
                    <center><h3>Sucursales(obligatorio)</h3></center>
                    <div class="sucursales">
                        <?php
                        $sucursal = $inventario->getSucursales();
                        $sucursalChecked=[];
                        foreach($sucursal as $sucursales){
                                
                                if(isset($_GET['sucursal']))
                                    $sucursalChecked=$_GET['sucursal'];
                                
                        ?>
                        <div class="col-100">
                        <input type="checkbox" class="inventario sucursal" name ="sucursal[]" value="<?= $sucursales["sucursal"]; ?>"  
                        <?php if(in_array($sucursales['sucursal'], $sucursalChecked)){ echo "checked"; } ?>> <?= $sucursales["sucursal"]; ?>
                        </div>
                        <?php }	?>                      
                    </div>
                    <center><h3>Categorias</h3></center>
                    <div class="container-menu">
                        <select name="categoria" id="categoria">
                                
                         <?php
                            $sql="select codigo,categoria from categorias order by categoria asc";
                            $result=mysqli_query($con, $sql);
                            if (!$result){ 
                                echo  mysqli_error($con);
                                
                            }else{
                                if(isset($_GET['categoria'])){
                                    $sql="select codigo,categoria from categorias where codigo='".$_GET['categoria']."'";
                                    $res=mysqli_query($con, $sql);
                                    if (!$res){ 
                                        echo  mysqli_error($con);
                                        
                                    }else{
                                        $row1=mysqli_fetch_assoc($res);
                                        echo "<option value='".$row1['codigo']."'>".$row1['categoria']."</option>";
                                        $sql="select codigo,categoria from categorias order by categoria asc";
                                        $result=mysqli_query($con, $sql);
                                        echo "<option value=''>Seleccione una categoria</option>";
                                        while($row=mysqli_fetch_assoc($result)){
                                            echo "<option value='".$row['codigo']."'>".$row['categoria']."</option>";
                                            //var_dump($html);die();
                                        }
                                    }
                                }else{
                                    $sql="select codigo,categoria from categorias order by categoria asc";
                                    $result=mysqli_query($con, $sql);
                                    echo "<option value=''>Seleccione una categoria</option>";
                                    while($row=mysqli_fetch_assoc($result)){
                                        echo "<option value='".$row['codigo']."'>".$row['categoria']."</option>";
                                        //var_dump($html);die();
                                    }
                                }
                              
                            }
                         ?>
                           
                        </select>
                    </div>
                  
                    <center><h3>Modelo</h3></center>
                    <div class="container-menu">
                        <select name="modelo" id="modelo">
                                
                            <?php
                                if(isset($_GET['modelo'])){
                                    echo "<option value='".$_GET['modelo']."'>".$_GET['modelo']."</option>";
                                }
                            ?>
                            <option value="">Seleccione un modelo</option>
                            <?php 
                                if(isset($_GET['categoria'])){
                                    $sql="select DISTINCT(modelo) from inventario where categoria='".$_GET['categoria']."' AND (
                                        (alSolePunta!='0' and alSolePunta!='not stocked') or (almacenArmada!='0' and almacenArmada!='not stocked') or
                                        (amazonUSA!='0' and amazonUSA!='not stocked') or (phGlobal!='0' and phGlobal!='not stocked') or
                                        (eventos!='0' and eventos!='not stocked') or (liverpoolMP!='0' and liverpoolMP!='not stocked') or
                                        (monteLibano!='0' and monteLibano!='not stocked') or (phCoyoacan!='0' and phCoyoacan!='not stocked') or
                                        (phDurango!='0' and phDurango!='not stocked') or (phEcommerce!='0' and phEcommerce!='not stocked') or
                                        (phGuadalajara!='0' and phGuadalajara!='not stocked') or (phInterlomas!='0' and phInterlomas!='not stocked') or
                                        (phPerisur!='0' and phPerisur!='not stocked') or (phPolanco!='0' and phPolanco!='not stocked') or
                                        (phPuebla!='0' and phPuebla!='not stocked') or (phQueretaro!='0' and phQueretaro!='not stocked') or
                                        (phSantaFe!='0' and phSantaFe!='not stocked') or (phSatelite!='0' and phSatelite!='not stocked') or
                                        (terraLuna!='0' and terraLuna!='not stocked') or (reginaRomero!='0' and reginaRomero!='not stocked'))order by modelo asc ";
                                    $result=mysqli_query($con, $sql);
                                    if (!$result){ 
                                        echo  mysqli_error($con);  
                                    }else{
                                        
                                        while($row=mysqli_fetch_assoc($result)){
                                            echo "<option value='".$row['modelo']."'>".$row['modelo']."</option>";
                                            //var_dump($html);die();
                                        }
                                    }
                                }
                            ?>
                        </select>
                    </div>
                   
                    <center><h3>Colores</h3></center>
                    <div class="container-menu">
                        <select name="color" id="color">
                                 
                        <?php
                            if(isset($_GET['color'])){
                                    echo "<option value='".$_GET['color']."'>".$_GET['color']."</option>";
                                }
                            ?>
                            <option value="">Seleccione un color</option>
                        <?php
                            
                            if(isset($_GET['modelo'])){
                                    $sql="select Distinct(color) from inventario where  modelo='".$_GET['modelo']."' and (alSolePunta!='0' and alSolePunta!='not stocked') or (almacenArmada!='0' and almacenArmada!='not stocked') or
                                    (amazonUSA!='0' and amazonUSA!='not stocked') or (phGlobal!='0' and phGlobal!='not stocked') or
                                    (eventos!='0' and eventos!='not stocked') or (liverpoolMP!='0' and liverpoolMP!='not stocked') or
                                    (monteLibano!='0' and monteLibano!='not stocked') or (phCoyoacan!='0' and phCoyoacan!='not stocked') or
                                    (phDurango!='0' and phDurango!='not stocked') or (phEcommerce!='0' and phEcommerce!='not stocked') or
                                    (phGuadalajara!='0' and phGuadalajara!='not stocked') or (phInterlomas!='0' and phInterlomas!='not stocked') or
                                    (phPerisur!='0' and phPerisur!='not stocked') or (phPolanco!='0' and phPolanco!='not stocked') or
                                    (phPuebla!='0' and phPuebla!='not stocked') or (phQueretaro!='0' and phQueretaro!='not stocked') or
                                    (phSantaFe!='0' and phSantaFe!='not stocked') or (phSatelite!='0' and phSatelite!='not stocked') or
                                    (terraLuna!='0' and terraLuna!='not stocked') or (reginaRomero!='0' and reginaRomero!='not stocked') order by color asc";
                                    $result=mysqli_query($con, $sql);
                                    if (!$result){ 
                                        echo  mysqli_error($con);
                                        
                                    }else{
                                        $row1=mysqli_fetch_assoc($result);
                                        echo "<option value='".$row1['color']."'>".$row1['color']."</option>";
                                    }
                                }
                                echo "<option value=''>Seleccione un color</option>";
                                while($row=mysqli_fetch_assoc($result)){
                                    echo "<option value='".$row['color']."'>".$row['color']."</option>";
                                    //var_dump($html);die();
                                }
                            
                         ?>

                        </select>
                    </div>
                    <center><h3>Tallas</h3></center>
                    <div class="container-menu">
                        <select name="talla" id="talla">
                        <?php
                            if(isset($_GET['talla'])){
                                    echo "<option value='".$_GET['talla']."'>".$_GET['talla']."</option>";
                                }
                            ?>
                            <option value="">Seleccione una talla</option>
                        <?php  
                        if(isset($_GET['modelo'])){
                          $sql="select Distinct(talla) from inventario where  
                              (alSolePunta!='0' and alSolePunta!='not stocked') or (almacenArmada!='0' and almacenArmada!='not stocked') or
                              (amazonUSA!='0' and amazonUSA!='not stocked') or (phGlobal!='0' and phGlobal!='not stocked') or
                              (eventos!='0' and eventos!='not stocked') or (liverpoolMP!='0' and liverpoolMP!='not stocked') or
                              (monteLibano!='0' and monteLibano!='not stocked') or (phCoyoacan!='0' and phCoyoacan!='not stocked') or
                              (phDurango!='0' and phDurango!='not stocked') or (phEcommerce!='0' and phEcommerce!='not stocked') or
                              (phGuadalajara!='0' and phGuadalajara!='not stocked') or (phInterlomas!='0' and phInterlomas!='not stocked') or
                              (phPerisur!='0' and phPerisur!='not stocked') or (phPolanco!='0' and phPolanco!='not stocked') or
                              (phPuebla!='0' and phPuebla!='not stocked') or (phQueretaro!='0' and phQueretaro!='not stocked') or
                              (phSantaFe!='0' and phSantaFe!='not stocked') or (phSatelite!='0' and phSatelite!='not stocked') or
                              (terraLuna!='0' and terraLuna!='not stocked') or (reginaRomero!='0' and reginaRomero!='not stocked') order by talla asc";
                                $result=mysqli_query($con, $sql);
                                if (!$result){ 
                                    echo  mysqli_error($con);
                                    
                                }else{
                                    $row1=mysqli_fetch_assoc($result);
                                    echo "<option value='".$row1['talla']."'>".$row1['talla']."</option>";
                                }
                        }
                        while($row=mysqli_fetch_assoc($result)){
                            echo "<option value='".$row['talla']."'>".$row['talla']."</option>";
                            //var_dump($html);die();
                        }
                                
                       ?>

                        </select>
                    </div>
                
                   
                </form>
            </div>

            <div id="posts">
                <center> <h2>Inventario</h2></center>      
                    <div class="row">
                        <div class="col-20"></div>
                        <div class="col-20">
                            <h3>Importar inventario</h3>
                        </div>
                        <div class="col-20"></div>
                        <div class="col-20">
                            <h3>Mes y año de inventario</h3>
                        </div>
                        <div class="col-20"></div>
                    </div>
                    <form action="" name="importar" method="POST" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-20"></div>
                            <div class="col-20">
                                <input type="file" name="file" data-buttonText="Seleccione el archivo" >
                            </div>
                            <div class="col-20"></div>
                            <div class="col-20"></div>
                            <div class="col-20"></div>
                            
                        </div>

                        <div class="row">
                            <div class="col-20"></div>
                            <div class="col-20">
                                
                            
                                    <!--<input type="hidden" name="importar" value="importar">-->
                                    <input class="btn" type="submit" name="importar"value="Importar">
                            </div>
                            <div class="col-20"></div>
                            <div class="col-20">
                                <Select name="cmbMes" id="cmbMes">
                                                <option value="">Mes</option>
                                                <option value="01">Enero</option>
                                                <option value="02">Febrero</option>
                                                <option value="03">Marzo</option>
                                                <option value="04">Abril</option>
                                                <option value="05">Mayo</option>
                                                <option value="06">Junio</option>
                                                <option value="07">Julio</option>
                                                <option value="08">Agosto</option>
                                                <option value="09">Septiembre</option>
                                                <option value="10">Octubre</option>
                                                <option value="11">Noviembre</option>
                                                <option value="12">Diciembre</option>
                                            </Select>
                            </div>
                            <div class="col-20">
                                <Select name="cmbAnio" id="cmbAnio">
                                                    <option>Año</option>
                                                    <?php
                                                    $query="SELECT anio FROM anios order by anio asc";
                                                    $res=mysqli_query($con,$query);
                                                    if(!$res){
                                                        echo "fallo";
                                                    }else{
                                                        while($row=mysqli_fetch_assoc($res)){
                                                        echo '<option value="'.$row['anio'].'">'.$row['anio'].'</option>';
                                                        }
                                                    }
                                                    ?>
                                </Select>
                            </div>
                        </div>
                    </form>
                    


                    <div class="row">
                        <div class="col-20"></div>
                        <div class="col-20">
                        <form action="excelInventario.php" method="get">
                        <?php
                        if(isset($sucursalChecked)){
                            foreach($sucursalChecked as $sucursal){
                                ?>
                                <input type="hidden" name ="sucursal[]" value="<?= $sucursal; ?>">                           
                            <?php }	
                        }?>

                            <input type="hidden" name="categoria" value="<?= $_GET["categoria"];?>"> 
                            <input type="hidden" name="modelo" value="<?= $_GET["modelo"]; ?>">
                            <input type="hidden" name="color" value="<?= $_GET["color"]; ?>">
                            <input type="hidden" name="talla" value="<?= $_GET["talla"]; ?>">
                            <input type="submit" class="btn fa fa-download" value="Exportar reporte a Excel">
                        </form>
                            
                        </div>
                        <div class="col-20"></div>
                        <div class="col-20">
                           <!-- <button class="btn"><i class="fa fa-search"></i> Generar Reporte</button>-->
                        </div>
                        <div class="col-20"></div>
                    </div>

                    
            
               
                <!--Cargar los post desde JS-->
                <div id="ctable" class="searchInventario">
             <?php
            if(!isset($_GET['sucursal'])){
                echo "<h3>Debe de escoger al menos una sucursal</h3>";
            }else{                 
                
                if($_GET['modelo']!=''){
                    if($_GET['color']!=''){
                        if($_GET['talla']!=''){//busqueda por modelo,color y talla    
                           
                            
                            $sucursalArray=$_GET['sucursal'];
                            foreach($sucursalArray as $sucursal1){
                                ?>
                                <table>
                                    <tr><td>Modelo</td><td>Color</td><td>Talla</td><td>Cantidad por color</td></tr>
                                <?php
                                echo "<p><h2>".$sucursal1."</h2></p>";
                                $query="SELECT ".$sucursal1." from inventario where  ";
                                $query.=" modelo='".$_GET['modelo']."' and color='".$_GET['color']."' and talla=".$_GET['talla']."";
                               
                                $res=mysqli_query($con,$query);
                                if(!$res){
                                    echo mysqli_error($con);
                                }else{
                                    if(mysqli_num_rows($res)>0){ 
                                        $contInventario=0;
                                        while($row=mysqli_fetch_assoc($res)){
                                            if($row[$sucursal1]=="not stocked"){
                                                $aux=0;
                                                $contInventario=$contInventario+$aux;
                                            }else{
                                                $contInventario=$contInventario+$row[$sucursal1];
                                                }
                                        }
                                        if($contInventario>0){
                                            echo "<tr><td>".$_GET['modelo']."</td><td>".$_GET['color']."</td><td>".$_GET['talla']."</td><td>".$contInventario."</td></tr>";
                                        }
                                        
                                    }
                                }
                            }
                        }else{                      //busqueda por modelo y color
                            $sucursalArray=$_GET['sucursal'];
                            foreach($sucursalArray as $sucursal1){
                                ?>
                                <table>
                                    <tr><td>Modelo</td><td>Color</td><td>Talla</td><td>Cantidad por color</td></tr>
                                <?php
                                echo "<p><h2>".$sucursal1."</h2></p>";
                                $modelo1 = $_GET['modelo'];
                                
                                $sql1 = "select distinct(talla)from inventario where modelo='".$_GET['modelo']."' and ".$sucursal1."!='0' and ".$sucursal1."!='not stocked' order by talla asc";
                                $resTalla=mysqli_query($con,$sql1);
                                if(!$resTalla){
                                    echo mysqli_error($con);
                                }else{
                                    $contModelo=0;
                                    while($rowTalla=mysqli_fetch_assoc($resTalla)){
                                        if(!$resTalla){
                                            echo mysqli_error($con);
                                        }else{
                                            $query="SELECT ".$sucursal1." from inventario where  ";
                                            $query.=" modelo='".$_GET['modelo']."' and color='".$_GET['color']."' and talla=".$rowTalla['talla']."";
                                           
                                            $res=mysqli_query($con,$query);
                                            if(!$res){
                                                echo mysqli_error($con);
                                            }else{
                                                if(mysqli_num_rows($res)>0){ 
                                                    $contInventario=0;
                                                    while($row=mysqli_fetch_assoc($res)){
                                                        if($row[$sucursal1]=="not stocked"){
                                                            $aux=0;
                                                            $contInventario=$contInventario+$aux;
                                                        }else{
                                                            $contInventario=$contInventario+$row[$sucursal1];
                                                            }
                                                    }
                                                    if($contInventario>0){
                                                        echo "<tr><td>".$_GET['modelo']."</td><td>".$_GET['color']."</td><td>".$rowTalla['talla']."</td><td>".$contInventario."</td></tr>";
                                                    }
                                                    $contModelo=$contModelo+$contInventario;
                                                }
                                            }
                                        }
                                    }
                                }
                                echo "<tr><td>Total de unidades por color <td><td><td>".$contModelo."</td></tr></table>";
                                echo "</table>";
                            }
                        }
                    }else{
                        if($_GET['talla']!=''){ //Busqueda por modelo y talla       
                            $sucursalArray=$_GET['sucursal'];
                            foreach($sucursalArray as $sucursal1){
                                ?>
                                <table>
                                    <tr><td>Modelo</td><td>Color</td><td>Talla</td><td>Cantidad por talla</td></tr>
                                <?php
                                echo "<p><h2>".$sucursal1."</h2></p>";
                                $modelo1 = $_GET['modelo'];
                                $talla =    $_GET['talla'];
                                $sql1 = "select distinct(color)from inventario where modelo='".$_GET['modelo']."' and ".$sucursal1."!='0' and ".$sucursal1."!='not stocked' order by color asc";
                                $resColor=mysqli_query($con,$sql1);
                                if(!$resColor){
                                    echo mysqli_error($con);
                                }else{
                                    $contModelo=0;
                                    while($rowColor=mysqli_fetch_assoc($resColor)){
                                            $query="SELECT ".$sucursal1." from inventario where  ";
                                            $query.=" modelo='".$_GET['modelo']."' and talla='".$_GET['talla']."' and color='".$rowColor['color']."' ";
                                            
                                            $res=mysqli_query($con,$query);
                                            if(!$res){
                                                echo mysqli_error($con);
                                            }else{
                                                if(mysqli_num_rows($res)>0){ 
                                                    $contInventario=0;
                                                    while($row=mysqli_fetch_assoc($res)){
                                                        if($row[$sucursal1]=="not stocked"){
                                                            $aux=0;
                                                            $contInventario=$contInventario+$aux;
                                                        }else{
                                                            $contInventario=$contInventario+$row[$sucursal1];
                                                            }
                                                    }
                                                    if($contInventario>0){
                                                        echo "<tr><td>".$_GET['modelo']."</td><td>".$rowColor['color']."</td><td>".$_GET['talla']."</td><td>".$contInventario."</td></tr>";
                                                    }
                                                    $contModelo=$contModelo+$contInventario;
                                                }
                                            }
                                        
                                    }
                                }
                                echo "<tr><td>Total de unidades por modelo<td><td><td>".$contModelo."</td></tr></table>";
                                echo "</table>";
                            }
                        }else{          //Busqueda por modelo

                            $sucursalArray=$_GET['sucursal'];
                            foreach($sucursalArray as $sucursal1){
                                ?>
                                <table>
                                    <tr><td>Modelo</td><td>Color</td><td>Talla</td><td>Cantidad por modelo</td></tr>
                                <?php
                                $modelo1 = $_GET['modelo'];
                                echo "<p><h2>".$sucursal1."</h2></p>";
                                $contModelo=0;
                                $contColores=0;
                                $contTalla=0;
                                $sql1 = "select distinct(color) from inventario where modelo='".$_GET['modelo']."'  order by color asc";
                               
                                $resColor=mysqli_query($con,$sql1);
                                if(!$resColor){
                                    echo mysqli_error($con);
                                }else{
                                    $contModelo=0;
                                    while($rowColor=mysqli_fetch_assoc($resColor)){
                                        $sql2 = "select distinct(talla) from inventario where modelo='".$_GET['modelo']."'  order by talla asc";                                
                                        $resTalla=mysqli_query($con,$sql2);
                                        if(!$resTalla){
                                            echo mysqli_error($con);
                                        }else{
                                            while($rowTalla=mysqli_fetch_assoc($resTalla)){
                                                $query="SELECT ".$sucursal1." from inventario where  ";
                                                $query.=" modelo='".$_GET['modelo']."' and talla='".$rowTalla['talla']."' and color='".$rowColor['color']."' ";
                                                
                                                $res=mysqli_query($con,$query);
                                                if(!$res){
                                                    echo mysqli_error($con);
                                                }else{
                                                    if(mysqli_num_rows($res)>0){ 
                                                        $contInventario=0;
                                                        while($row=mysqli_fetch_assoc($res)){
                                                            if($row[$sucursal1]=="not stocked"){
                                                                $aux=0;
                                                                $contInventario=$contInventario+$aux;
                                                            }else{
                                                                $contInventario=$contInventario+$row[$sucursal1];
                                                                }
                                                        }
                                                        if($contInventario>0){
                                                            echo "<tr><td>".$_GET['modelo']."</td><td>".$rowColor['color']."</td><td>".$rowTalla['talla']."</td><td>".$contInventario."</td></tr>";
                                                        }
                                                        
                                                        $contModelo=$contModelo+$contInventario;
                                                    }
                                                }
                                                
                                            }     
                                        }
                                    }
                                    echo "<tr><td>Total de unidades del modelo<td><td><td>".$contModelo."</td></tr></table>";
                                
                                }
                                ?></td>
                                </tr></table>
                                <?php   
                            }
                        }
                    }
                }else{
                    if($_GET['categoria']!=''){
                        $sucursales=$_GET['sucursal'];
                        foreach($sucursales as $sucursal1){
                            ?>
                            <table>
                                <tr><td>Modelo</td><td>Cantidad</td></tr>
                            <?php
                            echo "<p><h2>".$sucursal1."</h2></p>";
                            ?>
                            <?php
                                 $sql="select distinct(modelo) from inventario order by modelo asc";

                                 $res=mysqli_query($con,$sql);
                                if(!$res){
                                     echo mysqli_error($con);
                              }else{
                                    $contTotalCat=0;
                                    while($row1=mysqli_fetch_assoc($res)){
                                        if(($row1['modelo']!='')){
                                            if($sucursal1=="phGeneral"){
                                                $query="SELECT phGlobal,phCoyoacan,phDurango,phEcommerce,phGuadalajara,
                                                phInterlomas,phPerisur,phPolanco,phPuebla,phQueretaro,phSantaFe,
                                                phSatelite from inventario where  ";
                                                $query.="modelo='".$row1['modelo']."' and categoria='".$_GET['categoria']."'";
                                                $res2=mysqli_query($con,$query);
                                                if(!$res2){
                                                    echo mysqli_error($con);
                                                }else{
                                                    if(mysqli_num_rows($res2)>0){
                                                        $contInventario=0;
                                                        while($row=mysqli_fetch_assoc($res2)){
                                                                if($row['phGlobal']=='not stocked' || $row['phCoyoacan']=='not stocked' || $row['phDurango']=='not stocked' || $row['phEcommerce']
                                                                =='not stocked' || $row['phGuadalajara']=='not stocked' || $row['phInterlomas']=='not stocked' || $row['']=='not stocked' || 
                                                                $row['phPerisur']=='not stocked' || $row['phPolanco']=='not stocked' || $row['phPuebla']=='not stocked' || $row['phPuebla']
                                                                =='not stocked' || $row['phQueretaro']=='not stocked' || $row['phGSantaFe']=='not stocked' || $row['phSatelite']=='not stocked'){
                                                                    $aux=0;
                                                                    $contInventario=$contInventario+$aux;
                                                                }else{
                                                                    $contInventario=$contInventario+$row['phGlobal']+$row['phCoyoacan']+$row['phDurango']+$row['phEcommerce']
                                                                    +$row['phGuadalajara']+$row['phInterlomas']+$row['']+$row['phPerisur']+$row['phPolanco']+$row['phPuebla']
                                                                    +$row['phPuebla']+$row['phQueretaro']+$row['phGSantaFe']+$row['phSatelite'];
                                                                }
                                                        }
                                                        if($contInventario>0){
                                                            ?>
                                                            <tr><td><?php echo $row1['modelo'];?></td><td><?php echo $contInventario;?></td></tr><?php
                                                            $contTotalCat=$contTotalCat+$contInventario;
                                                        }
                                                    }
                                                }
                                            }else{
                                                $query="select ".$sucursal1." from inventario where ";
                                                $query.="modelo='".$row1['modelo']."' and categoria='".$_GET['categoria']."'";
                                                $res2=mysqli_query($con,$query);
                                                if(!$res2){
                                                    echo mysqli_error($con);
                                                }else{
                                                    $contInventario=0;
                                                    while($row=mysqli_fetch_assoc($res2)){
                                                            if($row[$sucursal1]=="not stocked"){
                                                                $aux=0;
                                                                $contInventario=$contInventario+$aux;
                                                            }else{
                                                                $contInventario=$contInventario+$row[$sucursal1];
                                                            }
                                                    }
                                                    if($contInventario>0){
                                                        ?>
                                                        <tr><td><?php echo $row1['modelo'];?></td><td><?php echo $contInventario;?></td><?php
                                                        $contTotalCat=$contTotalCat+$contInventario;
                                                        
                                                    }
                                                }
                                            }
                                        }    
                                        
                                    }
                                    ?><tr><td>Cantidad total de los Accesorios</td><td><?php echo $contTotalCat; ?></td> <?php
                                }
                        }

                    }else{                          //Busqueda por sucursal
                        $sucursales=$_GET['sucursal'];
                        foreach($sucursales as $sucursal1){
                            ?>
                            <table>
                                <tr><td>Categoria</td><td>Cantidad</td></tr>
                            <?php
                            echo "<p><h2>".$sucursal1."</h2></p>";
                            ?>
                            <?php
                                 $sql="select distinct(categoria) from inventario order by categoria asc";
                                 $res=mysqli_query($con,$sql);
                                if(!$res){
                                     echo mysqli_error($con);
                                }else{
                                     $contTotalCat=0;
                                     while($row1=mysqli_fetch_assoc($res)){
                                        
                                        $sql1="select categoria from categorias where codigo='".$row1['categoria']."' ";
                                        $res1=mysqli_query($con,$sql1);
                                        if(!$res1){
                                            echo mysqli_error($con);
                                        }
                                        $row2=mysqli_fetch_assoc($res1);
                                       
                                        if(($row1['categoria']!='') && $row2['categoria']!=''){

                                                if($sucursal1=="phGeneral"){
                                                    $query="SELECT phGlobal,phCoyoacan,phDurango,phEcommerce,phGuadalajara,
                                                    phInterlomas,phPerisur,phPolanco,phPuebla,phQueretaro,phSantaFe,
                                                    phSatelite from inventario where  ";
                                                    $query.="categoria='".$row1['categoria']."' ";
                                                    $res2=mysqli_query($con,$query);
                                                    if(!$res2){
                                                        echo mysqli_error($con);
                                                    }else{
                                                        $contInventario=0;
                                                        while($row=mysqli_fetch_assoc($res2)){
                                                                if($row['phGlobal']=='not stocked' || $row['phCoyoacan']=='not stocked' || $row['phDurango']=='not stocked' || $row['phEcommerce']
                                                                =='not stocked' || $row['phGuadalajara']=='not stocked' || $row['phInterlomas']=='not stocked' || $row['']=='not stocked' || 
                                                                $row['phPerisur']=='not stocked' || $row['phPolanco']=='not stocked' || $row['phPuebla']=='not stocked' || $row['phPuebla']
                                                                =='not stocked' || $row['phQueretaro']=='not stocked' || $row['phGSantaFe']=='not stocked' || $row['phSatelite']=='not stocked' ){
                                                                    $aux=0;
                                                                    $contInventario=$contInventario+$aux;
                                                                }else{
                                                                    $contInventario=$contInventario+$row['phGlobal']+$row['phCoyoacan']+$row['phDurango']+$row['phEcommerce']
                                                                    +$row['phGuadalajara']+$row['phInterlomas']+$row['']+$row['phPerisur']+$row['phPolanco']+$row['phPuebla']
                                                                    +$row['phPuebla']+$row['phQueretaro']+$row['phGSantaFe']+$row['phSatelite'];
                                                                }
                                                        }
                                                        if($contInventario>0){
                                                            ?>
                                                            <tr><td><?php echo $row2['categoria'];?></td><td><?php echo $contInventario;?></td><?php
                                                            $contTotalCat=$contTotalCat+$contInventario;
                                                            echo $contInventario;
                                                        }
                                                    }
                                                }else{
                                                    $query="SELECT ".$sucursal1." from inventario where  ";
                                                    $query.="categoria='".$row1['categoria']."' ";
                                                    $res2=mysqli_query($con,$query);
                                                    if(!$res2){
                                                        echo mysqli_error($con);
                                                    }else{
                                                        if(mysqli_num_rows($res2)>0){
                                                            $contInventario=0;
                                                            while($row=mysqli_fetch_assoc($res2)){
                                                                    if($row[$sucursal1]=="not stocked"){
                                                                        $aux=0;
                                                                        $contInventario=$contInventario+$aux;
                                                                    }else{
                                                                        $contInventario=$contInventario+$row[$sucursal1];
                                                                    }
                                                            }
                                                            if($contInventario>0){
                                                                ?>
                                                                <tr><td><?php echo $row2['categoria'];?></td><td><?php echo $contInventario;?></td><?php
                                                                $contTotalCat=$contTotalCat+$contInventario;
                                                            }
                                                        }else{
                                                            echo "NO se encontraron resultados";
                                                        }                                         
                                                    }
                                                }
                                            ?>
                                            </td></tr>
                                            <?php
                                        }    
                                        
                                    }
                                    ?><tr><td>Cantidad total de los Accesorios</td><td><?php echo $contTotalCat; ?></td> <?php
                                }
                        }

                    }
                }
            }
             //ODIGO PARA IMPORTAR ARCHIVOS
             if(isset($_POST['importar'])){
                $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values',
                  'application/octet-stream', 'application/vnd.ms-excel', 
                 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 
                 'application/vnd.msexcel', 'text/plain');
                   if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$file_mimes)){
                       if(is_uploaded_file($_FILES['file']['tmp_name'])){   
                           $csv_file = fopen($_FILES['file']['tmp_name'], 'r');           
                           fgetcsv($csv_file);            
                           // get data records from csv file
                                $query="Select MAX(id_inventario) as id from inventario ";
                               $res=mysqli_query($con,$query);
                               $id=0;
                               if(!$res){
                                   echo "No se importo bien los datos";
                                   //echo mysqli_erno();
                               }else{
                                   $row=mysqli_fetch_assoc($res);
                                   if($row['id']==''){
                                       $id=1;
                                   }else{ 
                                       $id=$row['id'];
                                       $id=$id+1;
                                   }
                               }  


                           while(($columna = fgetcsv($csv_file)) !== FALSE){
                               // Check if employee already exists with same email
                             
                                   $modelo=[];
                                   $modelo= explode("-",$columna[1]);
                                   $categoria=substr($columna[8],0,1);
           
                                   $sql = "INSERT INTO inventario (handle,title,categoria,modelo,color,talla,
                                       sku,alSolePunta,almacenArmada,amazonUSA,
                                       phGlobal,eventos,liverpoolMP,monteLibano,
                                       phCoyoacan,phDurango,phEcommerce,phGuadalajara,
                                       phInterlomas,phPerisur,phPolanco,phPuebla,
                                       phQueretaro,phSantaFe,phSatelite,terraLuna,
                                       reginaRomero,mes,anio,id_inventario)VALUES
                                   ('".$columna[0]."', '".$columna[1]."','".$categoria."','".strtoupper($modelo[0])."','".strtoupper($columna[3])."', '".$columna[5]."'
                                   ,'".$columna[8]."','".$columna[11]."', '".$columna[12]."','".$columna[13]."'
                                   ,'".$columna[14]."','".$columna[15]."', '".$columna[16]."','".$columna[17]."' 
                                   ,'".$columna[18]."','".$columna[19]."','".$columna[20]."','".$columna[21]."' 
                                  ,'".$columna[22]."','".$columna[23]."', '".$columna[24]."', '".$columna[25]."'
                                  ,'".$columna[26]."','".$columna[27]."', '".$columna[28]."', '".$columna[29]."'
                                  ,'".$columna[30]."','".date("n")."','".date("Y")."','".$id."')";
                                   $result=mysqli_query($con, $sql);
                                   if (!$result){ 
                                       echo  mysqli_error($con);
                                       
                                   }
                               
                           }            
                           fclose($csv_file);
                           $import_status = '?import_status=success';
                       }else{
                           $imprt_status = '?import_status=error';
           
                       }
                   }else{
           
                   }
               }



            ?>
                </div>

            </div>
           
            <div class="clearfix"></div>
        </section>
    </section>
   
</body>
 <!--Jquery-->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>     
<!--Bootstrap-->
<!--Scripts-->
<!--Codigo en JavaScipt-->
<script type="text/javascript" src="js/main.js">
</script>

</html>
