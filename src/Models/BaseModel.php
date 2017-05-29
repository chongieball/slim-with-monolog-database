<?php 

namespace App\Models;

abstract class BaseModel
{
    protected $table;
    protected $column;
    protected $db;
    protected $query;
    protected $check; //column you want to check

    public function __construct($db = null)
    {
        $this->db = $db;
        $this->query = null;
    }

    protected function setDb()
    {
        global $container;

        $this->db = $container['db'];
    }

    protected function getBuilder()
    {
        if ($this->db == null) {
            $this->setDb();
        }
        return $this->db->createQueryBuilder();
    }

    /**
     * conditional find
     * @param  string/array $column db column name
     * @param  string $operator find operator
     * @param  string $value  value
     * @return this model
     */
    public function find($column, $value = null, $operator = '=')
    {
        $param = ':'.$column;
        $qb = $this->getBuilder();
        $this->query = $qb->select($this->column)
                     ->from($this->table);
        if (is_array($column)) {
            foreach ($column as $key => $value) {
                if (is_numeric($key) && is_array($value)) {
                    $column = current($value);
                    $param = ':'.$column;
                    $valueParam = end($value);
                    $qb->andWhere($column.$value[1].$param)
                       ->setParameter($param, $valueParam);
                }
            }
        } else {
            $qb->where($column.$operator.$param)
               ->setParameter($param, $value);
        }
        return $this;
    }

    public function fetchAll()
	{
		return $this->query->execute()->fetchAll();
	}

	public function fetch()
	{
		return $this->query->execute()->fetch();
	}

	/**
	 * Create New Data
	 * @param  array  $data column and value
	 * @return int id rows
	 */
	public function create(array $data)
    {
        $column = [];
        $paramData = [];
        foreach ($data as $key => $value) {
            $column[$key] = ':'.$key;
            $paramData[$key] = $value;
        }
        $qb = $this->getBuilder();
        $qb->insert($this->table)
           ->values($column)
           ->setParameters($paramData)
           ->execute();

        return (int) $this->db->lastInsertId();
    }
}