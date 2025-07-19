@component('admin.layouts.content', ['title' => 'لیست کاربران'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">لیست کاربران</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">کاربران</h3>

                    <div class="card-tools d-flex">
                        <form action="">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="جستجو" value="{{ request('table_search') }}">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                        <div class="btn-group-sm mr-2">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-info">افزودن کاربر جدید</a>
                            <a href="{{ request()->fullUrlWithQuery(['admin' => 1]) }}" class="btn btn-warning"> کاربران مدیر</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>آیدی کاربر</th>
                            <th>نام کاربر</th>
                            <th>وضعیت ایمیل</th>
                            <th>اقدامات</th>
                        </tr>

                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="badge badge-success">تایید شده</span>
                                    @else
                                        <span class="badge badge-danger">تایید نشده</span>
                                    @endif
                                </td>
                                <td class="d-flex">
                                    @can('edit-user', $user)
                                      <a href='{{ route('admin.users.edit', ['user' => $user->id]) }}'
                                       class="btn btn-info btn-sm">ویرایش</a>

                                       <button class="btn btn-danger mr-2 btn-sm" onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')"> حذف</button>
                                    @endcan 

                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{ $users->links() }}
                </div>
            </div>
            <!-- /.card -->
        </div>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmDelete(userId, userName) {
                Swal.fire({
                    title: `کاربر ${userName} حذف شود؟`,
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
                form.action = `/admin/users/${userId}`;
                
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
