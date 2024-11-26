<?php

const db_host = "localhost";
const db_user = "root";
const db_password = "";
const db_name = "shoper_vission";

const DB = new mysqli(db_host, db_user, db_password, db_name);
if(DB-> errno < 0){
    die("Error connecting to DB");
    
}





   
    

?>