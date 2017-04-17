<?php

class DB
{
    public function __construct()
    {

    }
    public function DB()
    {

    }
    function connect_db($host, $user, $pwd, $dbname)
    {

    }

    function select($field,$table,$query)
    {

    }

    function select_all($table,$query)
    {

    }

    function insert($table,$query1,$query2)
    {

    }

    function update($table,$query1,$query2)
    {

    }

    function delete($table,$query)
    {

    }
    function fetch_array()
    {
        return mysqli_fetch_array($this->_queryResource);
    }
}