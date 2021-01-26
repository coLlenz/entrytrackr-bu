    var myQuestions = [];
    
    function questiontype(){
        Swal.fire({
            animation: false,
            title : 'Choose Question Type',
            showCloseButton: false,
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            showConfirmButton: false,
            html : QuestionOption(),
        });
    }
    
    function QuestionOption(){
        var html = '';
        
        html = `
            <button class="btn btn-outline-primary btn-lg questionOption mb-4" id="Multiple"> Multiple Choice </button>
            <button class="btn btn-outline-primary btn-lg questionOption" id="txtbase"> Text-based </button>
        `;
        
        return html;
    }
    
    function txtBase(){
        Swal.fire({
            animation: false,
            title: 'Add Question',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            showConfirmButton: true,
            confirmButtonText: 'Save',
            input: 'textarea',
            reverseButtons: true,
            inputValidator: function(value){
                if (!value) {
                    return 'Input value is required'
                }
            }
        }).then( result => {
            if (result.isConfirmed) {
                generateQuestion( result.value , 'freetext' )
            }
        })
    }
    
    // basic = Yes/No Questions
    // freetext = no correctAnswer
     
    function generateQuestion( data  , type = 'basic' ){
        var questionSet = {};
        if (type === 'basic') {
            questionSet = {
                question: data[0],
                answers: {
                    a: data[1],
                    b: data[2],
                },
                correctAnswer: data[3],
                type: type
            }
        }else{
            questionSet = {
                question: data,
                answers: {
                    a: '',
                    b: '',
                },
                correctAnswer: '',
                type: type
            }
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
            // base elements
            var container = $('#generated_container');
            var innerContainer = $('<div class="target"></div>');
            innerContainer.append(`<div class="float-right">
            <a class="editQue"> <i class="fa fa-pencil mr-2" aria-hidden="true"></i> </a>
            <a class="deleteQue"> <i class="fa fa-trash"></i> </a>
            </div>`);
            
            if (data.type === 'basic') {
                innerContainer.append( `<h2>${data.question}</h2>` );
                $(data.answers).each( (idx , item) =>{
                    options = `
                        <div class="mb-4" id=" ${makeid(15)} ">
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
                innerContainer.append( options );
                container.append(innerContainer);
            }else{
                var txtfield = '';
                innerContainer.append( `<h2>${data.question}</h2>` );
                    txtfield = `
                        <div class="txtarea">
                            <textarea name="freetext[]" class="form-control" row="100" ></textarea>
                        </div> <hr />
                    `;
                innerContainer.append( txtfield );
                container.append(innerContainer);
            }
        }
    }
    
    $(document).on('click' , '.deleteQue', function(){
        if (confirm("Do you really want to remove this?")) {
            var target = $(this).parent().parent();
            var txt = $(this).parent().next().text();
            $(myQuestions).each( (idx , val) => {
                if (val.question === txt) {
                    myQuestions.splice(idx , 1);
                }
            })
            target.remove();
        }else{
            console.log('cancel');
        }
    })
    
    $(document).on('click' , '.editQue' , function() {
        var h2_html = $(this).parent().next();
        var options = $(h2_html).next().children('.custom-control');
        var optionA = $( options[0] ).find('label');
        var optionB = $( options[1] ).find('label');
        var answer = $(h2_html).next().children('.form-group').find('input');
        
        var txt = $(this).parent().next().text();
        $(myQuestions).each( (idx , val) => {
            if (val.question === txt && val.type === 'basic') {
                Swal.fire({
                    title : 'Edit Question',
                    html : `<textarea class="form-control" rows="4" cols="50" name="question" id="question"/>${val.question}</textarea><br />
                    <input class="form-control" name="optionA" value="${val.answers.a}" id="optionA"/><br />
                    <input class="form-control" name="optionB" value="${val.answers.b}" id="optionB" /><br />
                    <input class="form-control" name="answer" value="${val.correctAnswer}" id="answer"/>
                    `,
                    allowOutsideClick: false,
                    confirmButtonText: 'Save',
                    showCancelButton : true,
                    preConfirm: () => {
                        return [
                            document.getElementById('question').value,
                            document.getElementById('optionA').value,
                            document.getElementById('optionB').value,
                            document.getElementById('answer').value,
                        ]
                    }
                }).then( values => {
                    val.question = values.value[0]
                    val.answers.a = values.value[1];
                    val.answers.b = values.value[2];
                    val.correctAnswer = values.value[3];
                    h2_html.text(val.question);
                    optionA.text(val.answers.a);
                    optionB.text(val.answers.b);
                    answer.attr('value',val.correctAnswer);
                })
            }else if (val.question === txt && val.type === 'freetext') {
                Swal.fire({
                    title : 'Edit Question',
                    html : `<textarea class="form-control" rows="4" cols="50" name="question" id="question"/>${val.question}</textarea><br />`,
                    allowOutsideClick: false,
                    confirmButtonText: 'Save',
                    showCancelButton : true,
                    preConfirm: () => {
                        return [
                            document.getElementById('question').value,
                        ]
                    }
                }).then( values => {
                    val.question = values.value[0];
                    h2_html.text(val.question);
                })
            }
        })
    });

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
            animation: false,
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
                animation: false,
                input : 'textarea',
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
                animation: false,
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
                animation: false,
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
                html: 'You must enter the letter of the option that will be the correct answer allowing visitor to enter. <br/>e.g. A or B',
                input : 'text',
                animation: false,
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