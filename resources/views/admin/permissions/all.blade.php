@component('admin.layouts.content', ['title' => 'دسترسی ها'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">دسترسی ها</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">دسترسی ها</h3>

                    <div class="card-tools d-flex">
                        <form action="">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                       placeholder="جستجو" value="{{ request('table_search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                        <div class="btn-group-sm mr-2">
                            <a href="{{ route('admin.permissions.create') }}" class="btn btn-info">ایجاد دسترسی جدید</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>نام دسترسی</th>
                            <th>توضیح دسترسی</th>
                            <th>اقدامات</th>
                        </tr>

                        @foreach($permissions as $permission)
                            <tr>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->label }}</td>
                                <td class="d-flex">
                                        <a href='{{ route('admin.permissions.edit', ['permission' => $permission->id]) }}'
                                           class="btn btn-info btn-sm">ویرایش</a>

                                        <button class="btn btn-danger mr-2 btn-sm"
                                                onclick="confirmDelete({{ $permission->id }}, '{{ $permission->name }}')"> حذف
                                        </button>

                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{ $permissions->links() }}
                </div>
            </div>
            <!-- /.card -->
        </div>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            import Swal from "sweetalert2";

            function confirmDelete(permissionId, permissionName) {
                Swal.fire({
                    title: `دسترسی  ${permissionName} حذف شود؟`,
                    text: "شما نمی توانید این کار را برگردانید!",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonText: "لغو",
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "بله، حذف کن!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // ساخت و ارسال فرم به صورت POST/DELETE
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/admin/permissions/${permissionId}`;

                        const tokenInput = document.createElement('input');
                        tokenInput.type = 'hidden';
                        tokenInput.name = '_token';
                        tokenInput.value = '{{ csrf_token() }}';

                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';

                        form.appendChild(tokenInput);
                        form.appendChild(methodInput);

                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }
        </script>


    </div>

@endcomponent
