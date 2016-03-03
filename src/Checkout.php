<?php
    class Checkout
    {
        private $book_id;
        private $patron_id;
        private $checkout_date;
        private $due_date;
        private $id;

        function __construct($book_id, $patron_id, $checkout_date, $due_date, $id = null)
        {
            $this->book_id = $book_id;
            $this->patron_id = $patron_id;
            $this->checkout_date = $checkout_date;
            $this->due_date = $due_date;
            $this->id = $id;
        }

        function setBookId($book_id)
        {
            $this->book_id = $book_id;
        }

        function getBookId()
        {
            return $this->book_id;
        }

        function setPatronId($patron_id)
        {
            $this->patron_id = $patron_id;
        }

        function getPatronId()
        {
            return $this->patron_id;
        }

        function setCheckoutDate($checkout_date)
        {
            $this->checkout_date = $checkout_date;
        }

        function getCheckoutDate()
        {
            return $this->checkout_date;
        }

        function setDueDate($due_date)
        {
            $this->due_date = $due_date;
        }

        function getDueDate()
        {
            return $this->due_date;
        }

        function getId()
        {
            return $this->id;
        }

        function setId($new_id)
        {
            $this->id = $new_id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO checkouts (book_id, patron_id, checkout_date, due_date) VALUES ({$this->getBookId()}, {$this->getPatronId()}, '{$this->getCheckoutDate()}', '{$this->getDueDate()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_checkouts = $GLOBALS['DB']->query("SELECT * FROM checkouts;");
            $checkouts = [];

            foreach($returned_checkouts as $checkout) {
                $book_id = $checkout['book_id'];
                $patron_id = $checkout['patron_id'];
                $checkout_date = $checkout['checkout_date'];
                $due_date = $checkout['due_date'];
                $id = $checkout['id'];
                $new_checkout = new Checkout($book_id, $patron_id, $checkout_date, $due_date, $id);
                array_push($checkouts, $new_checkout);
            }
            return $checkouts;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM checkouts;");
        }

    }
 ?>
