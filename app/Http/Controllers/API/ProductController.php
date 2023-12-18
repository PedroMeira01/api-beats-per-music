<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Core\Domain\Repositories\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function __construct(
        protected ProductRepositoryInterface $repository
    ){}

    public function index(Request $request)
    {
        $output = $this->repository->paginate(
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

    public function store(StoreProductRequest $request)
    {
        $output = $this->repository->store($request->validated());

        return (new ProductResource($output))
                                ->response()
                                ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $output = $this->repository->findById($id);

        return (new ProductResource($output));
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $output = $this->repository->update($id, $request->validated());

        return (new ProductResource($output));
    }


    public function destroy(string $id)
    {
        $this->repository->delete($id);

        return response()->noContent();
    }
}
