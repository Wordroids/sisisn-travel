<!-- filepath: d:\Saruna\Work\sisisn-travel\resources\views\pages\allquotes\pdf\tour_plan_pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tour Plan - {{ $main_ref }}</title>
    <style>
        /* Base reset and variables */
        :root {
            --blue-50: #eff6ff;
            --blue-100: #dbeafe;
            --blue-200: #bfdbfe;
            --blue-300: #93c5fd;
            --blue-400: #60a5fa;
            --blue-500: #3b82f6;
            --blue-600: #2563eb;
            --blue-700: #1d4ed8;
            --blue-800: #1e40af;
            --blue-900: #1e3a8a;
            
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            
            --red-50: #fef2f2;
            --red-100: #fee2e2;
            --red-200: #fecaca;
            --red-300: #fca5a5;
            --red-400: #f87171;
            --red-500: #ef4444;
            --red-600: #dc2626;
            --red-700: #b91c1c;
            --red-800: #991b1b;
            --red-900: #7f1d1d;
            
            --green-50: #f0fdf4;
            --green-100: #dcfce7;
            --green-500: #22c55e;
            --green-600: #16a34a;
            --green-700: #15803d;
            
            --amber-50: #fffbeb;
            --amber-100: #fef3c7;
            --amber-500: #f59e0b;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: var(--gray-700);
            background: white;
        }
        
        /* Layout container optimized for landscape */
        .container {
            width: 100%;
            max-width: 1024px;
            margin: 0 auto;
            padding: 24px;
        }
        
        /* Header with improved spacing */
        .header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--gray-300);
        }
        
        .logo {
            max-height: 70px;
            margin-bottom: 12px;
        }
        
        h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 6px;
            letter-spacing: 0.05em;
        }
        
        .ref-number {
            font-weight: 600;
            color: var(--blue-600);
            font-size: 14px;
        }
        
        /* Improved tour info bar */
        .tour-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 10px 16px;
            background-color: var(--blue-50);
            border: 1px solid var(--blue-200);
            border-left: 4px solid var(--blue-600);
            border-radius: 4px;
            font-size: 13px;
        }
        
        /* Enhanced section styling */
        .section {
            margin-bottom: 24px;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--gray-800);
            background-color: var(--gray-100);
            padding: 10px 16px;
            border-left: 5px solid var(--blue-600);
            margin-bottom: 12px;
            border-radius: 0 4px 4px 0;
        }
        
        /* Improved table styling for better readability */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        
        th {
            background-color: var(--gray-100);
            color: var(--gray-700);
            font-weight: 600;
            text-align: left;
            padding: 8px 12px;
            border: 1px solid var(--gray-300);
            font-size: 12px;
        }
        
        td {
            padding: 8px 12px;
            border: 1px solid var(--gray-300);
            vertical-align: top;
            line-height: 1.5;
        }
        
        tr:nth-child(even) {
            background-color: var(--gray-50);
        }
        
        /* Enhanced itinerary styling */
        .itinerary-day {
            margin-bottom: 20px;
            page-break-inside: avoid;
            border: 1px solid var(--gray-200);
            border-radius: 6px;
            overflow: hidden;
        }
        
        .day-header {
            font-weight: 600;
            padding: 10px 12px;
            background-color: var(--blue-50);
            color: var(--blue-800);
            border-bottom: 1px solid var(--blue-200);
            font-size: 14px;
        }
        
        .itinerary-day table {
            margin-bottom: 0;
        }
        
        .itinerary-day th {
            width: 20%;
            background-color: var(--gray-50);
        }
        
        /* Notes sections with better visual hierarchy */
        .notes {
            padding: 12px 16px;
            background-color: var(--gray-50);
            border: 1px solid var(--gray-200);
            border-radius: 4px;
            line-height: 1.6;
        }
        
        .important-notes {
            padding: 12px 16px;
            background-color: var(--red-50);
            border: 1px solid var(--red-100);
            border-left: 5px solid var(--red-500);
            border-radius: 4px;
            margin-top: 12px;
            line-height: 1.6;
            color: var(--red-800);
        }
        
        /* Footer with more professional styling */
        .footer {
            margin-top: 36px;
            padding-top: 12px;
            border-top: 1px solid var(--gray-200);
            text-align: center;
            font-size: 10px;
            color: var(--gray-500);
        }
        
        /* Utility classes */
        .page-break {
            page-break-before: always;
        }
        
        .font-bold {
            font-weight: 700;
        }
        
        .font-semibold {
            font-weight: 600;
        }
        
        .text-xs {
            font-size: 10px;
        }
        
        .text-sm {
            font-size: 12px;
        }
        
        .text-base {
            font-size: 14px;
        }
        
        .text-blue {
            color: var(--blue-600);
        }
        
        .text-gray {
            color: var(--gray-600);
        }
        
        .text-red {
            color: var(--red-600);
        }
        
        .bg-blue-light {
            background-color: var(--blue-50);
        }
        
        .mt-2 {
            margin-top: 8px;
        }
        
        .mb-1 {
            margin-bottom: 4px;
        }
        
        .mb-2 {
            margin-bottom: 8px;
        }
        
        .mb-4 {
            margin-bottom: 16px;
        }
        
        .p-2 {
            padding: 8px;
        }
        
        .p-4 {
            padding: 16px;
        }
        
        .rounded {
            border-radius: 4px;
        }
        
        /* Specific optimizations for landscape mode */
        @page {
            size: landscape;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <img class="logo" src="{{ public_path('images/Sisin Travel Logo-01.png') }}" alt="Sisin Travel Logo">
            <h1>TOUR PLAN</h1>
            <p class="ref-number">Booking Reference: {{ $main_ref }}</p>
        </div>

        <!-- Tour Info Section -->
        <div class="tour-info">
            <div>
                <span class="font-bold">Tour Period:</span> 
                @if($startDate && $endDate)
                    {{ $startDate }} to {{ $endDate }} ({{ $duration }} days)
                @else
                    Not specified
                @endif
            </div>
            <div>
                <span class="font-bold">Generated:</span> {{ now()->format('d M Y') }}
            </div>
        </div>

        <!-- Guest List Section -->
        <div class="section">
            <div class="section-title">Guest List</div>
            @if(!empty($tourPlan->guests) && count($tourPlan->guests) > 0)
                <table>
                    <thead>
                        <tr>
                            <th width="30%">Guest Name</th>
                            <th width="20%">Arrival</th>
                            <th width="20%">Departure</th>
                            <th width="30%">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tourPlan->guests as $guest)
                            <tr>
                                <td class="font-semibold">{{ $guest['name'] ?? 'N/A' }}</td>
                                <td>
                                    @if(!empty($guest['arrival']))
                                        {{ \Carbon\Carbon::parse($guest['arrival'])->format('d M Y') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($guest['departure']))
                                        {{ \Carbon\Carbon::parse($guest['departure'])->format('d M Y') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $guest['remarks'] ?? '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-4 bg-blue-light rounded">No guest information available.</div>
            @endif
        </div>

        <!-- Tour Notes Section -->
        @if(!empty($tourPlan->tour_notes))
            <div class="section">
                <div class="section-title">Tour Commencing Notes</div>
                <div class="notes">
                    {!! $tourPlan->tour_notes !!}
                </div>
            </div>
        @endif

        <!-- Important Notes Section -->
        @if(!empty($tourPlan->important_notes))
            <div class="section">
                <div class="section-title">Important Notes</div>
                <div class="important-notes">
                    {!! $tourPlan->important_notes !!}
                </div>
            </div>
        @endif

        <!-- Itinerary Section -->
        <div class="section">
            <div class="section-title">Itinerary</div>
            
            @if(!empty($tourPlan->itinerary_days) && count($tourPlan->itinerary_days) > 0)
                @foreach($tourPlan->itinerary_days as $index => $day)
                    <!-- Add page break after every 2 days for better readability in landscape mode -->
                    @if($index > 0 && $index % 2 == 0)
                        <div class="page-break"></div>
                    @endif
                    
                    <div class="itinerary-day">
                        <div class="day-header">
                            Day {{ $index + 1 }}: 
                            @if(!empty($day['date']))
                                {{ \Carbon\Carbon::parse($day['date'])->format('d M Y (l)') }}
                            @else
                                Date not specified
                            @endif
                        </div>
                        
                        <table>
                            @if(!empty($day['sites_experiences']))
                                <tr>
                                    <th>Sites & Experiences</th>
                                    <td>{{ $day['sites_experiences'] }}</td>
                                </tr>
                            @endif
                            
                            @if(!empty($day['guidelines']))
                                <tr>
                                    <th>Special Guidelines</th>
                                    <td>{{ $day['guidelines'] }}</td>
                                </tr>
                            @endif
                            
                            @if(!empty($day['contact_details']))
                                <tr>
                                    <th>Contact Details</th>
                                    <td>{{ $day['contact_details'] }}</td>
                                </tr>
                            @endif
                            
                            @if(!empty($day['hotel_details']))
                                <tr>
                                    <th>Accommodation</th>
                                    <td>{{ $day['hotel_details'] }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                @endforeach
            @else
                <div class="p-4 bg-blue-light rounded">No itinerary information available.</div>
            @endif
        </div>

        <!-- Footer Section -->
        <div class="footer">
            <p>Generated by Sisin Travel System • {{ now()->format('d M Y H:i') }}</p>
        </div>
    </div>
</body>
</html>