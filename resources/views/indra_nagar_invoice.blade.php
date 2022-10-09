<html>
   <head>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>
      <script>
         function printInvoice()
         
         {
         
             printDiv = "#printDiv"; // id of the div you want to print
         
             $("*").addClass("no-print");
         
             $(printDiv+" *").removeClass("no-print");
         
             $(printDiv).removeClass("no-print");
         
         
         
             parent =  $(printDiv).parent();
         
             while($(parent).length)
         
             {
         
                 $(parent).removeClass("no-print");
         
                 parent =  $(parent).parent();
         
             }
         
             window.print();
         
         
         
         }
         
      </script>
   </head>
   <style>
      @media print {
      .no-print{
      display : none !important;
      }
      @page {
      margin-top: 0;
      margin-bottom: 0;
      }
      body  {
      padding-top: 20px;
      padding-bottom: 20px ;
      }
      }
   </style>
   <body>
      <div style="background:#9b99991c;" id="printDiv" >
         <div class="sec-pay"  style="background: white;width: 100%;max-width:750px;margin: 20px auto 20px auto;">
            <div id="container" style="margin:10px;">
               <table border="0" class="table-responsive" cellpadding="3" cellspacing="3" style="width:100%">
                  <tbody>
                     <tr>
                        <td>
                           <table border="0" class="table-responsive" cellpadding="3" cellspacing="3" style="width:100%">
                              <tbody>
                                 <tr>
                                    <td width="20%"><img src="https://lakhmanis.in/public/lakhmani_web/assets/images/logo.png" style="width:190px;height:auto;" /></td>
                                    <td width="60%">
                                       <div style="text-align:center;">
                                          <span class="company-address" 
                                                style="font-size: 20px;font-weight: 700;
                                                         text-transform: uppercase;
                                                       color: #0b0a0a;font-family: sans-serif;
                                                       display: inline-block;">
                                                {{ $plotDetail->plotSociety->name ?? "N/A" }}</span>
                                                <br>
                                          <span style="color: #888;display:inline-block;min-width: 15px; margin-top:10px;">
                                          (A PUBLIC HOUSEING SCHEME)</span><br>
                                          <span class="company-email" style="color: #888;display:inline-block;min-width: 15px;">{{ $plotDetail->plotSociety->location ?? "N/A" }}</span><br>
                                          <span class="company-email" style="color: #888;display:inline-block;min-width: 15px;">Mobile No: {{$buyerDetail->mobile??"N/A"}}</span><br>
                                    </td>
                                    <td width="20%"><span style="color:#7fb8dc; font-weight: bold;">Date: {{ \Carbon\Carbon::parse( date('Y-m-d') )->format(config('app.date_format')) }}</span>
                                    <span></span></div></td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                     <tr>
                        <td style="padding: 20px;border: 1px #cac6c6 solid;background: #99c4e62b;width: 100%;margin-top: 10px;">
                           <table style="width: 100%;margin-top: 10px;">
                              <tbody>
                                 <tr>
                                    <td>
                                       <div id="memo" style="width:100%; display:inline-flex; margin-top:20px;">
                                          <div style=" width:50%;">
                                             <span style=" font-size:16px;font-weight:bold;font-family: sans-serif;">Name :</span>
                                             <span style="line-height:28px;">{{ $plotDetail->plotSociety->name ?? "N/A" }}</span><br>
                                             <span style=" font-size:16px;font-weight:bold;font-family: sans-serif;">Block No. :</span>
                                             <span style="line-height:28px;">{{ $plotDetail->plotBlock->title ?? "N/A" }}</span><br>
                                             <span style=" font-size:16px;font-weight:bold;font-family: sans-serif;">Address :</span>
                                             <span style="line-height:28px;">{{ $plotDetail->plotSociety->location ?? "N/A" }}</span><br>
                                             <span style=" font-size:16px;font-weight:bold;font-family: sans-serif;">Name :</span>
                                             <span style="line-height:28px;">{{ sHelper::getFullName($buyerDetail)}}</span><br>
                                             <span style=" font-size:16px;font-weight:bold;font-family: sans-serif;">Phone Number :</span>
                                             <span style="line-height:28px;"> {{ $buyerDetail->mobile ?? "N/A"}}</span>
                                          </div>
                                          <div style=" width:50%;text-align:right;">
                                             <span style="font-size: 18px;
                                                font-weight: 800;
                                                color: #da2b2b;
                                                font-family: sans-serif;">Invoice :</span>
                                             <span style="line-height:28px;">{{$plotDetail->id}}</span><br>
                                             <span style=" font-size:16px;font-weight:bold;font-family: sans-serif;">Plot No. :</span>
                                             <span style="line-height:28px;"> {{$plotDetail->plot_number ?? ""}}  {{ $plotDetail->plot_area ?? "" }}</span><br>
                                             <span style=" font-size:16px;font-weight:bold;font-family: sans-serif;">Booking Date :</span>
                                             <span style="line-height:28px;">{{ \Carbon\Carbon::parse($plotDetail->booking_date)->format(config('app.date_format')) }}</span>
                                          </div>
                                       </div>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                     <tr>
                        <td style="width: 100%;margin-top: 10px;padding: 0px;">
                           <table border="0" class="table-responsive" cellpadding="5" cellspacing="" style="width:100%;border-collapse: collapse;">
                              <tr>
                                 <th align="left" style="color: #fff;
                                    background:#29536d;
                                    padding: 13px 7px; width:70%;border-left: 1px #cac6c6 solid;
                                    border-right: 1px #cac6c6 solid;">DESCRIPTION</th>
                                 <th style="color: #fff;
                                    background: #29536d;
                                    padding: 13px 7px; width:30%;border-left: 1px #cac6c6 solid;
                                    border-right: 1px #cac6c6 solid;" align="left">AMOUNT</th>
                              </tr>
                              <tr>
                                 <td style="background: #fff;
                                    border-left: 1px #cac6c6 solid;
                                    border-right: 1px #cac6c6 solid;">Plot Value :- {{ $plotDetail->plot_description ?? "N/A" }}</td>
                                 <td style="background: #fff;
                                    border-left: 1px #cac6c6 solid;
                                    border-right: 1px #cac6c6 solid;">{{ $plotDetail->plot_value ?? 0 }} INR.</td>
                              </tr>
                              @if($plotDetail->plotPaymentHistory->count() > 0)
                              @forelse ($plotDetail->plotPaymentHistory as $payment)
                              @php
                              $paymentDetail = sHelper::returnPaymentMethodStatus($payment);   
                              @endphp
                              <tr>
                                <td style="background: #fff;
                                    border-left: 1px #cac6c6 solid;
                                    border-right: 1px #cac6c6 solid;">{{ $loop->iteration }} Pay amount ( {{ $paymentDetail->PaymentMethodStatus}},
                                    {{  \Carbon\Carbon::parse($payment->paid_amount_date)->format(config('app.date_format')) }} )
                                </td>
                                 <td style="background: #fff;
                                    border-left: 1px #cac6c6 solid;
                                    border-right: 1px #cac6c6 solid;">{{$payment->paid_amount ?? 0 }} INR</td>
                              </tr>
                              @empty
                              <tr>
                                 <td colspan="2">No payment available !!!</td>
                              </tr>
                              @endforelse
                              @else
                              @endif
                              <tr>
                                 <th width="70%" align="left" style="background: #fff;
                                    border: 1px #cac6c6 solid;">Balance</th>
                                 <th width="30%" align="left" style="background: #fff;
                                    border: 1px #cac6c6 solid;">Rs. {{$remainAmount}} INR.</th>
                              </tr>
                           </table>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <table border="0" cellpadding="0" cellspacing="0" style=" margin-top:5px; width:100%">
                              <tbody>
                                 <tr data-iterate="item" style="">
                                    <td style="padding: 10px;vertical-align: top; text-align:right;">
                                       Signature of Authorized Person </p>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <div style="text-align:center">
         <button onclick="printInvoice()" style="background: #0d6094;border: none;border-radius: 5px;color: #fff;padding: 10px;">Print this page</button>
      </div>
   </body>
</html>