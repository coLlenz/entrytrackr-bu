  @extends('layouts.app')

@section('content')
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        {{ __('You are logged in!') }} <a href="{{ route('profile.edit') }}"
                            class="btn btn-link">{{ __('Edit Profile') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
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
                                            <p class="lead color-theme-1" style="font-size: 56px;">{{$list_data['total_sign_in']}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card mt-2">
                                        <div class="card-body text-left">
                                            <h5 class="card-title">Currently Signed In by Visitor Type</h5>
                                            <div class="chart-container chart">
                                                <canvas id="pieChart"></canvas>
                                            </div>
                                            {{-- <p class="lead text-bold color-theme-1" style="font-size: 56px;">1</p> --}}
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-md-12">
                                    <div class="card mt-2">
                                        <div class="card-body text-left">
                                            <h5 class="card-title">Line Chart</h5>
                                            <div class="chart-container chart">
                                                <canvas id="lineChart"></canvas>
                                            </div>
                                            <p class="lead text-bold color-theme-1" style="font-size: 56px;">1</p>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>


                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mt-2">
                                        <div class="card-body text-left">
                                            <h5 class="card-title">Visitors Currently Signed In</h5>
                                            <table class="table">
                                                <tbody>
                                                    @if(!empty($list_data['current_signin']))
                                                    @foreach($list_data['current_signin'] as $signin)
                                                        <tr>
                                                            <td>{{$signin->firstName}} {{$signin->lastName}}</td>
                                                            <td>{{$signin->type}}</td>
                                                            <td class="color-theme-1">{{\Carbon\Carbon::parse($signin->created_at)->diffForHumans()}}</td>
                                                        </tr>
                                                        @endforeach
                                                    @else
                                                    {{'No Visitors Currently Signed In'}}
                                                    @endif
                                                </tbody>
                                              </table>
                                              {{$list_data['current_signin']->links()}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card mt-2">
                                        <div class="card-body text-left">
                                            <h5 class="card-title">Visitors Requiring Assistance</h5>
                                            <table class="table">
                                                <tbody>
                                                    @if(!empty($list_data['need_assistance']))
                                                        @foreach($list_data['need_assistance'] as $assist)
                                                            <tr>
                                                                <td>{{$assist->firstName}} {{$assist->lastName}}</td>
                                                                <td>{{$assist->type}}</td>
                                                                <td class="color-theme-1">{{\Carbon\Carbon::parse($assist->created_at)->diffForHumans()}}</td>
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
                    <table class="data-table data-table-feature">
                      <thead>
                          <tr>
                              <th>Name</th>
                              <th>Visitor Type</th>
                              <th>Created At</th>
                              <th>Safe</th>
                              <th class="text-center">Date Marked Safe</th>
                          </tr>
                      </thead>
                      <tbody>
                          @if(!empty($list_data['evac_list']))
                              @foreach($list_data['evac_list'] as $evac)
                                  <tr>
                                    <td>{{$evac->firstName}} {{$evac->lastName}}</td>
                                    <td class="color-theme-1">{{$evac->type}}</td>
                                    <td>{{$evac->created_at}}</td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            @if($evac->safe == 'safe')
                                            <input checked disabled  type="checkbox" class="custom-control-input" id="switch{{$evac->id}}" onclick="checkbox({{$evac->id}})" >
                                            @else
                                            <input type="checkbox" class="custom-control-input" id="switch{{$evac->id}}" onclick="checkbox({{$evac->id}})">
                                            @endif
                                            <label class="custom-control-label" for="switch{{$evac->id}}">{{''}}</label>
                                        </div>
                                    </td>
                                    <td class="text-center safe_date{{$evac->id}}">{{$evac->date_marked_safe ? $evac->date_marked_safe : 'No records yet'}}</td>
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
    Chart.defaults.PieWithShadow = Chart.defaults.pie;
      Chart.controllers.PieWithShadow = Chart.controllers.pie.extend({
        draw: function (ease) {
          Chart.controllers.pie.prototype.draw.call(this, ease);
          let ctx = this.chart.chart.ctx;
          ctx.save();
          ctx.shadowColor = "rgba(0,0,0,0.15)";
          ctx.shadowBlur = 10;
          ctx.shadowOffsetX = 0;
          ctx.shadowOffsetY = 10;
          ctx.responsive = true;
          Chart.controllers.pie.prototype.draw.apply(this, arguments);
          ctx.restore();
        }
      });
    var rootStyle = getComputedStyle(document.body);
    var themeColor1 = rootStyle.getPropertyValue("--theme-color-1").trim();
    var themeColor2 = rootStyle.getPropertyValue("--theme-color-2").trim();
    var themeColor3 = rootStyle.getPropertyValue("--theme-color-3").trim();
    var themeColor4 = rootStyle.getPropertyValue("--theme-color-4").trim();
    var themeColor5 = rootStyle.getPropertyValue("--theme-color-5").trim();
    var themeColor6 = rootStyle.getPropertyValue("--theme-color-6").trim();
    var themeColor1_10 = rootStyle
      .getPropertyValue("--theme-color-1-10")
      .trim();
    var themeColor2_10 = rootStyle
      .getPropertyValue("--theme-color-2-10")
      .trim();
    var themeColor3_10 = rootStyle
      .getPropertyValue("--theme-color-3-10")
      .trim();
    var themeColor4_10 = rootStyle
      .getPropertyValue("--theme-color-4-10")
      .trim();
    var themeColor5_10 = rootStyle
      .getPropertyValue("--theme-color-5-10")
      .trim();
    var themeColor6_10 = rootStyle
      .getPropertyValue("--theme-color-6-10")
      .trim();
    var primaryColor = rootStyle.getPropertyValue("--primary-color").trim();
    var foregroundColor = rootStyle
      .getPropertyValue("--foreground-color")
      .trim();
    var separatorColor = rootStyle.getPropertyValue("--separator-color").trim();
    var chartTooltip = {
        backgroundColor: foregroundColor,
        titleFontColor: primaryColor,
        borderColor: separatorColor,
        borderWidth: 0.5,
        bodyFontColor: primaryColor,
        bodySpacing: 10,
        xPadding: 15,
        yPadding: 15,
        cornerRadius: 0.15,
        displayColors: false
      };
      if (document.getElementById("pieChart")) {
        var pieChart = document.getElementById("pieChart");
        var myChart = new Chart(pieChart, {
          type: "PieWithShadow",
          data: {
            labels: ["Visitors",  "Employees" , "Contractors"],
            datasets: [
              {
                label: "",
                borderColor: [themeColor1, themeColor2, themeColor3],
                backgroundColor: [
                  themeColor1_10,
                  themeColor2_10,
                  themeColor3_10
                ],
                borderWidth: 2,
                data: [{{!empty($piedata[0]->total) ? $piedata[0]->total : 0}} , {{!empty($piedata[1]->total) ? $piedata[1]->total : 0}} , {{!empty($piedata[2]->total) ? $piedata[2]->total : 0}}]
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
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/vendor/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/vendor/datatables.responsive.bootstrap4.min.css') }}" />
@endsection