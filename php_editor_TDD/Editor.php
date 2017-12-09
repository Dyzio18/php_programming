<?php
/**
 * Created by PhpStorm.
 * User: Patryk Nizio
 * Date: 09.12.17
 * Time: 00:36
 */

namespace String;

/**
 * Class Editor
 * @package String
 */
class Editor
{
    /**
     * @var string
     */
    protected $memory;

    /**
     * Editor constructor.
     * Save value $text to $this->memory
     * @param $text (string)
     */
    public function __construct($text)
    {
        $this->memory = (string)$text;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->memory;
    }

    /**
     * Returns string in lower case
     * @return $this
     */
    public function lower()
    {
        $this->memory =  strtolower($this->memory);
        return $this;
    }

    /**
     * Returns string in upper case
     * @return $this
     */
    public function upper()
    {
        $this->memory = strtoupper($this->memory);
        return $this;
    }

    /**
     * Returns replace text
     * @param $find     (Specifies the value to find)
     * @param $replace  (Specifies the value to replace the value in find)
     * @return $this
     */
    public function replace($find, $replace)
    {
        $this->memory = str_replace($find, $replace, $this->memory);
        return $this;
    }

    /**
     * Returns replace text. Censor $find to asterisks (with the same length as words)
     * @param $find (Specifies the value to find)
     * @return $this
     */
    public function censor($find)
    {
        $this->memory = str_replace($find, str_repeat('*' , strlen($find) ), $this->memory);
        return $this;
    }

    /**
     * Returns text with repeated word/sentence ($find) N ($counter) times
     * @param $find
     * @param $counter
     * @return $this
     */
    public function repeat($find, $counter)
    {
        $this->memory = str_replace($find, str_repeat($find , $counter ), $this->memory);
        return $this;
    }

    /**
     * Returns text without $find
     * @param $find
     * @return $this
     */
    public function remove($find)
    {
        $this->memory = str_replace($find,'', $this->memory);
        return $this;
    }

}