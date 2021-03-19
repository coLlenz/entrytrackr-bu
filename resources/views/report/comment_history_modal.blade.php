<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Comment history</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table" id="comment_history_">
            <thead>
                <tr>
                    <th class="text-center">Date</th>
                    <th class="text-center">Comment</th>
                </tr>
            </thead>
            <tbody>
               
            </tbody>
        </table>
        <div class="text-center" id="history_load" style="display:none;">
            <div class="spinner-border text-primary " role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-md" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>