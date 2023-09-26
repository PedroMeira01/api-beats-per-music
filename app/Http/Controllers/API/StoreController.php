<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Resources\StoreResource;
use App\Services\StoreService;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __construct(
        protected StoreService $service
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $output = $this->service->paginate(
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
        $output = $this->service->store($request->validated());
        
        return (new StoreResource($output));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $output = $this->service->delete($id);

        return response()->noContent();
    }
}
