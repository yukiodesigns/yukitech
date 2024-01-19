<?php

/** 
 * Get the base path
 * @param string $path
 * @return string
 */

 function basePath($path = ''){
    return __DIR__.'/'.$path;
 }

 /**  
  * Load a view
  * @param string $name
  * @return void 
  */
  function loadView($name, $data=[]){
   $viewpath= basePath("App/views/{$name}.view.php");
   if(file_exists($viewpath)){
      extract($data);
      require $viewpath;
   }else{
      echo "View '{$name} not found";
   }
  }

   /**  
  * Load a partial
  * @param string $name
  * @return void 
  */
  function loadPartial($name){
   $partial = basePath("App/views/partials/{$name}.php");
   if(file_exists($partial)){
      require $partial;
   }else{
      echo "Partial '{$name} not found";
   }
  }

  /** 
   * Inspect a value
   * @param mixed $value
   * @return void
   */
  function inspect($value){
   echo '<pre>';
   var_dump($value);
   echo '</pre>';
  }

  /** 
   * Inspect a value nad die
   * @param mixed $value
   * @return void
   */
  function inspectAndDie($value){
   echo '<pre>';
   var_dump($value);
   echo '</pre>';
   die();
  }

  /** 
   * Format salary
   * @param string $salary
   * @return string Formatted Salary
   */
  function formatSalary($salary){
   return '$'.number_format(floatval($salary));
  }