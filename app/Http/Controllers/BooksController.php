<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;


class BooksController extends Controller
{
    
    public function store(Request $request)
    {
        Book::create($this->validateRequiest());
    }

    public function update(Book $book){ 

        $book->update($this->validateRequiest());
    }

    public function validateRequiest(){
        $rule = [
                  'title' => 'required',
                  'author' => 'required'
                ];
        return request()->validate($rule);
    }

}
