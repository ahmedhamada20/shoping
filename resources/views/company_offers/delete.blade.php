<!-- Modal -->
<div class="modal fade" id="deleted{{ $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete company offers</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <form action="{{ route('companyOffres.delete',$row->id) }}" method="POST">
            @csrf

            <input type="hidden" name="id" value="{{ $row->id }}">
            <div class="row">
                <div class="col">
                    <label class="text-danger">Name : </label>
                    <input type="text" name="name" readonly value="{{ $row->name }}" class="form-control">
                </div>
            </div>
          

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Deleted</button>
              </div>
         </form>
        </div>
      
      </div>
    </div>
  </div>