<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Caja
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($codigo,$idsucursal,$cajero)
	{
        //codcaja	id_sucursal	cajero	estado

		$sql="INSERT INTO caja (codcaja,id_sucursal,cajero,estado)
		VALUES ('$codigo','$idsucursal','$cajero','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idcaja,$codigo,$idsucursal,$cajero)
	{
		$sql="UPDATE caja SET codcaja='$codigo',id_sucursal='$idsucursal',cajero='$cajero' WHERE idcaja='$idcaja'";
		//echo $sql;
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idcaja)
	{
		$sql="UPDATE caja SET estado='0' WHERE idcaja='$idcaja'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idcaja)
	{
		$sql="UPDATE caja SET estado='1' WHERE idcaja='$idcaja'";
		return ejecutarConsulta($sql);
	}
	public function contarcajaporsucursal()
	{
		$sql="SELECT COUNT(*) from caja WHERE id_sucursal = ".$_SESSION["idsucursal"]." and cajero=".$_SESSION["idusuario"]."";
		//echo $_SESSION["idusuario"];
		//echo json_encode(ejecutarConsulta($sql));
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcaja)
	{
		$sql="SELECT * FROM caja WHERE idcaja='$idcaja'";
		return ejecutarConsultaSimpleFila($sql);
	}
	public function mostrardocumentodecaja($idcaja,$tipodedocumento)
	{
		$sql="SELECT * FROM documento WHERE idcaja='$idcaja' and tipodedocumento ='$tipodedocumento'";
		return ejecutarConsultaSimpleFila($sql);
	}
	public function mostrariddocumento($idcaja,$tipodedocumento)
	{
		$sql="SELECT iddocumento FROM documento WHERE idcaja='$idcaja' and tipodedocumento ='$tipodedocumento'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT c.idcaja as idcaja, c.codcaja as codcaja, s.nombresucursal as sucursal, u.nombre as cajero, c.estado as estado FROM caja c INNER JOIN sucursal s on c.id_sucursal = s.id_sucursal INNER JOIN usuario u on u.idusuario = c.cajero";
		return ejecutarConsulta($sql);		
	}
	public function listarcajasporsucursal()
	{
		$sql="SELECT c.idcaja as idcaja, c.codcaja as codcaja, s.nombresucursal as sucursal, u.nombre as cajero, c.estado as estado FROM caja c INNER JOIN sucursal s on c.id_sucursal = s.id_sucursal INNER JOIN usuario u on u.idusuario = c.cajero where c.id_sucursal= ".$_SESSION['idsucursal']."";
		return ejecutarConsulta($sql);		
	}

	// este metodo carga las sucursales para cajeros
	public function listarcajasporsucursalcajero()
	{
		$sql="SELECT c.idcaja as idcaja, c.codcaja as codcaja, s.nombresucursal as sucursal, u.nombre as cajero, c.estado as estado FROM caja c INNER JOIN sucursal s on c.id_sucursal = s.id_sucursal INNER JOIN usuario u on u.idusuario = c.cajero where c.id_sucursal= ".$_SESSION['idsucursal']." and c.cajero = ".$_SESSION['idusuario']."	and c.cajero = ".$_SESSION['idusuario']."	 ";
		return ejecutarConsulta($sql);	
		//and c.cajero = ".$_SESSION['idusuario']."	
	}
	//Implementar un método para listar los registros activos
	public function listarActivos()
	{
		$sql="SELECT c.idcaja as idcaja, c.codcaja as codcaja, s.nombresucursal as sucursal, u.nombre as cajero , c.estado as estado FROM caja c INNER JOIN sucursal s on c.id_sucursal = s.id_sucursal INNER JOIN usuario u on u.idusuario = c.cajero WHERE c.estado='1'";
		return ejecutarConsulta($sql);		
	}
	// implementamos listado de cajas por sucursales
	public function listarActivosporsucursales()
	{
		$sql="SELECT c.idcaja as idcaja, c.codcaja as codcaja, s.nombresucursal as sucursal, u.nombre as cajero , c.estado as estado FROM caja c INNER JOIN sucursal s on c.id_sucursal = s.id_sucursal INNER JOIN usuario u on u.idusuario = c.cajero WHERE c.id_sucursal='".$_SESSION["idsucursal"]."' and c.estado='1'";
		return ejecutarConsulta($sql);		
	}
	// implementamos listado de cajas por sucursales y cajeros
	public function listarActivosporsucursalesycajeros()
	{
		$sql="SELECT c.idcaja as idcaja, c.codcaja as codcaja, s.nombresucursal as sucursal, u.nombre as cajero , c.estado as estado FROM caja c INNER JOIN sucursal s on c.id_sucursal = s.id_sucursal INNER JOIN usuario u on u.idusuario = c.cajero WHERE c.id_sucursal='".$_SESSION["idsucursal"]."' and c.cajero='".$_SESSION["idusuario"]."' and c.estado='1'";
		return ejecutarConsulta($sql);		
	}

}

?>