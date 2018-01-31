<?php
/**
 * 
 * @package CodeIgniter
 * @category Helpers
 * @author Andre Hardika (andrehardika@gmail.com)
 */
if (!function_exists('ambil_sub_kategori')) {
	function ambil_sub_kategori($id){
	    
        $ci=& get_instance();
    $ci->load->database(); 

    $sql ="SELECT name FROM categories where id='$id'"; 
    
    $query = $ci->db->query($sql);
    $row = $query->row();
    return $row->name;
    }
}
?>