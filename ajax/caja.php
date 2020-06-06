<?php 
ob_start();
if (strlen(session_id()) < 1){
	session_start();//Validamos si existe o no la sesión
}
if (!isset($_SESSION["nombre"]))
{
  header("Location: ../vistas/login.html");//Validamos el acceso solo a los usuarios logueados al sistema.
}
else
{
//Validamos el acceso solo al usuario logueado y autorizado.
if ($_SESSION['almacen']==1 || $_SESSION["compras"]==1  || $_SESSION["ventas"]==1)
{	
require_once "../modelos/Usuario.php";
require_once "../modelos/Caja.php";
require_once "../modelos/Sucursal.php";
$caja=new Caja();
$sucursal = new Sucursal();
$usuario = new Usuario();

$idcaja=isset($_POST["idcaja"])? limpiarCadena($_POST["idcaja"]):"";
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$idsucursal=isset($_POST["idsucursal"])? limpiarCadena($_POST["idsucursal"]):"";
$cajero=isset($_POST["idcajero"])? limpiarCadena($_POST["idcajero"]):"";
$tipodocumento=isset($_POST["tipodocumento"])? limpiarCadena($_POST["tipodocumento"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':

		if (empty($idcaja)){
			$rspta=$caja->insertar($codigo,$idsucursal,$cajero);
			echo $rspta ? "Caja registrada" : "Caja no se pudo registrar";
		}
		else {
			$rspta=$caja->editar($idcaja,$codigo,$idsucursal,$cajero);
			echo $rspta ? "Caja actualizada" : "Caja no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$caja->desactivar($idcaja);
 		echo $rspta ? "Caja cerrada." : "Caja no se puede cerrar.";
	break;

	case 'activar':
		// CODIGO QUE HACE QUE SOLO UN CAJERO ACTIVE UNA SOLA CAJA POR SUCURSAL ASIGNADA
		if($_SESSION["cargo"]==3){
			$contador=$caja->contarcajaporsucursal();
			$rptacontador= implode($contador);
		if($rptacontador == "1"){
			$rspta=$caja->activar($idcaja);
		}
		else{
			$rspta=false;
		}
		}
		else{
			$rspta=$caja->activar($idcaja);
		}
		
 		echo $rspta ? "Caja Aperturada" : "Caja no se puede aperturar.";
	break;

	case 'mostrarcajero':
		$rspta=$usuario->selectanidado($idsucursal);
		//echo $idcategoria;
		echo '<option disabled="true" value="" selected>Selecciona</option>';
		while ($reg = $rspta->fetch_object())
				{
					//echo implode($reg);

					echo '<option value=' . $reg->idusuario . '>' . $reg->nombre. '</option>';
				}
		//echo json_encode($rspta);
	break;

	case 'mostrar':
		$rspta=$caja->mostrar($idcaja);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
	case 'mostrardocumento':
		$rspta=$caja->mostrardocumentodecaja($idcaja,$tipodocumento);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
	

	case 'listar':
		if($_SESSION["idsucursal"] == ""){
		$rspta=$caja->listar();
 		//Vamos a declarar un array
 		$data= Array();
		echo implode($data);
 		while ($reg = $rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idcaja.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idcaja.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idcaja.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idcaja.')"><i class="fa fa-check"></i></button>',
				 "1"=>$reg->codcaja,
				 "2"=>$reg->sucursal,
 				"3"=>$reg->cajero,
 				"4"=>($reg->estado)?'<span class="label bg-green">Aperturada</span>':
 				'<span class="label bg-red">Cerrada</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	}
	if($_SESSION["idsucursal"] != "" && $_SESSION['cargo'] !=3){
		$rspta=$caja->listarcajasporsucursal();
 		//Vamos a declarar un array
 		$data= Array();
		echo implode($data);
 		while ($reg = $rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idcaja.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idcaja.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idcaja.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idcaja.')"><i class="fa fa-check"></i></button>',
				 "1"=>$reg->codcaja,
				 "2"=>$reg->sucursal,
 				"3"=>$reg->cajero,
 				"4"=>($reg->estado)?'<span class="label bg-green">Aperturada</span>':
 				'<span class="label bg-red">Cerrada</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	}
	if($_SESSION["idsucursal"] != "" && $_SESSION['cargo'] ==3){
		$rspta=$caja->listarcajasporsucursalcajero();
 		//Vamos a declarar un array
 		$data= Array();
		echo implode($data);
 		while ($reg = $rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'
 					<button class="btn btn-danger" onclick="desactivar('.$reg->idcaja.')"><i class="fa fa-close"></i></button>':
 					
 					' <button class="btn btn-primary" onclick="activar('.$reg->idcaja.')"><i class="fa fa-check"></i></button>',
				 "1"=>$reg->codcaja,
				 "2"=>$reg->sucursal,
 				"3"=>$reg->cajero,
 				"4"=>($reg->estado)?'<span class="label bg-green">Aperturada</span>':
 				'<span class="label bg-red">Cerrada</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	}
	break;

	case "selectSucursal":
		//require_once "../modelos/Categoria.php";
	//	$sucursal = new Categoria();

		$rspta = $sucursal->select();
		echo '<option disabled="true" value="" selected>Selecciona</option>';
		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->id_sucursal . '>' . $reg->nombresucursal . '</option>';
				}
    break;
    

}
//Fin de las validaciones de acceso
}
else
{
  require 'noacceso.php';
}
}
ob_end_flush();
?>