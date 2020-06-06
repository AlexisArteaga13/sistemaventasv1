<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Articulo
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idsubcategoria,$codigo,$nombre,$stock,$impuesto,$descripcion,$imagen,$unidad)
	{
		$sql="INSERT INTO articulo (id_subcategoria,codigo,nombre,stock,impuesto,descripcion,imagen,id_unidad,condicion)
		VALUES ('$idsubcategoria','$codigo','$nombre','$stock','$impuesto','$descripcion','$imagen','$unidad','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idarticulo,$idsubcategoria,$codigo,$nombre,$stock,$impuesto,$descripcion,$imagen,$unidad)
	{
		$sql="UPDATE articulo SET id_subcategoria='$idsubcategoria',codigo='$codigo',nombre='$nombre',impuesto='$impuesto',stock='$stock',descripcion='$descripcion',imagen='$imagen',id_unidad ='$unidad' WHERE idarticulo='$idarticulo'";
		//echo $sql;
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idarticulo)
	{
		$sql="UPDATE articulo SET condicion='0' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idarticulo)
	{
		$sql="UPDATE articulo SET condicion='1' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idarticulo)
	{
		$sql="SELECT * FROM articulo WHERE idarticulo='$idarticulo'";
		return ejecutarConsultaSimpleFila($sql);
	}
	public function mostrararticuloarevisar($idarticulo)
	{
		$sql="SELECT impuesto FROM articulo WHERE idarticulo='$idarticulo'";
		return ejecutarConsultaSimpleFila($sql);
	}
	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT a.idarticulo as idarticulo, a.nombre as nombre,a.impuesto as impuesto, c.nombre as nombrecategoria, a.codigo as codigo, a.stock as stock, a.descripcion as descripcion, a.imagen as imagen, a.condicion as condicion, s.nombre_subcat as nombresubcategoria, u.prefijo as unidad FROM articulo a INNER JOIN sub_categoria s on a.id_subcategoria = s.idsub_categoria INNER JOIN unidades u ON u.id_unidad = a.id_unidad inner join categoria c on s.idcategoria=c.idcategoria";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros activos
	public function listarActivos()
	{
		$sql="SELECT a.idarticulo as idarticulo,a.impuesto as impuesto, a.nombre as nombre, c.nombre as nombrecategoria, a.codigo as codigo, a.stock as stock, a.descripcion as descripcion, a.imagen as imagen, a.condicion as condicion, s.nombre_subcat as nombresubcategoria, u.prefijo as unidad FROM articulo a INNER JOIN sub_categoria s on a.id_subcategoria = s.idsub_categoria INNER JOIN unidades u ON u.id_unidad = a.id_unidad inner join categoria c on s.idcategoria=c.idcategoria WHERE a.condicion='1'";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros activos, su último precio y el stock (vamos a unir con el último registro de la tabla detalle_ingreso)
	public function listarActivosVenta()
	{
		$sql="SELECT a.idarticulo as idarticulo,a.impuesto as impuesto, a.nombre as nombre, c.nombre as nombrecategoria, a.codigo as codigo, a.stock as stock,(SELECT precio_venta FROM detalle_ingreso WHERE idarticulo=a.idarticulo order by iddetalle_ingreso desc limit 0,1) as precio_venta, a.descripcion as descripcion, a.imagen as imagen, a.condicion as condicion, s.nombre_subcat as nombresubcategoria, u.prefijo as unidad FROM articulo a INNER JOIN sub_categoria s on a.id_subcategoria = s.idsub_categoria INNER JOIN unidades u ON u.id_unidad = a.id_unidad inner join categoria c on s.idcategoria=c.idcategoria  WHERE a.condicion='1'";
		return ejecutarConsulta($sql);		
	}
}

?>