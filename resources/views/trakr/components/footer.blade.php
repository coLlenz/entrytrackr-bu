<footer class="page-footer bg-transparent mt-auto" style="border-top:0px; ">
    <div class="float-right">
        <button type="button" class="et_btn et_btn_secondary et_mr-fullscreen" id="fullscreen_btn">
            <i class="simple-icon-size-fullscreen" aria-hidden="true"></i>
        </button>
        <button type="button" class="et_btn et_btn_secondary et_mr-fullscreen" id="actual_btn" style="display:none">
            <i class="simple-icon-size-actual" aria-hidden="true"></i>
        </button>
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
    .et_mr-fullscreen{
        margin-right: 150px;
    }
</style>

<script>
var elem = document.getElementById("app-container");

    function openFullscreen() {
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) { 
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
        }
    }

    function closeFullscreen() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) { 
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) { 
            document.msExitFullscreen();
        }
    }

    $('#fullscreen_btn').on('click' , function(){
        openFullscreen();
        $(this).hide();
        $('#actual_btn').show();
    });

    $('#actual_btn').on('click' , function(){
        closeFullscreen();
        $(this).hide();
        $('#fullscreen_btn').show();
    });
</script>
