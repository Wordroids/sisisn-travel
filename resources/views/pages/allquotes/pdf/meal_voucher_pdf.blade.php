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
                            <th>Tour No</th>
                            <th>Guest Name</th>
                            <th>{{ $mealVoucher->meal_plan }} Date</th>
                            <th>No. of Packs</th>
                            <th>Guide Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            try {
                                $tourData = json_decode($mealVoucher->selected_tours_data, true) ?? [];
                                $totalPacks = 0;
                            } catch (\Exception $e) {
                                $tourData = [];
                                $totalPacks = 0;
                            }
                        @endphp

                        @foreach($tourData as $tourNo => $tour)
                            @php 
                                $firstRow = true; 
                                $mealDates = $tour['mealDates'] ?? [];
                                $mealDatesCount = count($mealDates);
                            @endphp
                            
                            @foreach($mealDates as $index => $mealDate)
                                @php 
                                    try {
                                        $totalPacks += intval($mealDate['noOfPacks'] ?? 0);
                                        $dateFormatted = \Carbon\Carbon::parse($mealDate['date'])->format('d/m/Y');
                                    } catch (\Exception $e) {
                                        $dateFormatted = 'Invalid Date';
                                    }
                                @endphp
                                <tr class="text-sm">
                                    @if($firstRow)
                                        <td rowspan="{{ $mealDatesCount > 0 ? $mealDatesCount : 1 }}" class="text-center">
                                            {{ $tourNo }}
                                        </td>
                                        <td rowspan="{{ $mealDatesCount > 0 ? $mealDatesCount : 1 }}" class="text-center">
                                            {{ $tour['guestName'] ?? 'N/A' }}
                                        </td>
                                        @php $firstRow = false; @endphp
                                    @endif
                                    <td class="text-center">
                                        {{ $dateFormatted }}
                                    </td>
                                    <td class="text-center">
                                        {{ $mealDate['noOfPacks'] ?? '0' }}
                                    </td>
                                    @if($index === 0)
                                        <td rowspan="{{ $mealDatesCount > 0 ? $mealDatesCount : 1 }}" class="text-center">
                                            {{ $tour['guideDetails'] ?? '-' }}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach
                        
                        
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

            
        </div>
    </div>
</body>
</html>