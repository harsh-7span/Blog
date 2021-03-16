<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Author\Upsert;
use App\Http\Requests\User\signup;
use App\Http\Requests\User\login;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponser;
use App\Http\Resources\Author\Resource as AuthorResource;
use App\Http\Resources\Author\Collection as AuthorCollection;
use App\Services\AuthorService;

class AuthorController extends Controller
{
    
    use ApiResponser;

    private $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function index(Request $request)
    {
        $data = $this->authorService->collection($request->all());
        return $this->collection(new AuthorCollection($data));
    }
    public function store(Upsert $request)
    {
        $data = $this->authorService->store($request->all());
        return isset($data['errors']) ? $this->error($data) : $this->resource(new AuthorResource($data));
    }
    public function show($id)
    {
        $data = $this->authorService->show($id);
        return isset($data['errors']) ? $this->error($data) : $this->resource(new AuthorResource($data));
    }
    public function update(Upsert $request, $id)
    {
        $data = $this->authorService->update($id, $request->all());
        return isset($data['errors']) ? $this->error($data) : $this->resource(new AuthorResource($data));
    }
    public function destroy($id)
    {
        $data = $this->authorService->delete($id);
        return isset($data['errors']) ? $this->error($data) :  $this->success($data, 200);
    }
}
