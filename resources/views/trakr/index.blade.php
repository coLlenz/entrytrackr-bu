@extends('trakr.layouts.app')

@section('content')
<div class="container">
    
    <div class="col-md-10 mx-auto" v-show="page == 0">
        <div class="card" style="background: rgba(245, 245, 245, 0.8);">
            <div class="card-header">
                
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <center>
                            <h1 class="text-white">
                                WELCOME
                            </h1>
                            <img src="" alt="" srcset="">
                        </center>
                        <div class="row">
                            <div class="col-md-6">
                                <a class="card  mb-2" @click="signin()" style="min-height: 123px;" id="signin-tab" data-toggle="tab" href="#signin"
                                role="tab" aria-controls="signin" aria-selected="false">
                                    <div class="card-body text-center">
                                        <i class="simple-icon-login" style="font-size:38px;"></i>
                                        <p class="card-text font-weight-semibold mb-0">Sign In</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a class="card mb-2" @click="trakrid()" style="min-height: 123px;" id="trakrid-tab" data-toggle="tab" href="#trakrid"
                                role="tab" aria-controls="trakrid" aria-selected="false">
                                    <div class="card-body text-center" style="padding: 1.75rem 0.75rem 0.75rem 0.75rem;">
                                        <i class="simple-icon-login" style="font-size:38px;"></i>
                                        <p class="card-text font-weight-semibold mb-0">Use my trakrID to Sign In</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-12">
                                <a class="card mb-2" @click="signout()" style="min-height: 123px;" id="signout-tab" data-toggle="tab" href="#signout"
                                role="tab" aria-controls="signout" aria-selected="false">
                                    <div class="card-body text-center">
                                        <i class="simple-icon-logout" style="font-size:38px;"></i>
                                        <p class="card-text font-weight-semibold mb-0">Sign Out</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 card">
                        <center>
                            <h3 class="mt-2">
                                Contactless Entry
                            </h3>
                            {!! QrCode::size(200)->margin(5)->generate(route("trakr-view",$id->id)); !!}
                            <p>
                                Scan the QR Code with your smartphone camera to Sign In or Sign Out
                            </p>
                        </center>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Alert & Notifications --}}
    @if($notification !== null)
    <div class="col-md-8 mx-auto" v-show="page == 'alert'">
        <div class="d-flex justify-content-between">
            <a href="#" @click="back()" class="header-icon" style="font-size: 18px;" type="button">
                <i class="simple-icon-arrow-left-circle"></i> Back
            </a>
            <a  href="#" @click="cancel()" class="header-icon"  style="font-size: 18px;"  type="button">
                <i class="simple-icon-close"></i> Cancel
            </a>
        </div>
        <div class="card">
            
            <div class="card-body">
               {!! $notification->content !!} 
                <center>
                    <button @click="conti()" type="button" class="btn btn-primary btn-lg mt-3">Continue</button>
                </center>
            </div>
        </div>
    </div>
    @endif
    {{-- SingnIN  --}}
    <div class="col-md-8 mx-auto" v-show="page == 'signin'">
        <div class="d-flex justify-content-between">
            <a href="#" @click="back()" class="header-icon" style="font-size: 18px;" type="button">
                <i class="simple-icon-arrow-left-circle"></i> Back
            </a>
            <a  href="#" @click="cancel()" class="header-icon"  style="font-size: 18px;"  type="button">
                <i class="simple-icon-close"></i> Cancel
            </a>
        </div>
        <div class="card">
            
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="fname">First Name <span class="text-danger">*</span></label>
                        <div class="input-group mb-2 mr-sm-2">
                            {{-- <div class="input-group-prepend">
                                <div class="input-group-text"><i class="iconsminds-id-card" style="font-size: 18px;"></i></div>
                            </div> --}}
                            <input type="text" class="form-control" id="fname" placeholder="First Name" v-model="fname">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lname">Last Name <span class="text-danger">*</span></label>
                        <div class="input-group mb-2 mr-sm-2">
                            {{-- <div class="input-group-prepend">
                                <div class="input-group-text"><i class="iconsminds-id-card" style="font-size: 18px;"></i></div>
                            </div> --}}
                            <input type="text" class="form-control" id="lname" placeholder="Last Name" v-model="lname">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">Email Address <span class="text-muted">(Optional)</span></label>
                        <div class="input-group mb-2 mr-sm-2">
                            {{-- <div class="input-group-prepend">
                                <div class="input-group-text"><i class="iconsminds-email" style="font-size: 18px;"></i></div>
                            </div> --}}
                            <input type="email" class="form-control" id="email" placeholder="Email" v-model="email">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone">Phone <span class="text-danger">*</span></label>
                        <div class="input-group mb-2 mr-sm-2">
                            {{-- <div class="input-group-prepend">
                                <div class="input-group-text"><i class="iconsminds-smartphone-4" style="font-size: 18px;"></i></div>
                            </div> --}}
                            <input type="text" class="form-control" id="phone" placeholder="Phone" v-model="phone">
                        </div>
                    </div>
                </div>
                <center>
                    <button @click="conti()" type="button" class="btn btn-primary btn-lg mt-3">Continue</button>
                </center>
            </div>
        </div>
    </div>
    {{-- Custom Form --}}
    @if($form !== null)
    <div class="col-md-6 mx-auto" v-show="page == 'form'">
        <div class="d-flex justify-content-between">
            <a href="#" @click="back()" class="header-icon" style="font-size: 18px;" type="button">
                <i class="simple-icon-arrow-left-circle"></i> Back
            </a>
            <a  href="#" @click="cancel()" class="header-icon"  style="font-size: 18px;"  type="button">
                <i class="simple-icon-close"></i> Cancel
            </a>
        </div>
        <div class="card">
            
            <div class="card-body">
                <form ref="form" id="fb-render"></form>
                <center>
                    <button @click="conti()" type="button" class="btn btn-primary btn-lg mt-3">Continue</button>
                </center>
            </div>
        </div>
    </div>
    @endif
    {{-- Type --}}
    <div class="col-md-4 mx-auto" v-show="page == 'type'">
        <div class="d-flex justify-content-between">
            <a href="#" @click="back()" class="header-icon" style="font-size: 18px;" type="button">
                <i class="simple-icon-arrow-left-circle"></i> Back
            </a>
            <a  href="#" @click="cancel()" class="header-icon"  style="font-size: 18px;"  type="button">
                <i class="simple-icon-close"></i> Cancel
            </a>
        </div>
        <div class="card">
            
            <div class="card-body">
                <div class="form-group">
                    <label for="trakrid">I am a...  <span class="text-danger">*</span></label>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="visitor" name="customRadio" value="1" class="custom-control-input" v-model="visitor">
                        <label class="custom-control-label" for="visitor">Visitor</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="contractor" name="customRadio" value="2" class="custom-control-input" v-model="visitor">
                        <label class="custom-control-label" for="contractor">Contractor</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="employee" name="customRadio" value="3" class="custom-control-input" v-model="visitor">
                        <label class="custom-control-label" for="employee">Employee</label>
                    </div>
                </div>
                <center>
                    <button @click="conti()" type="button" class="btn btn-primary btn-lg mt-3">Continue</button>
                </center>
            </div>
        </div>
    </div>
    {{-- reason --}}
    <div class="col-md-4 mx-auto" v-show="page == 'reason'">
        <div class="d-flex justify-content-between">
            <a href="#" @click="back()" class="header-icon" style="font-size: 18px;" type="button">
                <i class="simple-icon-arrow-left-circle"></i> Back
            </a>
            <a  href="#" @click="cancel()" class="header-icon"  style="font-size: 18px;"  type="button">
                <i class="simple-icon-close"></i> Cancel
            </a>
        </div>
        <div class="card">
            
            <div class="card-body">
                <div class="form-group">
                    <div class="form-group">
                        <label for="visit">Who are you visiting? <span class="text-danger">*</span></label>
                        <textarea id="visit" rows="3" class="form-control" v-model="who"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="visit">In the event of an emergency, do you require assistance? <span class="text-danger">*</span></label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="assistance" type="radio" id="yes" value="yes" v-model="assistance">
                            <label class="form-check-label" for="yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="assistance" type="radio" id="no" value="no" v-model="assistance">
                            <label class="form-check-label" for="no">No</label>
                        </div>
                    </div>
                </div>
                <center>
                    <button @click="conti()" type="button" class="btn btn-primary btn-lg mt-3">Continue</button>
                </center>
            </div>
        </div>
    </div>
    {{-- Trakr ID Login --}}
    <div class="col-md-6 mx-auto" v-show="page == 'trakrid'">
        <div class="d-flex justify-content-between">
            <a href="#" @click="back()" class="header-icon" style="font-size: 18px;" type="button">
                <i class="simple-icon-arrow-left-circle"></i> Back
            </a>
            <a  href="#" @click="cancel()" class="header-icon"  style="font-size: 18px;"  type="button">
                <i class="simple-icon-close"></i> Cancel
            </a>
        </div>
        <div class="card">
            
            <div class="card-body">
                <div class="form-group">
                    <label for="trakrid">Enter your trakrID <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="trakrid" placeholder="trakrID" v-model="id">
                    <div class="invalid-feedback" style="display: block" v-html="idresponse">
                      </div>
                </div>
                <center>
                    <button @click="conti()" type="button" class="btn btn-primary btn-lg mt-3">Sign In</button>
                </center>
            </div>
        </div>
    </div>
    {{-- Trakr ID Login --}}
    <div class="col-md-6 mx-auto" v-show="page == 'tracksignout'">
        <div class="d-flex justify-content-between">
            <a href="#" @click="back()" class="header-icon" style="font-size: 18px;" type="button">
                <i class="simple-icon-arrow-left-circle"></i> Back
            </a>
            <a  href="#" @click="cancel()" class="header-icon"  style="font-size: 18px;"  type="button">
                <i class="simple-icon-close"></i> Cancel
            </a>
        </div>
        <div class="card">
            
            <div class="card-body">
                <div class="form-group">
                    <label for="trakrid">First Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="First Name" v-model="sfname">
                    <div class="invalid-feedback" style="display: block" v-html="signoutresponse">
                    </div>
                    
                </div>
                <div class="form-group">
                    <label for="trakrid">Last Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control"  placeholder="Last Name" v-model="slname">
                    <div class="invalid-feedback" style="display: block" v-html="signoutresponse">
                    </div>
                </div>
                <div class="form-group">
                    <label for="trakrid">Phone <span class="text-danger">*</span></label>
                    <input type="text" class="form-control"  placeholder="Phone Number" v-model="sphone">
                    <div class="invalid-feedback" style="display: block" v-html="signoutresponse">
                    </div>
                </div>
                <center>
                    <button @click="conti()" type="button" class="btn btn-primary btn-lg mt-3">Sign Out</button>
                </center>
            </div>
        </div>
    </div>
    {{-- Welcome card --}}
    <div class="col-md-6 mx-auto" v-show="page == 'success'">
        
        <div class="card">
            
            <div class="card-body">
                <center>
                    <h4><span v-html="sign == 'in' ? 'Welcome':'Goodbye'">Welcome</span>, <span v-html="fname"></span></h4>
                    <h5>You have successfully been signed <span v-html="sign"></span> at <br>
                    <span v-html="date"></span>
                    </h5>
                </center>
                
                <center>
                    <p class="text-muted">Automatically returning to Sign In page in 10 seconds</p>
                </center>
            </div>
        </div>
    </div>
    {{-- Reject card --}}
    <div class="col-md-6 mx-auto" v-show="page == 'reject'">
        
        <div class="card">
            
            <div class="card-body">
                <center>
                    {{-- <h4>Access Denied</h4> --}}
                    <h5>We regret to inform you that you are not permitted to enter. Please report to the reception desk for further assistance.</h5>
                </center>
                
                <center>
                    <br>
                    <p class="text-muted">Automatically returning to Sign In page in 10 seconds</p>
                </center>
            </div>
        </div>
    </div>
    <div class="row" id="cookie">
        <div class="col-md-12">
            <center>
                <p class="text-center mb-0 mt-4 text-white">
                    Our Terms of use and privacy policy can be found on our website <a target="_blank" href="//www.entrytrakr.com/">www.entrytrakr.com</a>
                </p>
            </center>
        </div>
    </div>
