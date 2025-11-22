@extends('layouts.app')
@section('content')

<style>
  .card p { margin:0; }

</style>
{{-- kanwal --}}
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <h3 class="mb-4">Categories</h3>

    <div class="row mb-4">
      <div class="col-md-4">
        <div class="card p-3 text-center">
          <h5>Total Categories</h5>
          <h2 id="countTotal">0</h2>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card p-3 text-center">
          <h5>Active Categories</h5>
          <h2 id="countActive">0</h2>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card p-3 text-center">
          <h5>Inactive Categories</h5>
          <h2 id="countInactive">0</h2>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-end mb-3">
      <button class="btn btn-primary" id="btnAddCategory">+ Add Category</button>
    </div>

    <div class="table-responsive">
      <table class="table" id="categoryTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="categoryList"></tbody>
      </table>
    </div>

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

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Confirm Delete</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">Are you sure you want to delete this category?</div>
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
let categoryData = [];
let deleteIndex = null;

const categoryModal = new bootstrap.Modal(document.getElementById('categoryModal'));
const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

const catId = document.getElementById("catId");
const cattitle = document.getElementById("cattitle");
const catStatus = document.getElementById("catStatus");
const editIndex = document.getElementById("editIndex");

let table;

$(document).ready(function () {
    table = $('#categoryTable').DataTable({
        dom: '<"row mb-3"<"col-md-6 d-flex align-items-center"f><"col-md-6 text-end"B>>' +
             'rt' +
             '<"row mt-3"<"col-md-6"i><"col-md-6"p>>',
        buttons: [
            { extend: 'csv', text: 'CSV' },
            { extend: 'excel', text: 'Excel' },
            { extend: 'pdf', text: 'PDF' }
        ],
        language: { search: "", searchPlaceholder: "Search category..." }
    });

    $('.select2').select2({ width: '100%', dropdownParent: $('#categoryModal') });

    if (!CKEDITOR.instances.catDesc) {
        CKEDITOR.replace('catDesc');
    }
});

// Open Add modal
document.getElementById('btnAddCategory').addEventListener('click', function () {
  resetForm();
  document.getElementById('categoryModalLabel').innerText = 'Add Category';
  categoryModal.show();
});

$('#categoryModal').on('hidden.bs.modal', function () {
    resetForm();
    $('.select2').val('').trigger('change');
});

document.getElementById("categoryForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const title = cattitle.value.trim();
  const desc = CKEDITOR.instances.catDesc.getData().trim();
  const status = catStatus.value;
  const editIdx = editIndex.value;

  if (!title || !status) {
    alert('Please provide Title and Status.');
    return;
  }

  if (editIdx === "") {
    const newId = categoryData.length > 0 ? categoryData[categoryData.length - 1].id + 1 : 1;
    categoryData.push({ id: newId, title, desc, status });
  } else {
    categoryData[editIdx] = { id: parseInt(catId.value), title, desc, status };
    editIndex.value = "";
  }

  renderTable();
  updateCounters();
  categoryModal.hide();
});

function renderTable() {
  table.clear();

  categoryData.forEach((item, index) => {
    const tmpDiv = document.createElement('div');
    tmpDiv.innerHTML = item.desc || '';
    let shortDesc = tmpDiv.textContent || tmpDiv.innerText || '';
    if (shortDesc.length > 80) shortDesc = shortDesc.substring(0, 77) + '...';

   table.row.add([
  item.id,
  item.title,      
  shortDesc,
  item.status,
  `<button class="btn btn-warning btn-sm" onclick="editCategory(${index})">Edit</button>
   <button class="btn btn-danger btn-sm" onclick="deleteCategory(${index})">Delete</button>`
]);
  });

  table.draw(false);
}

function updateCounters() {
  document.getElementById("countTotal").innerText = categoryData.length;
  document.getElementById("countActive").innerText = categoryData.filter(x => x.status === "Active").length;
  document.getElementById("countInactive").innerText = categoryData.filter(x => x.status === "Inactive").length;
}

function resetForm() {
  editIndex.value = '';
  catId.value = '';
  cattitle.value = '';
  catStatus.value = '';
  CKEDITOR.instances.catDesc.setData('');
}

function editCategory(index) {
  const item = categoryData[index];
  catId.value = item.id;
  cattitle.value = item.title;
  catStatus.value = item.status;
  editIndex.value = index;

  document.getElementById('categoryModalLabel').innerText = 'Edit Category';
  categoryModal.show();

  $('#categoryModal').one('shown.bs.modal', function () {
    CKEDITOR.instances.catDesc.setData(item.desc || '');
    cattitle.focus();
    $('#categoryType').val(item.type || '').trigger('change');
  });
}

function deleteCategory(index) {
  deleteIndex = index;
  deleteModal.show();
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
  if (deleteIndex !== null) {
    categoryData.splice(deleteIndex, 1);
    renderTable();
    updateCounters();
    deleteModal.hide();
    deleteIndex = null;
  }
});

window.editCategory = editCategory;
window.deleteCategory = deleteCategory;

</script>
@endpush
