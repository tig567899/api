<?php

class database extends mysqli
{
	public function __construct($host=NULL, $user=NULL, $pass=NULL, $dbname=NULL, $port=NULL, $socket=NULL)
	{
       parent::__construct($host, $user, $pass, $dbname, $port, $socket);
       // check if a connection established
       if( mysqli_connect_errno() ) {
           throw new exception(mysqli_connect_error(), mysqli_connect_errno()); 
       }
    }
	public function prepare($query) {
        $stmt = new mysqli_stmt($this, $query);
        return $stmt;
    }
}
?>