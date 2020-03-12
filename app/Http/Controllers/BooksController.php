<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;


class BooksController extends Controller
{
    
    public function store(Request $request)
    {
       $book = Book::create($this->validateRequiest());
       return redirect($book->path());
    }

    public function update(Book $book){ 

        $book->update($this->validateRequiest());
        return redirect($book->path());
    }


    public function destroy(Book $book){
        $book->delete();
        return redirect('/books');
    }

    protected function validateRequiest(){
        $rule = [
                  'title' => 'required',
                  'author' => 'required'
                ];
        return request()->validate($rule);
    }

}
