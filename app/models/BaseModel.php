<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

abstract class BaseModel extends Eloquent {
    public $errors = [];
    public $timestamps = false;

    public function pushError($error = "")
    {
        if(!empty($error)){
            array_push($this->errors,$error);
        }
    }

    public function getLastError()
    {
        return array_pop($this->errors);
    }

    public static function ifSoftDelete()
    {
        return isset(self::$softDelete) && self::$softDelete == true;
    }
}

trait SoftDeleteTrait {
    use SoftDeletingTrait;
    public static $softDelete = true;
}