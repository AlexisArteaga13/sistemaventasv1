<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Sucursal
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($codsucursal,$nombresucu,$nombre,$direccion,$telefono,$email)
	{
		$sql="INSERT INTO sucursal (codsucursal,nombresucursal,nombre_encargado,direccion,telefono,email,estado)
		VALUES ('$codsucursal','$nombresucu','$nombre','$direccion','$telefono','$email','1')";
		$idsucursalnew=ejecutarConsulta_retornarID($sql);
		$rpta = true;
		if($idsucursalnew != null){
			$sql_usuario_sucursal = "INSERT INTO usuarioporsucursal(idusuario, id_sucursal,tipousuario) VALUES('$nombre', '$idsucursalnew','A')";
			ejecutarConsulta($sql_usuario_sucursal) or $rpta = false;
		}
		return $rpta;
	}

	//Implementamos un método para editar registros
	public function editar($idsucursal,$codsucursal,$nombresucu,$nombre,$direccion,$telefono,$email)
	{
        
		$sql="UPDATE sucursal SET codsucursal = '$codsucursal',nombresucursal ='$nombresucu', nombre_encargado ='$nombre',direccion='$direccion',telefono = '$telefono',email='$email' WHERE id_sucursal ='$idsucursal'";
		ejecutarConsulta($sql);
		//Eliminamos todos los usuarios asignados para volverlos a registrar
		$sqldel="DELETE FROM usuarioporsucursal WHERE id_sucursal='$idsucursal' and tipousuario = 'A' ";
		ejecutarConsulta($sqldel);
		$rpta = true;
		$sql_usuario_sucursal = "INSERT INTO usuarioporsucursal(idusuario, id_sucursal,tipousuario) VALUES('$nombre', '$idsucursal','A')";
		ejecutarConsulta($sql_usuario_sucursal) or $rpta = false;
		return $rpta;
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idsucursal)
	{
		$sql="UPDATE sucursal SET estado='0' WHERE id_sucursal='$idsucursal'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idsucursal)
	{
		$sql="UPDATE sucursal SET estado='1' WHERE id_sucursal='$idsucursal'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idsucursal)
	{
		$sql="SELECT * FROM sucursal WHERE id_sucursal='$idsucursal'";
        
        return ejecutarConsultaSimpleFila($sql);
	}
	public function mostraridsucursalsesion($idsucursal)
	{
		$sql="SELECT id_sucursal FROM sucursal WHERE id_sucursal='$idsucursal'";
        
        return ejecutarConsultaSimpleFila($sql);
	}
	public function mostrarnombresucursalsesion($idsucursal)
	{
		$sql="SELECT nombresucursal FROM sucursal WHERE id_sucursal='$idsucursal'";
        
        return ejecutarConsultaSimpleFila($sql);
	}
	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT s.id_sucursal as id_sucursal, s.codsucursal as codsucursal,s.nombresucursal as nombresucursal,u.nombre as nombre_encargado, s.direccion as direccion, s.direccion as direccion, s.telefono as telefono, s.email as email, s.estado as estado FROM sucursal s INNER JOIN usuario u on u.idusuario=s.nombre_encargado WHERE s.estado = 1 ";
		return ejecutarConsulta($sql);		
	}
	//  LISTAS POR ADMINSTRADORES DE CURSAL
	public function listarporadministradoresdesucursal()
	{
		$sql="SELECT s.id_sucursal as id_sucursal, s.codsucursal as codsucursal,s.nombresucursal as nombresucursal,u.nombre as nombre_encargado, s.direccion as direccion, s.direccion as direccion, s.telefono as telefono, s.email as email, s.estado as estado FROM sucursal s INNER JOIN usuario u on u.idusuario=s.nombre_encargado WHERE s.estado = 1 and s.id_sucursal='".$_SESSION["idsucursal"]."'";
		return ejecutarConsulta($sql);		
	}
	public function listarsucursalporusuario($idusuario)
	{
		$sql="SELECT s.codsucursal as codsucursal, s.id_sucursal as id_sucursal, s.nombresucursal as nombresucursal,u.nombre as nombre_encargado, s.direccion as direccion,s.telefono as telefono, s.email as email, s.estado as estado from usuarioporsucursal ups INNER JOIN usuario u on ups.idusuario = u.idusuario INNER JOIN sucursal s on ups.id_sucursal = s.id_sucursal where u.idusuario= '$idusuario' and s.estado='1'";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM sucursal where estado=1";
		return ejecutarConsulta($sql);		
	}
/*	public function selectanidadodecategoria()
	{
		$sql="SELECT * FROM categoria where condicion=1";
		return ejecutarConsulta($sql);		
	}*/
}

?>