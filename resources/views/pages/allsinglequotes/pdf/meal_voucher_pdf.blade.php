<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meal Voucher</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page {
            size: A4;
            margin: 0.5cm;
        }
        body {
            font-family: Arial, sans-serif;
        }
        .border-table th, .border-table td {
            border: 0.5px solid #333;
            padding: 8px;
        }
        .border-table th {
            background: #f0f0f0;
            font-weight: bold;
        }
        .amendment-text {
            background: #ffff00;
            padding: 2px 4px;
            font-weight: bold;
        }
        .logo-image {
            max-height: 80px;
        }
    </style>
</head>
<body class="p-5 text-sm leading-normal text-black bg-white">
    <div class="voucher-container border border-gray-300 bg-white">
        <!-- Header -->
        <div class="p-4">
            <div class="flex justify-between items-center mb-3">
                
                <div></div>

                <!-- Company Info -->
                <div class="text-right">
                    <!-- Logo -->
                <img src="{{ public_path('images/Sisin Travel New.jpg') }}" alt="Sisin Travels" class="logo-image">

                    <div class="font-bold">Sisin Travels (Pvt) Ltd</div>
                    <div>50/9, Mahalwara, Pannipitiya, Sri Lanka</div>
                    <div>Telephone: 0094 11 2840404</div>
                    <div>Hot Line: 0094 777904999</div>
                    <div>Reservation: 0777343748</div>
                    <div>reservations@sisintravels.com</div>
                </div>
            </div>
        </div>

        <!-- Title -->
        <div class="bg-gray-100 border border-gray-300 p-3 mx-4 mb-6 text-xl font-bold">
            MEAL VOUCHER
            @if(!empty($amendmentText))
            - <span class="amendment-text">{!! $amendmentText !!}</span>
            @endif
        </div>

        <!-- Content -->
        <div class="px-6 pb-6">
            <!-- Basic Information Section -->
            <div class="mb-6">
                <table class="w-full">
                    <tr>
                        <td class="py-1 font-bold w-32">Date</td>
                        <td class="py-1 pr-2">:</td>
                        <td class="py-1">{{ \Carbon\Carbon::parse($mealVoucher->voucher_date)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-bold">Hotel Name</td>
                        <td class="py-1 pr-2">:</td>
                        <td class="py-1">{{ $mealVoucher->hotel_name }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-bold">Address</td>
                        <td class="py-1 pr-2">:</td>
                        <td class="py-1">{{ $mealVoucher->hotel_address ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-bold">Tour No</td>
                        <td class="py-1 pr-2">:</td>
                        <td class="py-1">{{ $quotation->booking_reference }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-bold">Market</td>
                        <td class="py-1 pr-2">:</td>
                        <td class="py-1">{{ $mealVoucher->market ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>

            <!-- Separator -->
            <div class="border-b-2 border-gray-300 my-6"></div>

            <!-- Meal Schedule Table -->
            <div class="mb-6">
                <table class="w-full border-table border">
                    <thead>
                        <tr class="text-center">
                            <th>Date</th>
                            <th>No. of Pax</th>
                            <th>Breakfast</th>
                            <th>Lunch</th>
                            <th>Dinner</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            try {
                                $mealDatesData = json_decode($mealVoucher->meal_dates, true) ?? [];
                                
                                // Convert to array of values if it's an associative array
                                if (is_array($mealDatesData) && !empty($mealDatesData) && array_keys($mealDatesData) !== range(0, count($mealDatesData) - 1)) {
                                    $mealDatesData = array_values($mealDatesData);
                                }
                                
                                $totalPacks = 0;
                            } catch (\Exception $e) {
                                $mealDatesData = [];
                                $totalPacks = 0;
                            }
                        @endphp

                        @foreach($mealDatesData as $mealDate)
                            @php
                                try {
                                    $pax = intval($mealDate['pax'] ?? 0);
                                    $totalPacks += $pax;
                                    $dateFormatted = \Carbon\Carbon::parse($mealDate['date'])->format('d/m/Y');
                                } catch (\Exception $e) {
                                    $pax = 0;
                                    $dateFormatted = 'Invalid Date';
                                }
                            @endphp
                            <tr class="text-sm">
                                <td class="text-center">{{ $dateFormatted }}</td>
                                <td class="text-center">{{ $pax }}</td>
                                <td class="text-center">
                                    @if(isset($mealDate['breakfast']) && $mealDate['breakfast'])
                                        ✓
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(isset($mealDate['lunch']) && $mealDate['lunch'])
                                        ✓
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(isset($mealDate['dinner']) && $mealDate['dinner'])
                                        ✓
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        <!-- Total row -->
                        <tr class="text-sm font-bold">
                            <td colspan="1" class="text-right">Total:</td>
                            <td class="text-center">{{ $totalPacks }} pax</td>
                            <td colspan="3"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Meal Plan -->
            <div class="mb-4">
                <div class="flex">
                    <div class="font-bold w-32">Meal Plan</div>
                    <div class="pr-2">:</div>
                    <div class="text-xl font-bold">{{ $mealVoucher->meal_plan ?: '-' }}</div>
                </div>
            </div>

            <!-- Special Notes -->
            <div class="mb-4">
                <div class="flex">
                    <div class="font-bold w-32">Special Notes</div>
                    <div class="pr-2">:</div>
                    <div>{{ $mealVoucher->special_notes ?: '-' }}</div>
                </div>
            </div>

            <!-- Billing Instructions -->
            <div class="mb-4">
                <div class="flex">
                    <div class="font-bold w-32">Billing Instructions</div>
                    <div class="pr-2">:</div>
                    <div>{{ $mealVoucher->billing_instructions ?: '-' }}</div>
                </div>
            </div>

            <!-- Remarks -->
            <div class="mb-4">
                <div class="flex">
                    <div class="font-bold w-32">Remarks</div>
                    <div class="pr-2">:</div>
                    <div>{!! nl2br(e($mealVoucher->remarks ?: '-')) !!}</div>
                </div>
            </div>

            <!-- Reservation Note -->
            <div class="mt-8 pt-4 border-t border-gray-300">
                <p>{!! nl2br(e($mealVoucher->reservation_note ?: '')) !!}</p>
                
                <div class="mt-4 font-bold">
                    Contact Person: {{ $mealVoucher->contact_person ?: '-' }}
                </div>
            </div>

            <!-- Signature area -->
            <div class="mt-16 flex justify-between">
                <div class="w-1/3">
                    <div class="border-t border-black"></div>
                    <div class="text-center mt-1">Prepared By</div>
                </div>
                
                <div class="w-1/3">
                    <div class="border-t border-black"></div>
                    <div class="text-center mt-1">Hotel Confirmation</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>