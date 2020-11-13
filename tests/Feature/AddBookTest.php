<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Book;

class AddBookTest extends TestCase
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
        // if we do not do this we can not get the correct error because of bubbling???
        $this->withoutExceptionHandling();

        $data = [
            'title'     =>  'Cool Book Title',
            'author'    =>  'Victor'
        ];

        $response = $this->post('/books', $data);

        $response->assertOk();

        $this->assertDatabaseHas('books', $data);

        // $this->assertDatabaseCount('books', 1);
    }


    public function testATitleIsRequired()
    {
        // We have disabled this to prevent bubbling???
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
    }


}




