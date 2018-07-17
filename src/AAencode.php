<?php
/**
 * Created by PhpStorm.
 * User: zcm
 * Date: 2018/6/26
 * Time: 12:06
 */

namespace Zcmzc;


class AAEncode
{
    private static $feature = [
        'header'  => "\(ﾟεﾟ\+\(ﾟДﾟ\)\[ﾟoﾟ\]\+ ",
        'footer'  => "(ﾟДﾟ)[ﾟoﾟ]) (ﾟΘﾟ)) ('_');",
        'replace' => [
            "(c^_^o)+",
            "(ﾟΘﾟ)+",
            "((o^_^o) - (ﾟΘﾟ))+",
            "(o^_^o)+",
            "(ﾟｰﾟ)+",
            "((ﾟｰﾟ) + (ﾟΘﾟ))+",
            "((o^_^o) +(o^_^o))+",
            "((ﾟｰﾟ) + (o^_^o))+",
            "((ﾟｰﾟ) + (ﾟｰﾟ))+",
            "((ﾟｰﾟ) + (ﾟｰﾟ) + (ﾟΘﾟ))+",
            "(ﾟДﾟ) .ﾟωﾟﾉ+",
            "(ﾟДﾟ) .ﾟΘﾟﾉ+",
            "(ﾟДﾟ) ['c']+",
            "(ﾟДﾟ) .ﾟｰﾟﾉ+",
            "(ﾟДﾟ) .ﾟДﾟﾉ+",
            "(ﾟДﾟ) [ﾟΘﾟ]+"
        ]
    ];

    /**
     * @param string $code
     * @return string
     */
    public static function decode(string $code): string
    {
        //掐头去尾
        $code = preg_replace("#.*?".self::$feature['header']."#", '', $code);
        $code = str_replace([self::$feature['footer'], '(oﾟｰﾟo)+ '], '', $code, $count);
        if (! $count){
            return $code;
        }
        //字符转数字
        $code = str_replace(self::$feature['replace'], array_keys(self::$feature['replace']), $code);
        //8位转字符
        $code = preg_replace_callback(
            '#\(ﾟДﾟ\)\[ﾟεﾟ\]\+(?<num>[0-9 ]+)#',
            function($preg){
                $preg = explode(' ', trim($preg['num']));
                if(count($preg) > 3){
                    array_walk($preg, function(&$v){
                        $v = dechex($v);
                    });
                    $preg = hexdec(implode('', $preg));
                    $preg = html_entity_decode('&#'.$preg.';',ENT_NOQUOTES,'UTF-8');
                }else{
                    $preg = chr(octdec(implode('', $preg)));
                }
                return $preg;
            },
            $code
        );
        return $code;
    }
}