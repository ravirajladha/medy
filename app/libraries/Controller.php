<?php
/* base controller
 * loads models and views
 */

 class Controller{
   // load model
   public function model($model){
     // require model file_copy
     require_once '../app/models/'. $model .'.php';
     // instantiate model
     return new $model();
   }
   // load views
   public function view($view, $data =[]){
     // check for view file
     if(file_exists('../app/views/'.$view.'.php')){
       require_once '../app/views/'.$view.'.php';
     } else{
       // view does not exists
       die('view does not exists');
     }
   }
 }
 ?>
