<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION["nombre"]))
{
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
}
else
{
if ($_SESSION['almacen']==1)
{

//Inlcuímos a la clase PDF_MC_Table
require('PDF_MC_Table.php');
 
//Instanciamos la clase para generar el documento pdf
//$pdf=new PDF_MC_Table();
$pdf=new PDF_MC_Table('L','mm','letter');
//Agregamos la primera página al documento pdf
$pdf->AddPage();
 
//Seteamos el inicio del margen superior en 25 pixeles 
$y_axis_initial = 25;
 
//Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
$pdf->SetFont('Arial','B',12);

$pdf->Cell(40,6,'',0,0,'C');
$pdf->Cell(100,6,'LISTA DE SUCURSALES',1,0,'C'); 
$pdf->Ln(10);
 
//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(232,232,232); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20,6,utf8_decode('Código'),1,0,'C',1); 
$pdf->Cell(30,6,utf8_decode('Nombre'),1,0,'C',1);
$pdf->Cell(60,6,'Nombre del encargado',1,0,'C',1); 
$pdf->Cell(20,6,utf8_decode('Teléfono'),1,0,'C',1);
$pdf->Cell(60,6,utf8_decode('Dirección'),1,0,'C',1); 
$pdf->Cell(50,6,utf8_decode('Correo'),1,0,'C',1);
$pdf->Ln(10);
//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../modelos/Sucursal.php";
$sucursal= new Sucursal();

$rspta = $sucursal->listar();

//Table with filas y columnas
$pdf->SetWidths(array(20,30,60,20,60,50));

while($reg= $rspta->fetch_object())
{  
    $codigosucursal= $reg->codsucursal;
    $nombre = $reg->nombresucursal;
    $encargado = $reg->nombre_encargado;
    $direccion=$reg->direccion;
    $telefono = $reg->telefono;
    $email = $reg->email;
 	$pdf->SetFont('Arial','',10);
    $pdf->Row(array(utf8_decode($codigosucursal),utf8_decode($nombre),utf8_decode($encargado),utf8_decode($telefono),utf8_decode($direccion),utf8_decode($email)));
}
 
//Mostramos el documento pdf
$pdf->Output();

?>
<?php
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>