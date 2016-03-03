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

        // function getAuthors()
        // {
        //     $found_authors = $GLOBALS['DB']->query("SELECT authors.* FROM books
        //         JOIN author_book ON (books.id = author_book.book_id)
        //         JOIN authors ON (author_book.author_id = authors.id)
        //         WHERE books.id = {$this->getId()};");
        //
        //     $authors = [];
        //     foreach($found_authors as $author) {
        //
        //         $author_name = $author['author_name'];
        //         $id = $author['id'];
        //         $new_author = new Author($author_name, $id);
        //         array_push($authors, $new_author);
        //     }
        //     return $authors;
        // }
        //
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons;");
        }

        // function deleteOneBook()
        // {
        //     $GLOBALS['DB']->exec("DELETE FROM book WHERE id = {$this->getId()};");
        //     $GLOBALS['DB']->exec("DELETE FROM author_book WHERE book_id = {$this->getId()};");
        // }

    }
