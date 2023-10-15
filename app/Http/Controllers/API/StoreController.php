<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreStoreRequest;
use App\Http\Requests\Store\UpdateStoreRequest;
use App\Http\Resources\StoreResource;
use App\Services\StoreService;
use Core\Domain\Repositories\StoreRepositoryInterface;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __construct(
        protected StoreRepositoryInterface $repository
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $output = $this->repository->paginate(
            $request->get('filter', ''),
            $request->get('order', 'DESC'),
            $request->get('page', 1),
            $request->get('totalPerPage', 15)
        );

        return StoreResource::collection(collect($output->items()))
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
    public function store(StoreStoreRequest $request)
    {
        $output = $this->repository->store($request->validated());
 
        return (new StoreResource($output));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $output = $this->repository->findById($id);

        return (new StoreResource($output));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStoreRequest $request, string $id)
    {
        $output = $this->repository->update($id, $request->validated());
        
        return (new StoreResource($output));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $output = $this->repository->delete($id);

        return response()->noContent();
    }
}
