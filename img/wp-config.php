<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('WP_CACHE', true); //Added by WP-Cache Manager
define('DB_NAME', 'arquitectura');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'arquitectura');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', '89KDTD64');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'X)N|>SQAPViEwK|Syxf_#im!{j#WC:2aztUloVc/48os>HA}ahV:$nFh8)%B&)}M'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_KEY', 'p:T9U[cE,NT[+B*sXS7GF{t6A]ZVs6[jj=1=]OZ(Y.hE#|3!/~GGb?k#gz*nDq 4'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_KEY', ',W*dZzTph`.Xf.C|P8DPVnpY?GxzNp_DAC2|L1%0BC8}(d-vAq!6t{0!<&:UCn:-'); // Cambia esto por tu frase aleatoria.
define('NONCE_KEY', 'M_8=2Fxc}r_=- +baa6td?0BP@d,**Rn:0<m<R]<,Yg[Y~wP@k~MwZ 6h*(jlWVj'); // Cambia esto por tu frase aleatoria.
define('AUTH_SALT', '3&ElULSqO2F$ZZX(`$bF_=AzDdo~i$fL#@`jt:7N1$.c*Qb<, -Ecv$sS?[zf3|@'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_SALT', 'P)UxchMUw$38CN_[wq@0i<Cs59Ukm:jq2>bz+P4G]1~p;_or[?|i!q{zrDq@xQ%|'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_SALT', 'PUy+e54wDB/5qL0Iqot[?EIE@j[hh0!OaQ+85Z5{F%O0p@+^I6tb58.8mB)^61s*'); // Cambia esto por tu frase aleatoria.
define('NONCE_SALT', '>z62;R21 SPx/L41t[ftl!F6hyj#e8%5be=O0o8%Fnp`OIHWR$<!Q3C}]P]?eepd'); // Cambia esto por tu frase aleatoria.

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';

/**
 * Idioma de WordPress.
 *
 * Cambia lo siguiente para tener WordPress en tu idioma. El correspondiente archivo MO
 * del lenguaje elegido debe encontrarse en wp-content/languages.
 * Por ejemplo, instala ca_ES.mo copiándolo a wp-content/languages y define WPLANG como 'ca_ES'
 * para traducir WordPress al catalán.
 */
define('WPLANG', 'es_ES');

/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

