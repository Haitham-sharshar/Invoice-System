@extends('layouts.print')
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex">
                     <h2>Invoice </h2>
                </div>
                 <div class="card-body">
                     <div class="table-responsive">
                         <table class="table">
                             <tr>
                                 <th>Customer name</th>
                                 <td>{{$invoice->customer_name}}</td>
                                 <th>Customer email</th>
                                 <td>{{$invoice->customer_email}}</td>
                             </tr>
                             <tr>
                                 <th>Customer mobile</th>
                                 <td>{{$invoice->customer_mobile}}</td>
                                 <th>Cumpany name</th>
                                 <td>{{$invoice->company_name}}</td>
                             </tr>
                             <tr>
                                 <th>Invoice number</th>
                                 <td>{{$invoice->invoice_number}}</td>
                                 <th>Invoice date</th>
                                 <td>{{$invoice->invoice_date}}</td>
                             </tr>
                         </table>
                         <h3>invoice details</h3>
                         <table class="table">
                             <thead>
                               <tr>
                                    <th></th>
                                    <th>Product name</th>
                                    <th>Unit</th>
                                    <th>Quantity</th>
                                    <th>Unit price</th>
                                    <th>Subtotal</th>
                               </tr>
                             </thead>
                             <tbody>
                             @foreach($invoice->details as $item)
                                <tr>
                                    <td with="5%">{{$loop->iteration}}</td>
                                    <td with="35%">{{$item->product_name}}</td>
                                    <td with="10%">{{$item->unit}}</td>
                                    <td with="10%">{{$item->quantity}}</td>
                                    <td width="10%">{{$item->unit_price}}</td>
                                    <td>{{$item->row_sub_total}}</td>
                                </tr>
                                 @endforeach
                             </tbody>
                             <tfoot>
                               <tr>
                                   <td colspan="3"></td>
                                   <th colspan="2">Sub total</th>
                                   <td>{{$invoice->sub_total}}</td>
                               </tr> <tr>
                                   <td colspan="3"></td>
                                   <th colspan="2">Discount</th>
                                   <td>{{$invoice->discount}}</td>
                               </tr> <tr>
                                   <td colspan="3"></td>
                                   <th colspan="2">Vat value</th>
                                   <td>{{$invoice->vat_value}}</td>
                               </tr> <tr>
                                   <td colspan="3"></td>
                                   <th colspan="2">shipping</th>
                                   <td>{{$invoice->shipping}}</td>
                               </tr> <tr>
                                   <td colspan="3"></td>
                                   <th colspan="2">Total due</th>
                                   <td>{{$invoice->total_due}}</td>
                               </tr>
                             </tfoot>
                         </table>
                     </div>
                 </div>
               </div>
             </div>
          </div>
   @endsection
  @section('script')
      <script>
          window.print();
      </script>
      @endsection