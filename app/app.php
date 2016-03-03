<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/Patron.php";
    require_once __DIR__."/../src/Checkout.php";

    $app = new Silex\Application();

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
            // twig input associative array
        ));
    });

    $app->get("/books", function() use ($app) {
        return $app['twig']->render('books.html.twig', array(
            'books' => Book::getAll()
        ));
    });
    
    $app->get("/authors", function() use ($app) {
        return $app['twig']->render('authors.html.twig', array(
            'authors' => Author::getAll()
        ));
    });
    
    $app->get("/patrons", function() use ($app) {
        return $app['twig']->render('patrons.html.twig', array(
            'patrons' => Patron::getAll()
        ));
    });

    return $app;
?>
