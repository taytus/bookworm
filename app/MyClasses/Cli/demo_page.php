<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 3/6/19
 * Time: 10:38 AM
 */

/////

The path to the different assets should be prefixed with:

{{$img}} for images
{{$css}} for stylesheets
{{$js}} for javascript files
{{$json}} for JSON files

              The local assets should be inside:

assets/img for images
               assets/css for Stylesheets
                              assets/js for Javascript files
                                            assets/json for JSON files

                                                            The declarations for the variables will be in the same file either if using PHP (recommended) or not and will be inside the following code block.

<?php


echo $var;
?>
<img src="<?php echo $var;?>">

/**ROBOAMP INIT VARS BLOCK**/


$img="some_root_path_for_images"


/**ROBOAMP END VARS BLOCK**/


https://robowiki.kanuca.com/link/30#bkmrk-%3F%3E

?>


<HTML>


<body>

<nav_bar>

</nav_bar>

<footer>
</footer>
</body>


</html>




//output is some string or some HTML;