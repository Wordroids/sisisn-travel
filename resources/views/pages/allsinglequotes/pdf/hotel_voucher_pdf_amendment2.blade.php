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
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            background: #fff;
            padding: 5px;
        }

        .voucher-container {
            width: 100%;
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
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }

        .voucher-title {
            text-align: left;
            font-weight: bold;
            font-size: 16px;
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
            margin-bottom: 5px;
            align-items: flex-start;
        }

        .info-label {
            font-weight: bold;
            min-width: 130px;
            flex-shrink: 0;
            padding-right: 10px;
            font-size: 13px;
        }

        .info-colon {
            margin-right: 5px;
            font-size: 13px;
        }

        .info-value {
            flex: 1;
            font-size: 13px;
        }

        .separator-line {
            border-bottom: 2px solid #ddd;
            margin: 20px 0;
        }

        .room-schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 13px;
        }

        .room-schedule-table th,
        .room-schedule-table td {
            border: 2px solid #333;
            padding: 10px;
            text-align: center;
        }

        .room-schedule-table th {
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
            font-size: 12px;
            line-height: 1.5;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }

        .contact-info {
            margin-top: 15px;
            font-size: 13px;
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
            font-size: 13px;
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
                margin: 0.5cm;
            }
        }
    </style>
</head>
<body>
    <div class="voucher-container">
        <div class="header">
            <div class="logo-section">
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
            <div class="voucher-title">HOTEL RESERVATION VOUCHER 
                @if(!empty($amendmentText))
                - <span class="amendment-text">{!! $amendmentText !!}</span>
                @endif
            </div>

            <div class="section">
                <div class="info-row">
                    <span class="info-label">Date</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $voucher->voucher_date ? \Carbon\Carbon::parse($voucher->voucher_date)->format('d/m/Y') : now()->format('d/m/Y') }}</span>
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
                    <span class="info-value">{{ $quotation->booking_reference ?? 'N/A' }}</span>
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
                        <th>SGL</th>
                        <th>DBL</th>
                        <th>TWIN</th>
                        <th>TPL</th>
                        <th>Extra Bed</th>
                        <th>No of Pax</th>
                        <th>Meal Plan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ isset($roomCounts['single']) && $roomCounts['single'] > 0 ? $roomCounts['single'] : '' }}</td>
                        <td>{{ isset($roomCounts['double']) && $roomCounts['double'] > 0 ? $roomCounts['double'] : '' }}</td>
                        <td>{{ isset($roomCounts['twin']) && $roomCounts['twin'] > 0 ? $roomCounts['twin'] : '' }}</td>
                        <td>{{ isset($roomCounts['triple']) && $roomCounts['triple'] > 0 ? $roomCounts['triple'] : '' }}</td>
                        <td>{{ isset($roomCounts['extra_bed']) && $roomCounts['extra_bed'] > 0 ? $roomCounts['extra_bed'] : '' }}</td>
                        <td>{{ $voucher->adults + $voucher->children }}</td>
                        <td>{{ $voucher->meal_plan }}</td>
                    </tr>
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
            
            <div class="signature-area">
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div class="signature-text">Prepared By</div>
                </div>
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div class="signature-text">Hotel Confirmation</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>