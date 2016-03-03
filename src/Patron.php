<?php
    class Patron
    {
        private $patron_name;
        private $id;

        function __construct($patron_name, $id = null)
        {
            $this->patron_name = $patron_name;
            $this->id = $id;
        }

        function setPatronName($new_patron_name)
        {
            $this->patron_name = $new_patron_name;
        }

        function getPatronName()
        {
            return $this->patron_name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO patrons (patron_name) VALUES ('{$this->getPatronName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_patrons = $GLOBALS['DB']->query("SELECT * FROM patrons;");
            $patrons = [];

            foreach($returned_patrons as $patron) {
                $patron_name = $patron['patron_name'];
                $id = $patron['id'];
                $new_patron = new Patron($patron_name, $id);
                array_push($patrons, $new_patron);
            }
            return $patrons;
        }

        function update($new_patron_name)
        {
            $GLOBALS['DB']->exec("INSERT INTO patrons SET patron_name = '{$new_patron_name}';");
            $this->setPatronName($new_patron_name);
        }

        static function find($search_id)
        {
            $found_patron = null;
            $patrons = Patron::getAll();
            foreach($patrons as $patron) {
                if ($patron->getId() == $search_id) {
                    $found_patron = $patron;
                }
            }
            return $found_patron;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons;");
        }

        function deleteOnePatron()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons WHERE id = {$this->getId()};");
        }

        function addCheckout($checkout)
        {
            $GLOBALS['DB']->exec("INSERT INTO checkouts (book_id, patron_id, checkout_date, due_date) VALUES ({$checkout->getBookId()}, {$this->getId()}, '{$checkout->getCheckoutDate()}', '{$checkout->getDueDate()}');");
            $checkout->setId($GLOBALS['DB']->lastInsertId());
        }

        function getCheckouts()
        {
            $checkouts = [];
            $returned_checkouts = $GLOBALS['DB']->query("SELECT * FROM checkouts WHERE patron_id = {$this->getId()};");
            foreach ($returned_checkouts as $checkout)
            {
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

    }
