<?php
namespace Api\Books;

class Repository
{
    public function get(int $id) : Book
    {
        $book = new Book;
        $book->title = 'a';

        $book->body = 'body';
        return $book;
    }
}