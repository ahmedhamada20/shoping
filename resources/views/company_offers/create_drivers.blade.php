<!-- Modal -->
<div class="modal fade" id="createcompanyOffres" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create company offers</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <form action="{{ route('companyOffres.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col">
                    <label>Name : </label>
                    <input type="text" name="name" required value="{{ old('name') }}" class="form-control">
                </div>
            </div>
          
            <br>

            <div class="row">
                <div class="col">
                    <label>offres : </label>
                    <input type="text" name="offres" required value="{{ old('offres') }}" class="form-control">

                </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
         </form>
        </div>
      
      </div>
    </div>
  </div>