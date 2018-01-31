<?php
/**
 * CodeIgniter Dump Helpers
 * 
 * @package CodeIgniter
 * @category Helpers
 * @author Youssef JLIDAT (jlidat@gmail.com)
 * @version 1.0
 */
 
if (!function_exists('dump')) {
    function dump ($var, $show = TRUE, $exit = FALSE) {

        // Add formatting
        $output  = '<pre>';
        $output .= var_dump($var);
        $output .= '</pre>';
        
        // Output
        if ($show == TRUE) {
            echo $output;
        }
        else {
            return $output;
        }
        
        //exit ?
        if ($exit == TRUE) {
            exit;
        }
        
    }
}

/* End of file dump_helper.php */
/* Location: ./application/helpers/dump_helper.php */
