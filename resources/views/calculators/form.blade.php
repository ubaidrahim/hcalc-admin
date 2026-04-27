<div class="modal fade" id="calculatorModal" tabindex="-1" aria-labelledby="calculatorModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <form id="calculatorForm" method="POST" action="{{route('calculators.store')}}">
            <div class="modal-header">
              <h5 class="modal-title" id="calculatorModalLabel">Add Calculator</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Title</label>
                  <input type="text" id="calTitle" name="title" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Slug</label>
                  <input type="text" id="calSlug" name="slug" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Meta Title</label>
                  <input type="text" id="calMetaTitle" name="meta_title" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Meta Keywords (Comma Seperated)</label>
                  <input type="text" id="calMetaKeywords" name="meta_keywords" class="form-control">
                </div>
                <div class="col-md-12 mb-3">
                  <label class="form-label">Meta Description</label>
                  <input type="text" id="calMetaDescription" name="meta_description" class="form-control">
                </div>
                <div class="col-md-12 mb-3 d-flex gap-3">
                  <img
                          src=""
                          alt="user-avatar"
                          class="d-block w-px-100 h-px-100 rounded"
                          id="uploadedAvatar" />
                        <div class="button-wrapper">
                          <label for="upload" class="btn btn-sm btn-primary me-3 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Upload new photo</span>
                            <i class="icon-base ri ri-upload-2-line d-block d-sm-none"></i>
                            <input
                              type="file"
                              id="upload"
                              class="account-file-input"
                              name="image"
                              hidden
                              accept="image/*" />
                          </label>
                          <button type="button" class="btn btn-sm btn-outline-danger account-image-reset mb-4">
                            <i class="icon-base ri ri-refresh-line d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                          </button>

                          <div>Allowed JPG, GIF or PNG. Max size of 800K</div>
                        </div>
                </div>
                <div class="col-lg-12 mb-3">
                  <small class="fw-medium">Related Calculators</small>
                  <div class="demo-inline-spacing mt-4">
                    <div class="list-group flex-row flex-wrap" id="relatedCalculators">
                    </div>
                  </div>
                </div>
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
                  <select id="subcategoryType" name="subcategory_id" class="form-control select2" data-placeholder="Choose SubCategory" data-parent="#calculatorModal">
                    
                  </select>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Brief Description</label>
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