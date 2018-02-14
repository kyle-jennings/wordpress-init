<?php

namespace wordpressInit;
require_once "./vendor/autoload.php";
use Dotenv;

$dotenv = new Dotenv\Dotenv( dirname(__DIR__) );
$dotenv->load();

class postInstall {
    function __construct() {
        
    }

    static public function init()
    {
        self::cloanRepo();
        self::runComposer();
        self::moveRootFiles();
    }


    /**
     * Download the repo from the env file
     * @return [type] [description]
     */
    static public function cloanRepo() {

        $dst = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'htdocs';
        if( !isset($_ENV['GITHUB']) || is_readable($dst . '/wp-content') )
            return;

        $cmd = 'cd ' .  $dst;
        $cmd .= ' git clone '. $_ENV['GITHUB'] . ' wp-content';
        shell_exec($cmd);
    }


    /**
     * run composer on the downloaded repo
     * @return [type] [description]
     */
    static public function runComposer() 
    {

        $cmd = 'cd ' .  dirname(__FILE__) . DIRECTORY_SEPARATOR . 'htdocs/wp-content;';
        $cmd .= ' composer install -n';

        shell_exec($cmd);
    }


    /**
     * Move any files from the "root" folder up to htdocs
     *
     * These are usuall just a htaccess file, and webapp stuff
     * @return [type] [description]
     */
    static public function moveRootFiles() {

        $src = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'htdocs/wp-content/root';
        $dst = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'htdocs';

        if(!is_readable($src)){
            echo('no root folder found.');
            copy($dst . DIRECTORY_SEPARATOR . '.htaccess-template', $dst . DIRECTORY_SEPARATOR . '.htaccess')
            return;
        }

        self::copy(
            $src,
            $dst
        );

        if(!is_readable($src . DIRECTORY_SEPARATOR . '.htaccess'))
            copy($dst . DIRECTORY_SEPARATOR . '.htaccess-template', $dst . DIRECTORY_SEPARATOR . '.htaccess')
    }


    /**
     * Recursivily copy files
     * @param  string $src path/to/src_file
     * @param  string $dst path/to/dest
     */
    static public function copy( $src, $dst ) {
        if( !defined('DS') ) define( 'DS', DIRECTORY_SEPARATOR );

        $dir = opendir( $src );

        // make the destination folder if it doesnt exist
        if(!is_readable($dst)){
            mkdir( $dst, 0777, true );
        }

        while( false !== ( $file = readdir( $dir ) ) ) {
            if( $file != '.' && $file != '..' ) {
                if( is_dir( $src . DS . $file ) ) {
                    self::copy( $src . DS . $file, $dst . DS . $file );
                } else {
                    if(is_readable($src . DS . $file))
                        copy( $src . DS . $file, $dst . DS . $file );
                }
            }
        }
        closedir( $dir );
    }


    /**
     * Helper function to examine an object or array
     */
    static public function examine($val = array(), $mode = null)
    {
        if( empty($val) && $mode != 'vardump' )
            return;
        echo "<pre>";
        print_r($val);
        die;
    }
}