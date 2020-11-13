<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Author;
use Illuminate\Support\Carbon;

class AuthorManagementTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAnAuthorCanBeCreated()
    {
        $this->withoutExceptionHandling();


        $data = [
            'name'  =>  'Author Name',
            'birth' =>  '05/14/1998',
        ];
        $this->post('/author', $data);

        $author = Author::all();

        $this->assertCount(1, $author);
        // Assert it is coming as Carbon format
        $this->assertInstanceOf(Carbon::class, $author->first()->birth);
        $this->assertEquals('1998/14/05', $author->first()->birth->format('Y/d/m'));
    }

}





<?php
class AuthorManagementTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAnAuthorCanBeCreated()
    {
        $this->withoutExceptionHandling();


        $data = [
            'name'  =>  'Author Name',
            'birth' =>  '05/14/1998',
        ];
        $this->post('/author', $data);

        $author = Author::all();

        $this->assertCount(1, $author);
        // Assert it is coming as Carbon format
        $this->assertInstanceOf(Carbon::class, $author->first()->birth);
        $this->assertEquals('1998/14/05', $author->first()->birth->format('Y/d/m'));
    }

}