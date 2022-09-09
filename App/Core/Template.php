<?php
 
namespace Core;
 
class Template {
    public static function render($viewPath){
        if ($content = self::loadTemplate($viewPath)){
            preg_match_all("/{{([^}}]*)}}/", $content, $matches);
            foreach($matches[1] as $key => $value) {
                preg_match_all("/(.*)\.(.*)\(([^\)]*)\)/", trim($value), $matchesFunction);

                if (isset($matchesFunction[0]) && isset($matchesFunction[0][0])) {
                    $className = trim($matchesFunction[1][0]);
                    $methodName = trim($matchesFunction[2][0]);
                    $arguments = explode (",",trim($matchesFunction[3][0]));

                    if (class_exists($className) && method_exists($className, $methodName)){
                        $resultat = call_user_func_array([$className,$methodName],$arguments);
                        $content = str_replace($matches[0][$key],$resultat,$content); 
                    }
                }

                


            }
            echo $content;
        }


    }

    
    
    public static function loadTemplate($viewPath) {
        $viewPath = __DIR__."/../Views/".$viewPath;
        if (file_exists($viewPath)) {
            ob_start();
            require $viewPath;
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        }
        return false;
    }
}