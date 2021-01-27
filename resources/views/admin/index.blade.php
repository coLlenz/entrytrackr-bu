@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="col-md-8 col-sm-4 col-xs-6 col-lg-2 mb-4">
            <a href="#" class="card">
                <div class="card-body text-center">
                    <i class="fa fa-user fa-3x" aria-hidden="true"></i>
                    <p class="card-text mb-4">Total Accounts</p>
                    <p class="lead text-center">{{$data['total_accounts']}}</p>
                </div>
            </a>
            </div>
            <div class="col-md-8 col-sm-4 col-xs-6 col-lg-2 mb-4">
            <a href="#" class="card">
                <div class="card-body text-center">
                    <i class="fa fa-sign-in fa-3x" aria-hidden="true"></i>
                    <p class="card-text mb-4">Total Sign In's</p>
                    <p class="lead text-center">{{$data['total_sigin_in']}}</p>
                </div>
            </a>
            </div>
            <div class="col-md-8 col-sm-4 col-xs-6 col-lg-2 mb-4">
            <a href="#" class="card">
                <div class="card-body text-center">
                    <i class="fa fa-sign-out fa-3x" aria-hidden="true"></i>
                    <p class="card-text mb-4">Total Sign Out's</p>
                    <p class="lead text-center">{{$data['total_sigin_out']}}</p>
                </div>
            </a>
            </div>
            <div class="col-md-8 col-sm-4 col-xs-6 col-lg-2 mb-4">
            <a href="#" class="card">
                <div class="card-body text-center">
                    <i class="fa fa-user-times fa-3x" aria-hidden="true"></i>
                    <p class="card-text mb-4">Deniedd</p>
                    <p class="lead text-center">{{$data['total_denied']}}</p>
                </div>
            </a>
            </div>
            <div class="col-md-8 col-sm-4 col-xs-6 col-lg-2 mb-4">
            <a href="#" class="card">
                <div class="card-body text-center">
                    <i class="fa fa-id-card-o fa-3x"></i>
                    <p class="card-text mb-4">trakr ID's</p>
                    <p class="lead text-center">{{$data['trakr_id']}}</p>
                </div>
            </a>
            </div>
        </div>
        
    <div class="row justify-content-md-center">
        <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <canvas id="bar-chart-grouped" width="800" height="450"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <canvas id="bar-chart-horizontal" width="800" height="450"></canvas>
                </div>
            </div>
        </div>
    </div>
        
    </div>
    <script src="{{ asset('js/vendor/Chart.bundle.min.js') }}"></script>
    
    <script type="text/javascript">
    new Chart(document.getElementById("bar-chart-grouped"), {
        type: 'bar',
        data: {
          labels: ["Monday", "Tuesday", "Wednesday", "Thursday" , "Friday" , "Saturday" , "Sunday"],
          datasets: [
            {
              label: "Allowed",
              backgroundColor: "#3e95cd",
              data: [133,221,783,2478]
            }, {
              label: "Denied",
              backgroundColor: "#8e5ea2",
              data: [408,547,675,734]
            }
          ]
        },
        options: {
          title: {
            display: true,
            text: 'Weekly Access'
          }
        }
    });
    
    new Chart(document.getElementById("bar-chart-horizontal"), {
    type: 'horizontalBar',
    data: {
      labels: ["Visitor", "Contractor", "Employee"],
      datasets: [
        {
          label: "Count",
          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f"],
          data: [
              {{$visitor['visitors']}} ,
              {{$visitor['contractors']}} , 
              {{$visitor['employees']}}
          ]
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: 'Currently Signed In by Visitor Type'
      }
    }
});
    
    </script>
@endsection