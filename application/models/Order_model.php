<?php
class Order_model extends CI_Model
{
    public function get_all()
    {
        return $this->db->get("tbl_pinjam");
    }

    public function insert($table, $data)
    {
        return $this->db->insert($table, $data);
    }
}
