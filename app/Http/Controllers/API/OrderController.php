<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Core\Domain\Repositories\OrderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    public function __construct(
        protected OrderRepositoryInterface $repository
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $output = $this->repository->paginateByUser(
                $request->get('filter', ''),
                $request->get('order', 'DESC'),
                $request->get('page', 1),
                $request->get('totalPerPage', 15)
        );

        return OrderResource::collection(collect($output->items()))
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
    public function store(StoreOrderRequest $request)
    {
        $output = $this->repository->register($request->validated());
 
        return (new OrderResource($output))
                                ->response()
                                ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $output = $this->repository->findById($id);

        return (new OrderResource($output));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function cancel(string $id, Request $request)
    {
        $output = $this->repository->cancel($id, $request->input('userId'));

        return (new OrderResource($output));
    }
}
