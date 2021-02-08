  @extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs " role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general"
                        role="tab" aria-controls="general" aria-selected="true">General</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="evacuation-tab" data-toggle="tab" href="#evacuation"
                        role="tab" aria-controls="evacuation" aria-selected="false">Evacuation List</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="general" role="tabpanel"
                    aria-labelledby="general-tab">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="card mt-2">
                                        <div class="card-body text-left">
                                            <p class="lead  color-theme-1 text-nowrap" style="font-size: 21px;">{{$date}}</p>
                                            <p class="lead  color-theme-1 text-nowrap" style="font-size: 56px;">{{$time}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="card mt-2">
                                        <div class="card-body text-left">
                                            <p class="text-left">Currently Signed In</p>
                                            <p class="lead color-theme-1" style="font-size: 56px;" id="visit_count">{{$list_data['total_sign_in']}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card mt-2">
                                        <div class="card-body text-left">
                                            <h5 class="card-title">Currently Signed In by Visitor Type</h5>
                                            @if( $piedata['visitors'] != 0 || $piedata['contractors'] != 0 || $piedata['employees'] != 0 )
                                                <div class="">
                                                    <canvas id="doughnutChart" style="height:400px; width:400px"></canvas>
                                                </div>
                                            @else
                                                <p class="text-center"> {{ 'No data to show' }} </p>
                                            @endif
                                            {{-- <p class="lead text-bold color-theme-1" style="font-size: 56px;">1</p> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mt-2">
                                        <div class="card-body text-left">
                                            <h5 class="card-title">
                                                Visitors Currently Signed In
                                                <div class="float-right">
                                                    <a href="{{route('showAll')}}" class="text-primary" style="font-size: 16px;"> Show All </a>
                                                </div>
                                            </h5>
                                            <table class="table">
                                                <tbody>
                                                    @if(!$list_data['current_signin']->isEmpty())
                                                    @foreach($list_data['current_signin'] as $signin)
                                                        <tr>
                                                            <td>{{$signin->firstName}} {{$signin->lastName}}</td>
                                                            <td>{{$signin->type}}</td>
                                                            <td class="color-theme-1">{{\Carbon\Carbon::parse($signin->check_in_date)->timezone(userTz())->diffForHumans()}}</td>
                                                            <td> <button type="button" name="dashBoardSignOut" class="btn btn-primary entry_sm_btn" visitor-id="{{$signin->id}}">Sign Out</button> </td>
                                                        </tr>
                                                        @endforeach
                                                    @else
                                                    {{'No Visitors Currently Signed In'}}
                                                    @endif
                                                </tbody>
                                              </table>
                                              {{$list_data['current_signin']->onEachSide(0)->links()}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card mt-2">
                                        <div class="card-body text-left">
                                            <h5 class="card-title">Visitors Requiring Assistance</h5>
                                            <table class="table">
                                                <tbody>
                                                    @if(!$list_data['need_assistance']->isEmpty())
                                                        @foreach($list_data['need_assistance'] as $assist)
                                                            <tr>
                                                                <td>{{$assist->firstName}} {{$assist->lastName}}</td>
                                                                <td>{{$assist->type}}</td>
                                                                <td class="color-theme-1">{{\Carbon\Carbon::parse($assist->check_in_date)->timezone(userTz())->diffForHumans()}}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                    {{'No Visitors Currently Signed In'}}
                                                    @endif
                                                </tbody>
                                              </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="evacuation" role="tabpanel"
                    aria-labelledby="evacuation-tab">
                    <table class="table">
                      <thead>
                          <tr>
                              <th class="text-center">Name</th>
                              <th class="text-center">Visitor Type</th>
                              <th class="text-center">Date & Time Signed In</th>
                              <th class="text-center">Safe</th>
                              <th class="text-center">Date Marked Safe</th>
                              <th class="text-center">Marked By</th>
                          </tr>
                      </thead>
                      <tbody>
                          @if(!empty($list_data['evac_list']))
                              @foreach($list_data['evac_list'] as $evac)
                                  <tr>
                                    <td class="text-center">{{$evac->firstName}} {{$evac->lastName}}</td>
                                    <td class="text-center">{{$evac->type}}</td>
                                    <td class="text-center">{{\Carbon\Carbon::parse($evac->check_in_date)->timezone(userTz())->format('d-m-Y H:i')}}</td>
                                    <td class="text-center">
                                        <div class="custom-control custom-switch">
                                            @if($evac->safe == 'safe')
                                            <input checked disabled  type="checkbox" class="custom-control-input" id="switch{{$evac->id}}" onclick="checkbox({{$evac->id}})" >
                                            @else
                                            <input type="checkbox" class="custom-control-input" id="switch{{$evac->id}}" onclick="checkbox({{$evac->id}})">
                                            @endif
                                            <label class="custom-control-label" for="switch{{$evac->id}}">{{''}}</label>
                                        </div>
                                    </td>
                                    <td class="text-center safe_date{{$evac->id}}">{{$evac->date_marked_safe ? \Carbon\Carbon::parse($evac->date_marked_safe)->timezone(userTz())->format('d-m-y H:i') : 'No records yet'}}</td>
                                    <td class="text-center safe_date{{$evac->id}}">{{$evac->marked_by ? $evac->marked_by : 'Pending'}}</td>
                                  </tr>
                              @endforeach
                            @endif
                      </tbody>
                  </div>
                  </table>
                    <a href="{{ route('generate_pdf',['download'=>'pdf']) }}" class="btn btn-primary btn-lg mr-1">Download PDF</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
<script src="{{ asset('js/vendor/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('js/vendor/chartjs-plugin-datalabels.js') }}"></script>
<script src="{{ asset('js/vendor/datatables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/vendor/sweetalert2@10.js') }}" charset="utf-8"></script>
<script>
  
  function checkbox(i){
    if($("#switch"+i).is(':checked'))
    {
      $("#switch"+i).attr('checked',true);
    }
    else
    {
      $("#switch"+i).attr('checked',false);
    }
    $("body").addClass("show-spinner");
    $("body > *").css({ opacity: 0 });
    axios.post('{{route('trakr-safe')}}', {
            id:i,
            value:$("#switch"+i).is(':checked'),
        })
        .then(function (response) {
            $("body").removeClass("show-spinner");
            $("body > *").animate({ opacity: 1 }, 100);
            $('.safe_date'+i).text(response.data.trakr_safe.date_marked_safe);
        })
        .catch(function (error) {
          $("body").removeClass("show-spinner");
          $("body > *").animate({ opacity: 1 }, 100);
        });
    // console.log($("#switch"+i).is(':checked'));
    // $("#"+i).val()
  }
      $table = $(".data-table-feature").DataTable({
        sDom: '<"row view-filter"<"col-sm-12"<"float-right"l><"float-left"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
        drawCallback: function () {
          $($(".dataTables_wrapper .pagination li:first-of-type"))
            .find("a")
            .addClass("prev");
          $($(".dataTables_wrapper .pagination li:last-of-type"))
            .find("a")
            .addClass("next");
          $(".dataTables_wrapper .pagination").addClass("pagination-sm");
        },
        language: {
          paginate: {
            previous: "<i class='simple-icon-arrow-left'></i>",
            next: "<i class='simple-icon-arrow-right'></i>"
          },
          search: "_INPUT_",
          searchPlaceholder: "Search...",
          lengthMenu: "Items Per Page _MENU_"
        },
      });
</script>

<script type="text/javascript">
    var chartTooltip = {
        borderColor: '#ffffff',
        borderWidth: 2,
        bodySpacing: 10,
        xPadding: 20,
        yPadding: 20,
        cornerRadius: 20,
        displayColors: true
    };
    if (document.getElementById("doughnutChart")) {
        var pieChart = document.getElementById("doughnutChart");
        var myChart = new Chart(pieChart, {
        type: "doughnut",
        data: {
        labels: ["Visitors","Contractors", "Employees"],
        datasets: [
            {
                label: "",
                borderColor: '#ffffff',
                backgroundColor: ['#00ff00','#e9c937' , '#3b3bbd'],
                borderWidth: 2,
                data: [
                    {{!empty($piedata['visitors']) ? $piedata['visitors'] : 0}} ,
                    {{!empty($piedata['contractors']) ? $piedata['contractors'] : 0}} , 
                    {{!empty($piedata['employees']) ? $piedata['employees'] : 0}}
                ]
            }
        ]
        },
        draw: function () { },
        options: {
            plugins: {
                datalabels: {
                    display: false
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: false
            },
            layout: {
                padding: {
                    bottom: 20
                }
            },
            legend: {
                position: "bottom",
                labels: {
                    padding: 30,
                    usePointStyle: true,
                    fontSize: 12
                }
            },
            tooltips: chartTooltip
        }
        });
    }
</script>
<script type="text/javascript">
    $('.entry_sm_btn').on('click' , function() {
        var id = $(this).attr('visitor-id');
        var target = $(this).closest('tr');
        Swal.fire({
            title: 'This will manually sign out the visitor.',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: `Proceed`,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                Swal.showLoading();
                $.ajax({
                    url :`{{route('manualSignOut')}}`,
                    type : 'POST',
                    data : {data_id : id},
                    success: function(response){
                        if (response.status) {
                            target.remove();
                            $('#visit_count').text(Number($('#visit_count').text()) - 1);
                        }
                    }
                })
            }
        })
    })
</script>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/vendor/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/vendor/datatables.responsive.bootstrap4.min.css') }}" />
@endsection