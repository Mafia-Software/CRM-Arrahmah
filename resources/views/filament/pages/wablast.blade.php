<x-filament-panels::page>
    <div class="p-6 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">WhatsApp Blast</h1>

            <!-- Dropdown Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Content Plan Dropdown -->
                <div>
                    <label for="contentplaner" class="block text-sm font-medium text-gray-700">Content Plan</label>
                    <select id="contentplaner" name="contentplaner" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        @foreach ($ContentPlanner as $contentPlan)
                            <option value="{{ $contentPlan->id }}" data-message="{{ $contentPlan->pesan }}">{{ $contentPlan->id }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Unit Work Dropdown -->
                <div>
                    <label for="UnitKerja" class="block text-sm font-medium text-gray-700">Unit Kerja</label>
                    <select id="UnitKerja" name="UnitKerja" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        @foreach ($UnitKerja as $UnitKerja)
                            <option value="{{ $UnitKerja->id }}">{{ $UnitKerja->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Form Section -->
            <form action="/send-blast" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf

                <!-- Input Message -->
                <div class="col-span-1">
                    <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                    <textarea id="message" name="message" rows="10" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Type your message here..."></textarea>
                </div>

                <!-- Input Recipients -->
                <div class="col-span-1">
                    <label for="recipients" class="block text-sm font-medium text-gray-700">Recipients</label>
                    <textarea id="message" name="message" rows="10" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Masukan Nomor Handphone"></textarea>
                </div>

                <!-- Schedule Option -->
                <div class="col-span-2">
                    <label for="schedule" class="block text-sm font-medium text-gray-700">Schedule</label>
                    <input type="datetime-local" id="schedule" name="schedule" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>

                <!-- Submit Button -->
                <div class="col-span-2">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">Send Blast</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('contentplaner').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const message = selectedOption.getAttribute('data-message'); // Ambil atribut data-message
            const messageField = document.getElementById('message'); // Ambil teks area

            if (messageField && message) {
                messageField.value = message; // Isi teks area dengan pesan
            }
        });

    </script>

</x-filament-panels::page>
