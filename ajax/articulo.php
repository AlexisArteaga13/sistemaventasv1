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
require_once "../modelos/Articulo.php";
require_once "../modelos/Subcategoria.php";
$articulo=new Articulo();
$subcategoria = new Subcategoria();

$idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
$idsubcategoria=isset($_POST["idsubcategoria"])? limpiarCadena($_POST["idsubcategoria"]):"";
$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
$stock=isset($_POST["stock"])? limpiarCadena($_POST["stock"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
$unidad=isset($_POST["idunidad"])? limpiarCadena($_POST["idunidad"]):"";
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/articulos/" . $imagen);
			}
		}
		if (empty($idarticulo)){
			$rspta=$articulo->insertar($idsubcategoria,$codigo,$nombre,$stock,$impuesto,$descripcion,$imagen,$unidad);
			echo $rspta ? "Artículo registrado" : "Artículo no se pudo registrar";
		}
		else {
			$rspta=$articulo->editar($idarticulo,$idsubcategoria,$codigo,$nombre,$stock,$impuesto,$descripcion,$imagen,$unidad);
			echo $rspta ? "Artículo actualizado" : "Artículo no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$articulo->desactivar($idarticulo);
 		echo $rspta ? "Artículo Desactivado" : "Artículo no se puede desactivar";
	break;

	case 'activar':
		$rspta=$articulo->activar($idarticulo);
 		echo $rspta ? "Artículo activado" : "Artículo no se puede activar";
	break;

	case 'mostrarselect':
		$rspta=$subcategoria->selectanidado($idcategoria);
		//echo $idcategoria;
		echo '<option disabled="true" value="" selected>Selecciona</option>';
		while ($reg = $rspta->fetch_object())
				{
					//echo implode($reg);

					echo '<option value=' . $reg->idsub_categoria . '>' . $reg->nombre_subcat. '</option>';
				}
		//echo json_encode($rspta);
	break;

	case 'mostrar':
		$rspta=$articulo->mostrar($idarticulo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
	

	case 'listar':
		$rspta=$articulo->listar();
 		//Vamos a declarar un array
 		$data= Array();
		echo implode($data);
 		while ($reg = $rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idarticulo.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idarticulo.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idarticulo.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idarticulo.')"><i class="fa fa-check"></i></button>',
				 "1"=>$reg->nombre,
				 "2"=>$reg->nombrecategoria,
 				"3"=>$reg->nombresubcategoria,
 				"4"=>$reg->codigo,
				 "5"=>$reg->stock,
				 "6"=>$reg->unidad,
				 "7"=>($reg->impuesto)?'<span class="label bg-blue-active">Tiene impuesto</span>':
 				'<span class="label bg-orange-active">No tiene</span>',
 				"8"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >",
 				"9"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
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

	case "selectCategoria":
		require_once "../modelos/Categoria.php";
		$categoria = new Categoria();

		$rspta = $categoria->select();
		echo '<option disabled="true" value="" selected>Selecciona</option>';
		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idcategoria . '>' . $reg->nombre . '</option>';
				}
	break;
	case "selectSubcategoria":
		require_once "../modelos/Subcategoria.php";
		$subcategoria = new Subcategoria();

		$rspta = $subcategoria->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idcategoria . '>' . $reg->nombre . '</option>';
				}
	break;


	case "selectUnidad":
		require_once "../modelos/Unidad.php";
		$unidad = new Unidad();

		$rspta = $unidad->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->id_unidad . '>' . $reg->prefijo . '</option>';
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