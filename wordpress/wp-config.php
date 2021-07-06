<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp' );

/** MySQL database username */
define( 'DB_USER', 'wp' );

/** MySQL database password */
define( 'DB_PASSWORD', 'AAAaaa111' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'cx-6cRWq@(4uYU=4Pe{?FzumQNSLH<D/BexfN#p#@+4+.V`va9*VP2dU#f?<k1Eo' );
define( 'SECURE_AUTH_KEY',  '<P%VW-M9Q,x<7EShiXVD)p#684NIhYMFos/rHC pN1~{22%XN:OH@i% G1UUYl}*' );
define( 'LOGGED_IN_KEY',    'a>iiX%-2Q|XjxAZ%(v Oy2ZZAc ay2IVT6s</s9HhIrXaT!G3JE3pLni}nkmH]$J' );
define( 'NONCE_KEY',        ']r||2fD+pT~fjb_WV6Ce2iDtIg:1-{Di>g{(&^jB<T~_;aC.Z^<I_$^+y-4nWEna' );
define( 'AUTH_SALT',        ';^!. ,OsLHLGRdnFipWP~gNpK-5K,kQd}v6yw_RneU=!hGavy,&[Q^P_5HQ?hEN{' );
define( 'SECURE_AUTH_SALT', 'T/F;wZQS`If.pZ~`E-Y^:437I(JR(ie1b`DYf,tU{o{@vo>6p]>Ea65zv>R)9d@4' );
define( 'LOGGED_IN_SALT',   '4jnZe<[[N(Y8XSt`y!k%W>9*YSJ?t`_k%og@8Y,6bxd`_1@O4qA^h=X>P9WKRT<V' );
define( 'NONCE_SALT',       'A{QJ$WP[n1Fj*aWx;I1fEn3BO(ZyZp%TkLtL%g4I$3Qu,n@~Ufe90k-gk.ZKW2,f' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_kikiclub';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
