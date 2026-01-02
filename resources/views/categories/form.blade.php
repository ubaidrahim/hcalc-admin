<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <form id="categoryForm">
            <div class="modal-header">
              <h5 class="modal-title" id="categoryModalLabel">Add Category</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <input type="hidden" id="editIndex" value="">
              <input type="hidden" id="catId" value="">

              <div class="mb-3">
                  <label class="form-label">Category title</label>
                  <input type="text" id="cattitle" class="form-control" required>
                </div>

              <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea id="catDesc" class="form-control" rows="6"></textarea>
              </div>

              <div class="mb-3">
                <label class="form-label">Status</label>
                <select id="catStatus" class="form-control" required>
                  <option value="">Select status</option>
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
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