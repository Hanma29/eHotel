<?php

session_start();
$_SESSION['errors'] = array();
$_SESSION['alerts'] = array();

function clearErrorLog() {
    $_SESSION['errors'] = array();
}

function clearAlerts() {
    $_SESSION['alerts'] = array();
}

function logErrorToDisplay($error) {

    clearErrorLog();

    array_push($_SESSION['errors'], $error);
}

function alertToDisplay($alert) {

    clearAlerts();

    array_push($_SESSION['alerts'], $alert);
}

function hasOustandingErrors(){
     $errors = $_SESSION['errors'];
     if(sizeof($errors) > 0){
        return true;
     }

     return false;
}

function getErrorsFormatted(){
    $html = '';
    
    foreach ($_SESSION['errors'] as $error) {
        $html.='<div class="flex space-y-4"> 
        <div role="alert" class="alert alert-warning w-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
        <span>'.$error.'</span>
         </div>
        </div>';
    }

    return $html;
}

function hasAlerts(){
    $alerts = $_SESSION['alerts'];
    if(sizeof($alerts) > 0){
       return true;
    }

    return false;
}

function getAlertsFormatted(){
   $html = '';
   
   foreach ($_SESSION['alerts'] as $alert) {
       $html.='<div class="flex space-y-4"> 
       <div role="alert" class="alert alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span>'.$alert.'</span>
        </div>
       </div>';
   }

   return $html;
}