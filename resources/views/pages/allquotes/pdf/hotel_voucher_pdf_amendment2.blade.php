<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Reservation Voucher - 2nd Amendment</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px; /* Increased base font size */
            line-height: 1.4;
            color: #000;
            background: #fff;
            padding: 5px; /* Reduced padding to use more space */
        }

        .voucher-container {
            width: 100%; /* Full width */
            margin: 0 auto;
            border: 1px solid #ccc;
            background: #fff;
        }

        .header {
            padding: 15px;
            border-bottom: none;
        }

        .logo-section {
            text-align: right;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo-image {
            max-height: 80px;
        }

        .company-info {
            text-align: right;
            font-size: 12px; /* Larger company info text */
            line-height: 1.5;
            color: #333;
        }

        .voucher-title {
            text-align: left;
            font-weight: bold;
            font-size: 16px; /* Larger title */
            margin: 15px 0;
            padding: 10px;
            background: #f0f0f0;
            border: 1px solid #ccc;
        }

        .amendment-text {
            background: #ffff00;
            padding: 2px 4px;
            font-weight: bold;
        }

        .content {
            padding: 0 15px 20px 15px;
        }

        .section {
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            margin-bottom: 5px; /* More space between rows */
            align-items: flex-start;
        }

        .info-label {
            font-weight: bold; /* Make labels bold for better readability */
            min-width: 130px; /* Wider label space */
            flex-shrink: 0;
            padding-right: 10px;
            font-size: 13px; /* Larger label text */
        }

        .info-colon {
            margin-right: 5px;
            font-size: 13px;
        }

        .info-value {
            flex: 1;
            font-size: 13px; /* Larger value text */
        }

        .separator-line {
            border-bottom: 2px solid #ddd;
            margin: 20px 0;
        }

        .room-schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 13px; /* Larger table text */
        }

        .room-schedule-table th,
        .room-schedule-table td {
            border: 2px solid #333;
            padding: 10px; /* More padding in cells */
            text-align: center;
        }

        .room-schedule-table th {
            background: #f0f0f0;
            font-weight: bold;
        }
        
        .rooming-list {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
        }

        .rooming-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 15px;
            text-decoration: underline;
        }

        .rooming-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 12px; /* Larger rooming list text */
        }

        .rooming-table th,
        .rooming-table td {
            border: 2px solid #333;
            padding: 8px;
            text-align: left;
        }

        .rooming-table th {
            background: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .rooming-table .guest-names {
            font-weight: bold;
        }

        .honeymoon-text {
            color: #d32f2f;
            font-weight: bold;
        }

        .daily-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 12px; /* Larger daily table text */
        }

        .daily-table th,
        .daily-table td {
            border: 2px solid #333;
            padding: 8px;
            text-align: center;
        }

        .daily-table th {
            background: #f0f0f0;
            font-weight: bold;
        }

        .notes-section {
            margin: 15px 0;
        }

        .billing-section {
            margin: 15px 0;
        }

        .remarks-section {
            margin: 15px 0;
        }

        .footer-instructions {
            margin-top: 25px;
            font-size: 12px; /* Larger footer text */
            line-height: 1.5;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }

        .contact-info {
            margin-top: 15px;
            font-size: 13px; /* Larger contact info */
            font-weight: bold;
        }
        
        .superscript {
            vertical-align: super;
            font-size: 8px;
        }
        
        .signature-area {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        
        .signature-box {
            width: 45%;
            text-align: center;
        }
        
        .signature-line {
            border-top: 1px solid #000;
            width: 80%;
            margin: 0 auto 5px auto;
            margin-top: 70px;
        }
        
        .signature-text {
            font-size: 13px; /* Larger signature text */
        }

        @media print {
            body {
                padding: 0;
                margin: 0;
            }
            
            .voucher-container {
                border: none;
                width: 100%;
                max-width: none;
                box-shadow: none;
            }
            
            @page {
                size: A4;
                margin: 0.5cm; /* Minimal margins for more space */
            }
        }
    </style>
</head>
<body>
    <div class="voucher-container">
        <div class="header">
            <div class="logo-section">
                <!-- Use the same image path as in the hotel_voucher_pdf.blade.php file -->
                <img src="{{ public_path('images/Sisin Travel New.jpg') }}" alt="Sisin Travels" class="logo-image">
                
                <div class="company-info">
                    <strong>Sisin Travels (Pvt) Ltd</strong><br>
                    50/9, Mahalwara, Pannipitiya, Sri Lanka<br>
                    Telephone: 0094 11 2840404<br>
                    Hot Line: 0094 777904999<br>
                    Reservation: 0777343748<br>
                    reservations@sisintravels.com
                </div>
            </div>
        </div>

        <div class="content">
            <div class="voucher-title">HOTEL RESERVATION VOUCHER - <span class="amendment-text">2<span class="superscript">ND</span> AMENDMENT</span></div>

            <div class="section">
                <div class="info-row">
                    <span class="info-label">Date</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($amendment->voucher_date)->format('d/m/Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Hotel Name</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $hotel->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Address</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $amendment->hotel_address }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tour No</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $quotation->template->booking_reference ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tour Name</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $quotation->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Market</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $quotation->market ? $quotation->market->name : 'N/A' }}</span>
                </div>
            </div>

            <div class="separator-line"></div>

            <div class="section">
                <div class="info-row">
                    <span class="info-label">Booking Name</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $amendment->booking_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Arrival Date</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $arrivalDate->format('d/m/Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Departure date</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $departureDate->format('d/m/Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Total Nights</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $amendment->total_nights }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Room Category</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $amendment->room_category }}</span>
                </div>
            </div>

            <table class="room-schedule-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>SGL</th>
                        <th>DBL</th>
                        <th>TWIN</th>
                        <th>TPL</th>
                        <th>No of Pax</th>
                        <th>Meal Plan</th>
                        <th>Guide Room/Basis</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dailyRooms as $room)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($room['date'])->format('d.m.Y') }}</td>
                        <td>{{ $room['single'] > 0 ? $room['single'] : '' }}</td>
                        <td>{{ $room['double'] > 0 ? sprintf('%02d', $room['double']) : '' }}</td>
                        <td>{{ $room['twin'] > 0 ? sprintf('%02d', $room['twin']) : '' }}</td>
                        <td>{{ $room['triple'] > 0 ? sprintf('%02d', $room['triple']) : '' }}</td>
                        <td>{{ $room['pax'] > 0 ? sprintf('%02d', $room['pax']) : '' }}</td>
                        <td>{{ $room['meal_plan'] }}</td>
                        <td>{{ $room['guide_room'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="notes-section">
                <div class="info-row">
                    <span class="info-label">Special Notes</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $amendment->special_notes ?: '-' }}</span>
                </div>
            </div>

            <div class="billing-section">
                <div class="info-row">
                    <span class="info-label">Billing instructions</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $amendment->billing_instructions }}</span>
                </div>
            </div>

            <div class="remarks-section">
                <div class="info-row">
                    <span class="info-label">Remarks</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{!! nl2br(e($amendment->remarks)) !!}</span>
                </div>
            </div>

            <div class="footer-instructions">
                <p>{!! nl2br(e($amendment->reservation_note)) !!}</p>
                
                <div class="contact-info">
                    Contact Person: {{ $amendment->contact_person }}
                </div>
            </div>
            
           
        </div>
    </br>
</br>
</br>
</br>
</br>
</br>
        @if(!empty($roomingList))
        <div class="rooming-list">
            <div class="content">
                <div class="rooming-title">ROOMING LIST</div>
                
                <table class="rooming-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;"></th>
                            <th style="width: 300px;">GUEST NAME</th>
                            <th style="width: 100px;">ARRIVAL<br>DATE</th>
                            <th style="width: 100px;">DEPARTURE<br>DATE</th>
                            <th style="width: 120px;">REMARKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roomingList as $index => $guest)
                        <tr>
                            <td style="text-align: center; font-weight: bold;">{{ $index + 1 }}</td>
                            <td class="guest-names">{!! nl2br(e($guest['guest_name'])) !!}</td>
                            <td style="text-align: center;">{{ isset($guest['arrival_date']) ? \Carbon\Carbon::parse($guest['arrival_date'])->format('d/m/Y') : '-' }}</td>
                            <td style="text-align: center;">{{ isset($guest['departure_date']) ? \Carbon\Carbon::parse($guest['departure_date'])->format('d/m/Y') : '-' }}</td>
                            <td style="text-align: center;">
                                
                                {{ $guest['remarks'] ?? '' }}
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</body>
</html>