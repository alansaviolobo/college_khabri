<?php
class MProducts extends Model{
    function MProducts(){
        parent::Model();
    }
    function getProduct($id){
        $data = array();
        $options = array('id' => $id);
        $Q = $this->db->getwhere(products,$options,1);
        if ($Q->num_rows() > 0){
            $data = $Q->row_array();
        }
        $Q->free_result();
        return $data;
    }
    function getAllProducts(){
        $data = array();
        $Q = $this->db->get('products');
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }
}?>
