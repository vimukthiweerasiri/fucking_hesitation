<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'rockinDBepej');

/** MySQL database username */
define('DB_USER', 'rockinDBepej');

/** MySQL database password */
define('DB_PASSWORD', 'DfULOGxor');

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
define('AUTH_KEY',         '>cz}F7Mbu,7Mbr^FYn^3Jcv,4Jcr,4FRcoz|0BNYoz|0CNZkz:CVk-[CNZo-|1CO');
define('SECURE_AUTH_KEY',  '[kk|Ghs@[1COZhs~[5COZhs~[5COZls~[5GOZlw~]5HSdlx_;9HSelx_;9LWep+#2');
define('LOGGED_IN_KEY',    'Dmx.;ALXiq+<2ALXiq$<2*<2EPXiu*{2EPbju*{6EQbnu^{7IQbny^{7IUfny,7I');
define('NONCE_KEY',        'g4Rk@0Jcw[8Nds!4GVk-[CRl-[8Ol-#1COZlw_:DOalx_:9KWht_;9LWix_;9LWit');
define('AUTH_SALT',        '8s[GVp#DSl~9Odp~]5p+]6HSep+]6HTeq+<2DPamx<2EPbmy.ALXiu*{6ITfu^{6');
define('SECURE_AUTH_SALT', ';t5Wit*]66HTam<2EPamx.2EPbmy.AMXiu*{6ITfu^{IXju^{7IUfr${7IUfr$>3');
define('LOGGED_IN_SALT',   'qMqMn.Ef^BMYju^7IUfr$>3FQcnz>3FQcnzgr$3FQcnz^}7JRcnz!}8JVgoz|08');
define('NONCE_SALT',       '~a~Oait~]5HPamx_]6HTamx.]6HTamx.;AHTemx.;ALXiq+<2AMXjq$<3EQbju^{7');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);define('WP_ALLOW_MULTISITE', true);define('FS_METHOD', 'direct');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
