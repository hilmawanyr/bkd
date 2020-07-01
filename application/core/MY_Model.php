<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

	/*
	 * --------------------------------------------------------------
     * VARIABLES
     * --------------------------------------------------------------
     * 
    */

    /**
     * This model's default database table. Automatically
     * guessed by pluralising the model name.
     */
    protected $_table;

    /**
     * This model's default primary key or unique identifier.
     * Used by the get(), update() and delete() functions.
     */
    protected $primaryKey = 'id';


	public function __construct()
	{
		parent::__construct();
		$this->load->helper('inflector');

		$this->_fetch_table();
	}

	/**
	 * Find Data
	 * 
	 * @param  string tableName but is optional
	 * @param  string or array $value 
	 * @return object
	 */
	public function find($value='')
	{
		if (func_num_args() == 2) {
			$this->_table = func_get_arg(0);
		}

		$value = func_get_arg(1);

		if (is_array($value)) {
			$condition = $value;
		}else{
			$condition = [ $this->primaryKey => $value ];
		}
		
		return $this->db->get_where($this->_table, $condition);
	}

	/**
	 *	Insert
	 * @param  string $tableName optional
	 * @return  Bool
	 */
	public function insert($data='')
	{

		if (func_num_args() == 2) {
			$this->_table = func_get_arg(0);
			$data = func_get_arg(1);
		}

		return $this->db->insert($this->_table, $data);
	}

	/**
	 * Update
	 * @param  array  $data      
	 * @param  array  $condition 
	 * @return Bool
	 */
	public function update($data=[], $condition = [])
	{
		if (func_num_args() > 2) {
			$this->_table = func_get_arg(0);

			$data      = func_get_arg(1);
			$condition = func_get_arg(2);
		}

		return $this->db->update($this->_table, $data, $condition);
	}

	/**
	 * Delete
	 * remove data from database
	 */
	public function delete($data='')
	{
		if (func_num_args() == 2) {
			$this->_table = func_get_arg(0);
			$data = func_get_arg(1);
		}

		return $this->db->delete($this->_table, $data);
	}

	public function findAll()
	{
		if (func_num_args() > 0) {
			$this->_table = func_get_arg(0);
		}
		return $this->db->get($this->_table);
	}
	
	
	/**
     * Guess the table name by pluralising the model name
     */
    private function _fetch_table()
    {
        if ($this->_table == NULL)
        {
            $this->_table = plural(preg_replace('/(_m|_model)?$/', '', strtolower(get_class($this))));
        }
    }

    /**
     * Guess the primary key for current table
     */
    private function _fetch_primary_key()
    {
        if($this->primaryKey == NULl)
        {
            $this->primaryKey = $this->db->query("SHOW KEYS FROM `".$this->_table."` WHERE Key_name = 'PRIMARY'")->row()->Column_name;
        }
    }

}

/* End of file MY_Model.php */
/* Location: ./application/models/MY_Model.php */