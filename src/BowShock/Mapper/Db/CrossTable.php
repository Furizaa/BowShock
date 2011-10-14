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

use BowShock\Mapper\Db\BaseMapper;

/**
 * Cross Table Base Mapper
 *
 * @package    Mapper
 * @subpackage Db
 * @author     Andreas Hoffmann <furizaa@gmail.com>
 * @copyright  2010-2011 Andreas Hoffmann <furizaa@gmail.com>
 * @version    Release: $Id:$
 * @since      Class available since Release 1.0.0
 */
class CrossTable extends BaseMapper
{

    /**
     * Convert model to data array
     *
     * @throws \BowShock\Exception
     */
    public function toArray()
    {
        throw new \BowShock\Exception('toArray method not implemented in Cross Tables!');
    }

    /**
     * Save Model
     *
     * Save provided model to database. If the tables primary key is set
     * in the model, the database will be updated instead.
     *
     * @throws \BowShock\Exception
     */
    public function save()
    {
        throw new \BowShock\Exception('Save method not implemented in Cross Tables!');
    }

    /**
     * Find table row by primary key
     *
     * Find a table row by its unique primary key
     * and populate a model with its data.
     *
     * @throws \BowShock\Exception
     */
    public function find()
    {
        throw new \BowShock\Exception('Find method not implemented in Cross Tables!');
    }

    /**
     * Build model from db table row data
     *
     * @throws \BowShock\Exception
     */
    public function buildModelFromRow()
    {
        throw new \BowShock\Exception('buildModelFromRow method not implemented in Cross Tables!');
    }

    /**
     * Build list of models from rowset
     *
     * @throws \BowShock\Exception
     */ 
    public function buildListFromRowset()
    {
        throw new \BowShock\Exception('buildListFromRowset method not implemented in Cross Tables!');
    }

}