<?php


namespace App\MyClasses\Cli;

use App\MyClasses\Directory;
use App\MyClasses\CliFormat;
use App\Property;
use Illuminate\Support\Facades\DB;
use File;

class CliCleanup {


    protected $option;
    protected $active_class;

    public static function directories_options(){
        //get a list of directories in the resources/views/properties directory
        Directory::delete_orphan_folders('resources/views/properties');

        Directory::delete_orphan_folders('public/properties');



    }


}