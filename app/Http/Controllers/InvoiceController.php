<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Mail\SendInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

use PDF;



class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::orderBy('id','desc')->paginate(10);
        return view('front.index',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('front.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data['customer_name']= $request->customer_name;
      $data['customer_email']= $request->customer_email;
      $data['customer_mobile']= $request->customer_mobile;
      $data['company_name']= $request->company_name;
      $data['invoice_number']= $request->invoice_number;
      $data['invoice_date']= $request->invoice_date;
      $data['sub_total']= $request->sub_total;
      $data['discount_type']= $request->discount_type;
      $data['discount_value']= $request->discount_value;
      $data['vat_value']= $request->vat_value;
      $data['shipping']= $request->shipping;
      $data['total_due']= $request->total_due;

        $invoice = Invoice::create($data);

        $details_list = [];
        for ($i=0; $i< count($request->product_name); $i++){
            $details_list[$i]['product_name'] = $request->product_name[$i];
            $details_list[$i]['unit'] = $request->unit[$i];
            $details_list[$i]['quantity'] = $request->quantity[$i];
            $details_list[$i]['unit_price'] = $request->unit_price[$i];
            $details_list[$i]['row_sub_total'] = $request->row_sub_total[$i];

        }
        $details = $invoice->details()->createMany($details_list);
        if($details){
            return redirect()->back()->with([
                'message' => 'created successfully',
                'alert-type'=>'success'
            ]);
        }else{
            return redirect()->back()->with([
               'message' => 'Created failed',
                'alert-type'=> 'danger'
            ]);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('front.show',compact('invoice'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('front.edit',compact('invoice'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $invoice = Invoice::whereId($id)->first();
        $data['customer_name']= $request->customer_name;
        $data['customer_email']= $request->customer_email;
        $data['customer_mobile']= $request->customer_mobile;
        $data['company_name']= $request->company_name;
        $data['invoice_number']= $request->invoice_number;
        $data['invoice_date']= $request->invoice_date;
        $data['sub_total']= $request->sub_total;
        $data['discount_type']= $request->discount_type;
        $data['discount_value']= $request->discount_value;
        $data['vat_value']= $request->vat_value;
        $data['shipping']= $request->shipping;
        $data['total_due']= $request->total_due;

        $invoice->update($data);

        $invoice->details()->delete();

        $details_list = [];
        for ($i=0; $i< count($request->product_name); $i++){
            $details_list[$i]['product_name'] = $request->product_name[$i];
            $details_list[$i]['unit'] = $request->unit[$i];
            $details_list[$i]['quantity'] = $request->quantity[$i];
            $details_list[$i]['unit_price'] = $request->unit_price[$i];
            $details_list[$i]['row_sub_total'] = $request->row_sub_total[$i];

        }
        $details = $invoice->details()->createMany($details_list);
        if($details){
            return redirect()->back()->with([
                'message' => 'updated successfully',
                'alert-type'=>'success'
            ]);
        }else{
            return redirect()->back()->with([
                'message' => 'updated failed',
                'alert-type'=> 'danger'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
      if($invoice){
          $invoice->delete();
          return redirect()->route('invoice.index')->with([
             'message' => 'invoice deleted successfully',
              'alert-type' =>'success'
          ]);
      }else{
          return redirect()->route('invoice.index')->with([
              'message' => 'invoice deleted failed',
              'alert-type' =>'danger'
          ]);
      }
    }
  public function printt($id)
 {
     $invoice = Invoice::findOrFail($id);
        return view('front.print',compact('invoice'));
 }

    public function pdf($id)
{
     $invoice = Invoice::findOrFail($id);

         $data['invoice_id'] = $invoice->id;
         $data['invoice_date'] = $invoice->date;
         $data['customer'] = [
          'customer_name' => $invoice->customer_name,
          'customer_email' => $invoice->customer_email,
          'customer_mobile' => $invoice->customer_mobile,
         ];
       $items = [];
       foreach($invoice->details()->get() as $item){
           $items[] = [
               'product_name' => $item->product_name,
               'unit' => $item->unit,
               'quantity' => $item->quantity,
               'unit_price' => $item->unit_price,
               'row_sub_total'=> $item->row_sub_total,
           ];
       }

     $data ['items']  = $items;
        $date ['invoice_number'] = $invoice->invoice_number;
        $data ['create_at'] = $invoice->create_at;
        $data ['sub_total'] = $invoice->sub_total;
        $data ['discount'] = $invoice->discount;
        $data ['vat_value'] = $invoice->vat_value;
        $data ['shipping'] = $invoice->shipping;
        $data ['total_due'] = $invoice->total_due;

        $pdf = PDF::loadView('front.pdf', $data);

            if(Route::currentRouteName() == 'invoice.pdf'){

                return $pdf->stream($invoice->invoice_number . '.pdf');
            }else{
                $pdf->save(public_path('assets/invoices/').$invoice->invoice_number.'.pdf');
                return $invoice->invoice_number .'.pdf' ;
            }

}

    public function send_to_email($id)
    {
        $invoice = Invoice::whereId($id)->first();
        $this->pdf($id);
        Mail::to($invoice->customer_email)->locale(config('app.locale'))->send(new SendInvoice($invoice));
        return redirect()->route('invoice.index')->with([
            'message' => 'invoice send successfully',
            'alert-type' =>'success'
        ]);

    }
}