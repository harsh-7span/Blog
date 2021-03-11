<?php

namespace App\Services;

use App\Models\book;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponser;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use DB;

class BookService
{
    use ApiResponser;

    private $bookObj;

    public function __construct(book $bookObj)
    {
        $this->bookObj = $bookObj;
    }
    public function collection($input = null)
    {
        if (!empty($input)) {
            $books = $this->bookObj->with(['images', 'user'])->where('name', 'like', '%' . $input['name'] . '%')->paginate(5);
            return $books;
        } else {
            $books = $this->bookObj->with(['images', 'user'])->paginate(5);
            return $books;
        }
    }
    public function store($input = null)
    {
        $input['user_id'] = Auth::user()->id;
        $book = $this->bookObj->create($input);
        foreach ($input['image'] as $image) {
            $images = new Image();
            $file =  $image->getClientOriginalName();
            $image->move(public_path().'/upload',$file);
            $images->image = $file;
            $images->book_id = $book->id;
            $images->save();
        }
        return $book;
    }
    public function update($id, $input)
    {
        $book = $this->bookObj->with('images')->find($id);
        if ($book == null) {
            $data['errors']['book'][] =  __('book.booknotfound');
            return $data;
        }
        if (isset($input['image'])) {
            foreach ($input['image'] as $image) {
                $images = new Image();
                $file =  $image->getClientOriginalName();
                $image->move(public_path().'/upload',$file);
                $images->image = $file;
                $images->book_id = $book->id;
                $images->save();
            }
        }
        $book->update($input);
        return $book->where('id', $book->id)->with(['images', 'user'])->first();
    }
    public function delete($id)
    {
        $book = $this->bookObj->where('id', $id)->with(['images', 'user'])->first();

        if ($book == null) {
            $data['errors']['book'][] =  __('book.booknotfound');
            return $data;
        }
        foreach ($book->images as $image) {
            $images =  $image->delete();
            Storage::disk('public')->delete($image->image);
        }
        $book =  $book->delete();
        if ($book == true && $images == true) {
            return $data['message']['book'][] =  __('book.datdeleted');
        }
    }
    public function images($id, $input)
    {
        $book = $this->bookObj->with('images')->find($id);
        foreach ($book->images as $images) {
            if ($images->id != $input['image_id']) {
                $data['errors']['imagenotfound'][] =  __('book.imagenotfound');
                return $data;
            } else {
                $images->delete();
                $imagestore = Storage::disk('public')->delete($images->image);
                if ($imagestore == true) {
                    $data['message']['imagedeleted'] = __('book.imagedeleted');
                    return $data;
                }
            }
        }
    }
}
