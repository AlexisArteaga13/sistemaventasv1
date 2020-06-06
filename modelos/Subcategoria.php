<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Subcategoria
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$descripcion,$idcategoria)
	{
		$sql="INSERT INTO sub_categoria (nombre_subcat,descripcion_subcat,condicion_subcat,idcategoria)
		VALUES ('$nombre','$descripcion','1','$idcategoria')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idsubcategoria,$nombre,$descripcion,$idcategoria)
	{
		$sql="UPDATE sub_categoria SET nombre_subcat='$nombre',descripcion_subcat='$descripcion',idcategoria='$idcategoria' WHERE idsub_categoria='$idsubcategoria'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idsubcategoria)
	{
		$sql="UPDATE sub_categoria SET condicion_subcat='0' WHERE idsub_categoria='$idsubcategoria'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idsubcategoria)
	{
		$sql="UPDATE sub_categoria SET condicion_subcat='1' WHERE idsub_categoria='$idsubcategoria'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idsubcategoria)
	{
		$sql="SELECT * FROM sub_categoria WHERE idsub_categoria='$idsubcategoria'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT s.idsub_categoria as idsub_categoria, c.nombre as categoria, s.nombre_subcat as nombre_subcat, s.descripcion_subcat as descripcion_subcat ,s.condicion_subcat as condicion_subcat FROM sub_categoria s INNER JOIN categoria c ON c.idcategoria=s.idcategoria";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM sub_categoria where condicion=1";
		return ejecutarConsulta($sql);		
	}
	public function selectanidado($idcategoria)
	{
		$sql="SELECT * FROM sub_categoria where condicion_subcat=1 AND idcategoria=$idcategoria";
		return ejecutarConsulta($sql);		
	}
}

?>