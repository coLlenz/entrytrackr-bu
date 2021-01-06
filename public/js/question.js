    var myQuestions = [];
    
    function generateQuestion( generate ){
        var questionSet = {};
        questionSet = {
            question: generate[0],
            answers: {
                a: generate[1],
                b: generate[2],
            },
            correctAnswer: generate[3]
        }
        Merge(questionSet);
    }

    function Merge( data ){
        myQuestions.push( data );
        generateHtml(data);
        checkChanges(myQuestions);
    }

    function generateHtml(data = false){
        var options = '';
        if (data) {
            var container = $('#generated_container');
            container.append( `<h2>${data.question}</h2>` );
            
            $(data.answers).each( (idx , item) =>{
                options = `
                    <div class="mb-4">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="${ this_id = makeid(10) }" name="${  myname = makeid(15) }" class="custom-control-input" value="A"> 
                            <label class="custom-control-label" for="${ this_id }"> ${ item.a } </label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="${ this_id = makeid(10) }" name="${ myname }" class="custom-control-input" value="B"> 
                            <label class="custom-control-label" for="${ this_id }">${ item.b }</label>
                        </div>
                        <br />
                        <div class="form-group">
                            <label for="answer"> Answer </label>
                            <input name="answer" class="form-control col-md-4" value="${data.correctAnswer}" readonly  />
                        </div>
                    </div>
                    <hr />
                `;
            });
            container.append( options );
        }
    }


    function checkChanges( myQuestions ){
        if (myQuestions) {
            return $('#saveQuestion').fadeIn();
        }else{
            return $('#saveQuestion').fadeOut();
        }
        
    }

    function makeid(length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }

    function setConfig() {
        var swal = Swal.mixin({
            input: 'text',
            confirmButtonText: 'Next &rarr;',
            showCancelButton: true,
            showCloseButton: true,
            allowOutsideClick : false,
            progressSteps: ['1', '2', '3' ,'4']
        });
        
        return swal;
    }

    function setSteps(){
        var steps = [
            {
                title: 'Add Question',
                input : 'text',
                showCancelButton: true,
                showCloseButton: true,
                allowOutsideClick : false,
                inputValidator: function(value){
                    if (!value) {
                        return 'Input value is required'
                    }
                }
            },
            {
                title: 'Option A',
                input : 'text',
                showCancelButton: true,
                showCloseButton: true,
                allowOutsideClick : false,
                inputValidator: function(value){
                    if (!value) {
                        return 'Input value is required'
                    }
                }
            },
            {
                title: 'Option B',
                input : 'text',
                showCancelButton: true,
                showCloseButton: true,
                allowOutsideClick : false,
                inputValidator: function(value){
                    if (!value) {
                        return 'Input value is required'
                    }
                }
            },
            {
                title: 'Set Answer',
                input : 'text',
                showCancelButton: true,
                showCloseButton: true,
                allowOutsideClick : false,
                inputValidator: function(value){
                    if (!value) {
                        return 'Input value is required'
                    }
                }
            }
        ];
        
        return steps;
    }
    
    function selectedTemplate(data , questions){
        $('#generated_container').html( data ).hide().fadeIn(1000);
        myQuestions = JSON.parse( questions );
        checkChanges( myQuestions );
    }
    
    function fieldCheck(){
        var input = $('input[name=question_title]').val();
        if (!input) {
            return false;
        }
        return true;
    }