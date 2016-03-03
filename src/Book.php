<?php
    class Book
    {
        private $title;
        private $copies;
        private $id;

        function __construct($title, $copies, $id = null)
        {
            $this->title = $title;
            $this->copies = $copies;
            $this->id = $id;
        }

        function setTitle($new_title)
        {
            $this->title = $new_title;
        }

        function getTitle()
        {
            return $this->title;
        }

        function setCopies($copies)
        {
            $this->copies = $copies;
        }

        function getCopies()
        {
            return $this->copies;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO books (title, copies) VALUES ('{$this->getTitle()}', {$this->getCopies()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");
            $books = [];

            foreach($returned_books as $book) {
                $title = $book['title'];
                $copies = $book['copies'];
                $id = $book['id'];
                $new_book = new Book($title, $copies, $id);
                array_push($books, $new_book);
            }
            return $books;
        }

        function update($new_title)
        {
            $GLOBALS['DB']->exec("INSERT INTO books SET title = '{$new_title}';");
            $this->setTitle($new_title);
        }

        static function find($search_id)
        {
            $found_book = null;
            $books = Book::getAll();
            foreach($books as $book) {
                if ($book->getId() == $search_id) {
                    $found_book = $book;
                }
            }
            return $found_book;
        }

        function addAuthor($author)
        {
            $GLOBALS['DB']->exec("INSERT INTO author_book (author_id, book_id) VALUES ({$author->getId()}, {$this->getId()});");
        }

        function getAuthors()
        {
            $found_authors = $GLOBALS['DB']->query("SELECT authors.* FROM books
                JOIN author_book ON (books.id = author_book.book_id)
                JOIN authors ON (author_book.author_id = authors.id)
                WHERE books.id = {$this->getId()};");

            $authors = [];
            foreach($found_authors as $author) {

                $author_name = $author['author_name'];
                $id = $author['id'];
                $new_author = new Author($author_name, $id);
                array_push($authors, $new_author);
            }
            return $authors;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM books;");
        }

        function deleteOneBook()
        {
            $GLOBALS['DB']->exec("DELETE FROM book WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM author_book WHERE book_id = {$this->getId()};");
        }

    }
 ?>
