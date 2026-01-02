<div class="modal fade" id="calculatorModal" tabindex="-1" aria-labelledby="calculatorModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <form id="calculatorForm">
            <div class="modal-header">
              <h5 class="modal-title" id="calculatorModalLabel">Add Calculator</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <input type="hidden" id="editIndex" value="">
              <input type="hidden" id="catId" value="">
              
              <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" id="cattitle" class="form-control" required>
              </div>

              <div class="row mb-3 same-height">
                <div class="col-md-6">
                  <label class="form-label">Category Type</label>
                  <select id="categoryType" class="form-control select2" required>
                    <option value="">Select Category</option>
                    <option value="Technology">Technology</option>
                    <option value="Business">Business</option>
                    <option value="Health">Health</option>
                    <option value="Education">Education</option>
                    <option value="Finance">Finance</option>
                  </select>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Sub-Category Type</label>
                  <select id="subcategoryType" class="form-control select2" required>
                    <option value="">Select Sub-Category</option>
                    <option value="Software">Software</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Fitness">Fitness</option>
                    <option value="Teaching">Teaching</option>
                    <option value="Investing">Investing</option>
                  </select>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea id="catDesc" class="form-control custom-ckeditor" rows="6"></textarea>
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