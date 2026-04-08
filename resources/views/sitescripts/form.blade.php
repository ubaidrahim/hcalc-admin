<div class="modal fade" id="scriptModal" tabindex="-1" aria-labelledby="scriptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
        <div id="scriptMsg"></div>
        <form id="scriptForm" action="#" method="POST">
        <div class="modal-header">
            <h5 class="modal-title" id="scriptModalLabel">Add Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <input type="hidden" id="scriptId" value="">
            <div class="row justify-content-center">

                <div class="col-md-8 mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" id="scriptName" name="name" class="form-control" required>
                    </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Type</label>
                    <input type="text" id="scriptType" name="type" class="form-control" required readonly>
                    </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Placement</label>
                    <select id="scriptPlace" name="placement" class="form-select" required>
                        <option value="head">Head</option>
                        <option value="body_start">Body Start</option>
                        <option value="body_end">Body End</option>
                    </select>
                    </div>
            </div>
            <div class="row justify-content-center d-none typeinput" data-type="gtag">
                <div class="col-md-8 mb-3">
                    <label class="form-label">GTAG Measurement ID</label>
                    <input type="text" id="gtagId" name="measurement_id" class="form-control" placeholder="e.g G-XXXXXXXXXX">
                    </div>
            </div>
            <div class="row justify-content-center d-none typeinput" data-type="gmt">
                <div class="col-md-8 mb-3">
                    <label class="form-label">GMT Measurement ID</label>
                    <input type="text" id="gmtId" name="measurement_id" class="form-control" placeholder="e.g G-XXXXXXXXXX">
                    </div>
            </div>
            <div class="row justify-content-center d-none typeinput" data-type="adsense">
                <div class="col-md-8 mb-3">
                    <label class="form-label">Adsense Client ID</label>
                    <input type="text" id="adsenseClientId" name="client_id" class="form-control" placeholder="e.g ca-pub-1234567890123456">
                    </div>
            </div>
            <div class="row justify-content-center d-none typeinput" data-type="meta_tag">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Meta Tag Name</label>
                    <input type="text" id="metaTagName" name="meta_name" class="form-control">
                    </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Meta Tag Value</label>
                    <input type="text" id="metaTagValue" name="meta_value" class="form-control">
                    </div>
            </div>
            <div class="row justify-content-center d-none typeinput" data-type="external_src">
                <div class="col-md-8 mb-3">
                    <label class="form-label">External URL Source</label>
                    <input type="text" id="externalUrlSrc" name="url_source" class="form-control">
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