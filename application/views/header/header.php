<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> INNOVA | PRODUN HOLDINGS </title>
    <!--Import Google Icon Font-->    
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">    
    <!--Import materialize.css-->    
    <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/materialize.css"  media="screen,projection"/>
    <!--CHOSEN CONTROLS-->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/select2.min.css">
	<!--DATATABLES-->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/dataTables.foundation.css" >
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/select.dataTables.min.css" >
    <!--Mis estilos css-->
    <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/_styles.css"  media="screen,projection"/>
    <!--DATEPICKERS-->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/daterangepicker.css" >
    <!--SWEETALERT2-->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/sweetalert2.min.css" >
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.png" />


</head>
<body>
	<header class="demo-header mdl-layout__header">
		<nav class="nav-extended">
			<div class="menu">
				<div class="nav-wrapper" >
                    <a href="#" class="left" style="margin-left: 10px;"><img  src="<?php echo base_url();?>assets/images/Logo.png" style="width: 100px;margin-top: 10px;"></a>
                    <ul id="nav-mobile" class="left hide-on-med-and-down" style="margin-left: 10px">

                        <?php

                        echo '<li id="main"><a href="'.base_url('index.php/main').'">FACTURAS</a></li>
                              <li id="inweb"><a href="'.base_url('index.php/inweb').'">WEB ACTIVO</a></li>';

                        ?>



                    </ul>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li><a href="#" class="HoverTrasparente"><?php echo $this->session->userdata('nombre');?></a></li>

                        <li><a href="salir">Cerrar sesión</a></li>
                    </ul>

                </div>
			</div>
		</nav>
	</header>
