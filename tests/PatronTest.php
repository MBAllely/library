<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    require_once __DIR__ . '/../src/Patron.php';

    class PatronTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Patron::deleteAll();
        }

        function test_getInfo()
        {
            //Arrange
            $patron_name = "Winston Rowntree";
            $id = 1;
            $test_patron = new Patron($patron_name, $id);

            //Act
            $result1 = $test_patron->getPatronName();
            $result2 = $test_patron->getId();

            //Assert
            $this->assertEquals($patron_name, $result1);
            $this->assertEquals($id, $result2);
        }

        function test_save()
        {
            //Arrange
            $patron_name = "Maragaret Atwood";
            $test_patron = new Patron($patron_name);
            $test_patron->save();

            //Act
            $result = Patron::getAll();

            //Assert
            $this->assertEquals([$test_patron], $result);
        }

        function test_getAll()
        {
            //Arrange
            $patron_name = "Maragaret Atwood";
            $test_patron = new Patron($patron_name);
            $test_patron->save();

            $patron_name2 = "Philip Pullman";
            $test_patron2 = new Patron($patron_name2);
            $test_patron2->save();

            //Act
            $result = Patron::getAll();

            //Assert
            $this->assertEquals([$test_patron, $test_patron2], $result);
        }



        // function test_getBooks()
        // {
        //     //Arrange
        //     $patron_name = "Philip Pullman";
        //     $test_patron = new Author($author_name);
        //     $test_author->save();
        //
        //     $title = "Golden Compass";
        //     $copies = 3;
        //     $id = 1;
        //     $test_book = new Book($title, $copies, $id);
        //     $test_book->save();
        //
        //     $title2 = "The Subtle Knife";
        //     $copies2 = 4;
        //     $id2 = 2;
        //     $test_book2 = new Book($title2, $copies2, $id2);
        //     $test_book2->save();
        //
        //     $title3 = "Amber Spyglass";
        //     $copies3 = 3;
        //     $test_book3 = new Book($title3, $copies3);
        //     $test_book3->save();
        //
        //     //Act
        //     $test_author->addBook($test_book);
        //     $test_author->addBook($test_book2);
        //     $test_author->addBook($test_book3);
        //
        //     //Assert
        //     $this->assertEquals([$test_book, $test_book2, $test_book3], $test_author->getBooks());
        //
        // }

    }

 ?>
