<?php

namespace Container;
use \SplFixedArray;


/**
 * Class RingBuffer - Circular buffer data structure
 * @package Container
 *
 */
class RingBuffer
{

    /**
     * Maximum number of  elements in buffer
     * @var int
     */
    private $maxSize;

    /**
     * Array of elements (implementation of structure with SPL)
     * @var SplFixedArray
     */
    private $buffer;

    /**
     * Current number of elements in the buffer
     * @var int
     */
    private $currentSize;

    /**
     * Pointer to tail in buffer
     * @var int
     */
    private $positionTail;

    /**
     * Pointer to head in buffer
     * @var int
     */
    private $positionHead;

    /**
     * Constructs a buffer with given $maxSize
     * @param  int $maxSize (maximum capacity for this buffer)
     */
    public function __construct($maxSize)
    {
        $this->currentSize = 0;
        $this->positionTail = 0;
        $this->positionHead = 0;
        $this->maxSize = $maxSize;
        $this->buffer = new SplFixedArray($maxSize);
    }

    /**
     * Returns current size of structure
     * @return int
     */
    public function size()
    {
        return $this->currentSize;
    }

    /**
     * Returns true if structure is empty in other cases returns false
     * @return boolean
     */
    public function empty()
    {
        return $this->currentSize == 0;
    }

    /**
     * Returns maxSize of buffer
     * @return int
     */
    public function capacity()
    {
        return $this->maxSize;
    }

    /**
     * Returns true if buffer is full
     * @return int
     */
    public function full()
    {
        return $this->maxSize <= $this->currentSize;
    }

    /**
     * Push an element to head of buffer
     * @param  mixed    $element to push into the buffer
     * @return boolean
     */
    public function push($element)
    {
        $this->currentSize = min($this->currentSize + 1, $this->maxSize);
        $this->positionHead = ($this->positionHead + 1) % $this->maxSize;
        $this->buffer[$this->positionHead] = $element;

        if ($this->positionHead == $this->positionTail && $this->full()) {
            $this->positionTail = ($this->positionTail+1) % $this->maxSize;
        }

        return true;
    }

    /**
     * Returns value from tail and removes it from buffer (if not empty).
     * @return mixed|null
     */
    public function pop()
    {
        if ($this->empty()) return null;
        else {
            $tailValue = $this->buffer[$this->positionTail];
            $this->positionTail = ($this->positionTail+1) % $this->maxSize;
            $this->currentSize--;
            return $tailValue;
        }
    }

    /**
     * Returns value from buffer tail
     * @return mixed
     */
    public function tail()
    {
        if($this->empty()) return null;
        else return $this->buffer[$this->positionTail];
    }

    /**
     * Returns value from buffer head
     * @return mixed
     */
    public function head()
    {
        if($this->empty()) return null;
        else return $this->buffer[$this->positionHead];
    }

    /**
     * Returns value by index
     * @param $index
     * @return mixed
     */
    public function at($index)
    {
        if($index>=$this->currentSize) return null;
        return $this->buffer[$index+1];
    }


}
