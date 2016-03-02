<?php
    class Author
    {
        private $author_name;
        private $id;

        function __construct($author_name, $id = null)
        {
            $this->author_name = $author_name;
            $this->id = $id;
        }

        function setAuthorName($new_author_name)
        {
            $this->author_name = $new_author_name;
        }

        function getAuthorName()
        {
            return $this->author_name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO authors (author_name) VALUES ('{$this->getAuthorName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors;");
            $authors = [];

            foreach($returned_authors as $author) {
                $author_name = $author['author_name'];
                $id = $author['id'];
                $new_author = new Author($author_name, $id);
                array_push($authors, $new_author);
            }
            return $authors;
        }

        function update($new_author_name)
        {
            $GLOBALS['DB']->exec("INSERT INTO authors SET author_name = '{$new_author_name}';");
            $this->setAuthorName($new_author_name);
        }

        static function find($search_id)
        {
            $found_author = null;
            $authors = Author::getAll();
            foreach($authors as $author) {
                if ($author->getId() == $search_id) {
                    $found_author = $author;
                }
            }
            return $found_author;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors;");
        }

        function deleteOneAuthor()
        {
            $GLOBALS['DB']->exec("DELETE FROM author WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM author_author WHERE author_id = {$this->getId()};");
        }

    }
 ?>
