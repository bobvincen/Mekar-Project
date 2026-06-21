<nav class="bg-white shadow-sm px-8 py-5 flex justify-between items-center">

    <div>

        <h2 class="text-2xl font-bold text-slate-800">
            @yield('title')
        </h2>

    </div>

    <div class="flex items-center gap-4">

        <input
            type="text"
            placeholder="Cari..."
            class="border border-gray-300 rounded-xl px-4 py-2 w-64">

        <button class="bg-slate-100 p-2 rounded-xl">
            🔔
        </button>

    </div>

</nav>
