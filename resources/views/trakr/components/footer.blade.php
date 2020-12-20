<footer class="page-footer bg-transparent mt-auto" style="border-top:0px; ">
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                    <button class="header-icon btn  btn-light ml-5 bg-white"  type="button" id="fullScreenButton" style="">
                        <i class="simple-icon-size-fullscreen"></i>
                        <i class="simple-icon-size-actual" style="display: none;"></i> FullScreen
                    </button>
                    <button @click="cancel()" class="header-icon btn  btn-light mr-5 bg-white" type="button" v-show="page != 0">
                        <i class="simple-icon-close"></i> Cancel Login
                    </button>
            </div>
        </div>
    </div>
</footer>
<style>
    .btn-outline-primary{
        background-color: #fff !important;
        border-color: #922c88;
    }
    .btn-outline-primary:hover {
        color: #fff;
        background-color: #922c88 !important;
        border-color: #922c88;
    }
</style>