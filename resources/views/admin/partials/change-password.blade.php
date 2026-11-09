<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
          <form id="adminForm" method="POST" action="{{route('settings.admin.changepassword')}}">
            <input type="hidden" id="passId" name="id" value="0">
            <div class="modal-header">
              <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <div class="row">
                <div class="col-md-12 mb-3">
                  <label class="form-label">Enter Password</label>
                  <input type="password" id="changePass" name="password" class="form-control" required>
                </div>
                <div class="col-md-12 mb-3">
                  <label class="form-label">Confirm</label>
                  <input type="password" id="changeConfirmPass" name="password_confirmation" class="form-control" required>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Update Password</button>
            </div>

          </form>
        </div>
      </div>
    </div>