<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use Core\Domain\Repositories\OrderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    public function __construct(
        protected OrderRepositoryInterface $repository
    ){}

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

    public function store(StoreOrderRequest $request)
    {
        $output = $this->repository->register($request->validated());
 
        return (new OrderResource($output))
                                ->response()
                                ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $output = $this->repository->findById($id);

        return (new OrderResource($output));
    }

    public function cancel(string $id, Request $request)
    {
        $output = $this->repository->cancel($id, $request->input('userId'));

        return (new OrderResource($output));
    }
}
