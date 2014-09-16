<?php 

namespace RecipeFinder;

class CsvFileIterator implements \Iterator {
    protected $file;
    protected $key = 0;
    protected $current;
    
    /**
     * __construct
     *
     * @param mixed $file
     */
    public function __construct($file) {
        $this->file = fopen($file, 'r');
    }

    /**
     * __destruct
     *
     */
    public function __destruct() {
        fclose($this->file);
    }

    /**
     * rewind
     *
     */
    public function rewind() {
        rewind($this->file);
        
        $this->current = fgetcsv($this->file);
        $this->key     = 0;
    }

    /**
     * valid
     *
     */
    public function valid() {
        return !feof($this->file);
    }

    /**
     * key
     *
     */
    public function key() {
        return $this->key;
    }

    /**
     * current
     *
     */
    public function current() {
        return $this->current;
    }

    /**
     * next
     *
     */
    public function next() {
        $this->current = fgetcsv($this->file);
        $this->key++;
    }
}
