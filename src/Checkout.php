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

        
    }
 ?>
