<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                <!-- form to add a new bill -->
                <form action="/dashboard" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="font-bold text-gray-800 dark:text-gray-100" for="name">Name</label>
                        <input class="border-2 dark:border-gray-700 border-gray-300 p-2 w-full dark:bg-transparent bg-transparent" type="text" name="name" id="name" required>
                    </div>
                    <div class="mb-4">
                        <label class="font-bold text-gray-800 dark:text-gray-100 bg-transparent" for="amount">Amount</label>
                        <input class="border-2 dark:border-gray-700 border-gray-300 p-2 w-full bg-transparent" type="number"step="any" name="amount" id="amount" required>
                    </div>
                    <div class="mb-4">
                        <label class="font-bold text-gray-800 dark:text-gray-100 bg-transparent" for="due_date">Due Date</label>
                        <input class="border-2 dark:border-gray-700 border-gray-300 p-2 w-full bg-transparent" type="date" name="due_date" id="due_date" required>
                    </div>
                    <div>
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Add Bill</button>
                    </div>
                </form>



                <!-- display bills in table -->
                   <table class="table-auto w-full">
                          <thead>
                            <tr>
                                 <th class="px-4 py-2">Name</th>
                                 <th class="px-4 py-2">Amount</th>
                                 <th class="px-4 py-2">Due Date</th>
                                 <th class="px-4 py-2">Paid Date</th>
                                 <th class="px-4 py-2">Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($bills as $bill)
                            <tr>
                                 <td class="border px-4 py-2">{{ $bill->name }}</td>
                                 <td class="border px-4 py-2">£{{ $bill->amount }}</td>
                                 <td class="border px-4 py-2">{{ $bill->due_date }}</td>
                                 <td class="border px-4 py-2">{{ $bill->paid_date }}</td>
                                 <!-- td with button to mark as paid -->
                                    <td class="border px-4 py-2">
                                    <!-- if bull is not paid display button to mark as paid -->
                                        @if ($bill->paid_date == null)
                                        <form action="/dashboard/paid/{{ $bill->id }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Mark as Paid</button>
                                        </form>
                                        <!-- add button to delete bill -->
                                        <form action="/dashboard/delete/{{ $bill->id }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                        </form>
                                        @else 
                                        <p class="font-dancing-script text-green-400 text-bold">PAID</p>
                                        @endif    
                                    
                            </tr>
                            @endforeach
                            <!-- row to show total amount of bills -->
                            <tr>
                                <td class="border px-4 py-2">Total</td>
                                <td class="border px-4 py-2">£{{ $bills->sum('amount') }}</td>
                                <td class="border px-4 py-2"></td>
                                <td class="border px-4 py-2"></td>
                                <!-- td with button to reset paid dates -->
                                <td class="border px-4 py-2">
                                    <form action="/dashboard/reset" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Reset</button>
                                    </form>
                            </tr>

                            <!-- Total left to pay -->
                            <tr>
                                <td class="border px-4 py-2">Left to Pay</td>
                                <td class="border px-4 py-2">£{{ $left_to_pay }}</td>
                                <td class="border px-4 py-2"></td>
                                <td class="border px-4 py-2"></td>
                                <td class="border px-4 py-2"></td>
                             
                          </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
