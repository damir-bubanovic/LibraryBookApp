<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Book;

class BookManagementTest extends TestCase
{
    // Every Time refreshes database
    use RefreshDatabase;

    /**
     * A basic feature test example.
     * - function must start with word test & then cammelcase (my call)
     * @return void
     */
    public function testABookCanBeAddedToLibrary()
    {
        // Exception Bubbling
        $this->withoutExceptionHandling();

        $data = [
            'title'     =>  'Cool Book Title',
            'author'    =>  'Victor'
        ];

        $response = $this->post('/books', $data);

        $book = Book::first();

        // $response->assertOk();

        $this->assertDatabaseHas('books', $data);

        $response->assertRedirect('/books/' . $book->id);

        // $this->assertDatabaseCount('books', 1);
    }


    public function testATitleIsRequired()
    {
        // Disable Exception Bubbling
        // $this->withoutExceptionHandling();

        $data = [
            'title'     =>  '',
            'author'    =>  'Victor'
        ];

        $response = $this->post('/books', $data);

        $response->assertSessionHasErrors('title');
    }



    public function testABookCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $data = [
            'title'     =>  'Cool Book Title',
            'author'    =>  'Victor'
        ];

        $this->post('/books', $data);
        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title'     =>  'New Title',
            'author'    =>  'New Author',
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);

        $response->assertRedirect('/books/' . $book->id);
    }


    public function testABookCanBeDeleted()
    {
        $data = [
            'title'     =>  'Cool Book Title',
            'author'    =>  'Victor'
        ];

        $this->post('/books', $data);
        $book = Book::first();

        $response = $this->delete('/books/' . $book->id);

        $this->assertCount(0, Book::all());

        // redirect
        $response->assertRedirect('/books');
    }


}



