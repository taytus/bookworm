<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 3/28/19
 * Time: 9:49 PM
 */

namespace App\MyClasses\Cli;
use PhpSchool\CliMenu\CliMenu;
use PhpSchool\CliMenu\MenuStyle;


class CLIAlert extends CliMenu {
    public $menu;

    public function __construct(CliMenu $menu){
        $this->menu=$menu;
    }

    public function error($error_message){

        $style=$this->set_style('info');

        $flash = $this->menu->flash($error_message,$style);

        $flash->display();
    }
    private function set_style($type){
        switch($type){
            case "error":
               return (new MenuStyle())->setBg('red')->setFg('white');
            break;
            case "info":
                return (new MenuStyle())->setBg('green')->setFg('white');
            break;
        }
    }

} 