<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Book;
use App\Author;

class BookManagementTest extends TestCase
{
    // Every Time refreshes database
    use RefreshDatabase;


    /**
     * Dummy Data
     * @return [type] [description]
     */
    private function data()
    {
        return [
            'title'         =>  'Cool Book Title',
            'author_id'     =>  1
        ];
    }


    /**
     * A basic feature test example.
     * - function must start with word test & then cammelcase (my call)
     * @return void
     */
    public function testABookCanBeAddedToLibrary()
    {
        // Exception Bubbling
        // $this->withoutExceptionHandling();

        $response = $this->post('/books', $this->data());

        $book = Book::first();

        $this->assertEquals('Cool Book Title', Book::first()->title);

        $response->assertRedirect('/books/' . $book->id);
    }


    public function testATitleIsRequired()
    {
        // Disable Exception Bubbling
        // $this->withoutExceptionHandling();

        $response = $this->post('/books', array_merge($this->data(), ['title' => '']));

        $response->assertSessionHasErrors('title');
    }



    public function testABookCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', $this->data());
        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title'         =>  'New Title',
            'author_id'     =>  1,
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals(1, Book::first()->author_id);

        $response->assertRedirect('/books/' . $book->id);
    }


    public function testABookCanBeDeleted()
    {
        $this->post('/books', $this->data());
        $book = Book::first();

        $response = $this->delete('/books/' . $book->id);

        $this->assertCount(0, Book::all());

        // redirect
        $response->assertRedirect('/books');
    }



    public function testANewAuthorIsAutomaticallyAdded()
    {
        $this->post('/books', $this->data());

        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());
    }



}



