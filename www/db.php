
<?php

class db{
    public function __construct(){
       
        $this->dblink = mysqli_connect("172.30.0.2","root","root","staff");

        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error()); 
            exit();
        }
        $this->dblink->set_charset("utf8");
    }

    public function query($sql){ 
        $this->last = $this->dblink->query($sql);
       
        if ($this->last === false) throw new Exception('Database error: '.$this->dblink->error);
      
        return $this;
    }

    public function all() { 
        $result = array();
        while ($row = $this->last->fetch_assoc()) $result[] = $row;
        return $result;
    }


}