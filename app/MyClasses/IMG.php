<?php
namespace App\MyClasses;

use Symfony\Component\Process\Process;
use Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use File;
use Intervention\Image\ImageManagerStatic;
use Image;


class IMG{

    private $assets;
    private $output_folders;
    private $data;
    private $formats;
    private $new_jpg_is_smaller;
    private $extension;

    function __construct($data){
        $this->setFormats();
        $this->setData($data);

    }




    public function setOutputFolders($output_folders){


        $this->output_folders = $output_folders;
    }
    public function getOutputFolders(){
        return $this->output_folders;
    }

    public function setAssets($assets){
        $this->assets = $assets;
    }
    public function setData($data){
        $this->data = $data;
        foreach ($data as $info){

            foreach ($this->getFormats() as $format){
                $this->create_folder($info['destination'],$format);

                call_user_func(array($this,'generate_'.$format),$info);
            }

        }
    }

    public function getData(){
        return $this->data;
    }

    public function getAssets(){
        return $this->assets;
    }


    public function setFormats(){
        $formats=['jpg','webp'];
        $this->formats = $formats;
    }
    public function getFormats()
    {
        return $this->formats;
    }
    private function generate_jpg($info){


        $img=Image::make(public_path($info['source']));
        $this->extension=($img->mime=='image/png')?'.png':'.jpg';

        $original_size=$img->filesize();
        $original_name=$img->filename;
        $new_file_name='../public/images/jpg/'.$info['destination'].$this->extension;
        $image_copy=$img->save($new_file_name,70);
        $copy_size=$image_copy->filesize();

        $this->setNewJpgIsSmaller(true);

        if($original_size<$copy_size) {
            File::copy(public_path($info['source']),$new_file_name);
            $this->setNewJpgIsSmaller(false);
        }

    }
    private function generate_webp($info){
        $webp='../public/images/webp/'.$info['destination'].'.webp';
        $source='../public/'.$info['source'];

        echo $webp."\n\n";
        echo $source."\n\n";
        echo "Current dir is ". getcwd()."  \n\n";

        $current_dir=basename(getcwd());
        $base_dir=basename(base_path());
        if($base_dir==$current_dir){
            chdir("bin");
        }else{
            chdir("../bin");
        }

        //dd(getcwd(),$current_dir);

        system('./cwebp 100 '. $source.' -o '. $webp);

        $original_size= File::size($source);
        $copy_size=File::size($webp);
        if($original_size<$copy_size) {
            if($this->getNewJpgIsSmaller()){
                $jpp_path='../public/images/jpg/'.$info['destination'].$this->extension;
                //copy the new jpg
                File::copy($jpp_path,$webp);
            }else{
                File::copy($source,$webp);

            }
        }




    }
    private function create_folder($destination,$format){


        $arr_folder=explode('/',$destination);
        $new_folder=array_pop($arr_folder);
        $new_dir="";
        foreach ($arr_folder as $dir){
            $new_dir.=$dir."/";
        }
        $new_dir=rtrim($new_dir,"/");
        $new_dir="../public/images/".$format."/".$new_dir;


        if(!File::isDirectory($new_dir)) {
            File::makeDirectory($new_dir, 0775, true, true);
            echo "\n\n NEW FOLDER HAS BEEN CREATED. FOLDER NAME :".ucwords($destination)."\n\n";

        }else{
            echo "nope, nothing has been created\n\n";
        }
    }


    public function setNewJpgIsSmaller($new_jpg_is_smaller){
        $this->new_jpg_is_smaller = $new_jpg_is_smaller;
    }

    public function getNewJpgIsSmaller(){
        return $this->new_jpg_is_smaller;
    }


}