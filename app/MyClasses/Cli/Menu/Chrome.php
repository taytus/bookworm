<?php

namespace App\MyClasses\Cli\Menu;

use App\MyClasses\Cli\CliMenu;
use App\MyClasses\Files;
use App\MyClasses\Paths;
use DB;

class Chrome{

    private $cli;
    private $menu_options;
    private $master_menu;
    private $output;
    private $apply_to_all=true;

    public function __construct($cli=null){
       $this->cli=$cli;
    }

    //take all the assets inside ROBOChrome folder and copy them to dropbox
    public function export_chrome_extension($cli){

        $origin=Paths::path_to_folder('robochrome');
        $destination=Paths::path_to_folder('dropbox');
        $real_path=realpath($destination);

        $files=new Files();
        $res=$files->copy_folder($origin,$destination.'ROBOChrome');
        echo "Extension has been copied\n";

    }



}