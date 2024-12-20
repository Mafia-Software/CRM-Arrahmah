<x-filament-panels::page>
    <div class="min-h-screen bg-gray-100 p-6">
        <div class="mx-auto max-w-4xl rounded-lg bg-white p-8 shadow-md">
            <h1 class="mb-6 text-2xl font-bold text-gray-800">WhatsApp Blast</h1>

            <!-- Dropdown Section -->
            <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Content Plan Dropdown -->
                <div>
                    <label for="contentplaner" class="block text-sm font-medium text-gray-700">Content Plan</label>
                    <select id="contentplaner" name="contentplaner"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option disabled selected>Pilih Content Plan</option>
                        @foreach ($ContentPlanner as $contentPlan)
                            <option value="{{ $contentPlan->id }}" data-message="{{ $contentPlan->pesan }}">
                                {{ $contentPlan->id }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Unit Work Dropdown -->
                <div>
                    <label for="UnitKerja" class="block text-sm font-medium text-gray-700">Unit Kerja</label>
                    <select id="UnitKerja" name="UnitKerja"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        @foreach ($UnitKerja as $UnitKerja)
                            <option value="{{ $UnitKerja->id }}">{{ $UnitKerja->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Form Section -->
            <form action="/sendMessage" method="POST" class="grid grid-cols-1 gap-6 md:grid-cols-2">
                @csrf
                <input type="hidden" name="instance_id" id="instance_id" value="676265690B7CF">
                <!-- Input Message -->
                <div class="col-span-1">
                    <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                    <textarea id="message" name="message" rows="10"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        placeholder="Type your message here..."></textarea>
                </div>

                <!-- Input Recipients -->
                <div class="col-span-1">
                    <label for="recipients" class="block text-sm font-medium text-gray-700">Recipients</label>
                    <textarea id="number" name="number" rows="10"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        placeholder="Masukan Nomor Handphone"></textarea>
                </div>

                {{-- <!-- Schedule Option -->
                <div class="col-span-2">
                    <label for="schedule" class="block text-sm font-medium text-gray-700">Schedule</label>
                    <input type="datetime-local" id="schedule" name="schedule"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div> --}}

                <!-- Submit Button -->
                <div class="col-span-2">
                    <button type="submit"
                        class="w-full rounded-md bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">Send
                        Message</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('contentplaner').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const message = selectedOption.getAttribute('data-message'); // Ambil atribut data-message
            const messageField = document.getElementById('message'); // Ambil teks area

            if (messageField && message) {
                messageField.value = message; // Isi teks area dengan pesan
            }
        });
    </script>

</x-filament-panels::page>
