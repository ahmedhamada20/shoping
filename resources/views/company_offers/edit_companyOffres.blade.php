<!-- Modal -->
<div class="modal fade" id="edit{{ $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update company offers</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <form action="{{ route('companyOffres.update',$row->id) }}" method="POST">
            @csrf

            <input type="hidden" name="id" value="{{ $row->id }}">
            <div class="row">
                <div class="col">
                    <label>Name : </label>
                    <input type="text" name="name"  value="{{ $row->name }}" class="form-control">
                </div>
            </div>
          
            <br>

            <div class="row">
                <div class="col">
                    <label>offres : </label>
                    <input type="text" name="offres" required value="{{ $row->offres }}" class="form-control">

                </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
         </form>
        </div>
      
      </div>
    </div>
  </div>