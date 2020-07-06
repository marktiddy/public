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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'ulMu+Rgg93O7DcTlUPGc4a2jCEKh5bXrBz5wZT4KDZn2BzcjEkOH+Q87qPQa5xupCQFjS1AhO6Esoc7RjEzhEw==');
define('SECURE_AUTH_KEY',  'Vg5XhfzFV2MQb1dC6ySVj279/RAfxt4CjGiI1j3FluTesG7hkkKEK83OhrEwlCnJg64YdVFmCLcHkt5OVVjU+Q==');
define('LOGGED_IN_KEY',    'YVU7H57df2Oco/TUvLstXZ1ZxuxFYkT1qYKqEDg+K4LSlI/oq5hZmfwTlo3M+kp4SJ4XWRn3Oixk/uHSQD6BXw==');
define('NONCE_KEY',        'UF/tVGFr3od3ilW7JhvmZqgmmKQRkGWuG/W0OEu8/AH4/3aG0geONjARByDfOBKI8+HvyngSxYJII2Bms0Haug==');
define('AUTH_SALT',        'DhHZ5IqVpOYHDeHv25v7dv+1TbyjTCOSC9oQHdJq2Wg0TEsOhNNBsw68gUuuy6sSG+qgRjxZm1Zjsx3ZQJf9eQ==');
define('SECURE_AUTH_SALT', 'jLywDx5/0ACOwW15isXyU9XxYeRR+T4R1WKI/saeM2v/X6V3iYVsCKP1O3rDfQ5dQCTN+Gv9vTxG3Gwl5IYzPQ==');
define('LOGGED_IN_SALT',   'nwj+YuN3UgOLRRoOoKbHqYBxDbVFAAlltNaD42OJBWUV6xmDOxHLvQ9CxA3YhPRqpr66jZg8gyDGXroOs+j3iw==');
define('NONCE_SALT',       '6M+/Xd7rN4swRQuyLRqO7K8kJXD2onorM886ZzmOjhuRixVkKGUQiu6frMyh4IcVPBnGam4O0aQVDykARlHQCg==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
