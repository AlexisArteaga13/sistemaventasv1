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
require_once "../modelos/Subcategoria.php";
require_once "../modelos/Categoria.php";
$Subcategoria=new Subcategoria();

$idSubcategoria=isset($_POST["idSubcategoria"])? limpiarCadena($_POST["idSubcategoria"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$idcategoria=isset($_POST["idcategoriadelsub"])? limpiarCadena($_POST["idcategoriadelsub"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idSubcategoria)){
			$rspta=$Subcategoria->insertar($nombre,$descripcion,$idcategoria);
			echo $rspta ? "Sub Categoría registrada" : "Sub Categoría no se pudo registrar";
		}
		else {
			$rspta=$Subcategoria->editar($idSubcategoria,$nombre,$descripcion,$idcategoria);
			echo $rspta ? "Sub Categoría actualizada" : "Sub Categoría no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$Subcategoria->desactivar($idSubcategoria);
 		echo $rspta ? "Categoría Desactivada" : "Categoría no se puede desactivar";
	break;

	case 'activar':
		$rspta=$Subcategoria->activar($idSubcategoria);
 		echo $rspta ? "Categoría activada" : "Categoría no se puede activar";
	break;

	case 'mostrar':
		$rspta=$Subcategoria->mostrar($idSubcategoria);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
    break;
    case 'mostrarcate':
		$rspta=$Subcategoria->mostrar($idSubcategoria);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
    break;
    
    case "selectCategoria":
      
		//require_once "../modelos/Categoria.php";
		$categoria = new Categoria();
     
		$rspta = $categoria->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idcategoria . '>' . $reg->nombre . '</option>';
				}
    break;
    

	case 'listar':
		$rspta=$Subcategoria->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion_subcat)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idsub_categoria.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idsub_categoria.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idsub_categoria.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idsub_categoria.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre_subcat,
                 "2"=>$reg->descripcion_subcat,
                 "3"=>$reg->categoria,
 				"4"=>($reg->condicion_subcat)?'<span class="label bg-green">Activado</span>':
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