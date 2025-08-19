<?php
if (!class_exists('StubResult')) {
    class StubResult {
        private $row;
        public function __construct($row) { $this->row = $row; }
        public function fetch_assoc() { return $this->row; }
    }
    class StubStatement {
        private $row;
        public function __construct($row) { $this->row = $row; }
        public function bind_param($types, &...$vars) {}
        public function execute() {}
        public function get_result() { return new StubResult($this->row); }
    }
    class StubConnection {
        private $row;
        public function __construct($row) { $this->row = $row; }
        public function prepare($sql) { return new StubStatement($this->row); }
    }
}
$conn = new StubConnection($GLOBALS['__TEST_PRODUCT__'] ?? null);

