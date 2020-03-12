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
      
        $response = $this->post('/books',[
            'title' => 'Cool Book Title',
            'author' => 'Victor',
        ]);
        
        $book = Book::first();

        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

    /** @test*/
    public function a_title_is_required(){
       
        $response = $this->post('/books',[
                     'title' => '',
                     'author' => 'Puni'
                    ]);
       
        $response->assertSessionHasErrors('title');
    }

    /** @test*/
    public function a_author_is_required(){
       
        $response = $this->post('/books',[
                     'title' => 'A Cool title',
                     'author' => '',
                    ]);
       
        $response->assertSessionHasErrors('author');
    }

    /** @test*/
    public function a_book_can_be_updated(){

        $this->post('/books',[
            'title' => 'Cool Title',
            'author' => 'Puni'
        ]);
       
        $book = Book::first();

        $response = $this->patch($book->path() ,[
            'title' => 'New Title',
            'author' => 'New Author',
        ]);

        $this->assertEquals('New Title',Book::first()->title);
        $this->assertEquals('New Author',Book::first()->author);

        $response->assertRedirect($book->fresh()->path());
    }

    /** @test*/
    public function a_book_can_be_deleted(){

        $this->withoutExceptionHandling();

        $this->post('/books',[
            'title' => 'Cool Title',
            'author' => 'Puni'
        ]);

        $book = Book::first();
        $this->assertCount(1,Book::all());

        $response = $this->delete($book->path());

        $this->assertCount(0,Book::all());
        $response->assertRedirect('/books');
    }

}
