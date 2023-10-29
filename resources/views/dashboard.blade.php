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
                                        @else 
                                        PAID
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
                             
                          </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
