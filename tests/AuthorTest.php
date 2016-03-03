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

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
            Author::deleteAll();
        }

        function test_getInfo()
        {
            //Arrange
            $author_name = "Winston Rowntree";
            $id = 2;
            $test_author = new Author($author_name, $id);

            //Act
            $result1 = $test_author->getAuthorName();
            $result2 = $test_author->getId();

            //Assert
            $this->assertEquals($author_name, $result1);
            $this->assertEquals($id, $result2);
        }

        function test_save()
        {
            //Arrange
            $author_name = "Maragaret Atwood";
            $test_author = new Author($author_name);
            $test_author->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_author], $result);
        }

        function test_getAll()
        {
            //Arrange
            $author_name = "Maragaret Atwood";
            $test_author = new Author($author_name);
            $test_author->save();

            $author_name2 = "Philip Pullman";
            $test_author2 = new Author($author_name2);
            $test_author2->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        function test_addBook()
        {
            //Arrange
            $author_name = "Philip Pullman";
            $test_author = new Author($author_name);
            $test_author->save();

            $title = "Golden Compass";
            $copies = 3;
            $test_book = new Book($title, $copies);
            $test_book->save();

            //Act
            $test_author->addBook($test_book);


            //Assert
            $this->assertEquals($test_author->getBooks(), [$test_book]);

        }


        function test_getBooks()
        {
            //Arrange
            $author_name = "Philip Pullman";
            $test_author = new Author($author_name);
            $test_author->save();

            $title = "Golden Compass";
            $copies = 3;
            $id = 1;
            $test_book = new Book($title, $copies, $id);
            $test_book->save();

            $title2 = "The Subtle Knife";
            $copies2 = 4;
            $id2 = 2;
            $test_book2 = new Book($title2, $copies2, $id2);
            $test_book2->save();

            $title3 = "Amber Spyglass";
            $copies3 = 3;
            $test_book3 = new Book($title3, $copies3);
            $test_book3->save();

            //Act
            $test_author->addBook($test_book);
            $test_author->addBook($test_book2);
            $test_author->addBook($test_book3);

            //Assert
            $this->assertEquals([$test_book, $test_book2, $test_book3], $test_author->getBooks());

        }

    }





 ?>
