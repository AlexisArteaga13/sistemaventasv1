<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Cargo
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$descripcion)
	{
		$sql="INSERT INTO cargos (nombre,descripcion,condicion)
		VALUES ('$nombre','$descripcion','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idcargo,$nombre,$descripcion)
	{
		$sql="UPDATE cargos SET nombre='$nombre',descripcion='$descripcion' WHERE idcargo='$idcargo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idcargo)
	{
		$sql="UPDATE cargos SET condicion='0' WHERE idcargo='$idcargo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idcargo)
	{
		$sql="UPDATE cargos SET condicion='1' WHERE idcargo='$idcargo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcargo)
	{
		$sql="SELECT * FROM cargos WHERE idcargo='$idcargo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM cargos";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM cargos where condicion=1";
		return ejecutarConsulta($sql);		
	}
/*	public function selectanidadodecategoria()
	{
		$sql="SELECT * FROM cargos where condicion=1";
		return ejecutarConsulta($sql);		
	}*/
}

?>