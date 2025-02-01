<div class="fi-sidebar-footer mt-auto flex flex-col items-center p-4">
    <div class="profile-picture mb-2">
        <i class="bi-person-circle"></i>
        <x-bi-person-circle width="50" height="50" color="#fff" />
    </div>
    <span class="font-medium text-white">{{ Auth::user()->name ?? 'ADMIN' }}</span>

    <form action="/logout" method="POST">
        @csrf
        <button type="submit"
            class="mt-2 flex items-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-purple-700">
            <x-bi-box-arrow-right width="20" height="20" color="#000" />&nbsp;LOGOUT
        </button>
    </form>

</div>
