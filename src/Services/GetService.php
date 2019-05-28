<?php
/**
 * Created by PhpStorm.
 * User: arnol
 * Date: 20-5-2019
 * Time: 10:50
 */

namespace EenmaalAndermaal\Services {

    class GetService implements \Iterator
    {

        private static $instance;
        private $position;

        public static function getInstance()
        {
            if (self::$instance == null) {
                self::$instance = new GetService();
            }
            return self::$instance;
        }

        public $variables = [];

        function __construct()
        {
            $this->variables = $_GET;
            if (isset($this->variables["link"])) {
                unset($this->variables["link"]);
            }
        }

        public function getVar($key)
        {
            if (isset($this->variables[$key]) && !empty($this->variables[$key])) {
                return $this->variables[$key];
            }
            return false;
        }

        public function setVar($key, $value)
        {
            $this->variables[$key] = $value;
            return $this;
        }

        public function addVar($key, $value)
        {
            if (!isset($this->variables[$key])) {
                $this->setVar($key, $value);
                return true;
            }
            return false;
        }

        public function removeVar($key)
        {
            if (isset($this->variables[$key])) {
                unset ($this->variables[$key]);
                return true;
            }
            return false;
        }

        public function clear()
        {
            $this->variables = [];
            return $this;
        }

        public function createHiddenInputs(array $exclude = [])
        {
            $inputs = "";
            foreach ($this->variables as $key => $value) {
                if (in_array($key, $exclude)) continue;
                $inputs .= "<input type='hidden' name='$key' value='$value'>";
            }
            return $inputs;
        }

        public function build()
        {
            return http_build_query($this->variables, '', '&');
        }

        /**
         * Return the current element
         * @link https://php.net/manual/en/iterator.current.php
         * @return mixed Can return any type.
         * @since 5.0.0
         */
        public function current()
        {
            return $this->variables[$this->position];
        }

        /**
         * Move forward to next element
         * @link https://php.net/manual/en/iterator.next.php
         * @return void Any returned value is ignored.
         * @since 5.0.0
         */
        public function next()
        {
            ++$this->position;
        }

        /**
         * Return the key of the current element
         * @link https://php.net/manual/en/iterator.key.php
         * @return mixed scalar on success, or null on failure.
         * @since 5.0.0
         */
        public function key()
        {
            return $this->position;
        }

        /**
         * Checks if current position is valid
         * @link https://php.net/manual/en/iterator.valid.php
         * @return boolean The return value will be casted to boolean and then evaluated.
         * Returns true on success or false on failure.
         * @since 5.0.0
         */
        public function valid()
        {
            return $this->position < count($this->variables);
        }

        /**
         * Rewind the Iterator to the first element
         * @link https://php.net/manual/en/iterator.rewind.php
         * @return void Any returned value is ignored.
         * @since 5.0.0
         */
        public function rewind()
        {
            $this->position = 0;
        }
    }
}