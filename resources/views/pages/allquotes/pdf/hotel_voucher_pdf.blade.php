<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Reservation Voucher</title>
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

        .room-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 13px; /* Larger table text */
        }

        .room-table th,
        .room-table td {
            border: 2px solid #333;
            padding: 10px; /* More padding in cells */
            text-align: center;
        }

        .room-table th {
            background: #f0f0f0;
            font-weight: bold;
        }

        .room-table td {
            height: 35px; /* Taller cells */
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
                <!-- Replace the CSS logo with the actual image -->
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
            <div class="voucher-title">HOTEL RESERVATION VOUCHER{{ isset($amendmentNumber) ? ' - AMENDMENT ' . $amendmentNumber : '' }}</div>

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
                    <span class="info-label">No of Adults</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $amendment->adults }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">No of Children</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $amendment->children }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Room Category</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $amendment->room_category }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Meal Plan</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $amendment->meal_plan }}</span>
                </div>
            </div>

            <table class="room-table">
                <thead>
                    <tr>
                        <th>Single</th>
                        <th>Double</th>
                        <th>Twin</th>
                        <th>Triple</th>
                        <th>Guide Room</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $roomCounts['single'] ?? 0 }}</td>
                        <td>{{ $roomCounts['double'] ?? 0 }}</td>
                        <td>{{ $roomCounts['twin'] ?? 0 }}</td>
                        <td>{{ $roomCounts['triple'] ?? 0 }}</td>
                        <td>{{ $roomCounts['guide'] ?? 0 }}</td>
                    </tr>
                </tbody>
            </table>
            
            @if(!empty($dailyRooms))
            <div class="voucher-title" style="margin-top: 20px; font-size: 14px;">DAILY ROOM DETAILS</div>
            <table class="daily-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>SGL</th>
                        <th>DBL</th>
                        <th>TWIN</th>
                        <th>TPL</th>
                        <th>PAX</th>
                        <th>Meal</th>
                        <th>Guide</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dailyRooms as $room)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($room['date'])->format('d/m/Y') }}</td>
                        <td>{{ $room['single'] ?? 0 }}</td>
                        <td>{{ $room['double'] ?? 0 }}</td>
                        <td>{{ $room['twin'] ?? 0 }}</td>
                        <td>{{ $room['triple'] ?? 0 }}</td>
                        <td>{{ $room['pax'] ?? 0 }}</td>
                        <td>{{ $room['meal_plan'] ?? '-' }}</td>
                        <td>{{ $room['guide_room'] ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            @if(!empty($roomingList))
            <div class="voucher-title" style="margin-top: 20px; font-size: 14px;">ROOMING LIST</div>
            <table class="rooming-table">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="40%">Guest Name</th>
                        <th width="20%">Arrival</th>
                        <th width="20%">Departure</th>
                        <th width="15%">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roomingList as $index => $guest)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $guest['guest_name'] ?? '-' }}</td>
                        <td>{{ isset($guest['arrival_date']) ? \Carbon\Carbon::parse($guest['arrival_date'])->format('d/m/Y') : '-' }}</td>
                        <td>{{ isset($guest['departure_date']) ? \Carbon\Carbon::parse($guest['departure_date'])->format('d/m/Y') : '-' }}</td>
                        <td>{{ $guest['remarks'] ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            <div class="notes-section">
                <div class="info-row">
                    <span class="info-label">Special Notes</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $amendment->special_notes }}</span>
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
                    <span class="info-value">{{ $amendment->remarks }}</span>
                </div>
            </div>

            <div class="footer-instructions">
                <p>{{ $amendment->reservation_note }}</p>
                
                <div class="contact-info">
                    Contact Person: {{ $amendment->contact_person }}
                </div>
            </div>
            
            
        </div>
    </div>
</body>
</html>