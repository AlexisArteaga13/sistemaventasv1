
var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})
	$.post("../ajax/caja.php?op=selectSucursal", function(r){
		$("#idsucursal").html(r);
		$("#idsucursal").selectpicker('refresh');

	});
	//Cargamos los items al select categoria
/*	$.post("../ajax/articulo.php?op=selectCategoria", function(r){
	            $("#idcategoria").html(r);
	            $('#idcategoria').selectpicker('refresh');

	});*/
	
	//$("#imagenmuestra").hide();
	$('#mAdministracion').addClass("treeview active");
	$('#lCaja').addClass("active");
	// funcion que se ejecuta al cambio de select de categoría

}
$("#idsucursal").change(function(event){
   
    var idsucursal = this.value;
     console.log(location.href);
    console.log(idsucursal);
    $.post("../ajax/caja.php?op=mostrarcajero",{idsucursal : idsucursal}, function(r){
		console.log(r);
		$("#idcajero").html(r);
		$('#idcajero').selectpicker('refresh');

});
  });
//Función limpiar
function limpiar()
{
	console.log("limpiar");
	$("#idcaja").val("");
	$("#idsucursal").val("");
	$("#idcajero").val("");
	
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
					url: '../ajax/caja.php?op=listar',
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
	console.log($("#formulario")[0]);
	$.ajax({
		url: "../ajax/caja.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,
		
	    success: function(datos)
	    {      console.log(datos);     
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
	
}

function mostrar(idcaja)
{

	$.post("../ajax/caja.php?op=mostrar",{idcaja : idcaja}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		console.log(data);
		$.post("../ajax/caja.php?op=selectSucursal",function(r){
            $("#idsucursal").html(r);
            $("#idsucursal").val(data.id_sucursal);
            $("#idsucursal").selectpicker('refresh');
            $.post("../ajax/caja.php?op=mostrarcajero",{idsucursal : data.id_sucursal}, function(r){
                //console.log(r);
                $("#idcajero").html(r);
                $("#idcajero").val(data.cajero);
                $('#idcajero').selectpicker('refresh');
        
        });
        });
		
		
		$("#codigo").val(data.codcaja);
 		$("#idcaja").val(data.idcaja);
 		
 	})
}

//Función para desactivar registros
function desactivar(idcaja)
{
	bootbox.confirm("¿Está Seguro de cerrar la caja?", function(result){
		if(result)
        {
        	$.post("../ajax/caja.php?op=desactivar", {idcaja : idcaja}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idcaja)
{
	bootbox.confirm("¿Está Seguro de aperturar la caja?", function(result){
		if(result)
        {
        	$.post("../ajax/caja.php?op=activar", {idcaja : idcaja}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}





init();