<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 's0yl3ntgr33n');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'a6tg$Qp%/UU^6;lm%CJ)~KO,/{iC2`~]Fak}+9.g.wJBj1fP]P*8f^1#rX>$*#`!');
define('SECURE_AUTH_KEY',  'Zm=}EzR/65x,Gwf?nWx!vBs$<7Pom>ym(G#4Drs.B1|kN+?|n{L;{F.[`Cc6&|D^');
define('LOGGED_IN_KEY',    '*a5-|*{Kc%P?Q7Go>Sc(%.NpLF0fUQs0Y[pycRMk}_X.h9Ll9$lJXz# =VF0JQ+S');
define('NONCE_KEY',        '~gR|>q<]A/!+I?a>d?[2y&|v,Q4+^PvjG1E Oq7|9p-ObOTbWS%4#>l~9Wb7DIh#');
define('AUTH_SALT',        'Fw^x_R(^AJw;V10&^uI9=9RouQ(j)$IwhD[poy9F:{~8:sUrRF-`_)|tFu;cr1tE');
define('SECURE_AUTH_SALT', '.v.1=E@-:(gi+-c!H8JQoeEtlwbwDLPkB!Z0=V3mMAy@h1XF$OytQpd66^>BV?fK');
define('LOGGED_IN_SALT',   '+;.itK?q@DjM+Rx>Q1-k8H9?VJ/IC)ZI,c/;]D|)IkTy4KjG~0XZz-T>{{6uFQRQ');
define('NONCE_SALT',       '&ezss%]4AxA45S?pu|M%a;BjNwI|Z=@7AP_97$3QOIP|c|wAMuNyo.Fyd9A#thpU');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
