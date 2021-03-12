<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Book\Upsert;
use App\Http\Requests\Book\images;
use App\Traits\ApiResponser;
use App\Services\BookService;
use App\Models\Book;
use App\Http\Resources\Book\Resource as BookResource;
use App\Http\Resources\Book\collection as BookCollection;

class BookController extends Controller
{
    use ApiResponser;

    private $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }
    public function index(Request $request)
    {
        $data = $this->bookService->collection($request->all());
        return $this->collection(new BookCollection($data));

    }
    public function store(Upsert $request)
    {
        $data = $this->bookService->store($request->all());
        return $this->resource(new BookResource($data));
    }
    public function show($id,Request $request)
    {
        $data = $this->bookService->show($id);
        return isset($data['errors']) ? $this->error($data) : $this->resource(new BookResource($data));
    }
    public function update(Upsert $request,$id)
    {
        $data = $this->bookService->update($id, $request->all());
        return isset($data['errors']) ? $this->error($data) : $this->resource(new BookResource($data));
    }
    public function destroy($id)
    {
        $data = $this->bookService->delete($id);
        return isset($data['errors']) ? $this->error($data) :  $this->success($data, 200);
    }
    public function removeImage($id,images $request)
    {
        $data = $this->bookService->removeImage($id,$request->all());
        return isset($data['errors']) ? $this->error($data) :  $this->success($data, 200);
    }
}
