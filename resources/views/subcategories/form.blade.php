<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <form id="categoryForm" action="#" method="POST">
            <div class="modal-header">
              <h5 class="modal-title" id="categoryModalLabel">Add SubCategory</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <input type="hidden" id="editIndex" value="">
              <input type="hidden" id="catId" value="">

              <div class="mb-3">
                  <label class="form-label">SubCategory Title</label>
                  <input type="text" id="cattitle" name="title" class="form-control" required>
                </div>

              <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea id="catDesc" class="form-control" name="description" rows="6"></textarea>
              </div>
              <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea id="catContent" name="content" class="form-control custom-ckeditor" rows="6"></textarea>
              </div>
              <div class="same-height mb-3">
                  <label class="form-label">Category Type</label>
                  <select id="categoryType" class="form-control select2" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $item)
                        <option value="{{$item->id}}">{{$item->title}}</option>
                    @endforeach
                  </select>
                </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>

          </form>
        </div>
      </div>
    </div>