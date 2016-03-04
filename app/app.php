<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/Patron.php";
    require_once __DIR__."/../src/Checkout.php";

    $app = new Silex\Application();

    $app['debug'] = true;

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $server = 'mysql:host=localhost;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array(
        ));
    });

    $app->get("/books", function() use ($app) {
        return $app['twig']->render('books.html.twig', array(
            'books' => Book::getAll()
        ));
    });

    $app->post("/books", function() use ($app) {
        $new_book = new Book($_POST['title'], $_POST['copies']);
        $new_book->save();
        return $app['twig']->render('books.html.twig', array(
            'books' => Book::getAll()
        ));
    });

    $app->get("/book/{id}", function($id) use ($app) {
        $book = Book::find($id);
        return $app['twig']->render('book.html.twig', array(
            'book' => $book,
            'authors' => $book->getAuthors(),
            'all_authors' => Author::getAll()
        ));
    });

    $app->get("/book/{id}/edit", function($id) use ($app) {
        $book = Book::find($id);
        return $app['twig']->render('book_edit.html.twig', array(
            'book' => $book,
            'authors' => $book->getAuthors()
        ));
    });

    $app->post("/book/{id}", function($id) use ($app) {
        $book = Book::find($id);
        $author = Author::find($_POST['id']);
        $book->addAuthor($author);
        return $app['twig']->render('book.html.twig', array(
            'book' => $book,
            'authors' => $book->getAuthors(),
            'all_authors' => Author::getAll()
        ));
    });

    $app->patch("/book/{id}", function($id) use ($app) {
        $book = Book::find($id);
        var_dump($book->getCopies());
        $book->update($_POST['new_title'], $_POST['new_copies']);
        return $app['twig']->render('book.html.twig', array(
            'book' => $book,
            'authors' => $book->getAuthors()
        ));
    });

    $app->delete("/book/{id}/delete", function($id) use ($app) {
        $book = Book::find($id);
        $book->deleteOneBook();
        return $app['twig']->render('books.html.twig', array(
            'books' => Book::getAll()
        ));
    });

    $app->get("/authors", function() use ($app) {
        return $app['twig']->render('authors.html.twig', array(
            'authors' => Author::getAll()
        ));
    });

    $app->post("/authors", function() use ($app) {
        $new_author = new Author($_POST['author_name']);
        $new_author->save();
        return $app['twig']->render('authors.html.twig', array(
            'authors' => Author::getAll()
        ));
    });

    $app->get("/author/{id}", function($id) use ($app) {
        $author = Author::find($id);
        return $app['twig']->render('author.html.twig', array(
            'author' => $author,
            'books' => $author->getBooks($id),
            'all_books' => Book::getAll()
        ));
    });

    $app->post("/author/{id}", function($id) use ($app) {
        $author = Author::find($id);
        $book = Book::find($_POST['id']);
        $author->addBook($book);
        return $app['twig']->render('author.html.twig', array(
            'author' => $author,
            'books' => $author->getBooks(),
            'all_books' => Book::getAll()
        ));
    });

    $app->get("/author/{id}/edit", function($id) use ($app) {
        $author = Author::find($id);
        return $app['twig']->render('author_edit.html.twig', array(
            'author' => $author
        ));
    });

    $app->patch("/author/{id}", function($id) use ($app) {
        $new_name = $_POST['new_name'];
        $author = Author::find($id);
        $author->update($new_name);

        return $app['twig']->render('author.html.twig', array(
            'author' => $author,
            'books' => $author->getBooks($id)
        ));
    });

    $app->delete("/author/{id}/delete", function($id) use ($app) {
        $author = Author::find($id);
        $author->deleteOneAuthor();
        return $app['twig']->render('authors.html.twig', array(
            'authors' => Author::getAll()
        ));
    });

    $app->get("/patrons", function() use ($app) {
        return $app['twig']->render('patrons.html.twig', array(
            'patrons' => Patron::getAll()
        ));
    });

    $app->post("/patrons", function() use ($app) {
        $new_patron = new Patron($_POST['patron_name']);
        $new_patron->save();
        return $app['twig']->render('patrons.html.twig', array(
            'patrons' => Patron::getAll()
        ));
    });

    $app->get("/patron/{id}", function($id) use ($app) {
        $patron = Patron::find($id);
        return $app['twig']->render('patron.html.twig', array(
            'patron' => $patron,
            'checkouts' => $patron->getCheckouts()
        ));
    });

    $app->get("/patron/{id}/edit", function($id) use ($app) {
        $patron = Patron::find($id);
        return $app['twig']->render('patron_edit.html.twig', array(
            'patron' => $patron,
            'checkouts' => $patron->getCheckouts()
        ));
    });

    $app->patch("/patron/{id}", function($id) use ($app) {
        $new_name = $_POST['new_patron_name'];
        $patron = Patron::find($id);
        $patron->update($new_name);

        return $app['twig']->render('patron.html.twig', array(
            'patron' => $patron,
            'checkouts' => $patron->getCheckouts()
        ));
    });

    $app->delete("/patron/{id}/delete", function($id) use ($app) {
        $patron = Patron::find($id);
        $patron->deleteOnePatron();
        return $app['twig']->render('patrons.html.twig', array(
            'patrons' => Patron::getAll()
        ));
    });

    $app->get("/checkouts", function() use ($app) {
        return $app['twig']->render('checkouts.html.twig', array(
            'checkouts' => Checkout::getAll()
        ));
    });


    return $app;
?>
