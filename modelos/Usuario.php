<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Usuario
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen,$permisos,$sucursales)
	{
		$sql="INSERT INTO usuario (nombre,tipo_documento,num_documento,direccion,telefono,email,idcargo,login,clave,imagen,condicion)
		VALUES ('$nombre','$tipo_documento','$num_documento','$direccion','$telefono','$email','$cargo','$login','$clave','$imagen','1')";
		//return ejecutarConsulta($sql);
		$idusuarionew=ejecutarConsulta_retornarID($sql);
		$inicialtipousuario="";
		if($cargo == "1"){
			$inicialtipousuario = "S";
		}
		else{
			if($cargo == "2"){
				$inicialtipousuario = "A";
			}
			else{
				$inicialtipousuario = "C";
			}
		}
		$numsucursales = 0;
		$num_elementos=0;
		$sw=true;
		while ($numsucursales < count($sucursales))
		{
			$sqlsucusuario = "INSERT INTO usuarioporsucursal (idusuario, id_sucursal,tipousuario) VALUES('$idusuarionew', '$sucursales[$numsucursales]','$inicialtipousuario')";
			ejecutarConsulta($sqlsucusuario) or $sw = false;
			$numsucursales=$numsucursales + 1;
		}

		while ($num_elementos < count($permisos))
		{
			$sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) VALUES('$idusuarionew', '$permisos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}

	//Implementamos un método para editar registros
	public function editar($idusuario,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen,$permisos,$sucursales)
	{
		$sql="UPDATE usuario SET nombre='$nombre',tipo_documento='$tipo_documento',num_documento='$num_documento',direccion='$direccion',telefono='$telefono',email='$email',idcargo='$cargo',login='$login',clave='$clave',imagen='$imagen' WHERE idusuario='$idusuario'";
		ejecutarConsulta($sql);

		//Eliminamos todos los permisos asignados para volverlos a registrar
		$sqldeleteussucursal="DELETE FROM usuarioporsucursal WHERE idusuario='$idusuario'";
		ejecutarConsulta($sqldeleteussucursal);
		$inicialtipousuario="";
		if($cargo == "1"){
			$inicialtipousuario = "S";
		}
		else{
			if($cargo == "2"){
				$inicialtipousuario = "A";
			}
			else{
				$inicialtipousuario = "C";
			}
		}
		$numsucursales = 0;
		$num_elementos=0;
		$sw=true;
		while ($numsucursales < count($sucursales))
		{
			$sqlsucusuario = "INSERT INTO usuarioporsucursal (idusuario, id_sucursal,tipousuario) VALUES('$idusuario', '$sucursales[$numsucursales]','$inicialtipousuario')";
			ejecutarConsulta($sqlsucusuario) or $sw = false;
			$numsucursales=$numsucursales + 1;
		}

		//Eliminamos todos las sucursales asignadas para volverlos a registrar
		$sqldel="DELETE FROM usuario_permiso WHERE idusuario='$idusuario'";
		ejecutarConsulta($sqldel);


		/*$num_elementos=0;
		$sw=true;*/

		while ($num_elementos < count($permisos))
		{
			$sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) VALUES('$idusuario', '$permisos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;

	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idusuario)
	{
		$sql="UPDATE usuario SET condicion='0' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idusuario)
	{
		$sql="UPDATE usuario SET condicion='1' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idusuario)
	{
		$sql="SELECT * FROM usuario WHERE idusuario='$idusuario'";
		return ejecutarConsultaSimpleFila($sql);
	}
	public function mostrarcargodeusuario($idusuario)
	{
		$sql="SELECT idcargo FROM usuario WHERE idusuario='$idusuario'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM usuario";
		return ejecutarConsulta($sql);		
	}
	public function listaradmin()
	{
		$sql="SELECT * FROM usuario where condicion='1' and idcargo=2 or idcargo=1";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los permisos marcados
	public function listarmarcados($idusuario)
	{
		$sql="SELECT * FROM usuario_permiso WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}
	//Implementar un método para listar los permisos marcados
	public function listarsucursalesmarcadas($idusuario)
	{
		$sql="SELECT * FROM usuarioporsucursal WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}
	//Función para verificar el acceso al sistema
	public function verificar($login,$clave)
    {
    	$sql="SELECT idusuario,nombre,tipo_documento,num_documento,telefono,email,idcargo,imagen,login FROM usuario WHERE login='$login' AND clave='$clave' AND condicion='1'"; 
    	return ejecutarConsulta($sql);  
	}
	public function selectanidado($sucursal)
	{
		$sql="SELECT * FROM usuario u INNER JOIN usuarioporsucursal up on u.idusuario=up.idusuario WHERE u.condicion=1 and id_sucursal='$sucursal'";
		return ejecutarConsulta($sql);		
	}
}

?>