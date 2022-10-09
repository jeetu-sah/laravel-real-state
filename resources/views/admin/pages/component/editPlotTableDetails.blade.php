<table class="table table-bordered">
                          <tr>
                             <th>Plot Number / Booking Date</th>
                             <td>{{ $response['plotsDetail']->plot_number ?? "N/A"}}
                               <strong>/</strong>
                              {{ \Carbon\Carbon::parse($plotDetail->booking_date)->format(config('app.date_format')) }}</td>
                              </td>
                             <th>Plot Area (in Gaj)</th>
                             <td>{{ $plotDetail->plot_area ?? "N/A"}}</td>
                             <th>Plot Size (in Gaj)</th>
                             <td>{{ $plotDetail->plot_size_in_gaj ?? "N/A"}}</td>
                          </tr>
                          <tr>
                            <th>Plots Value</th>
                             <td>{{ $plotDetail->plot_value ?? "0" }} INR.</td>
                             <th>Paid Amount</th>
                             <td>{{ $totalPaidAmount ?? "0" }} INR.</td>
                             <th>Remain Amount</th>
                             <td>{{ $remainAmount ?? "0" }} INR.</td>
                          </tr>
                          <tr>
                             <th>Booking Status</th>
                             <td>{{ $bookingStatus ?? "" }}. {{ !empty($plotDetail->hold_date) ? "Till ".  \Carbon\Carbon::parse($plotDetail->hold_date)->format(config('app.date_format')) : " "}}</td>
                          </tr>
                      </table>