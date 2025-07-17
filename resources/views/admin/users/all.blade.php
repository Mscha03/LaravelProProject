@component('admin.layouts.content', ['title' => 'پنل مدیریت'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">لیست کاربران</li>
    @endslot

    <h2>Admin panel</h2>

@endcomponent