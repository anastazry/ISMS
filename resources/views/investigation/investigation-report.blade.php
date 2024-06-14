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

    .landscape{
        size: A4 landscape;
    }

    .image-container {
    display: flex;
    flex-wrap: wrap;
}

.image {
    max-width: 400px;
    max-height: 200px;
    width: calc(50% - 10px); /* Adjust width to fit 2 images per row with some margin */
    margin: 5px;
    box-sizing: border-box;
}
span {
            font-weight: bold; /* Example style */
        }
</style>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @php
        $counter = 1;
        $pageCounter = 1;
        @endphp


        <div id="headings" class="bg-white border rounded shadow p-4">
            <div class="border-b p-2 text-center" style="font-size: 15px; font-weight: bold; text-align: center">
                X Construction Sdn Bhd
            </div>
            <div id="title" class="border-b p-2 text-center" style="font-size: 20px; font-weight: bold; text-align: center">
                INCIDENT/ACCIDENT INVESTIGATION REPORT
            </div>
            <div class="table-container" >
                <table class="center-table" >
                    <tr style="height: 10px; padding: 5px">
                        <td><span style="font-weight: bold">PART A</span></td>
                    </tr>
                    <tr style="height: 10px">
                        <td><span>Report NO :</span> {{$investigationA->reportNo}}</td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <span>Investigation Team</span>
                                <div style="margin-left: 10px">
                                    <?php
                                        $counterForName=1;
                                    ?>
                                @foreach($investigationA->investigation_team as $team)
                                @if($counterForName == 1)
                                    <p>{{$counterForName++}}. {{$team}} (Leader)</p>
                                @else
                                    <p>{{$counterForName++}}. {{$team}}</p>
                                @endif
                                @endforeach
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <span>Terms of Reference</span>
                                <table style="margin-left: 10px">
                                    <tr>
                                        <td>1. Site Of Incident</td>
                                        <td>{{$investigationA->referenceSiteOfIncident}}</td>
                                    </tr>
                                    <tr>
                                        <td>2. Copy Of HIRARC</td>
                                        <td>{{$investigationA->referenceHIRARC}}</td>
                                    </tr>
                                    <tr>
                                        <td>3. Interview Victims or Witness</td>
                                        <td>
                                            @if($investigationA->interview_victims_or_witness == 1)
                                                <img src="{{ asset('images/icons/black-tick-icon.jpg') }}" width = "30px" height="30px">
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <span>Category of Incident : </span>
                                <div style="margin-left: 10px">
                                    <p>{{$investigationA->incident_category}}</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <span>When and Where did the Incident Occur?</span> 
                                <div style="margin-left: 10px">
                                    <p>{{$investigationA->incidentWhenAndWhere}}</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <span>Description of the incident :</span> 
                                <div style="margin-left: 10px">
                                    <p>{{$investigationA->incident_desc}}</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <span>Description of property damage (if any) :</span> 
                                <div style="margin-left: 10px">
                                    <p>{{$investigationA->property_damage}}</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <span>How did the incident occur : </span>
                                <div style="margin-left: 10px">
                                    @if(!empty($investigationA->incident_drawing))
                                        <p><span>REV NO :</span> {{$investigationA->referenceHowIncidentHappen}}</p>
                                    @endif
                                        <p>{{$investigationA->incident_explanation}}</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <span>Findings of the investigation :</span> 
                                <div style="margin-left: 10px">
                                    <p>{{$investigationA->investigation_findings}}</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <span>Reported By :</span> 
                                <div class="flex justify-between">
                                    <div style="margin-top: 5px; margin-left: 20px">
                                        <img src="{{asset($investigationA->submitted_by)}}" alt="" width="120px" height="60px">
                                    </div>
                                    <div>
                                        <p><span>Name :</span> {{$investigationA->investigation_team[0]}}</p>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="page-break"></div>
        <div id="headings" class="bg-white border rounded shadow p-4">
            <div class="border-b p-2 text-center" style="font-size: 15px; font-weight: bold; text-align: center">
                X Construction Sdn Bhd
            </div>
            <div id="title" class="border-b p-2 text-center" style="font-size: 20px; font-weight: bold; text-align: center">
                INCIDENT/ACCIDENT INVESTIGATION REPORT
            </div>
            <div class="table-container" >
                <table class="center-table" >
                    <tr style="height: 10px; padding: 5px">
                        <td><span>PART B</span></td>
                    </tr>
                    <tr style="height: 10px">
                        <td><span>Report NO :</span> {{$investigationA->reportNo}}</td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <span>Need For Corrective Actions:</span>
                                <div style="margin-left:10px">
                                    <?php
                                        $counterForName=1;
                                    ?>
                                @foreach($investigationB->ncr as $ncr)
                                    <p>{{$counterForName++}}. {{$ncr}}</p>
                                @endforeach
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <span>Mitigative Actions:</span>
                                <div style="margin-left:10px">
                                    <?php
                                        $counterForName=1;
                                    ?>
                                @foreach($investigationB->mitigative_actions as $mitigative_actions)
                                    <p>{{$counterForName++}}. {{$mitigative_actions}}</p>
                                @endforeach
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <span>Mitigative Actions:</span>
                                <div style="margin-left:10px">
                                    <?php
                                        $counterForName=1;
                                    ?>
                                @foreach($investigationB->cont_improve as $cont_improve)
                                    <p>{{$counterForName++}}. {{$cont_improve}}</p>
                                @endforeach
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <span>Penalty:</span>
                                <div style="margin-left:10px">
                                    <?php
                                        $counterForName=1;
                                    ?>
                                @foreach($investigationB->penalty as $penalty)
                                    <p>{{$counterForName++}}. {{$penalty}}</p>
                                @endforeach
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <span>The results has been communicated to the following personnel:</span>
                                <table style="margin-left:10px">
                                    <tr>
                                        <td>Safety Committee</td>
                                        <td>
                                            @if($investigationB->safety_comittee_know == 1)
                                                <img src="{{ asset('images/icons/black-tick-icon.jpg') }}" width = "30px" height="30px">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Project Manager</td>
                                        <td>
                                            @if($investigationB->pm_know == 1)
                                                <img src="{{ asset('images/icons/black-tick-icon.jpg') }}" width = "30px" height="30px">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Staffs</td>
                                        <td>
                                            @if($investigationB->staff_know == 1)
                                                <img src="{{ asset('images/icons/black-tick-icon.jpg') }}" width = "30px" height="30px">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Others</td>
                                        <td>
                                            @if($investigationB->others_know == 1)
                                                <img src="{{ asset('images/icons/black-tick-icon.jpg') }}" width = "30px" height="30px">
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <span>Signature (SHO) : </span>
                                <div class="flex justify-between">
                                    <div style="margin-top: 5px" style="margin-left:10px">
                                        <img src="{{asset($investigationB->sho_signature)}}" alt="" width="120px" height="60px">
                                    </div>
                                    <div>
                                        <p><span>Name :</span> {{$investigationB->shoName}}</p>
                                        <p><span>Date :</span> {{$investigationB->sho_signature_date}}</p>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    @if(!empty($investigationA->project_site))
    <div class="page-break"></div>
        <div>
            <div class="flex justify-between" style="font-size: 20px; font-weight: bold; text-align: center">
                <div>ATTACHMENTS</div>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <div>
                    Date:
                </div>
                <div>
                    Rev Number:{{$investigationA->referenceSiteOfIncident}}
                </div>

            </div>
                <?php
                    $imageCounter = 0;
                ?>
                @foreach($investigationA->project_site as $index => $image)
                 <div class="image-container" style="display: flex; justify-content:center">

                    <?php
                    $imageCounter++;
                    ?>
                    <img src="{{ asset('storage/' . $image) }}" alt="Image" class="image">
                    @if($imageCounter == 2)
                        <br>
                        <?php
                        $imageCounter = 0;
                        ?>
                    @endif
                </div>

                @endforeach

        </div>
    @endif
    @if(!empty($investigationA->incident_drawing))
    <div class="page-break"></div>
    <div>
        <div class="flex justify-between" style="font-size: 20px; font-weight: bold; text-align: center">
            <div>ATTACHMENTS</div>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <table>
                <tr>
                    <td>
                        Date:
                    </td>
                </tr>
                <tr>
                    <td>
                    Rev Number:{{$investigationA->referenceHowIncidentHappen}}
                    </td>
                </tr>
            </table>


        </div>
            <?php
                $imageCounter = 0;
            ?>
            @foreach($investigationA->incident_drawing as $index => $image)
             <div class="image-container" style="display: flex; justify-content:center">

                <?php
                $imageCounter++;
                ?>
                <img src="{{ asset('storage/' . $image) }}" alt="Image" class="image">
                @if($imageCounter == 2)
                    <br>
                    <?php
                    $imageCounter = 0;
                    ?>
                @endif
            </div>

            @endforeach

    </div>
    @endif
</div>

{{-- @endsection --}}
