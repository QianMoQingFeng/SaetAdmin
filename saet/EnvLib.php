<?php
namespace saet;

use think\facade\Env;

// 应用请求对象类
class EnvLib
{
    public static function setEnv(String $name,$value){


        $value=json_encode($value,JSON_UNESCAPED_UNICODE);
        Env::offsetSet($name,$value);
        $envArray =Env::get();
        ksort($envArray);

        $envPath = root_path() . DIRECTORY_SEPARATOR . '.env';
        $inicontent= self::arr_trinsform_ini($envArray);

        $fp = fopen($envPath, "w") or die("Couldn't open $envPath");
        fputs($fp,$inicontent);
        fclose($fp);

    }
    
    // 获取分组变量
    public static function getEnvGroup(String $group){
        $envArray =Env::get();
        dump($envArray);
        ksort($envArray);
        $arr = [];
        foreach ($envArray as $k => $v) {
            $key=explode('_',$k);
            if($group == $key[0]){
                $arr[$key[1]] = $v;
                break;
            }
        }
        return $arr;
    }
 
    protected static function arr_trinsform_ini(array $a, array $parent = array()){
        $out = '';
        $keysindent=[];
        $key_num = 0;
        foreach ($a as $k => $v) {
            $key_num++;
            if (is_array($v)) {
                $sec = array_merge((array) $parent, (array) $k);
                $out .= '[' . join('.', $sec) . ']' . PHP_EOL;
                $out .= self::arr_trinsform_ini($v, $sec);
            }
            else {
                $key=explode('_',$k);
                if(count($key)>1 && !in_array($key[0],$keysindent)){
                    $keysindent[]=$key[0];
                    
                    if( $key_num>1){
                        $out .=PHP_EOL.PHP_EOL;
                    }

                    $out .="[$key[0]]".PHP_EOL;
                    unset($key[0]);
                    $out .= implode('_',$key)." = $v" . PHP_EOL;
                    unset($key);
                }elseif (count($key)>1 && in_array($key[0],$keysindent)){
                    unset($key[0]);
                    $out .= implode('_',$key)." = $v" . PHP_EOL;
                }else{
                    $out .= "$k = $v" . PHP_EOL;
                }
            }
        }
        return $out;
    }


}
