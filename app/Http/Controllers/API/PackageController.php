<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\PatchPackageRequest;
use App\Http\Requests\API\PutPackageRequest;
use App\Http\Requests\API\StorePackageRequest;
use App\Packages\Rest\Rest;
use App\Services\PackageService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class PackageController extends Controller
{
    public function __construct(
        protected PackageService $packageService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->packageService->getAll();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackageRequest $request)
    {
        $data = $request->getData();

        try {
            $this->packageService->getByTransactionID($data->transaction_id);

            return Rest::error(Response::HTTP_BAD_REQUEST, "Transaction ID {$data->transaction_id} already exists.");
        } catch (\Throwable $th) {
            if ($th instanceof ModelNotFoundException) {
                return $this->packageService->store($data);
            }

            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->packageService->getByTransactionID($id);
    }

    public function upsert(PutPackageRequest $request, string $id)
    {
        if ($id !== $request->transaction_id) {
            return Rest::error(Response::HTTP_BAD_REQUEST, "Transaction ID {$request->transaction_id} is not same as ID {$id}.");
        }

        return $this->packageService->upsert($request->getData(), $id);
    }

    public function updatePartial(PatchPackageRequest $request, string $id)
    {
        return $this->packageService->updatePartial($request->getData(), $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->packageService->getByTransactionID($id);

        $this->packageService->delete($id);
    }
}
