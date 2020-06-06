<?php
//Activamos el almacenamiento en el buffer
//ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';

?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Sucursales En Curso 
                             
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!--
                        
                    
                    <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> <a href="../reportes/rptsucursales.php" target="_blank"><button class="btn btn-info"><i class="fa fa-clipboard"></i> Reporte</button></a>
                    
                    !-->
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Acceso</th>
                            <th>Código</th>
                            <th>Nombre Sucursal</th>
                            
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>  
                       
                          </tbody>
                          <tfoot>
                          <th>Acceso</th>
                            <th>Código</th>
                            <th>Nombre Sucursal</th>
                           
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                   
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php


require 'footer.php';
?>
<script type="text/javascript" src="scripts/acceso.js"></script>
<?php 
}
//ob_end_flush();
?>


