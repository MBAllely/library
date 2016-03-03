<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    require_once __DIR__ . '/../src/Book.php';
    require_once __DIR__ . '/../src/Author.php';

    class BookTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
            Author::deleteAll();
        }

        function test_getInfo()
        {
            // Arrange
            $title = "The Grapes of Wrath";
            $copies = 3;
            $id = 3;
            $test_book = new Book($title, $copies, $id);

            // Act
            $result1 = $test_book->getTitle();
            $result3 = $test_book->getCopies();
            $result4 = $test_book->getId();

            // Assert
            $this->assertEquals($title, $result1);
            $this->assertEquals($copies, $result3);
            $this->assertEquals($id, $result4);
        }

        function test_save()
        {
            // Arrange
            $title = "The Grapes of Wrath";
            $copies = 3;

            $test_book = new Book($title, $copies);

            //Act
            $test_book->save();
            $result = Book::getAll();

            //Assert
            $this->assertEquals($test_book, $result[0]);
        }

        function test_getAll()
        {
            // Arrange
            $title = "Little Women";
            $copies = 5;
            $id = null;
            $test_book = new Book ($title, $copies, $id);
            $test_book->save();

            $title2 = "Anne of Green Gables";
            $copies2 = 2;
            $id2 = null;
            $test_book2 = new Book ($title2, $copies2, $id2);
            $test_book2->save();

            // Act
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_book, $test_book2], $result);
        }


        function test_update()
        {
            // Arrange
            $title = "Little Women";
            $copies = 5;
            $id = null;
            $test_book = new Book ($title, $copies, $id);
            $test_book->save();

            $new_name = "Lil' Womynz";

            // Act
            $test_book->update($new_name);
            $result = $test_book->getTitle();

            // Assert
            $this->assertEquals($new_name, $result);
        }

        function test_find()
        {
            // Arrange
            $title = "Little Women";
            $copies = 5;
            $id = null;
            $test_book = new Book ($title, $copies, $id);
            $test_book->save();

            $title2 = "Anne of Green Gables";
            $copies2 = 2;
            $id2 = null;
            $test_book2 = new Book ($title2, $copies2, $id2);
            $test_book2->save();

            // Act
            $result = Book::find($test_book2->getId());

            //Assert
            $this->assertEquals($test_book2, $result);
        }

        function test_addAuthor()
        {
            //Arrange
            $author_name = "Kafka";
            $test_author = new Author($author_name);
            $test_author->save();

            $title = "The Metamorphosis";
            $copies = 3;
            $test_book = new Book($title, $copies);
            $test_book->save();

            //Act
            $test_book->addAuthor($test_author);

            //Assert
            $this->assertEquals($test_book->getAuthors(), [$test_author]);
        }

        function test_getAuthors()
        {
            //Arrange
            $author_name = "Neil Gaiman";
            $test_author = new Author($author_name);
            $test_author->save();

            $author_name2 = "Terry Pratchett";
            $test_author2 = new Author($author_name2);
            $test_author2->save();

            $title = "Good Omens";
            $copies = 3;
            $test_book = new Book($title, $copies);
            $test_book->save();

            //Act
            $test_book->addAuthor($test_author);

            //Assert
            $this->assertEquals($test_book->getAuthors(), [$test_author]);
        }

        function test_deleteOneBook()
        {
            // Arrange
            $title = "Little Women";
            $copies = 5;
            $id = null;
            $test_book = new Book ($title, $copies, $id);
            $test_book->save();

            $title2 = "Anne of Green Gables";
            $copies2 = 2;
            $id2 = null;
            $test_book2 = new Book ($title2, $copies2, $id2);
            $test_book2->save();

            // Act
            $test_book->deleteOneBook();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_book2], $result);
        }
    }
 ?>
