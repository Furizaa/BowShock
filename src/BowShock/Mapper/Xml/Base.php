<?php
/**
 * BowShock
 *
 * @category   BowShock
 * @package    Mapper
 * @subpackage Xml
 * @author     Andreas Hoffmann <furizaa@gmail.com>
 * @copyright  2010-2011 Andreas Hoffmann <furizaa@gmail.com>
 * @since      File available since Release 1.0.0
 */

namespace BowShock\Mapper\Xml;

use BowShock\Mapper\MapperException;

/**
 * Xml Base Mapper
 *
 * @package    Mapper
 * @subpackage Xml
 * @author     Andreas Hoffmann <furizaa@gmail.com>
 * @copyright  2010-2011 Andreas Hoffmann <furizaa@gmail.com>
 * @version    Release: $Id:$
 * @since      Class available since Release 1.0.0
 */
class Base
{

    /**
     * @var \SimpleXMLElement
     */
    private $source;

    /**
     * @var string
     */
    private $fileName;

    /**
     * @param string|\SimpleXmlElement $xmlSource
     */
    public function __construct($xmlSource)
    {
        if ($xmlSource instanceof \SimpleXMLElement) {
            $this->source = $xmlSource;
        } else {
            $this->fileName = $xmlSource;
        }
    }

    /**
     * @return SimpleXMLElement
     */
    protected function getSource()
    {
        if (null === $this->source) {
            if (!is_file($this->fileName)) {
                throw new MapperException('Could not open xml file!');
            }
            $this->source = simplexml_load_file($this->fileName);
        }
        return $this->source;
    }

}