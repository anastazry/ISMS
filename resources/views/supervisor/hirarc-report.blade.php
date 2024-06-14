{{-- Assuming you're using Blade templating --}}
{{-- @extends('layouts.app') --}}

{{-- @section('content') --}}
<style>
    body {
        /* Set body margin to 0 to remove default spacing */
        margin: 0;
        font-family: Arial, sans-serif; /* Optional: Set desired font family */
    }

    .table-container {
        /* Center the table horizontally */
        display: flex;
        justify-content: center;
        align-items: center;
        /* height: 100px;  */
        flex-direction: column; /* Stack elements vertically */
        /* background-color: red */
    }
    .table-container .center-table td,th{
        font-size: 13px;
        
    }
    
    .footer{
        display: flex;
        justify-content: space-between;
        flex-direction: row;
    }

    .center-table {
        /* Set table width to 100% of the screen */
        width: 100%;
        max-width: 100%; /* Optional: Limit maximum width of the table */
        /* Optional: Add styling for table appearance */
        border-collapse: collapse;
        margin-bottom: 20px; /* Add margin at the bottom of the first table */
        /* height: 100%; */
    }

    .center-table td, th {
        /* Optional: Add padding or styling for table cells */
        /* padding: 10px; */
        padding-left: 5px;
        border: 1px solid black;
        font-size: 15px;
    }

    #headings {
        margin: 5px;
        padding-bottom: 10px;
    }

    #title {
        margin-bottom: 10px;
    }

    .page-break {
    page-break-after: always;
    }

    h6{
        font-size: 15px
    }
</style>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @php
        $counter = 1;
        $pageCounter = 1;
        @endphp

        @for($i = 0; $i < count($data) ; $i++)

        <div id="headings" class="bg-white border rounded shadow p-4">
            <div class="border-b p-2 text-center" style="font-size: 15px; font-weight: bold; text-align: center">
                X Construction Sdn Bhd
            </div>
            <div id="title" class="border-b p-2 text-center" style="font-size: 20px; font-weight: bold; text-align: center">
                HAZARD IDENTIFICATION, RISK ASSESSMENT, AND RISK CONTROLS REGISTER
            </div>
            <div class="table-container" >
                <table class="center-table" >
                    <tr style="height: 10px; padding: 5px">
                        <td  style="height: 10px;"><span style="font-weight: bold">Project/HQ :</span> X Construction Sdn Bhd </td>
                        <td><span style="font-weight: bold">Description of Job :</span> {{$data[0][0]['hirarc']->desc_job}}</td>
                        <td>
                            <span style="font-weight: bold">Prepared By :</span> {{ $data[0][0]['hirarc']->prepared_by }}
                            <img src="{{ asset($data[0][0]['hirarc']->prepared_by_signature) }}" alt="" style="max-width: 100%; height: auto; width: 80px; max-height: 30px; margin-bottom: -10px">
                        </td>
                        
                        <td rowspan="2">
                            <p>Hirarc No :</p>
                            <p>Page : {{$pageCounter++}} of {{count($data)}}</p>
                            <p>Date : {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
                        </td>
                    </tr>
                    <tr style="height: 10px">
                        <td style="height: 10px;"><span style="font-weight: bold">Location:</span> {{$data[0][0]['hirarc']->location}} </td>
                        <td>
                            <span style="font-weight: bold">Verified By:</span> {{$data[0][0]['titlePage']->verified_by}}
                            <img src="{{ asset($data[0][0]['titlePage']->ver_signature_image) }}" alt="" style="max-width: 100%; height: auto; width: 80px; max-height: 30px; margin-bottom: -10px">
                        </td>
                        <td>
                            <span style="font-weight: bold">Approved By:</span> {{$data[0][0]['titlePage']->approved_by}}
                            <img src="{{ asset($data[0][0]['titlePage']->appr_signature_img) }}" alt="" style="max-width: 100%; height: auto; width: 80px; max-height: 30px; margin-bottom: -10px">
                        </td>
                    </tr>
                </table>
            </div>

            <div>
                {{-- @for($i = 0; $i < count($data['hazard']); $i++) --}}
                <table class="center-table">
                    <tr>
                        <th colspan="3">Hazard Identification</th>
                        <th colspan="6">Risk Assessment</th>
                        <th colspan="3">Risk Control</th>
                    </tr>
                    <tr>
                        <td style="width: 3%"><span style="font-weight: bold">No</span></td>
                        <td style="width: 15%"><span style="font-weight: bold">Job Sequence</span></td>
                        <td style="width: 8%"><span style="font-weight: bold">Hazard</span></td>
                        <td style="width: 10%"><span style="font-weight: bold">Risk</span></td>
                        <td style="width: 25%"><span style="font-weight: bold">Current Control</span></td>
                        <td style="width: 5%"><span style="font-weight: bold">L</span></td>
                        <td style="width: 5%"><span style="font-weight: bold">S</span></td>
                        <td style="width: 5%"><span style="font-weight: bold">Score</span></td>
                        <td style="width: 5%"><span style="font-weight: bold">Index</span></td>
                        <td><span style="font-weight: bold">Opportunity</span></td>
                        <td><span style="font-weight: bold">New Control (Suggestions)</span></td>
                        <td><span style="font-weight: bold">Responsibility</span></td>
                    </tr>
                    @for ($j = 0 ; $j < count($data[$i]); $j++)
                    <tr>
                    
                        <td>{{$counter++}}</td>
                        <td>{{ $data[$i][$j]['hazard']->job_sequence }}</td>
                        <td>{{ $data[$i][$j]['hazard']->hazard }}</td>
                        <td>{{ $data[$i][$j]['risk']->risk_desc }}</td>
                        <td>{{ $data[$i][$j]['risk']->current_control }}</td>
                        <td>{{ $data[$i][$j]['risk']->likelihood }}</td>
                        <td>{{ $data[$i][$j]['risk']->severity }}</td>
                        <td>{{ $data[$i][$j]['risk']->score }}</td>
                        <td>{{ $data[$i][$j]['risk']->index }}</td>
                        <td>{{ $data[$i][$j]['control']->opportunity }}</td>
                        <td>{{ $data[$i][$j]['control']->new_control }}</td>
                        <td>{{ $data[$i][$j]['control']->responsibility }}</td>
                    </tr>
            @endfor

                    <!-- Add table rows for data -->
                </table>
            </div>
            <div class="footer">
                @if(isset($referenceHIRARC))
                <p>Rev No: {{$referenceHIRARC}}</p>
                @else
                <p>Rev No:</p>
                @endif
                <p>Issue Date:{{$data[0][0]['hirarc']->inspection_date }}</p>
            </div>

        </div>
        @if($i != count($data) -1)
        <div class="page-break"></div>
        @endif
        @endfor
    </div>
</div>

{{-- @endsection --}}
