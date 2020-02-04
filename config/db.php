<?php
// TODO: connect to db by using defined variables from config file

// Check connection to DB
if (mysqli_connect_errno()) {
    //Connection field
    echo 'Failed the connect to mysql' . mysqli_connect_errno();
}