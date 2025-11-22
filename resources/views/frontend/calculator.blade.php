@extends('layouts.app')
@section('content')

<style>
  .card p { margin:0; }

  .same-height .form-control,
  .same-height .select2-container .select2-selection--single {
      height: 40px !important;
  }

  .same-height .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: 38px !important;
  }

  .same-height .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 38px !important;
  }
</style>

<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <h3 class="mb-4">Calculator</h3>

    <div class="row mb-4">
      <div class="col-md-4">
        <div class="card p-3 text-center">
          <h5>Total Calculator</h5>
          <h2 id="countTotal">0</h2>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card p-3 text-center">
          <h5>Active Calculator</h5>
          <h2 id="countActive">0</h2>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card p-3 text-center">
          <h5>Inactive Calculator</h5>
          <h2 id="countInactive">0</h2>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-end mb-3">
      <button class="btn btn-primary" id="btnAddcalculator">+ Add Calculator</button>
    </div>

    <div class="table-responsive">
      <table class="table" id="calculatorTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Sub-Category</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="calculatorList"></tbody>
      </table>
    </div>

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

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Confirm Delete</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">Are you sure you want to delete this?</div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
let calculatorData = [];
let deleteIndex = null;

const calculatorModal = new bootstrap.Modal(document.getElementById('calculatorModal'));
const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

const catId = document.getElementById("catId");
const cattitle = document.getElementById("cattitle");
const catStatus = document.getElementById("catStatus");
const editIndex = document.getElementById("editIndex");

let table;

$(document).ready(function () {
    table = $('#calculatorTable').DataTable({
        dom: '<"row mb-3"<"col-md-6 d-flex align-items-center"f><"col-md-6 text-end"B>>' +
             'rt' +
             '<"row mt-3"<"col-md-6"i><"col-md-6"p>>',
        buttons: [
            { extend: 'csv', text: 'CSV' },
            { extend: 'excel', text: 'Excel' },
            { extend: 'pdf', text: 'PDF' }
        ],
        language: { search: "", searchPlaceholder: "Search calculator..." }
    });

    $('.select2').select2({ width: '100%', dropdownParent: $('#calculatorModal') });

    if (!CKEDITOR.instances.catDesc) {
        CKEDITOR.replace('catDesc');
    }
});

document.getElementById('btnAddcalculator').addEventListener('click', function () {
  resetForm();
  document.getElementById('calculatorModalLabel').innerText = 'Add Calculator';
  calculatorModal.show();
});

$('#calculatorModal').on('hidden.bs.modal', function () {
    resetForm();
});

document.getElementById("calculatorForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const title = cattitle.value.trim();
  const desc = CKEDITOR.instances.catDesc.getData().trim();
  const status = catStatus.value;
  const category = document.getElementById('categoryType').value;
  const subCategory = document.getElementById('subcategoryType').value;
  const editIdx = editIndex.value;

  if (!title || !status || !category || !subCategory) {
    alert('Please fill in all required fields.');
    return;
  }

  if (editIdx === "") {
    const newId = calculatorData.length > 0 ? calculatorData[calculatorData.length - 1].id + 1 : 1;
    calculatorData.push({ id: newId, title, desc, status, category, subCategory });
  } else {
    calculatorData[editIdx] = { id: parseInt(catId.value), title, desc, status, category, subCategory };
    editIndex.value = "";
  }

  renderTable();
  updateCounters();
  calculatorModal.hide();
});

function renderTable() {
  table.clear();
  calculatorData.forEach((item, index) => {
    const tmpDiv = document.createElement('div');
    tmpDiv.innerHTML = item.desc || '';
    let shortDesc = tmpDiv.textContent || tmpDiv.innerText || '';
    if (shortDesc.length > 80) shortDesc = shortDesc.substring(0, 77) + '...';

    table.row.add([
      item.id,
      item.title,
      item.category || '',
      item.subCategory || '',
      shortDesc,
      item.status,
      `<button class="btn btn-warning btn-sm" onclick="editcalculator(${index})">Edit</button>
       <button class="btn btn-danger btn-sm" onclick="deletecalculator(${index})">Delete</button>`
    ]);
  });
  table.draw(false);
}

function updateCounters() {
  document.getElementById("countTotal").innerText = calculatorData.length;
  document.getElementById("countActive").innerText = calculatorData.filter(x => x.status === "Active").length;
  document.getElementById("countInactive").innerText = calculatorData.filter(x => x.status === "Inactive").length;
}

function resetForm() {
  editIndex.value = '';
  catId.value = '';
  cattitle.value = '';
  catStatus.value = '';
  $('#categoryType').val('').trigger('change');
  $('#subcategoryType').val('').trigger('change');
  CKEDITOR.instances.catDesc.setData('');
}
function editcalculator(index) {
  const item = calculatorData[index];
  catId.value = item.id;
  cattitle.value = item.title;
  catStatus.value = item.status;
  editIndex.value = index;

  document.getElementById('calculatorModalLabel').innerText = 'Edit Calculator';
  calculatorModal.show();

  $('#calculatorModal').one('shown.bs.modal', function () {
    CKEDITOR.instances.catDesc.setData(item.desc || '');
    $('#categoryType').val(item.category || '').trigger('change');
    $('#subcategoryType').val(item.subCategory || '').trigger('change');
    cattitle.focus();
  });
}

function deletecalculator(index) {
  deleteIndex = index;
  deleteModal.show();
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
  if (deleteIndex !== null) {
    calculatorData.splice(deleteIndex, 1);
    renderTable();
    updateCounters();
    deleteModal.hide();
    deleteIndex = null;
  }
});

window.editcalculator = editcalculator;
window.deletecalculator = deletecalculator;

</script>
@endpush
