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
     * Dummy Data
     * @return [type] [description]
     */
    private function data()
    {
        return [
            'name'  =>  'Author Name',
            'birth' =>  '05/14/1998',
        ];
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAnAuthorCanBeCreated()
    {
        $this->withoutExceptionHandling();

        $this->post('/authors', $this->data());

        $author = Author::all();

        $this->assertCount(1, $author);
        // Assert it is coming as Carbon format
        $this->assertInstanceOf(Carbon::class, $author->first()->birth);
        $this->assertEquals('1998/14/05', $author->first()->birth->format('Y/d/m'));
    }


    public function testANameIsRequired()
    {
        $response = $this->post('/authors', array_merge($this->data(), ['name' => '']));
        $response->assertSessionHasErrors('name');
    }


    public function testABirthIsRequired()
    {
        $response = $this->post('/authors', array_merge($this->data(), ['birth' => '']));
        $response->assertSessionHasErrors('birth');
    }



}