</div>
    
    
@endsection

@section('script')
<script src="{{ asset('js/vendor/form-render.min.js')}}"></script>
@if($form !== null)
<script>
    
    var formData = '{!!$form->content!!}';
    var formRenderOpts = {
        formData: formData,
    dataType: 'json'
  };
    var forminstance = $("#fb-render").formRender(formRenderOpts);
    
</script>
@endif
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    var app = new Vue({
  el: '#app',
  data: {
    page: 0,
    type:'',
    fname:'',
    lname:'',
    email:'',
    phone:'',
    visitor:'',
    who:'',
    assistance:'',
    customform: {!! $form == null ? 0:$form->content !!},
    entry:'',
    answer:null,
    date:'',
    id:'',
    idresponse:'',
    sfname:'',
    slname:'',
    sphone:'',
    signoutresponse:'',
    sign:'in'
  },
  methods:{
      signin:function(){
          this.page = {{$notification == null ? 1:0}} ? "signin" :"alert";
          this.type = 'signin'
      },
      trakrid:function(){
        this.page = {{$notification == null ? 1:0}} ? "trakrid" :"alert";
          this.type = 'trakrid'
      },
      cancel:function(){
          this.page = 0;
      },
      signout:function(){
        this.page="tracksignout"
        this.type = 'signout'
      },
      back:function(){
        if(this.type == 'signin'){
            if(this.page == 'alert'){
              this.page = 0;
            } else if(this.page == 'signin'){
                this.page = {{$notification == null ? 1:0}} ? 0:"alert";
            }else if(this.page == 'form'){
                this.page = 'signin';
            }else if(this.page =='type'){
                this.page = {{$form == null ? 1:0}} ? "signin":"form"
            }else if(this.page == "reason"){
                this.page = "type";
            }
        }else if(this.type == 'trakrid'){
            if(this.page == 'alert'){
              this.page = 0;
            }else if(this.page == 'trakrid'){
                this.page = {{$notification == null ? 1:0}} ? 0 :"alert";
            }
        }else if(this.type == "signout"){
            this.page = 0;
            
        }
          
      },
      conti:function(){
          if(this.type == 'signin'){
            if(this.page == 'alert'){
                this.page = 'signin';
            }else if(this.page =='signin'){
                if(this.fname !== "" && this.lname !== "" && this.phone !== ""){
                    this.page = {{$form == null ? 1:0 }} ? "type" :'form';
                }
                
            }else if(this.page =='form'){
                // alert('as');
                const Form = document.getElementById('fb-render');
                if(Form.reportValidity()){
                    this.page = 'type';
                }
            }else if(this.page =='type'){
                if(this.visitor !== ""){
                    if(this.visitor == 1){
                        this.submit();
                        
                    }else{
                        this.page = 'reason';
                    }
                    
                }
                
            }else if(this.page == 'reason'){
                if(this.who !== "" && this.assistance !== ""){
                    this.submit();
                }
            }
          }else if(this.type == 'trakrid'){
                if(this.page == 'alert'){
                    this.page = "trakrid";
                }else if(this.page = "trakrid"){
                    if(this.id !== ""){
                        this.findid();
                    }
                    
                }
          }else if(this.type == "signout"){
            if(this.sfname !== "" && this.slname !== "" && this.sphone !== ""){
                this.signoutit();
            }
          }
        
      },
      signoutit:function(){
        var that = this;
        axios.post('{{route('trakrid-signout')}}', {
            fname:this.sfname,
            lname:this.slname,
            phone:this.sphone,
        })
        .then(function (response) {
          console.log(response.data);
          if(response.data !== ""){
            that.date = response.data.check_out_date;
            that.fname = response.data.name;
            that.page = 'success';
            that.sign ='out';
            setTimeout(function(){
                window.location.reload(1);
            }, 10000);
          }else{
              that.signoutresponse = "Details you Entered Doesn't Match Our Records"; 
          }
        })
        .catch(function (error) {
            console.log(error);
        });
      },
      findid:function(){
        var that = this;
        axios.post('{{route('trakrid-post')}}', {
            id:this.id
        })
        .then(function (response) {
            console.log(response);
          if(response.data !== ""){
            that.date = response.data.check_in_date;
            that.fname = response.data.name;
            that.page = 'success';
            
            setTimeout(function(){
                window.location.reload(1);
            }, 10000);
          }else{
              that.idresponse = "TrakrId you Entered is incorrect"; 
          }
        })
        .catch(function (error) {
            console.log(error);
        });
      },
      reject:function(){
            var that = this;
            axios.post('{{route('trakr-post',$id->id)}}', {
            firstName: this.fname,
            lastName: this.lname,
            phone:this.phone,
            email:this.email,
            who:this.who,
            visitor:this.visitor,
            assistance:this.assistance,
            form:{{$form == null ? 0 :$form->id}} ,
            customform: (this.answer !== null ? this.answer : ""),
            entry:this.entry,
            userid: {{$id->id}},
        })
        .then(function (response) {
            that.page = 'reject';
          
            setTimeout(function(){
                window.location.reload(1);
            }, 10000);
        })
        .catch(function (error) {
            console.log(error);
        });
      },
      submit:function(){
        if(this.customform !== 0){
            this.answer = [];
            var i;
            var correct =0;
            var incorrect = 0;
            for (i = 0; i < this.customform.length; i++) {
                this.answer.push({ [this.customform[i].name] : document.querySelector('input[name='+this.customform[i].name +']').value})
                if(this.customform[i].access !== undefined){
                    if(this.customform[i].access == document.querySelector('input[name='+this.customform[i].name +']').value){
                        correct++     
                    }else{
                        incorrect++;
                    }
                }else{
                    correct++;
                }
                
                // console.log(this.customform[i].access , document.querySelector('input[name='+this.customform[i].name +']').value)
            } 
            if(incorrect){
                this.entry= 1;
                this.reject();
            }else{
                this.entry= 0;
                this.accepted();
            }
            // console.log(this.answer)
        }else{
                this.entry= 0;
                this.accepted();
            }},
        accepted:function(){
            var that = this;
          
        axios.post('{{route('trakr-post',$id->id)}}', {
            firstName: this.fname,
            lastName: this.lname,
            phone:this.phone,
            email:this.email,
            who:this.who,
            visitor:this.visitor,
            assistance:this.assistance,
            form:{{$form == null ? 0 :$form->id}} ,
            customform: (this.answer !== null ? this.answer : null),
            entry:this.entry,
            userid: {{$id->id}},
        })
        .then(function (response) {
            console.log(response);
            that.page = 'success';
            that.date = response.data.check_in_date;
            that.fname = response.data.fname;
            setTimeout(function(){
                window.location.reload(1);
            }, 10000);
        })
        .catch(function (error) {
            console.log(error);
        });
        
      }
  }
})
</script>
    <script>
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $("#cookie").css("display","none");
        // e.target // newly activated tab
        // e.relatedTarget // previous active tab
        })
    </script>
@endsection