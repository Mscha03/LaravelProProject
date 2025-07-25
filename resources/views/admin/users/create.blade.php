@component('admin.layouts.content', ['title' => 'پنل مدیریت'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">پنل مدیریت</a></li>
    @endslot
    
    @slot('breadcrumb')
        <li class="breadcrumb-item active">ایجاد کاربر</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
          @include('admin.layouts.errors')
            <div class="card ">
              <div class="card-header">
                <h3 class="card-title">فرم ایجاد کاربر</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="card-body">
                  <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">نام کاربر</label>

                    <div >
                      <input type="text" name="name" class="form-control" id="name" placeholder="نام کاربر را وارد کنید">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">ایمیل</label>

                    <div >
                      <input type="email" name="email" class="form-control" id="email" placeholder="ایمیل را وارد کنید">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">پسورد</label>

                    <div >
                      <input name="password" type="password" class="form-control" id="password" placeholder="پسورد را وارد کنید">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="password_confirmation" class="col-sm-2 control-label">تکرار پسورد</label>

                    <div >
                      <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="پسورد را تکرار کنید">
                    </div>
                  </div>
                  <div>
                    <input type="checkbox" name="verify" class="form-check-input" id="verify">
                    <label class="form-check-label" for="verify">اکانت فعال باشد</label>
                  </div>
                 
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-info">ثبت کاربر</button>
                  <a href="{{ route('admin.users.index') }}" class="btn btn-default float-left">لغو</a>
                </div>
                <!-- /.card-footer -->
              </form>
            </div>
        </div>
    </div>

@endcomponent