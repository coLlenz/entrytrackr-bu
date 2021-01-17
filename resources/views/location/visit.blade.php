@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-md-4">
            <h1>{{ $account->name }}</h1>
            <div class="card">
            <div class="card-body">
                <h5 class="card-title">Entry Logs</h5>
                    <table class="table table-sm table-borderless">
                        <tbody>
                            @if( !$account['visitors']->isEmpty() )
                                @foreach($account['visitors'] as $key => $list)
                                <tr>
                                    <td>
                                        @if($list->status == 0)
                                            <span class="log-indicator border-theme-2 align-middle"></span>
                                        @else
                                            <span class="log-indicator border-danger align-middle"></span>
                                        @endif
                                    </td>
                                    <td><span class="font-weight-medium">{{$list->firstName}} {{$list->lastName}}</span></td>
                                    <td class="text-right"><span class="text-muted">{{ date('D-m-Y H:s' , strtotime($list->check_in_date)) }}</span></td>
                                </tr>
                                @endforeach
                            @else
                            <i> {{ 'No Logs' }} </i>
                            @endif
                        </tbody>
                    </table>
            </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card"  >
                <div class="card-body">
                    <h5 class="card-title">Currently Signed In by Visitor Type</h5>
                    <div class="chart-container chart">
                        <canvas id="visitorChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h2> Evacuation List </h2>
                    <table class="table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th class="text-center">Visitor Type</th>
                                    <th class="text-center">Date & Time Signed In</th>
                                    <th class="text-center">Safe</th>
                                    <th class="text-center">Date Marked Safe</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( !$account['visitors']->isEmpty()  )
                                    @foreach( $account['visitors'] as $list )
                                        <tr>
                                            <td >{{$list->firstName}} {{$list->lastName}}</td>
                                            <td class="text-center">{{$list->visitor_type}}</td>
                                            <td class="text-center">{{ date('D-m-y H:i' , strtotime($list->check_in_date)) }}</td>
                                            <td  class="text-center">{{ $list->safe ? 'Yes' : 'Pending' }}</td>
                                            <td  class="text-center">{{ $list->date_marked_safe ? $list->date_marked_safe : 'Pending' }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <h3 class="text-center"> <i> {{ $account['visitors']->isEmpty() ? 'No Results' : ''}} </i> </h3>
                    </table>
                    {{ $account['visitors']->links() }}
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12 col-md-4 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title"> trakrID </h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>trakrID</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Phone Number</th>
                                <th class="text-center">Visitor Type</th>
                                <th class="text-center">Time and date of entry</th>
                                <th class="text-center">Time and date of exit</th>
                                <th class="text-center">Access</th>
                                <th class="text-center">Visiting/Business</th>
                                <th class="text-center">Visit Logs</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @if( !$account['visitors']->isEmpty()  )
                                @foreach( $account['visitors'] as $list )
                                    @if( $list->status == 1 )
                                    <tr>
                                        <td>{{$list->trakr_id}}</td>
                                        <td class="text-center">{{$list->firstName}} {{$list->lastName}}</td>
                                        <td class="text-center">{{$list->phoneNumber}}</td>
                                        <td class="text-center">{{$list->visitor_type}}</td>
                                        <td class="text-center">{{date('D-m-y H:i' , strtotime($list->check_in_date))}}</td>
                                        <td class="text-center">{{ $list->check_out_date ?  date('D-m-y H:i' , strtotime($list->check_out_date)) : 'Pending'}}</td>
                                        <td class="text-center">
                                            @if( $list->status == 0 )
                                                <span class="badge badge-success">{{'Allowed'}}</span>
                                            @else
                                                <span class="badge badge-danger">{{'Denied'}}</span>
                                            @endif
                                        </td>
                                        <td class="text-center"> {{ $list->trakr_type_id == 1 ? $list->who : $list->name_of_company }}</td>
                                        <td class="text-center"> <a href="{{route('visitorLogs' , [$list->user_id , $list->id] )}}"> Show Logs  </a></td>
                                    </tr>
                                    @endif
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>

<script src="{{ asset('js/vendor/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('js/vendor/chartjs-plugin-datalabels.js') }}"></script>
<script type="text/javascript">
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
  if (document.getElementById("visitorChart")) {
    var pieChart = document.getElementById("visitorChart");
    var myChart = new Chart(pieChart, {
      type: "PieWithShadow",
      data: {
        labels: ["Visitors","Contractors", "Employees"],
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
            data: [
                {{!empty($visitor_count['visitors']) ? $visitor_count['visitors'] : 0}} ,
                {{!empty($visitor_count['contractors']) ? $visitor_count['contractors'] : 0}} , 
                {{!empty($visitor_count['employees']) ? $visitor_count['employees'] : 0}}
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
@endsection