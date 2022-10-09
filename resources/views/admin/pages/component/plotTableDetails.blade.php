<table class="table table-bordered">
                          <tr>
                            <th>Plot Number / Booking Date</th>
                             <td>{{ $plotsDetails->plot_number ?? "N/A"}} <strong>/</strong> 
                             {{ \Carbon\Carbon::parse($plotsDetails->booking_date)->format(config('app.date_format')) }}</td>
                             <th>Plot Area (in Gaj)</th>
                             <td>{{ $plotsDetails->plot_area ?? "N/A"}}</td>
                             <th>Plot Size (in Gaj)</th>
                             <td>{{ $plotsDetails->plot_size_in_gaj ?? "N/A"}}</td>
                          </tr>
                          <tr>
                            <th>Plots Value</th>
                             <td>{{ $plotsDetails->plot_value ?? "0" }} INR.</td>
                             <th>Paid Amount</th>
                             <td>{{ $plotsDetails->totalPaidAmount ?? "0" }} INR.</td>
                             <th>Remain Amount</th>
                             <td>{{ $plotsDetails->remainAmount ?? "0" }} INR.</td>
                          </tr>
                          <tr>
                             <th>Booking Status</th>
                             <td>{{ $plotsDetails->bookingStatus ?? "" }}. {{ !empty($plotsDetails->holdDate) ? "Till ".$plotsDetails->holdDate : " "}}</td>
                             <th>Broker Name / Broker Commission</th>
                             <td>{{ $plotsDetails->f_name ?? "N/A" }}
                                 /
                             	 {{ !empty($plotsDetails->broker_commission)  ? $plotsDetails->broker_commission : 0 }} INR.</td>
                             <th>Buyer Name</th>
                             <td>{{ $plotsDetails->buyer->f_name ?? $plotsDetails->buyer_name }}</td>
                          </tr>
                      </table>