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
    require_once __DIR__ . '/../src/Checkout.php';

    class PatronTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Patron::deleteAll();
        }

        // function test_getInfo()
        // {
        //     //Arrange
        //     $patron_name = "Winston Rowntree";
        //     $id = 1;
        //     $test_patron = new Patron($patron_name, $id);
        //
        //     //Act
        //     $result1 = $test_patron->getPatronName();
        //     $result2 = $test_patron->getId();
        //
        //     //Assert
        //     $this->assertEquals($patron_name, $result1);
        //     $this->assertEquals($id, $result2);
        // }
        //
        // function test_save()
        // {
        //     //Arrange
        //     $patron_name = "Maragaret Atwood";
        //     $test_patron = new Patron($patron_name);
        //     $test_patron->save();
        //
        //     //Act
        //     $result = Patron::getAll();
        //
        //     //Assert
        //     $this->assertEquals([$test_patron], $result);
        // }
        //
        // function test_getAll()
        // {
        //     //Arrange
        //     $patron_name = "Maragaret Atwood";
        //     $test_patron = new Patron($patron_name);
        //     $test_patron->save();
        //
        //     $patron_name2 = "Philip Pullman";
        //     $test_patron2 = new Patron($patron_name2);
        //     $test_patron2->save();
        //
        //     //Act
        //     $result = Patron::getAll();
        //
        //     //Assert
        //     $this->assertEquals([$test_patron, $test_patron2], $result);
        // }
        //
        // function test_deleteOnePatron()
        // {
        //     //Arrange
        //     $patron_name = "Margaret Atwood";
        //     $test_patron = new Patron($patron_name);
        //     $test_patron->save();
        //
        //     $patron_name2 = "Philip Pullman";
        //     $test_patron2 = new Patron($patron_name2);
        //     $test_patron2->save();
        //
        //     //Act
        //     $test_patron->deleteOnePatron();
        //     $result = Patron::getAll();
        //
        //     //Assert
        //     $this->assertEquals([$test_patron2], $result);
        // }
        //
        // function test_addCheckout()
        // {
        //     //Arrange
        //     $patron_name = "Margaret Atwood";
        //     $test_patron = new Patron($patron_name);
        //     $test_patron->save();
        //
        //     $book_id = 1;
        //     $patron_id = 2;
        //     $checkout_date = "2016-03-03";
        //     $due_date = "2016-03-17";
        //     $id = 3;
        //     $test_checkout = new Checkout($book_id, $patron_id, $checkout_date, $due_date, $id);
        //
        //     //Act
        //     $test_patron->addCheckout($test_checkout);
        //
        //     //Assert
        //     $this->assertEquals([$test_checkout], $test_patron->getCheckouts());
        //
        // }

        function test_getCheckouts()
        {
            //Arrange
            $patron_name = "Margaret Atwood";
            $test_patron = new Patron($patron_name);
            $test_patron->save();

            $book_id = 1;
            $patron_id = $test_patron->getId();
            $checkout_date = "2016-03-03";
            $due_date = "2016-03-17";
            $id = 3;
            $test_checkout = new Checkout($book_id, $patron_id, $checkout_date, $due_date);

            $book_id2 = 4;
            $checkout_date2 = "2016-02-15";
            $due_date2 = "2016-02-29";
            $id2 = 4;
            $test_checkout2 = new Checkout($book_id2, $patron_id, $checkout_date2, $due_date2);

            $book_id3 = 1;
            $checkout_date3 = "2016-01-03";
            $due_date3 = "2016-01-17";
            $id3 = 3;
            $test_checkout3 = new Checkout($book_id3, $patron_id, $checkout_date3, $due_date3);
            
            //Act
            $test_patron->addCheckout($test_checkout);
            $test_patron->addCheckout($test_checkout2);
            $test_patron->addCheckout($test_checkout3);
            $result = $test_patron->getCheckouts();
            
            //Assert
            $this->assertEquals([$test_checkout, $test_checkout2, $test_checkout3], $result);

        }

    }

 ?>
