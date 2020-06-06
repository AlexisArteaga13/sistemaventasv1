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
if ($_SESSION['almacen']==1)
{
require_once "../modelos/Sucursal.php";
require_once "../modelos/Usuario.php";
$sucursal=new Sucursal();

$idsucursal=isset($_POST["idsucursal"])? limpiarCadena($_POST["idsucursal"]):"";
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$nombresucursal=isset($_POST["nombresucursal"])? limpiarCadena($_POST["nombresucursal"]):"";
$nombreencargado=isset($_POST["nombreencargado"])? limpiarCadena($_POST["nombreencargado"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$correo=isset($_POST["correo"])? limpiarCadena($_POST["correo"]):"";
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idsucursal)){
			$rspta=$sucursal->insertar($codigo,$nombresucursal,$nombreencargado,$direccion,$telefono,$correo);
			echo $rspta ? "Sucursal registrada" : "Sucursal no se pudo registrar";
		}
		else {
			$rspta=$sucursal->editar($idsucursal,$codigo,$nombresucursal,$nombreencargado,$direccion,$telefono,$correo);
			echo $rspta ? "Sucursal actualizada" : "Sucursal no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$sucursal->desactivar($idsucursal);
 		echo $rspta ? "Sucursal Desactivada" : "Sucursal no se puede desactivar";
	break;

	case 'activar':
		$rspta=$sucursal->activar($idsucursal);
 		echo $rspta ? "Sucursal activada" : "Sucursal no se puede activar";
	break;

	case "selectAdministrador":
      
		
		$usuario = new Usuario();
     
		$rspta = $usuario->listaradmin();
		echo '<option value="" disabled="true" selected>Selecciona</option>';
		while ($reg = $rspta -> fetch_object())
				{
					echo '<option value=' . $reg->idusuario . '>' . $reg->nombre . '</option>';
				}
    break;

	case 'mostrar':
		$rspta=$sucursal->mostrar($idsucursal);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
	case 'sesionarsucursal':
		$rspta=$sucursal->mostrar($idsucursal);
		 //Codificar el resultado utilizando json
		 $cambiar=json_encode($rspta);
		
 		echo json_decode($cambiar);
	break;
	case 'listar':
		$rspta=$sucursal->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_sucursal.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->id_sucursal.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->id_sucursal.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->id_sucursal.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->codsucursal,
                 "2"=>$reg->nombresucursal,
                 "3"=>$reg->nombre_encargado,
                 "4"=>$reg->direccion,
                 "5"=>$reg->telefono,
                 "6"=>$reg->email,
 				"7"=>($reg->estado)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'listarsucursalesporusuario':
		$rspta=$sucursal->listarsucursalporusuario($_SESSION["idusuario"]);
		 //Vamos a declarar un array
		// echo $_SESSION["idusuario"];
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_sucursal.')"><i class="fa fa-pencil"></i>ADMINISTRAR</button>':
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->id_sucursal.')"><i class="fa fa-close"></i></button>',
 					/*'<button class="btn btn-warning" onclick="mostrar('.$reg->id_sucursal.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->id_sucursal.')"><i class="fa fa-check"></i></button>',*/
 				"1"=>$reg->codsucursal,
                 "2"=>$reg->nombresucursal,
                 "3"=>$reg->nombre_encargado,
                 "4"=>$reg->direccion,
                 "5"=>$reg->telefono,
                 "6"=>$reg->email,
 				"7"=>($reg->estado)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

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