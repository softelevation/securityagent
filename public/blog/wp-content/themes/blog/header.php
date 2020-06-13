<?php
/**
 * Header file for the Twenty Twenty WordPress default theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */
?><!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >

		<link rel="profile" href="https://gmpg.org/xfn/11">
		<!-- Bootstrap core CSS -->
	    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/custom/css/bootstrap.min.css" rel="stylesheet">
	    <!-- Custom styles for this template -->
        <link href="<?php echo get_stylesheet_directory_uri(); ?>/style.css" rel="stylesheet">
        <link href="<?php echo APP_URL; ?>/assets/css/style.css" rel="stylesheet">
	    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/custom/css/toaster.css" rel="stylesheet">
	    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/custom/css/all.css" rel="stylesheet">
	    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/custom/css/select2.css" rel="stylesheet">
	    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/custom/css/jquery.datetimepicker.min.css" rel="stylesheet">
	    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/custom/css/jquery-ui.css">
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
	    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/custom/js/jquery.min.js"></script>
	    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/custom/js/bootstrap.bundle.min.js"></script>
	    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/custom/js/bootstrap.bundle.min.js"></script>
	    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/custom/js/jquery.datetimepicker.full.min.js"></script>
	    <script type="text/javascript" charset="UTF-8" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/custom/js/common.js"></script>
	    <script type="text/javascript" charset="UTF-8" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/custom/js/controls.js"></script>

		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>
    	<div id="preloader">
            <div id="loader"></div>
        </div>
        <div id="Header">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="<?php echo APP_URL; ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/custom/img/logo.jpg"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"><i class="fa fa-bars" aria-hidden="true"></i></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <div class="main_menu">
                        <div class="menu_left">
                            <div class="top_menu">
                                <ul>
                                    <li><a href="<?php echo APP_URL; ?>/login">Connexion</a></li>
                                    <em>|</em>
                                    <!-- <li><a href="">Registration</a></li> -->
                                    <li>
                                        <div class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown"> 
                                                <img height="18" src="<?php echo APP_URL; ?>/assets/images/france_flag.png">
                                                French
                                                <span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="#">English</a></li>
                                                <li><a href="#">French</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="primary">
                                <ul>
                                    <li><a href="<?php echo APP_URL; ?>">Accueil</a></li>
                                    <li><a href="<?php echo APP_URL; ?>/available-agents">Agent disponible sur la carte</a></li>
                                    <li><a href="<?php echo APP_URL; ?>/agent_information">Agent</a></li>
                                    <li><a class="active" href="<?php echo APP_URL; ?>/blog">Blogs</a></li>
                                    <li><a href="<?php echo APP_URL; ?>/contact-us">Contactez-nous</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="menu_right">
                            <a href="<?php echo APP_URL; ?>/register-agent-view">Devenez un agent</a>
                            <a href="<?php echo APP_URL; ?>/customer-signup">Devenez un utilisateur</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>


