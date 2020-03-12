<?php

namespace Tests\Feature;

use App\Book;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /** @test*/
    public function a_book_can_be_added_to_the_library(){
        $this->withoutExceptionHandling();

        $responce = $this->post('/books',[
            'title' => 'Cool Book Title',
            'author' => 'Victor',
        ]);

        $responce->assertOk();
        $this->assertCount(1, Book::all());
    }

    /** @test*/
    public function a_title_is_required(){
       
        $responce = $this->post('/books',[
                     'title' => '',
                     'author' => 'Puni'
                    ]);
       
        $responce->assertSessionHasErrors('title');
    }

    /** @test*/
    public function a_author_is_required(){
       
        $responce = $this->post('/books',[
                     'title' => 'A Cool title',
                     'author' => '',
                    ]);
       
        $responce->assertSessionHasErrors('author');
    }

    /** @test*/
    public function a_book_can_be_updated(){

       $this->withoutExceptionHandling();

        $this->post('/books',[
            'title' => 'Cool Title',
            'author' => 'Puni'
        ]);
       
        $book = Book::first();

        $responce = $this->patch('/books/'.$book->id ,[
            'title' => 'New Title',
            'author' => 'New Author',
        ]);

        $this->assertEquals('New Title',Book::first()->title);
        $this->assertEquals('New Author',Book::first()->author);
    }

}
