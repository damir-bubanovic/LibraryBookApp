<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Book;

class BookTest extends TestCase
{

	use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testAnAuthorIdIsRecorded()
    {
        Book::create([
        	'title'		=>	'Cool Title',
        	'author_id'	=>	1,
        ]);

        $this->assertCount(1, Book::all());
    }
}
