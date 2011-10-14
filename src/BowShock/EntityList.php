<?php
/**
 * BowShock
 *
 * @category   BowShock
 * @package
 * @subpackage
 * @author     Andreas Hoffmann <furizaa@gmail.com>
 * @copyright  2010-2011 Andreas Hoffmann <furizaa@gmail.com>
 * @since      File available since Release 1.0.0
 */

namespace BowShock;

use BowShock\EntityList\Iterator;

/**
 * EntityList
 *
 * @package
 * @subpackage
 * @author     Andreas Hoffmann <furizaa@gmail.com>
 * @copyright  2010-2011 Andreas Hoffmann <furizaa@gmail.com>
 * @version    Release: $Id:$
 * @since      Class available since Release 1.0.0
 */
class EntityList implements \IteratorAggregate, \Countable
{

    /**
     * @var array
     */
    private $data = array();

    /**
     * @see IteratorAggregate::getIterator()
     * @return Iterator
     */
    public function getIterator()
    {
        return new Iterator($this->data);
    }

    /**
     * (non-PHPdoc)
     * @see Countable::count()
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * Add Value to List
     *
     * @param mixed $value
     */
    public function add($value)
    {
        $this->data[] = $value;
    }

    /**
     * Clear complete list data
     */
    public function clear()
    {
        $this->data = array();
    }

    /**
     * Find a entry by it's getter get<expression> and
     * the value. Always will return the first found element.
     *
     * @param string $expression
     * @param mixed $value
     * @return mixed
     */
    public function find($expression, $value)
    {
        $expression = 'get' . ucfirst($expression);
        $iterator = $this->getIterator();
        while ($iterator->valid()) {
            $current = $iterator->current();
            if (is_object($current) && method_exists($current, $expression)) {
                if ($value === $current->$expression()) {
                    return $current;
                }
            }
            $iterator->next();
        }
        return null;
    }

}