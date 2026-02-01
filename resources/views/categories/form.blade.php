<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <form id="categoryForm" action="#" method="POST">
            <div class="modal-header">
              <h5 class="modal-title" id="categoryModalLabel">Add Category</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <input type="hidden" id="editIndex" value="">
              <input type="hidden" id="catId" value="">
              <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Category title</label>
                    <input type="text" id="cattitle" name="title" class="form-control" required>
                  </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Category Slug</label>
                    <input type="text" id="catslug" name="slug" class="form-control" required>
                  </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Meta title</label>
                    <input type="text" id="metatitle" name="meta_title" class="form-control">
                  </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Meta Keywords (Comma Seperated)</label>
                    <input type="text" id="metakeywords" name="meta_keywords" class="form-control">
                  </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Meta Description</label>
                    <input type="text" id="metadescription" name="meta_description" class="form-control">
                  </div>
                <div class="col-md-12 mb-3">
                  <label class="form-label">Brief Description</label>
                  <textarea id="catDesc" class="form-control" name="description" rows="6"></textarea>
                </div>
                <div class="col-md-12 mb-3">
                  <label class="form-label">Content</label>
                  <textarea id="catContent" name="content" class="form-control custom-ckeditor" rows="6"></textarea>
                </div>
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