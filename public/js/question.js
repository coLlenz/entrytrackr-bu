$(document).ready(function(){
    var identifier = 0;
    var label = 0;
    $('#addQuestion').on('click' , function() {
        identifier++;
        generateHtml(identifier);
    });
    
    $(document).on('click' , '.question' , function() {
        var id = $(this).attr('data-id');
        $('#question'+id+'_answer').val( $(this).val() );
    })
    
    function generateHtml(id){
        var html = `
            <div class="form-group">
                <h2 class="mb-4 text-primary" contenteditable="true">Tap me to edit.</h2>
                <div class="custom-control custom-radio">
                    <input type="radio" id="option${label = Math.floor(Math.random() * 1000)}" name="question[]" class="custom-control-input question" value="A" data-id=${id}> 
                    <label class="custom-control-label" for="option${label}"> <h3 contenteditable="true" >Double tap me to edit.</h3> </label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="option${label = Math.floor(Math.random() * 1000)}" name="question[]" class="custom-control-input question" value="B" data-id=${id}> 
                    <label class="custom-control-label" for="option${label}"><h3 contenteditable="true" >Double tap me to edit.</h3></label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="option${label = Math.floor(Math.random() * 1000)}" name="question[]" class="custom-control-input question" value="C" data-id=${id}> 
                    <label class="custom-control-label" for="option${label}"><h3 contenteditable="true" >Double tap me to edit.</h3></label>
                </div>
                <div class="form-group">
                    <label for="">Set Answer</label>
                    <input type="text" class="form-control col-md-4" name="question_answer[]" value="" id="question_answer">
                </div>
            </div>
        `;
        $('#questionsHere').append(html)
    }
})