var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});
	$.post("../ajax/sucursal.php?op=selectAdministrador", function(r){
        $("#nombreencargado").html(r);
        $("#nombreencargado").selectpicker('refresh');

});
    $('#mAdministracion').addClass("treeview active");
    $('#lSucursales').addClass("active");
}

//Función limpiar
function limpiar()
{
	$("#idsucursal").val("");
	$("#codigo").val("");
    $("#nombresucursal").val("");
    $("#nombreencargado").val("");
    $("#direccion").val("");
    $("#telefono").val("");
	$("#correo").val("");
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"lengthMenu": [ 5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/sucursal.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"language": {
            "lengthMenu": "Mostrar : _MENU_ registros",
            "buttons": {
            "copyTitle": "Tabla Copiada",
            "copySuccess": {
                    _: '%d líneas copiadas',
                    1: '1 línea copiada'
                }
            }
        },
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/sucursal.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}

function mostrar(idsucursal)
{
	$.post("../ajax/sucursal.php?op=mostrar",{idsucursal : idsucursal}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);
	console.log(data.nombre_encargado);
        $("#codigo").val(data.codsucursal);
        $("#nombresucursal").val(data.nombresucursal);
		$("#nombreencargado").val(data.nombre_encargado);
        $("#direccion").val(data.direccion);
        $("#telefono").val(data.telefono);
		$("#correo").val(data.email);
 		$("#idsucursal").val(data.id_sucursal);

 	})
}

//Función para desactivar registros
function desactivar(idsucursal)
{
	bootbox.confirm("¿Está Seguro de desactivar la Sucursal?", function(result){
		if(result)
        {
        	$.post("../ajax/sucursal.php?op=desactivar", {idsucursal : idsucursal}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idsucursal)
{
	bootbox.confirm("¿Está Seguro de activar la Sucursal?", function(result){
		if(result)
        {
        	$.post("../ajax/sucursal.php?op=activar", {idsucursal : idsucursal}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}


init();