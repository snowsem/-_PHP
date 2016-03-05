<?php

/**
 * Created by PhpStorm.
 * User: semenpatnickij
 * Date: 05.03.16
 * Time: 13:43
 */
class QAR
{
    private $host;
    private $username;
    private $password;
    private $db;
    protected $init;

    function __construct() {
        $ini_array = parse_ini_file("config.ini");
        //var_dump($ini_array);
        $this->host = $ini_array['host'];
        $this->username = $ini_array['username'];
        $this->password = $ini_array['password'];
        $this->db = $ini_array['db'];

        $this->connect();

    }

    protected function connect() {
        $this->init = mysql_connect($this->host,$this->username,$this->password);
        if (!$this->init) {
            echo("<P>Cервер базы данных не доступен</P>");
            exit();
        }
        if (!@mysql_select_db($this->db, $this->init)) {
            echo( "<P>В настоящий момент база данных не доступна, поэтому корректное отображение страницы невозможно.</P>" );
            exit();
        }
        mysql_query("SET NAMES 'utf8'");
        mysql_query("SET CHARACTER SET 'utf8'");
    }

    public function get_subject($id) {
        $id =  mysql_real_escape_string($id);
        $ath = mysql_query("SELECT * FROM KLADR  WHERE `CODE` LIKE '%00000000000' AND `NAME` LIKE '%$id%'");
        $arr='';
        if($ath)
        {
            while($row = mysql_fetch_array($ath, MYSQL_ASSOC)) {
                $arr[] = array('id'=>$row['CODE'], 'name'=>$row['NAME'].' '.$row['SOCR'], 'GNINMB' => $row['GNINMB']);
                //print $row['NAME'];
            }
            print json_encode($arr);
        }
        else
        {
            echo "<p><b>Error: ".mysql_error()."</b></p>";
            exit();
        }

    }
    public function get_city($query, $param) {
        $id =  mysql_real_escape_string($query);
        $q = mysql_real_escape_string($param);
        //AND NAME  LIKE '%$id%'
        $sub = substr($q, 0, 2);
        //echo  $sub;
        $ath = mysql_query("SELECT * FROM KLADR  WHERE `CODE` LIKE '$sub%'  and NAME LIKE '%$id%'");
        $arr='';
        if($ath)
        {
            while($row = mysql_fetch_array($ath, MYSQL_ASSOC)) {
                if ($q == $row['CODE'] and ($row['SOCR'] != 'г')) {}
                else {

                    $arr[] = array('id' => $row['CODE'], 'name' => $row['NAME'] . ' ' . $row['SOCR'], 'GNINMB' => $row['INDEX']);
                }
            }
            print json_encode($arr);
        }
        else
        {
            echo "<p><b>Error: ".mysql_error()."</b></p>";
            exit();
        }

    }
    public function get_street($query, $param) {
        $id =  mysql_real_escape_string($query);
        $q = mysql_real_escape_string($param);
        //AND NAME  LIKE '%$id%'
        $sub = substr($q, 0, 8);
        $ath = mysql_query("SELECT * FROM STREET  WHERE CODE LIKE '$sub%' and NAME LIKE '%$id%'");
        $arr='';
        if($ath)
        {
            while($row = mysql_fetch_array($ath, MYSQL_ASSOC)) {
                $arr[] = array('id'=>$row['CODE'], 'name'=>$row['NAME'].' '.$row['SOCR'], 'GNINMB' => $row['GNINMB']);
            }
            print json_encode($arr);
        }
        else
        {
            echo "<p><b>Error: ".mysql_error()."</b></p>";
            exit();
        }
    }

    public function get_passport_code($query) {
        $id =  mysql_real_escape_string($query);
        $ath = mysql_query("select  * from passport_who  where id LIKE '$id' limit 1");
        if($ath)
        {
            while($row = mysql_fetch_array($ath, MYSQL_ASSOC)) {
                //print json_encode($row);
                print $row['who'];
            }
        }
        else
        {
            echo "<p><b>Error: ".mysql_error()."</b></p>";
            exit();
        }

    }




}


?>