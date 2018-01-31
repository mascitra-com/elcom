<?php
/**
 * 
 * @package CodeIgniter
 * @category Helpers
 * @author Andre Hardika (andrehardika@gmail.com)
 */
if (!function_exists('cek_file')) {
	/**
     * Membenarkan format url
     *
     * @param string $url
     *
     * @return string $url
     */
	function pretty_url($url){
		$pretty_url = preg_replace('/([^:])(\/{2,})/', '$1/', $url);
		return $pretty_url;
		dump($pretty_url);
	}
}
?>