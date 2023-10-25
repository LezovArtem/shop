<?php

namespace App\Http\Controllers\V1;

use App\DTO\Factories\InvoiceDtoFactory;
use App\Models\Invoice;
use App\Filters\V1\InvoiceFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Http\Resources\Invoice\InvoiceResource;
use App\Services\InvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct(private InvoiceService $invoiceService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new InvoiceFilter();
        $queryItems = $filter->transform($request);

        if (empty($queryItems)){
            return InvoiceResource::collection(Invoice::paginate());
        } else {
            $invoices = Invoice::where($queryItems)->paginate();
            return InvoiceResource::collection($invoices->appends($request->query()));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request, InvoiceDtoFactory $dtoFactory)
    {
        $dto = $dtoFactory->createFromRequest($request);

        $invoice = $this->invoiceService->store($dto);

        return $invoice instanceof Invoice ? new InvoiceResource($invoice) : $invoice;
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice, InvoiceDtoFactory $dtoFactory)
    {
        $dto = $dtoFactory->createFromRequest($request);

        $invoice = $this->invoiceService->update($invoice, $dto);

        return $invoice instanceof Invoice ? new InvoiceResource($invoice) : $invoice;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
    }
}
