<?php

include 'Model.php';

class Controller
{

    public static function createTable()
    {
        $table = new Model();
        $table->createTable();
    }

    public static function UnsetPost() {
        unset($_POST);
    }

    public static function CreateToken()
    {
        return md5(session_id() . time());
    }

    public static function saveData()
    {
        if (isset($_POST['token']))
        {
            if ($_POST['token'] != $_SESSION['token'])
            {
                if (isset($_POST['textMessage']) && !empty($_POST['textMessage'])) {
                    $save = new Model();
                    $save->saveData();
                }
            }
        }
    }

    public static function getAllMessages()
    {
        $getAllMessages = new Model();
        return $getAllMessages->getAllData();
    }
}