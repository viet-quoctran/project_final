@extends('admin.master.master')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Customer Manager</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered getUserId" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Package</th>
                            <th>Project</th>
                            <th>Create_at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Package</th>
                            <th>Project</th>
                            <th>Create_at</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <input type="hidden" class="userId" value="{{ $user->id }}">
                            <td>{{$user->name}}</td>
                            <td>
                                @foreach($user->packages as $package)
                                    {{$package->name}}
                                @endforeach
                            </td>
                            <td>
                                @if($user->projects->isEmpty())
                                <button type="button" class="btn btn-success" data-toggle="modal"  data-target="#addProjectModal" title="Add" data-user-id="{{ $user->id }}">
                                    <i class="fas fa-plus"></i>
                                </button>
                                @else
                                    @foreach($user->projects as $project)
                                        {{$project->name}}
                                    @endforeach
                                @endif
                            </td>
                            <td>{{$user->created_at}}</td>
                            <td>
                                <button class="btn btn-danger" onclick="deleteRow(this)" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <button class="btn btn-primary" onclick="editRow(this)" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addPackageModal">Add Package</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Quantity Dashboard</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Quantity Dashboard</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($packages as $package)
                        <tr>
                            <td>{{ $package->name }}</td>
                            <td>{{ $package->amount }}</td>
                            <td>{{ $package->quality_dashboard }}</td>
                            <td>{{ $package->description }}</td>
                            <td><img src="{{ Storage::url($package->image) }}" alt="Package Image" style="width: 200px; height: auto;"></td>
                            <td>
                                <button class="btn btn-danger" onclick="deleteRow(this)" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <button class="btn btn-primary" onclick="editRow(this)" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- Modal for Adding Package -->
<div class="modal fade" id="addProjectModal" tabindex="-1" role="dialog" aria-labelledby="addProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProjectModalLabel">Add New Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addProjectForm">
                    <!-- Form content for project -->
                    <input type="hidden" class="user-id-input" value="">
                    <div class="form-group">
                        <label for="projectName">Name</label>
                        <input type="text" name="projectName" class="form-control" id="projectName" placeholder="Enter project name">
                    </div>
                    <div class="form-group">
                        <label for="linkPowerBi">Link Power BI</label>
                        <input type="text" name="linkPowerBi" class="form-control" id="linkPowerBi" placeholder="Enter quality of dashboards">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveProject()">Save Project</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addPackageModal" tabindex="-1" role="dialog" aria-labelledby="addPackageModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPackageModalLabel">Add New Package</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addPackageForm">
          <!-- Form content for package -->
          <div class="form-group">
            <label for="packageName">Name</label>
            <input type="text" name="packageName" class="form-control" id="packageName" placeholder="Enter package name">
          </div>
          <div class="form-group">
            <label for="packageAmount">Amount ($)</label>
            <input type="number" name="packageAmount" class="form-control" id="packageAmount" placeholder="Enter amount">
          </div>
          <div class="form-group">
            <label for="packageQualityDashboard">Quality Dashboard</label>
            <input type="number" name="packageQualityDashboard" class="form-control" id="packageQualityDashboard" placeholder="Enter quality of dashboards">
          </div>
          <div class="form-group">
            <label for="packageDescription">Description</label>
            <textarea class="form-control" name="packageDescription" id="packageDescription" rows="3" placeholder="Enter package description"></textarea>
          </div>
          <div class="form-group">
            <label for="packageImage">Image</label>
            <input type="file" name="packageImage" class="form-control-file" id="packageImage">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="savePackage()">Save Package</button>
      </div>
    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    var userId; 

    $('.btn-success').click(function() {
        userId = $(this).data('user-id');
    });
    function savePackage() {
        // Tạo một đối tượng FormData để gửi dữ liệu form
        var formData = new FormData(document.getElementById('addPackageForm'));

        // Gửi dữ liệu đến server sử dụng AJAX
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Thêm token CSRF vào header
            },
            url: '{{ url("/admin/table") }}',
            type: 'POST',
            data: formData,
            contentType: false,    // Không set content type header
            processData: false,    // Không xử lý dữ liệu gửi lên
            success: function(response) {
                // Xử lý khi nhận được phản hồi thành công từ server
                console.log('Package added successfully:', response);
                $('#addPackageModal').modal('hide'); // Ẩn modal sau khi lưu thành công
                // Cập nhật lại danh sách package nếu cần
            },
            error: function(xhr, status, error) {
                // Xử lý khi có lỗi
                console.error('Error adding package:', xhr.responseText);
            }
        });
    }
    function saveProject() {
        if (typeof userId !== 'undefined') {
            var formData = new FormData(document.getElementById('addProjectForm'));
            formData.append('user_id', userId);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url("/admin/table/project") }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false, 
                success: function(response) {
                    console.log('Project added successfully:', response);
                    $('#addProjectModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error('Error adding package:', xhr.responseText);
                }
            });
        } else {
            console.error('userId is not defined.');
        }
    }
</script>
@endsection
