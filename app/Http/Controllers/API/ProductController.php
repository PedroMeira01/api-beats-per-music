<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $service
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $output = $this->service->paginate(
            filter: $request->get('filter', ''),
            order: $request->get('order', 'DESC'),
            page: $request->get('page', 1),
            totalPerPage: $request->get('totalPerPage', 15),
        );

        return ProductResource::collection(collect($output->items()))
                                ->additional([
                                    'meta' => [
                                        'total' => $output->total(),
                                        'current_page' => $output->currentPage(),
                                        'last_page' => $output->lastPage(),
                                        'first_page' => $output->firstItem(),
                                        'per_page' => $output->perPage(),
                                        'to' => $output->firstItem(),
                                        'from' => $output->lastItem()
                                    ]
                                ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $output = $this->service->store($request->validated());

        return (new ProductResource($output))
                                ->response()
                                ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $output = $this->service->findById($id);

        return (new ProductResource($output));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $output = $this->service->update($id, $request->validated());

        return (new ProductResource($output));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->service->delete($id);

        return response()->noContent();
    }
}
