<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Unidad
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$prefijo)
	{
		$sql="INSERT INTO unidades (nombre,prefijo,estado)
		VALUES ('$nombre','$prefijo','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idunidad,$nombre,$prefijo)
	{
		$sql="UPDATE unidades SET nombre='$nombre',prefijo='$prefijo' WHERE id_unidad='$idunidad'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idunidad)
	{
		$sql="UPDATE unidades SET estado='0' WHERE id_unidad='$idunidad'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idunidad)
	{
		$sql="UPDATE unidades SET estado='1' WHERE id_unidad='$idunidad'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idunidad)
	{
		$sql="SELECT * FROM unidades WHERE id_unidad='$idunidad'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM unidades";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM unidades where estado=1";
		return ejecutarConsulta($sql);		
	}
}

?>