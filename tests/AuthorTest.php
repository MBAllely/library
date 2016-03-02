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

    }





 ?>
