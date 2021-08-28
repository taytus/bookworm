<?
namespace App\MyClasses;
function pre_entities($matches) {
    return str_replace($matches[1],htmlentities($matches[1]),$matches[0]);
}
//to html entities;  assume content is in the "content" variable
