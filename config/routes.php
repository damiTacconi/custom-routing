<?php

use config\Route;

//Route::verb(path , controller , method)

Route::get("/" , "HomeController", "index");

Route::get("/greetings/{name:any}", "HomeController", "greetings");

Route::get("/person/{name:string}/{age:integer}/info", "HomeController", "info");

Route::post("/person/{name:string}", "PersonController", "message");
