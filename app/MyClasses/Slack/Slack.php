<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 9/10/18
 * Time: 9:51 AM
 */


namespace App\MyClasses\Slack;


use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Messages\SlackAttachment;
class Slack extends SlackMessage {

    public $attachment;

    public function action(){
        dd($this->attachment);
    }
    public function attachment(Closure $callback){
        dd("boo!");
    }
} 