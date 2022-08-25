<?php

namespace App\Http\Controllers\Api\Faqs;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\Faq\Faq;
use App\Models\FaqCategory\FaqCategory;
use App\Http\Requests\Api\Faq\StoreFaqRequest;
use App\Http\Requests\Api\Faq\UpdateFaqRequest;
use App\Http\Resources\Api\V1\Faqs\FaqsResource;
use App\Http\Resources\Api\V1\Faqs\FaqResource;

class FaqController extends BaseController
{
    private $faqs;
    private $categories;

    public function __construct(Faq $faqs, faqCategory $categories)
    {
        $this->middleware('permission:view_faqs', ['only' => ['index']]);
        $this->middleware('permission:add_faqs', ['only' => [ 'store']]);
        $this->middleware('permission:edit_faqs', ['only' => ['update']]);
        $this->middleware('permission:delete_faqs', ['only' => ['destroy']]);

        $this->faqs = $faqs;
        $this->categories = $categories;
    }

    public function index(Request $request)
    {
        $query = $this->faqs->orderBy('question', 'ASC');

        if ($request->filled('question')) {
            $query = $query->where('question', 'LIKE', '%' . $request->question . '%');
        }

        if ($request->filled('active')) {
            $query = $query->where('active', $request->active);
        }

        if ($request->filled('category_id')) {
            $query = $query->where('category_id', $request->category_id);
        }

        $results = $query->paginate(10);

        return ($results->count() == 0) ?
            $this->notFoundResponse() :
            FaqsResource::collection($results);
    }

    public function show($uuid)
    {
        $result = $this->faqs->findByUuid($uuid);

        return new FaqResource($result);
    }

    public function store(StoreFaqRequest $request)
    {
        try {

            $this->faqs->create($request->all());

            return response()->json([
                'message' => 'Pergunta criada com sucesso!'
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Falha ao criar nova pergunta'
            ], 500);
        }
    }

    public function update(UpdateFaqRequest  $request, $uuid)
    {
        $result = $this->faqs->findByUuid($uuid);

        try {

            $result->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Pergunta atualizada com sucesso!'
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Falha ao atualizar pergunta'
            ], 500);
        }
    }

    public function destroy($uuid)
    {
        $result = $this->faqs->findByUuid($uuid);

        try {

            $result->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pergunta excluida com sucesso!'
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Falha ao excluir pergunta'
            ], 500);
        }
    }
}
