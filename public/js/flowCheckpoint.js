function flowCheckpoint(response){
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    switch(response.type_of_visitor) {
        case '1':
                Swal.fire({
                    input: 'textarea',
                    inputLabel: 'Who are you visiting?',
                    inputPlaceholder: 'Type here...',
                    showCancelButton: false,
                    showCloseButton: false,
                    allowOutsideClick : false,
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Please provide who are you visiting.'
                        }
                    },
                }).then(complete => {
                    if (complete.isConfirmed) {
                        Swal.showLoading();
                        $.ajax({
                            url: "{{route('visiting-who')}}",
                            method:'POST',
                            data: {trakrid: response.trakrid , visited: complete.value},
                            success:function(response){
                                if (response.status == 'success') {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Data has been added to your logs.',
                                        showConfirmButton: false,
                                        timer: 3000
                                    })
                                }
                            },
                        })
                    }
                });
        break;
        case '2':
                Swal.fire({
                    input: 'textarea',
                    inputLabel: 'Name of Company/Business',
                    inputPlaceholder:'Type here...',
                    showCancelButton:false,
                    showCloseButton:false,
                    allowOutsideClick:false,
                    inputValidator: (value)=>{
                        if (!value) {
                            return 'Please provide name of company/business.';
                        }
                    },
                }).then(complete => {
                    if (complete.isConfirmed) {
                        Swal.showLoading;
                        $.ajax({
                            url : "{{route('business')}}",
                            method: 'POST',
                            data:{trakrid:response.trakrid, name_of_business:complete.value },
                            success:function(response){
                                if (response.status == 'success') {
                                    if (response.status == 'success') {
                                        Swal.fire({
                                            position: 'top-end',
                                            icon: 'success',
                                            title: 'Data has been added to your logs.',
                                            showConfirmButton: false,
                                            timer: 3000
                                        })
                                    }
                                }
                            }
                        })
                    }
                })
        break;
        case '3':
            var questions = JSON.parse(response.questions);
            Swal.fire({
                title: 'Employee Questions Coming Soon.',
                icon: 'info',
                // html: makeHtml(questions),
                allowOutsideClick:false,
                focusConfirm: false,
                confirmButtonText:'Okay',
                showConfirmButton:true,
            })
        break;
    default:
    // code block
    }
}

function makeHtml(questions){
    var form = document.createElement('form');
    $(form).append('<input class="form-control" />');
    $(form).append('<button type="submit" class="btn btn-primary" id="answerQuiz" > Submit </button>');
    return form;
}


