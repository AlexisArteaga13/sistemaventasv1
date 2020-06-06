<?php
if (strlen(session_id()) < 1) 
  session_start();
  
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ADVentas </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/font-awesome.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
    <link rel="shortcut icon" href="../public/img/favicon.ico">
 
    <!-- DATATABLES -->
    <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">    
    <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet"/>
    <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet"/>

    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">

  </head>
  <body class="hold-transition skin-blue-light sidebar-mini">
    <div class="wrapper">

      <header class="main-header">

        <!-- Logo -->
        <a href="index2.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>AD</b>Ventas</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>ADVentas</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <?php 
           
           require "../modelos/Usuario.php";
           $modelo = new Usuario();
           $cargodesession= $modelo ->mostrarcargodeusuario($_SESSION["idusuario"]); 
          
                $_SESSION['cargo']=implode($cargodesession);   
             
              ?>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo $_SESSION['nombre'].strlen(session_id()).ob_start().$_SESSION["cargo"]; ?></span>
                  <span class="hidden-xs"><?php echo $_SESSION['sucursaladministrada']; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                    <p>
                    
                    </p>
                  </li>
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    
                    <div class="pull-right">
                      <?php 
                      if($_SESSION['sucursaladministrada'] == "" ){
                        echo '<a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Cerrar Sesión</a>';
                      }
                      else{
                        echo ' <a href="../ajax/acceso.php?op=salirdesucursal" class="btn btn-default btn-flat">Salir de sucursal</a>
                        ';
                        
                      }
                      ?>
                      </div>
                  </li>
                </ul>
              </li>
              
            </ul>
          </div>

        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">       
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"></li>
            <?php 
            if($_SESSION["idsucursal"]=="" || $_SESSION["cargo"]==1){
              
              echo '<li id="mAccesos">
              <a href="acceso.php">
                <i class="fa fa-tasks"></i> <span>Acceso a sucursales</span>
              </a>
            </li>';
            }
            ?>
            <?php 
            if ($_SESSION['administracion']==1 &&  ($_SESSION["idsucursal"] != "" || $_SESSION["cargo"]==1) || ($_SESSION["idsucursal"] != "" && $_SESSION["cargo"]==3))
            {
              echo '<li id="mAdministracion" class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Administración</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              ';
              if($_SESSION["cargo"]==1 ){
               echo ' <li id="lSucursales"><a href="sucursales.php"><i class="fa fa-circle-o"></i>Sucursales</a></li> 
              
              <li id="lCargos"><a href="cargos.php"><i class="fa fa-circle-o"></i>Cargos</a></li>
              ';
            }
              if($_SESSION["cargo"]=="1"  || $_SESSION["cargo"]=="2"  || $_SESSION["cargo"]=="3"  || $_SESSION['sucursaladministrada'] != "") 
              { echo '<li id="lCaja"><a href="caja.php"><i class="fa fa-circle-o"></i>Caja</a></li>
                
             
                </ul>
            </li>';}
            else{

            }
            }
            ?>
            <?php 
            //$_SESSION['cajas']==1 && 
            if (($_SESSION["cargo"]=="1" || $_SESSION["cargo"]=="2") && $_SESSION['sucursaladministrada'] != ""  )
            {
              echo '<li id="mCaja">
              <a href="caja.php.php">
              
                <i class="fa fa-tasks"></i> <span>Caja</span>
              </a>
            </li>';
            }
            ?>
            <?php 
            if (($_SESSION['escritorio']==1 && $_SESSION["cargo"]==1) || ($_SESSION['escritorio']==1 && $_SESSION["idsucursal"]!=""))
            {
              echo '<li id="mEscritorio">
              <a href="escritorio.php">
              
                <i class="fa fa-tasks"></i> <span>Escritorio</span>
              </a>
            </li>';
            }
            ?>

            <?php 
            if (($_SESSION['almacen']==1 && $_SESSION["cargo"]==1) || ($_SESSION['almacen']==1 && $_SESSION["idsucursal"]!=""))
            {
              echo '<li id="mAlmacen" class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Almacén</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="lUnidades"><a href="unidades.php"><i class="fa fa-circle-o"></i>Unidades</a></li> 
                <li id="lArticulos"><a href="articulo.php"><i class="fa fa-circle-o"></i> Artículos</a></li>
                <li id="lCategorias"><a href="categoria.php"><i class="fa fa-circle-o"></i> Categorías</a></li>
                <li id="lSubcategorias"><a href="subcategoria.php"><i class="fa fa-circle-o"></i> Sub Categorías</a></li>
             
                </ul>
            </li>';
            }
            ?>

            <?php 
            if (($_SESSION['compras']==1 && $_SESSION["cargo"]==1) || ($_SESSION['compras']==1 && $_SESSION["idsucursal"]!=""))
            {
              echo '<li id="mCompras" class="treeview">
              <a href="#">
                <i class="fa fa-th"></i>
                <span>Compras</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="lIngresos"><a href="ingreso.php"><i class="fa fa-circle-o"></i> Ingresos</a></li>
                <li id="lProveedores"><a href="proveedor.php"><i class="fa fa-circle-o"></i> Proveedores</a></li>
              </ul>
            </li>';
            }
            ?>

            <?php 
            if (($_SESSION['ventas']==1 && $_SESSION["cargo"]==1) || ($_SESSION['ventas']==1 && $_SESSION["idsucursal"]!=""))
            {
              echo '<li id="mVentas" class="treeview">
              <a href="#">
                <i class="fa fa-shopping-cart"></i>
                <span>Ventas</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="lVentas"><a href="venta.php"><i class="fa fa-circle-o"></i> Ventas</a></li>
                <li id="lClientes"><a href="cliente.php"><i class="fa fa-circle-o"></i> Clientes</a></li>
              </ul>
            </li>';
            }
            ?>
                        
            <?php 
            if (($_SESSION['acceso']==1 && $_SESSION["cargo"]==1) || ($_SESSION['acceso']==1 && $_SESSION["idsucursal"]!="") )
            {
              echo '<li id="mAcceso" class="treeview">
              <a href="#">
                <i class="fa fa-folder"></i> <span>Acceso</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="lUsuarios"><a href="usuario.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                <li id="lPermisos"><a href="permiso.php"><i class="fa fa-circle-o"></i> Permisos</a></li>
                
              </ul>
            </li>';
            }
            ?>

            <?php 
            if (($_SESSION['consultac']==1 && $_SESSION["cargo"]==1) || ($_SESSION['consultac']==1 && $_SESSION["idsucursal"]!=""))
            {
              echo '<li id="mConsultaC" class="treeview">
              <a href="#">
                <i class="fa fa-bar-chart"></i> <span>Consulta Compras</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="lConsulasC"><a href="comprasfecha.php"><i class="fa fa-circle-o"></i> Consulta Compras</a></li>                
              </ul>
            </li>';
            }
            ?>

             <?php 
            if (($_SESSION['consultav']==1 && $_SESSION["cargo"]==1) || ($_SESSION['consultav']==1 && $_SESSION["idsucursal"]!=""))
            {
              echo '<li id="mConsultaV" class="treeview">
              <a href="#">
                <i class="fa fa-bar-chart"></i> <span>Consulta Ventas</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="lConsulasV"><a href="ventasfechacliente.php"><i class="fa fa-circle-o"></i> Consulta Ventas</a></li>                
              </ul>
            </li>';
            }
            ?>

           
                        
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
