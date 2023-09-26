<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(
        protected UserService $service
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
            totalPerPage: $request->get('totalPerPage', 15)
        );

        return UserResource::collection(collect($output->items()))
                                ->additional([
                                    'meta' => [
                                        'total' => $output->total(),
                                        'current_page' => $output->currentPage(),
                                        'last_page' => $output->lastPage(),
                                        'first_page' => $output->firstItem(),
                                        'per_page' => $output->perPage(),
                                        'to' => $output->firstItem(),
                                        'from' => $output->lastItem(),
                                    ]
                                ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $output = $this->service->store($request->validated());

        return (new UserResource($output))
                    ->response()
                    ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $output = $this->service->findById($id);

        return (new UserResource($output));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $output = $this->service->update($id, $request->validated());

        return (new UserResource($output))->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $output = $this->service->destroy($id);

        return response()->noContent();
    }
}
