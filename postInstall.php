<?php

namespace wordpressInit;

class postInstall {
    function __construct() {}

    function init()
    {
        self::downloadRepo();
    }

    static public downloadRepo() {
        $cmd = 'cd ' .  dirname(__FILE__) .  DIRECTORY_SEPARATOR . 'htdocs;';
        $cmd .= ' git clone '. $_ENV['repo'];
        shell_exec($cmd);
    }


    static public runComposer() 
    {

        $cmd = 'cd ' .  dirname(__FILE__) .  DIRECTORY_SEPARATOR . 'htdocs/wp-content;';
        $cmd .= ' composer install -n';
        shell_exec($cmd);
    }



    static public moveRootFiles() {
        self::copy(
            dirname(__FILE__) .  DIRECTORY_SEPARATOR . 'htdocs/wp-content/root',
            dirname(__FILE__) .  DIRECTORY_SEPARATOR . 'htdocs/',
        );
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
     * clone the repo listed in the env file
     */
    static public cloneRepo() {

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