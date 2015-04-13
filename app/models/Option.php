<?php
class Option extends BaseModel {
    public $primaryKey = 'key';

    /**
     * 批量保存设置
     * @param $items
     */
    public static function setVals($items)
    {
        foreach ($items as $key=>$value) {
            self::setVal($key,$value);
        }
    }

    /**
     * 保存单个设置
     * @param $key
     * @param string $value
     * @return bool
     */
    public static function setVal($key,$value="")
    {
        $option = self::where('key','=',$key)->first();
        if (!$option) {
            $option = new self;
            $option->key = $key;
            $option->value = $value;
        } else {
            $option->value = $value;
        }
        return $option->save();
    }

}