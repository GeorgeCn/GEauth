<?php
/**
 * Created User: lifeng
 * Create Date: 2018/4/14 15:05
 * Current User:lifeng
 * History User:lifeng
 * Description:工具类
 */

namespace Common\Helper;

class Util
{
    /**
     * @param $data
     * @return array
     * @author lifeng
     * @description:数组key下划线转驼峰
     */
    static function underlineToCamel($data)
    {
        $result = [];
        foreach ($data as $key => $item) {
            if (is_array($item)) {
                $result[self::toCamel($key)] = self::underlineToCamel($item);
            } else {
                $result[self::toCamel($key)] = $item;
            }
        }
        return $result;
    }

    /**
     * @param $str
     * @return null|string|string[]
     * @author lifeng
     * @description:下划线转驼峰
     */
    private static function toCamel($str)
    {
        $str = preg_replace_callback('/([-_]+([a-z]{1}))/i', function ($matches) {
            return strtoupper($matches[2]);
        }, $str);
        return $str;
    }

}