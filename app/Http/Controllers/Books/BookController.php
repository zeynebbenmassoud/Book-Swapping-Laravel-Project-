<?php

namespace App\Http\Controllers\Books;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use Validator;

class BookController extends Controller
{
    protected $user;
 
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->user = $this->guard()->user();
    }

    //../books
    public function index()
    {
        $book = $this->user->books()->get(['id', 'title','author','synopsis', 'prix', 'type', 'availability', 'likes', 'categories', 'user_id']);
        return response()->json($book->toArray());
    }

    //store
    public function store(BookRequest $request){

        $book = new book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->synopsis = $request->synopsis;
        $book->prix = $request->prix;
        $book->availability = $request->availability;
        $book->categories = $request->categories;
        $book->type = $request->type;

        if($this->user->books()->save($book)){
            return response()->json(['status' => true, 'book' => $book], 201);
        }else{
            return response()->json(['status' => false, 'message' => 'Oops, the book could not be saved']);
        }

    }

    //update
    public function update(BookRequest $request, Book $book){

        $book->title = $request->title;
        $book->author = $request->author;
        $book->synopsis = $request->synopsis;
        $book->prix = $request->prix;
        $book->availability = $request->availability;
        $book->categories = $request->categories;
        $book->type = $request->type;

        if($this->user->books()->save($book)){
            return response()->json(['status' => true, 'book' => $book], 201);
        }else{
            return response()->json(['status' => false, 'message' => 'Oops, the book could not be updated']);
        }
    }

    //destroy
    public function destroy(Book $book){
        if($book->delete()){
            return response()->json(['status' => true, 'book' => $book], 201);
        }else{
            return response()->json(['status' => false, 'message' => 'Oops, the book could not be deleted']);
        }    
    }

    public function like(){
        
    }

    protected function guard(){
        return Auth::guard();
    }

}
