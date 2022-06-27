<?php

require __DIR__ . '/ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
/*-------------------------
Autor: Obed Alvarado
Web: obedalvarado.pw
Mail: info@obedalvarado.pw
---------------------------*/
session_start();
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
	header("location: ../login.php");
	exit;
}


/* Connect To Database*/
include("../config/db.php");
include("../config/conexion.php");
//Archivo de funciones PHP
include("../funciones.php");
$session_id= session_id();
// Variables por GET
$id_factura= $_GET['id_factura'];
$id_cliente= $_GET['nome_cliente'];
$id_vendedor= $_GET['nome_vendedor'];
$condiciones=mysqli_real_escape_string($con,(strip_tags($_REQUEST['condiciones'], ENT_QUOTES)));


$sql_user=mysqli_query($con,"select * from users where user_id='$id_vendedor'");
$rw_user=mysqli_fetch_array($sql_user);
echo $rw_user['firstname']." ".$rw_user['lastname'];

/*
	Este ejemplo imprime un
	ticket de venta desde una impresora térmica
*/


/*
    Aquí, en lugar de "POS" (que es el nombre de mi impresora)
	escribe el nombre de la tuya. Recuerda que debes compartirla
	desde el panel de control
*/

$nombre_impresora = "imp1"; 


$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);
#Mando un numero de respuesta para saber que se conecto correctamente.
// echo 1;
/*
	Vamos a imprimir un logotipo
	opcional. Recuerda que esto
	no funcionará en todas las
	impresoras

	Pequeña nota: Es recomendable que la imagen no sea
	transparente (aunque sea png hay que quitar el canal alfa)
	y que tenga una resolución baja. En mi caso
	la imagen que uso es de 250 x 250
*/

# Vamos a alinear al centro lo próximo que imprimamos
$printer->setJustification(Printer::JUSTIFY_CENTER);

/*
	Intentaremos cargar e imprimir
	el logo
*/
try{
	$logo = EscposImage::load("geek.png", false);
    $printer->bitImage($logo);
}catch(Exception $e){/*No hacemos nada si hay error*/}

/*
	Ahora vamos a imprimir un encabezado
*/

$printer->text("\n". get_row('perfil','nombre_empresa', 'id_perfil', 1) . "\n");
$printer->text( get_row('perfil','direccion', 'id_perfil', 1) . "\n");
$printer->text( get_row('perfil','estado', 'id_perfil', 1) . "\n");
$printer->text( get_row('perfil','email', 'id_perfil', 1) . "\n");
$printer->text( get_row('perfil','telefono', 'id_perfil', 1) . "\n");
#La fecha también
date_default_timezone_set("Africa/Luanda");
$printer->text(date("m-d-Y H:i") . "\n");
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("---------------------------------"."\n");

// cliente e vendedor
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("Cliente: ". $id_cliente ."\n");
$printer->text("Vendedor: ". $id_vendedor ."\n");

$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("---------------------------------" . "\n");
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("QUANT   DESCRICAO    P.U    IMP.\n");
$printer->text("---------------------------------"."\n");
/*
	Ahora vamos a imprimir los
	productos
*/
	/*Alinear a la izquierda para la cantidad y el nombre*/
	$printer->setJustification(Printer::JUSTIFY_LEFT);
	$nums=1;
	$sumador_total=0;
	$sql=mysqli_query($con, "select * from products, detalle_factura, facturas where products.id_producto=detalle_factura.id_producto and detalle_factura.numero_factura=facturas.numero_factura and facturas.id_factura='".$id_factura."'");

		while ($row=mysqli_fetch_array($sql)){
			$id_producto=$row["id_producto"];
			$codigo_producto=$row['codigo_producto'];
			$cantidad=$row['cantidad'];
			$nombre_producto=$row['nombre_producto'];
			
			$precio_venta=$row['precio_venta'];
			$precio_venta_f=number_format($precio_venta,2);//Formateo variables
			$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
			$precio_total=$precio_venta_r*$cantidad;
			$precio_total_f=number_format($precio_total,2);//Precio total formateado
			$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
			$sumador_total+=$precio_total_r;//Sumador
			if ($nums%2==0){
				$clase="clouds";
			} else {
				$clase="silver";
			}
			
			//Insert en la tabla detalle_cotizacion
			$nums++;

			// var_dump($row);

			// $printer->text("Producto Galletas\n");
			$printer->text("$cantidad      ". "$nombre_producto     ".  "$precio_venta_f    "  ."$precio_total_f"   ."\n");
			echo "<br>";
			// $printer->text("Sabrtitas \n");
			// $printer->text( "3  pieza    10.00 30.00   \n");
			// $printer->text("Doritos \n");
			// $printer->text( "5  pieza    10.00 50.00   \n");
		}

			$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
			$subtotal=number_format($sumador_total,2,'.','');
			$total_iva=($subtotal * $impuesto )/100;
			$total_iva=number_format($total_iva,2,'.','');
			$total_factura=$subtotal+$total_iva;

/*
	Terminamos de imprimir
	los productos, ahora va el total
*/
$printer->text("-----------------------------"."\n");
$printer->setJustification(Printer::JUSTIFY_RIGHT);
$printer->text("SUBTOTAL: $subtotal\n");
$printer->text("IVA: $total_iva\n");
$printer->text("TOTAL: $total_factura\n");

// var_dump($subtotal, $total_iva, $total_factura);


/*
	Podemos poner también un pie de página
*/
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("Muito obrigado pela sua compra compra\n");



/*Alimentamos el papel 3 veces*/
$printer->feed(3);

/*
	Cortamos el papel. Si nuestra impresora
	no tiene soporte para ello, no generará
	ningún error
*/
$printer->cut();

/*
	Por medio de la impresora mandamos un pulso.
	Esto es útil cuando la tenemos conectada
	por ejemplo a un cajón
*/
$printer->pulse();

/*
	Para imprimir realmente, tenemos que "cerrar"
	la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
*/
$printer->close();

?>