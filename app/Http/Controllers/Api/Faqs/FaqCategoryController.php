<?php

namespace App\Http\Controllers\Api\Faqs;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\FaqCategory\FaqCategory;
use App\Http\Requests\Api\Faq\StoreFaqCategoryRequest;
use App\Http\Requests\Api\Faq\UpdateFaqCategoryRequest;
use App\Http\Resources\Api\V1\Faqs\FaqsCategoryResource;
use App\Http\Resources\Api\V1\Faqs\FaqCategoryResource;


class FaqCategoryController extends BaseController
{
    private $categories;

    public function __construct(FaqCategory $categories)
    {
        // $this->middleware('permission:view_faqs_submodules', ['only' => ['index']]);
        // $this->middleware('permission:add_faqs_submodules', ['only' => ['store',]]);
        // $this->middleware('permission:edit_faqs_submodules', ['only' => ['update']]);
        // $this->middleware('permission:delete_faqs_submodules', ['only' => ['destroy']]);

        $this->categories =  $categories;
    }

    public function index(Request $request)
    {
        $query = $this->categories->orderBy('title');

        if ($request->filled('title')) {
            $query = $query->where('title', 'LIKE', '%' . $request->title . '%');
        }

        if ($request->filled('active')) {
            $query = $query->where('active', $request->active);
        }

        $results = $query->paginate(10);

        return ($results->count() == 0) ?
            $this->notFoundResponse() :
            FaqsCategoryResource::collection($results);
    }

    public function show($uuid)
    {
        $result = $this->categories->findByUuid($uuid);

        return new FaqCategoryResource($result);
    }

    public function store(StoreFaqCategoryRequest $request)
    {
        try {

            $this->categories->create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Categoria criada com sucesso!',
            ], 200);
        } catch (\Exception $e) {
            dd($e);
            return response()->json([
                'success' => false,
                'message' => 'Falha ao adicionar categoria, verifique os dados e tente novamente.'
            ], 400);
        }
    }

    public function update(UpdateFaqCategoryRequest  $request, $uuid)
    {
        $result = $this->categories->findByUuid($uuid);

        try {

            $result->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Categoria atualizada com sucesso!'
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Falha ao atualizar categoria'
            ], 500);
        }
    }

    public function destroy($uuid)
    {
        $result = $this->categories->findByUuid($uuid);

        try {

            $result->delete();

            return response()->json([
                'message' => 'Categoria excluida com sucesso!'
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Falha ao excluir categoria'
            ], 500);
        }
    }
}
