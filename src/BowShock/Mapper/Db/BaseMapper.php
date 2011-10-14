<?php
/**
 * BowShock
 *
 * @category   BowShock
 * @package    Mapper
 * @subpackage Db
 * @author     Andreas Hoffmann <furizaa@gmail.com>
 * @copyright  2010-2011 Andreas Hoffmann <furizaa@gmail.com>
 * @since      File available since Release 1.0.0
 */

namespace BowShock\Mapper\Db;

use BowShock\EntityList,
	BowShock\Mapper\MapperException,
	BowShock\Model\DbTable\TableFactory,
	BowShock\Model\BaseModel;

/**
 * Base Database Mapper
 *
 * @package    Mapper
 * @subpackage Db
 * @author     Andreas Hoffmann <furizaa@gmail.com>
 * @copyright  2010-2011 Andreas Hoffmann <furizaa@gmail.com>
 * @version    Release: $Id:$
 * @since      Class available since Release 1.0.0
 */
class BaseMapper
{

    /**
     * @var \Zend_Db_Table_Abstract
     */
    private $registeredDbTable;

    /**
     * Convert model to data array
     *
     * @param  BaseModel $model
     * @return Array
     */
    public function toArray(BaseModel $model)
    {
        $mappedData = array('created_at' => $model->getCreatedAt(),
                            'updated_at' => $model->getUpdatedAt(),
                            'id' => $model->getId());

        return $mappedData;
    }

    /**
     * Register Db Table Instance this mapper will use.
     *
     * @param \Zend_Db_Table_Abstract $dbTable
     */
    public function registerDbTable(\Zend_Db_Table_Abstract $dbTable)
    {
        $this->registeredDbTable = $dbTable;
    }

    /**
     * Retrieve registered Db Table Instance
     *
     * @return \Zend_Db_Table_Abstract
     */
    public function getDbTable()
    {
        if (is_null($this->registeredDbTable)) {
            $tableFactory = TableFactory::getInstance();
            $tableToRegister = $tableFactory->createMappedTable(get_class($this));
            $this->registerDbTable($tableToRegister);
        }
        return $this->registeredDbTable;
    }

    /**
     * Save Model
     *
     * Save provided model to database. If the tables primary key is set
     * in the model, the database will be updated instead.
     *
     * @param  \BowShock\Model\Base $model
     * @param  array		        $data
     * @return void
     */
    public function save(\BowShock\Model\Base $model, array $data)
    {
        if (NULL === ($primaryVal = $model->getId())) {
            $data['created_at'] = date('Y-m-d H:i:s');
            unset($data['id']);
            $this->getDbTable()->insert($data);
            $primaryVal = $this->getDbTable()
                ->getAdapter()
                ->lastInsertId();

            $model->setOptions(array('id' => $primaryVal));
        } else {
            unset($data['created_at']);
            $this->getDbTable()->update($data, array('id = ?' => $primaryVal));
        }
    }

    /**
     * Find table row by primary key
     *
     * Find a table row by its unique primary key
     * and populate a model with its data.
     *
     * @param  Integer | String $primaryIndex
     * @param  \BowShock\Model\Base $model
     * @return \BowShock\Model\Base Return populated model or NULL if no row could be
     * found.
     */
    public function find($primaryIndex, \BowShock\Model\Base $model)
    {
        $tableRows = $this->getDbTable()->find($primaryIndex);
        if (0 == count($tableRows)) {
            return null;
        }
        $model->setOptions($tableRows->current()->toArray());
        return $model;
    }

    /**
     * Build model from db table row data
     *
     * @param \BowShock\Model\Base $model
     * @param \Zend_Db_Table_Row $row
     * @return BowShock_Model_Base
     */
    public function buildModelFromRow(\BowShock\Model\Base $model, \Zend_Db_Table_Row $row)
    {
        $model->setOptions($row->toArray());
        return $model;
    }

    /**
     * Build list of models from rowset
     *
     * @param EntityList $list
     * @param string $className
     * @param \Zend_Db_Table_Rowset $rowset
     * @throws MapperException
     * @return EntityList
     */
    public function buildListFromRowset(EntityList $list, $className, \Zend_Db_Table_Rowset $rowset)
    {
        if (!class_exists($className, false)) {
            throw new MapperException("Model Class $className not found!");
        }
        while ($rowset->valid()) {
            $model = new $className();
            $this->buildModelFromRow($model, $rowset->current());
            $list->add($model);
            $rowset->next();
        }
        return $list;
    }

    /**
     * Start Database Transaction
     *
     * @throws MapperException
     */
    public function startTransaction()
    {
        try {
            $this->getDbTable()->getAdapter()->beginTransaction();
        } catch (\PDOException $e) {
            throw new MapperException('Cannot start transaction.', 0, $e);
        }
    }

    /**
     * Rollback Database Transaction
     *
     * @throws MapperException
     */
    public function rollbackTransaction()
    {
        try {
            $this->getDbTable()->getAdapter()->rollBack();
        } catch (\PDOException $e) {
            throw new MapperException('Cannot rollback transaction.', 0, $e);
        }
    }

    /** 
     * Commit Database Transaction
     *
     * @throws MapperException
     */
    public function commitTransaction()
    {
        try {
            $this->getDbTable()->getAdapter()->commit();
        } catch (\PDOException $e) {
            throw new MapperException('Cannot commit transaction.', 0, $e);
        }
    }

}