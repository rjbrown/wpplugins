<?php
/**
 * @package Scroll Features
 * @version 0.1
 */
/*
Plugin Name: Bobby Brown
Plugin URI: #
Description: Adds scroll Animatetions
Author: Bobby Brown
Version: 0.1
*/

//Enque Needed scripts
wp_enqueue_script( 'rb-cssanimation', plugins_url() . '/rb-cssanimation/js/rb-audio.js', NULL, '0.1' );

// We need some CSS
function animate_css() {
	echo "
    <style>
	.fade-in-section {
	    opacity: 0;
	    transform: translateY(20vh);
	    visibility: hidden;
	    transition: opacity 1200ms ease-out, transform 600ms ease-out,visibility 1200ms ease-out;
	    will-change: opacity, transform, visibility;
	}
	.fade-in-section.is-visible {
	  opacity: 1;
	  transform: none;
	  visibility: visible;
	}
	
</style>
	";
}

add_action( 'admin_head', 'animate_css' );
