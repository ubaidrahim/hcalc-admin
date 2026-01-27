<div class="modal fade" id="calculatorModal" tabindex="-1" aria-labelledby="calculatorModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <form id="calculatorForm" method="POST" action="{{route('calculators.store')}}">
            <div class="modal-header">
              <h5 class="modal-title" id="calculatorModalLabel">Add Calculator</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              
              <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" id="calTitle" name="title" class="form-control" required>
              </div>

              <div class="row mb-3 same-height">
                <div class="col-md-6">
                  <label class="form-label">Category Type</label>
                  <select id="categoryType" name="category_id" class="form-control select2" required data-placeholder="Select Category" data-parent="#calculatorModal">
                    @foreach ($categories as $item)
                        <option value="{{$item->id}}">{{$item->title}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Sub-Category Type</label>
                  <select id="subcategoryType" name="subcategory_id" class="form-control select2" required data-placeholder="Choose SubCategory" data-parent="#calculatorModal">
                    @foreach ($subcategories as $item)
                        <option value="{{$item->id}}">{{$item->title}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea id="calDesc" name="description" class="form-control" rows="6"></textarea>
              </div>
              <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea id="calContent" name="content" class="form-control custom-ckeditor" rows="6"></textarea>
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