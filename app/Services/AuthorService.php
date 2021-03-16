<?php

namespace App\Services;

use App\Models\Author;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Traits\ApiResponser;
use App\Models\Tag;
use DB;
use GuzzleHttp\Promise\Create;

class AuthorService
{
    use ApiResponser;

    private $authorObj;

    public function __construct(Author $authorObj)
    {
        $this->authorObj = $authorObj;
    }
    public function collection()
    {
        if (!empty($input['name'])) {
            $authors = $this->authorObj->with(['books'])->where('name', 'like', '%' . $input['name'] . '%')->paginate(5);
        } else {
            $books = $this->authorObj->with(['books'])->paginate(5);
        }
        return $books;
    }
    public function store($input = null)
    {
        $author = $this->authorObj->create($input);
        if (!empty($input['tag'])) {
            foreach ($input['tag'] as $tags) {
                $tag = Tag::firstOrCreate(['name' => $tags]);
                $author->tags()->attach($tag->id);
            }
        }
        return $author;
    }
    public function show($id)
    {
        $author = $this->authorObj->where('id', $id)->with(['books'])->first();
        if ($author == null) {
            $data['errors']['author'][] =  __('author.authorNotFound');
            return $data;
        }
        return $author;
    }
    public function update($id,$input = null)
    {
        $author = $this->authorObj->where('id', $id)->with(['books'])->first();
        if ($author == null) {
            $data['errors']['author'][] =  __('author.authorNotFound');
            return $data;
        }
        if (!empty($input['tag'])) {
            foreach ($input['tag'] as $tags) {
                $tag = Tag::updateOrCreate (['name' => $tags]);
                $author->tags()->attach($tag->id);
            }
        }
        $author->update($input);
        return $author->where('id', $author->id)->with(['books'])->first();
    }
    public function delete($id)
    {
        $author = $this->authorObj->where('id', $id)->with(['books'])->first();
        
        if ($author == null) {
            $data['errors']['author'][] =  __('author.authorNotFound');
            return $data;
        }
        if ($author->tags !== null) {
            $author->tags()->detach($author->tags->pluck('id'));
        }
        $author =  $author->delete();
        if ($author== true) {
            return $data['message']['author'][] =  __('author.dataDeleted');
        }    
    }
}
