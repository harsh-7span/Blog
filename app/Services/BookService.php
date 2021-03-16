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
use App\Traits\MediableUploader;

class BookService
{
    use ApiResponser, MediableUploader;

    private $bookObj;

    public function __construct(book $bookObj)
    {
        $this->bookObj = $bookObj;
    }
    public function collection($input = null)
    {
        if (!empty($input['name'])) {
            $books = $this->bookObj->with(['images', 'user'])->where('name', 'like', '%' . $input['name'] . '%')->paginate(5);
        } else {
            $books = $this->bookObj->with(['images', 'user'])->paginate(5);
        }
        return $books;
    }
    public function store($input = null)
    {
        $input['user_id'] = Auth::user()->id;
        $book = $this->bookObj->create($input);
        if (isset($input['image'])) {
            foreach ($input['image'] as $image) {
                $uploadedMedia = $this->uploadFileViaObj($image, [ 'location' => 'books/' ]);
                $book->attachMedia($uploadedMedia, 'gallery');
            }
        }
        return $book;
    }
    public function update($id, $input)
    {
        $book = $this->bookObj->with('images')->find($id);
        if ($book == null) {
            $data['errors']['book'][] =  __('book.bookNotFound');
            return $data;
        }
        if (isset($input['image'])) {
            foreach ($input['image'] as $image) {
                $uploadedMedia = $this->uploadFileViaObj($image, [ 'location' => 'books/' ]);
                $book->attachMedia($uploadedMedia, 'gallery');
            }
        }
        $book->update($input);
        return $book->where('id', $book->id)->with(['images', 'user'])->first();
    }
    public function show($id)
    {
        $book = $this->bookObj->where('id', $id)->with(['images', 'user'])->first();
        if ($book == null) {
            $data['errors']['book'][] =  __('book.bookNotFound');
            return $data;
        }
        return $book;
    }
    public function delete($id)
    {
        $book = $this->bookObj->where('id', $id)->with(['images', 'user'])->first();

        if ($book == null) {
            $data['errors']['book'][] =  __('book.bookNotFound');
            return $data;
        }
        if ($book->images == null) {
            $data['errors']['imageNotFound'][] =  __('book.imageNotFound');
            return $data;
        }
        foreach ($book->images as $image) {
            Storage::disk('public')->delete($image->image);
            $images =  $image->delete();
        }
        $book =  $book->delete();
        return [];
    }
    public function removeImage($id, $input)
    {
        $book = $this->bookObj->with('images')->find($id);
        if ($book->images == null) {
            $data['errors']['imageNotFound'] =  __('book.imageNotFound');
            return $data;
        }
        foreach ($book->images as $images) {
            if ($images->id != $input['image_id']) {
                $data['errors']['imageNotFound'] =  __('book.imageNotFound');
            } else {
                if (Storage::disk('public')->delete($images->image) && $images->where('id', $input['image_id'])->delete()) {
                    $data['message']['imageDeleted'][] = __('book.imageDeleted');
                    return $data;
                }
            }
        }
        return $data;
    }
}
