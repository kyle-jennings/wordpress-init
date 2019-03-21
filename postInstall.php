<?php

namespace wordpressInit;

require_once './vendor/autoload.php';
use Dotenv;

$dotenv = new Dotenv\Dotenv( dirname( __DIR__ ) );
$dotenv->load();

class PostInstall {

	public static function init() {
		self::cloneRepo();
		self::runComposer();
		self::moveRootFiles();
	}


	/**
	 * Download the repo from the env file
	 * @return [type] [description]
	 */
	public static function cloneRepo() {

		echo "Cloning the repo \n";
		$dst = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'public';
		if ( ! isset( $_ENV['GITHUB'] ) || is_readable( $dst . '/content' ) ) {
			return;
		}

		$cmd  = 'cd ' . $dst;
		$cmd .= ' git clone ' . $_ENV['GITHUB'] . ' content';
		shell_exec( $cmd );
	}


	/**
	 * run composer on the downloaded repo
	 * @return [type] [description]
	 */
	public static function runComposer() {

		echo "Running composer on downloaded project \n";
		$cmd  = 'cd ' . dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'public/content;';
		$cmd .= ' composer install -n';

		shell_exec( $cmd );
	}


	/**
	 * Move any files from the "root" folder up to public
	 *
	 * These are usuall just a htaccess file, and webapp stuff
	 * @return [type] [description]
	 */
	public static function moveRootFiles() {

		$src = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'public/content/root';
		$dst = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'public';

		echo "Moving applicable files to public (web root) \n";

		if ( ! is_readable( $src ) ) {
			echo 'no root folder found.';
			return;
		}

		self::copy(
			$src,
			$dst
		);
	}


	/**
	 * Recursivily copy files
	 * @param  string $src path/to/src_file
	 * @param  string $dst path/to/dest
	 */
	public static function copy( $src, $dst ) {
		if ( ! defined( 'DS' ) ) {
			define( 'DS', DIRECTORY_SEPARATOR );
		}

		$dir = opendir( $src );

		// make the destination folder if it doesnt exist
		if ( ! is_readable( $dst ) ) {
			mkdir( $dst, 0777, true );
		}

		while ( false !== ( $file = readdir( $dir ) ) ) {
			if ( $file !== '.' && $file !== '..' ) {
				if ( is_dir( $src . DS . $file ) ) {
					self::copy( $src . DS . $file, $dst . DS . $file );
				} else {
					if ( is_readable( $src . DS . $file ) ) {
						copy( $src . DS . $file, $dst . DS . $file );
					}
				}
			}
		}
		closedir( $dir );
	}


	/**
	 * Helper function to examine an object or array
	 */
	public static function examine( $val = array(), $mode = null ) {
		if ( empty( $val ) && $mode !== 'vardump' )
			return;
		echo '<pre>';
		print_r( $val );
		die;
	}
}
