<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header border-bottom">
          <h5 class="card-title mb-0"><?= $title ?></h5>
        </div>
        <div class="card-body">
          <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                  <li><?= $error ?></li>
                <?php endforeach; ?>
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          
          <form action="<?= base_url('admin/complaint-data/update/' . $complaint['id']) ?>" method="POST">
            <div class="form-group mb-3">
              <label for="table_heading" class="form-label">Table Heading <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="table_heading" name="table_heading" value="<?= old('table_heading', $complaint['fld_table_heading']) ?>" required>
            </div>
            
            <div class="form-group mb-3">
              <label for="table_data" class="form-label">Table Data <span class="text-danger">*</span></label>
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                  <thead>
                    <tr>
                      <?php if (!empty($complaint['fld_table_data']) && is_array($complaint['fld_table_data'])): ?>
                        <?php 
                        $colCount = count($complaint['fld_table_data'][0]);
                        for ($i = 0; $i < $colCount; $i++): 
                        ?>
                          <th>Column <?= $i + 1 ?></th>
                        <?php endfor; ?>
                      <?php else: ?>
                        <th>Column 1</th>
                        <th>Column 2</th>
                        <th>Column 3</th>
                      <?php endif; ?>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($complaint['fld_table_data']) && is_array($complaint['fld_table_data'])): ?>
                      <?php foreach ($complaint['fld_table_data'] as $rowIdx => $row): ?>
                        <tr>
                          <?php foreach ($row as $colIdx => $cell): ?>
                            <td><input type="text" class="form-control" name="table_data[<?= $rowIdx ?>][<?= $colIdx ?>]" value="<?= $cell ?>"></td>
                          <?php endforeach; ?>
                          <td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="bx bx-trash"></i></button></td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td><input type="text" class="form-control" name="table_data[0][0]" value=""></td>
                        <td><input type="text" class="form-control" name="table_data[0][1]" value=""></td>
                        <td><input type="text" class="form-control" name="table_data[0][2]" value=""></td>
                        <td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="bx bx-trash"></i></button></td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
              <button type="button" class="btn btn-sm btn-success mt-2" id="addRow"><i class="bx bx-plus me-1"></i> Add Row</button>
              <button type="button" class="btn btn-sm btn-primary mt-2" id="addColumn"><i class="bx bx-plus me-1"></i> Add Column</button>
            </div>
            
            <div class="form-group mb-3">
              <label for="table_footer" class="form-label">Table Footer</label>
              <textarea class="form-control" id="table_footer" name="table_footer" rows="2"><?= old('table_footer', $complaint['fld_table_footer']) ?></textarea>
            </div>
            
            <div class="form-group mb-3">
              <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
              <select class="form-select" id="status" name="status" required>
                <option value="1" <?= old('status', $complaint['fld_status']) == '1' ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= old('status', $complaint['fld_status']) == '0' ? 'selected' : '' ?>>Inactive</option>
              </select>
            </div>
            
            <div class="d-flex justify-content-end">
              <a href="<?= base_url('admin/complaint-data') ?>" class="btn btn-label-secondary me-2">Cancel</a>
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  $(document).ready(function() {
    // Add new row
    $('#addRow').click(function() {
      var rowCount = $('#dataTable tbody tr').length;
      var colCount = $('#dataTable thead th').length - 1; // Exclude actions column
      
      var newRow = '<tr>';
      for (var i = 0; i < colCount; i++) {
        newRow += '<td><input type="text" class="form-control" name="table_data[' + rowCount + '][' + i + ']" value=""></td>';
      }
      newRow += '<td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="bx bx-trash"></i></button></td>';
      newRow += '</tr>';
      
      $('#dataTable tbody').append(newRow);
    });
    
    // Add new column
    $('#addColumn').click(function() {
      var colCount = $('#dataTable thead th').length;
      var newColIndex = colCount - 1; // Before actions column
      
      // Add header
      $('#dataTable thead tr').find('th:eq(' + newColIndex + ')').before('<th>Column ' + colCount + '</th>');
      
      // Add cells to each row
      $('#dataTable tbody tr').each(function(rowIdx) {
        $(this).find('td:eq(' + newColIndex + ')').before('<td><input type="text" class="form-control" name="table_data[' + rowIdx + '][' + (colCount - 1) + ']" value=""></td>');
      });
    });
    
    // Remove row
    $(document).on('click', '.remove-row', function() {
      if ($('#dataTable tbody tr').length > 1) {
        $(this).closest('tr').remove();
        
        // Reindex rows
        $('#dataTable tbody tr').each(function(rowIdx) {
          $(this).find('input').each(function(colIdx) {
            var name = $(this).attr('name');
            var newName = name.replace(/table_data\[\d+\]\[\d+\]/, 'table_data[' + rowIdx + '][' + colIdx + ']');
            $(this).attr('name', newName);
          });
        });
      } else {
        alert('Table must have at least one row');
      }
    });
  });
</script>
<?= $this->endSection() ?>