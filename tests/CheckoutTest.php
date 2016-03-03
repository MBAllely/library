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
    require_once __DIR__ . '/../src/Patron.php';
    require_once __DIR__ . '/../src/Checkout.php';

    class CheckoutTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Checkout::deleteAll();
        }

        function test_getInfo()
        {
            //Arrange
            $book_id = 1;
            $patron_id = 2;
            $checkout_date = "2016-03-03";
            $due_date = "2016-03-17";
            $id = 3;
            $test_checkout = new Checkout($book_id, $patron_id, $checkout_date, $due_date, $id);

            //Act
            $result1 = $test_checkout->getBookId();
            $result2 = $test_checkout->getPatronId();
            $result3 = $test_checkout->getCheckoutDate();
            $result4 = $test_checkout->getDueDate();
            $result5 = $test_checkout->getId();

            //Assert
            $this->assertEquals($book_id, $result1);
            $this->assertEquals($patron_id, $result2);
            $this->assertEquals($checkout_date, $result3);
            $this->assertEquals($due_date, $result4);
            $this->assertEquals($id, $result5);

        }

        function test_save()
        {
            //Arrange
            $book_id = 1;
            $patron_id = 2;
            $checkout_date = "2016-03-03";
            $due_date = "2016-03-17";
            $test_checkout = new Checkout($book_id, $patron_id, $checkout_date, $due_date);

            //Act
            $test_checkout->save();
            $result = Checkout::getAll();

            //Assert
            $this->assertEquals([$test_checkout], $result);
        }

    }
 ?>
