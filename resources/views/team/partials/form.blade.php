<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <form id="categoryForm" action="#" method="POST">
            <div class="modal-header">
              <h5 class="modal-title" id="categoryModalLabel">Add Team Member</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <input type="hidden" id="editIndex" value="">
              <input type="hidden" id="catId" value="">
              <div class="row">
                
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
                          <button type="button" class="btn btn-sm btn-danger mb-4" id="removeImg" data-id="0">
                            <i class="icon-base ri ri-delete-bin-6-line"></i>
                            <span class="d-none d-sm-block">Remove</span>
                          </button>

                          <div>Allowed JPG, GIF or PNG. Max size of 800K</div>
                        </div>
                </div>
                <hr class="my-3">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" id="memberName" name="name" class="form-control" required>
                  </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Designation</label>
                    <input type="text" id="memberDesignation" name="designation" class="form-control" required>
                  </div>
                <div class="col-md-12 mb-3">
                  <label class="form-label">Brief Description</label>
                  <textarea id="memberBrief" class="form-control" name="brief" rows="6" required></textarea>
                </div>
              </div>
              <div class="divider">
                <div class="divider-text">Social Links</div>
              </div>
              <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="icon-base text-primary ri ri-facebook-circle-fill icon-20px"></i>
                        </span>
                        <input
                          type="url"
                          class="form-control"
                          id="memberfacebook"
                          placeholder="Facebook Profile"
                          aria-label="Facebook Profile"
                          name="facebook"/>
                      </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="icon-base text-primary ri ri-linkedin-box-fill icon-20px"></i>
                        </span>
                        <input
                          type="url"
                          class="form-control"
                          id="memberlinkedin"
                          placeholder="Linkedin Profile"
                          aria-label="Linkedin Profile"
                          name="linkedin"/>
                      </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="icon-base text-primary ri ri-github-fill icon-20px"></i>
                        </span>
                        <input
                          type="url"
                          class="form-control"
                          id="membergithub"
                          placeholder="Github Profile"
                          aria-label="Github Profile"
                          name="github"/>
                      </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="icon-base text-primary ri ri-whatsapp-line icon-20px"></i>
                        </span>
                        <input
                          type="url"
                          class="form-control"
                          id="memberwhatsapp"
                          placeholder="Whatsapp Link"
                          aria-label="Whatsapp Link"
                          name="whatsapp"
                          aria-describedby="basic-addon43" />
                      </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="icon-base text-primary ri ri-instagram-line icon-20px"></i>
                        </span>
                        <input
                          type="url"
                          class="form-control"
                          id="memberinstagram"
                          placeholder="Instagram Profile"
                          aria-label="Instagram Profile"
                          name="instagram"/>
                      </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="icon-base text-primary ri ri-behance-line icon-20px"></i>
                        </span>
                        <input
                          type="url"
                          class="form-control"
                          id="memberbehance"
                          placeholder="Behance Profile"
                          aria-label="Behance Profile"
                          name="behance" />
                      </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="icon-base text-primary ri ri-youtube-line icon-20px"></i>
                        </span>
                        <input
                          type="url"
                          class="form-control"
                          id="memberyoutube"
                          placeholder="Youtube Profile"
                          aria-label="Youtube Profile"
                          name="youtube"/>
                      </div>
                </div>
                
                <div class="col-md-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="icon-base text-primary ri ri-tiktok-fill icon-20px"></i>
                        </span>
                        <input
                          type="url"
                          class="form-control"
                          id="membertiktok"
                          placeholder="Tiktok Profile"
                          aria-label="Tiktok Profile"
                          name="tiktok"/>
                      </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="icon-base text-primary ri ri-link-m icon-20px"></i>
                        </span>
                        <input
                          type="url"
                          class="form-control"
                          id="memberportfolio"
                          placeholder="Portfolio Link"
                          aria-label="Portfolio Link"
                          name="portfolio"/>
                      </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="icon-base text-primary ri ri-upwork-line icon-20px"></i>
                        </span>
                        <input
                          type="url"
                          class="form-control"
                          id="memberupwork"
                          placeholder="Upwork Profile"
                          aria-label="Upwork Profile"
                          name="upwork" />
                      </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="icon-base text-primary ri ri-fiverr-line icon-20px"></i>
                        </span>
                        <input
                          type="url"
                          class="form-control"
                          id="memberfiverr"
                          placeholder="Fiverr Profile"
                          aria-label="Fiverr Profile"
                          name="fiverr"/>
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