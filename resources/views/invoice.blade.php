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
<div style="background:#9b99991c;padding:0px;">
	<div class="sec-pay" id="printDiv" style="background: white;width: 100%;max-width:750px;margin: 20px auto 20px auto;">
        <div id="container" style="margin:10px;">
            <table border="0" class="table-responsive" cellpadding="3" cellspacing="3" style="width: 100%;">
           		<tbody>
                    <tr>
                        <td>
                            <table border="0" class="table-responsive" cellpadding="3" cellspacing="3" style="width:100%">
                       		   <tbody>
                                	<tr>
                                        <td width="20%"><img src="https://lakhmanis.in/public/lakhmani_web/assets/images/logo.png" style="width:190px;height:auto;" />
                                        </td>
                                        <td width="60%"><div style="text-align:center;"><span class="company-address" style="font-size: 20px;font-weight: 700;color: #0b0a0a;font-family: sans-serif;display: inline-block;">{{$paymentHistory->plotPaymentHistory->plotSociety->name??"N/A"}} </span><br>
                                         <span style="color: #888;display:inline-block;min-width: 15px;">
                                                       (A PUBLIC HOUSEING SCHEME)</span><br>
                                         <span class="company-email" style="color: #888;display:inline-block;min-width: 15px;">{{$paymentHistory->plotPaymentHistory->plotSociety->location??"N/A"}}</span><br>
                                         <span class="company-email" style="color: #888;display:inline-block;min-width: 15px;">Mobile No: {{$buyerDetail->mobile??"N/A"}}</span><br></td>
                                            <td width="20%"><span style="color:#7fb8dc; font-weight: bold;">Date:</span>
                                         <span>{{\Carbon\Carbon::parse($paymentHistory->paid_amount_date)->format(config('app.date_format'))}}</span></div></td>
                                    </tr>
                               </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table style="padding: 20px;border: 1px #cac6c6 solid;background: #99c4e62b;width: 100%;margin-top: 10px;">
           	                    <tbody>
                                    <tr>
                                        <td>
                                            <div id="memo" style="width:100%; display:inline-flex; margin-top:20px;">                                                                                    <div style="width:50%;">
                                                      <span style=" font-size:16px;font-weight:bold;font-family: sans-serif;">Receipt No. :</span>
                                                      <span style="line-height:28px;">{{$buyerDetail->login_id??"--"}}</span><br>
                                                      <span style=" font-size:16px;font-weight:bold;font-family: sans-serif;">Account No.:</span>
                                                      <span style="line-height:28px;">{{$accountNumber??"--"}}</span><br>
                                                      <span style=" font-size:16px;font-weight:bold;font-family: sans-serif;">Plot No.:</span>
                                                      <span style="line-height:28px;"> {{$paymentHistory->plotPaymentHistory->plot_number??"N/A"}}</span><br>
                                                      <span style=" font-size:16px;font-weight:bold;font-family: sans-serif;">Project :</span>
                                                      <span style="line-height:28px;">
                                                        {{$paymentHistory->plotPaymentHistory->plotSociety->name??"N/A"}}</span><br>
                                                </div>
                                                 <div style=" width:50%;text-align:right;">
                                                     <span style=" font-size:16px;font-weight:bold;font-family: sans-serif;">Aadhar No:</span>
                                                      <span style="line-height:28px;">{{$buyerDetail->id_proof_number??"N/A"}}</span><br>
                                                      <span style=" font-size:16px;font-weight:bold;font-family: sans-serif;">Area:</span>
                                                      <span style="line-height:28px;">{{$paymentHistory->plotPaymentHistory->plot_area??"N/A"}} </span><br>
                                                      <span style=" font-size:16px;font-weight:bold;font-family: sans-serif;">Total Plot Value:</span>
                                                      <span style="line-height:28px;"> {{$paymentHistory->plotPaymentHistory->plot_value??"N/A"}}</span>
                                                        <br>
                                                      <span style=" font-size:16px;font-weight:bold;font-family: sans-serif;">Agent Name:</span>
                                                      <span style="line-height:28px;"> {{$brokerDetail->f_name??"N/A"}}</span><br>
                                                </div>
                                           </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div id="memo" style="width:100%; display:inline-flex; margin-top:20px;">
                                                   <div style=" width:50%;">
                                                     <span style=" font-size:16px;font-weight:bold;font-family:sans-serif;">Customer name:</span>
                                                      <span style="line-height:28px;">{{$buyerDetail->f_name??"N/A"}}</span><br>
                                                      <span style=" font-size:16px;font-weight:bold;font-family: sans-serif;">Address:</span>
                                                      <span style="line-height:28px;">{{$buyerDetail->description??"N/A"}}</span><br>
                                                      <span style=" font-size:16px;font-weight:bold;font-family: sans-serif;">Total Amount :</span>
                                                      <span style="line-height:28px;">
                                                        {{$paymentHistory->plotPaymentHistory->plot_value??"N/A"}}
                                                      </span><br>
                                                      <span style=" font-size:16px;font-weight:bold;font-family: sans-serif;">Amount In Words :</span>
                                                      <span style="line-height:28px;"> 
                                                        @php
                                                            $totalAmount = $paymentHistory->plotPaymentHistory->plot_value??0;
                                                            $amountInword = \Terbilang::make($totalAmount, " INR.");
                                                        @endphp
                                                            {{ucfirst($amountInword)}}
                                                      </span><br>
                                                </div>
                                                <div style=" width:50%;text-align:right;">
                                                     <span style=" font-size:16px;font-weight:bold;font-family: sans-serif;">Installment No :</span>
                                                      <span style="line-height:28px;">{{$paymentHistory->installment_number??0}}</span><br>
                                                      <span style=" font-size:16px;font-weight:bold;font-family: sans-serif;">Installment Amount:</span>
                                                      <span style="line-height:28px;">  
                                                        {{$paymentHistory->plotPaymentHistory->payment_of_emi??"N/A"}}</span><br>
                                                      <span style=" font-size:16px;font-weight:bold;font-family: sans-serif;">Booking Deposited Amt :</span>
                                                      <span style="line-height:28px;">
                                                        {{$paymentHistory->plotPaymentHistory->down_payment_amount??"N/A"}}</span><br>
                                                      <span style=" font-size:16px;font-weight:bold;font-family: sans-serif;">Due Amount :</span>
                                                      <span style="line-height:28px;"> 
                                                        {{$paymentHistory->remain_amount??"N/A"}}</span><br>
                                                </div>
                                           </div>
                                        </td>
                                    </tr>
                                   
                                </tbody>
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
    <div style="text-align:center;padding-bottom: 15px;">
    <button onclick="printInvoice()" style="background: #0d6094;border: none;border-radius: 5px;color: #fff;padding: 10px;">Print of Authority</button>
    <button onclick="printInvoice()" style="background: #0d6094;border: none;border-radius: 5px;color: #fff;padding: 10px;">Print of Admin</button>

</div>
</div>

</body>
</html>

