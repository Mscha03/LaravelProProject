@component('admin.layouts.content', ['title' => 'پنل مدیریت'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">همه دسترسی ها</a></li>
    @endslot

    @slot('breadcrumb')
        <li class="breadcrumb-item active">ایجاد دسترسی</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
          @include('admin.layouts.errors')
            <div class="card ">
              <div class="card-header">
                <h3 class="card-title">فرم ایجاد دسترسی</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="{{ route('admin.permissions.store') }}" method="POST">
                @csrf

                <div class="card-body">
                  <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">نام دسترسی</label>

                    <div >
                      <input type="text" name="name" class="form-control" id="name" placeholder="عنوان دسترسی را وارد کنید">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="text" class="col-sm-2 control-label"> توضیح دسترسی</label>

                    <div >
                      <input type="text" name="label" class="form-control" id="text" placeholder="توضیح دسترسی را وارد کنید">
                    </div>
                  </div>


                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-info">ثبت دسترسی</button>
                  <a href="{{ route('admin.permissions.index') }}" class="btn btn-default float-left">لغو</a>
                </div>
                <!-- /.card-footer -->
              </form>
            </div>
        </div>
    </div>

@endcomponent
