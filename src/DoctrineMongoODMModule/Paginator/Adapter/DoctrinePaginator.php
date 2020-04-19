<?php

namespace DoctrineMongoODMModule\Paginator\Adapter;

use Zend\Paginator\Adapter\AdapterInterface;
use Doctrine\ODM\MongoDB\Iterator\Iterator;

/**
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @author  Roman Konz <roman@konz.me>
 */
class DoctrinePaginator implements AdapterInterface
{
    /**
     * @var Iterator
     */
    protected $iterator;

    /**
     * @var int
     */
    private $count;

    /**
     * Constructor
     *
     * @param Iterator $iterator
     */
    public function __construct(Iterator $iterator)
    {
        $this->iterator = $iterator;
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        if ($this->count === null) {
            $this->count = count($this->iterator->toArray());
        }

        return $this->count;
    }

    /**
     * {@inheritDoc}
     */
    public function getItems($offset, $itemCountPerPage)
    {
        // Return array version so that counting is correct
        return array_slice($this->iterator->toArray(), $offset, $itemCountPerPage);
    }
}
