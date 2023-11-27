<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\DTO\Factories\InvoiceDtoFactory;
use App\Models\Invoice;
use App\Filters\V1\InvoiceFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Http\Resources\Invoice\InvoiceResource;
use App\Repositories\InvoiceRepository;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class InvoiceController extends Controller
{
    public function __construct(private InvoiceService $invoiceService, private InvoiceRepository $invoiceRepository)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $filter = new InvoiceFilter();
        $queryItems = $filter->transform($request);

        $invoices = $this->invoiceRepository->getAll();

        if (empty($queryItems)){
            return response()->json(InvoiceResource::collection($invoices), Response::HTTP_OK);
        } else {
            $invoices = $this->invoiceRepository->withQueryItems($queryItems);

            return response()->json(InvoiceResource::collection($invoices->appends($request->query())), Response::HTTP_OK);
        }
    }

    public function store(StoreInvoiceRequest $request, InvoiceDtoFactory $dtoFactory): JsonResponse
    {
        $dto = $dtoFactory->createFromRequest($request);

        try {
            $invoice = $this->invoiceService->store($dto);
        } catch (Exception $exception){
            return response()->json($exception->getMessage());
        }

        return response()->json(new InvoiceResource($invoice), Response::HTTP_OK);
    }

    public function show(Invoice $invoice): JsonResponse
    {
        return response()->json(new InvoiceResource($invoice), Response::HTTP_OK);
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice, InvoiceDtoFactory $dtoFactory): JsonResponse
    {
        $dto = $dtoFactory->createFromRequest($request);

        try {
            $invoice = $this->invoiceService->update($invoice, $dto);
        } catch (Exception $exception){
            return response()->json($exception->getMessage());
        }

        return response()->json(new InvoiceResource($invoice), Response::HTTP_OK);
    }

    public function destroy(Invoice $invoice): Response
    {
        $invoice->delete();

        return response()->noContent();
    }
}
