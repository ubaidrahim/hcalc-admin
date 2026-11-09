<div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="calculatorModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <form id="adminForm" method="POST" action="{{route('settings.admin.store')}}">
            <div class="modal-header">
              <h5 class="modal-title" id="calculatorModalLabel">Add Admin User</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Name</label>
                  <input type="text" id="adminName" name="name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Account Email</label>
                  <input type="email" id="adminEmail" name="email" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3 password_field">
                  <label class="form-label">Password</label>
                  <input type="password" id="adminPassword" name="password" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3 password_field">
                  <label class="form-label">Confirm Password</label>
                  <input type="password" id="adminConfirmPassword" name="password_confirmation" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Role / Designation</label>
                  <input type="text" id="adminRole" name="role" class="form-control">
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