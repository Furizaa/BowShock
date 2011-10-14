<?php
/**
 * BowShock
 *
 * @category   BowShock
 * @package    List
 * @subpackage
 * @author     Andreas Hoffmann <furizaa@gmail.com>
 * @copyright  2010-2011 Andreas Hoffmann <furizaa@gmail.com>
 * @since      File available since Release 1.0.0
 */

namespace BowShock\EntityList;

/**
 * List Iterator
 *
 * @package    List
 * @subpackage
 * @author     Andreas Hoffmann <furizaa@gmail.com>
 * @copyright  2010-2011 Andreas Hoffmann <furizaa@gmail.com>
 * @version    Release: $Id:$
 * @since      Class available since Release 1.0.0
 */
class Iterator implements \Iterator
{

    /**
     * @var array
     */
    private $data;

    /**
     * @var int
     */
    private $pointer = 0;

    /**
     * Constructor
     * 
     * @param array|null $data
     */
    public function __construct(array $data = array())
    {
        $this->data = (array)$data;
    }

    /**
     * @see Iterator::current()
     */
    public function current()
    {
        return $this->data[$this->pointer];
    }

    /**
     * @see Iterator::next()
     */
    public function next()
    {
        $this->pointer++;
    }

    /**
     * @see Iterator::key()
     */
    public function key()
    {
        return $this->pointer;
    }

    /**
     * @see Iterator::valid()
     */
    public function valid()
    {
        return (count($this->data) > $this->pointer);
    }

    /** 
     * @see Iterator::rewind()
     */
    public function rewind()
    {
        $this->pointer = 0;
    }

}