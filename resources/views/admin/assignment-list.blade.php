@extends('layouts.app')

@section('content')
      <!-- Card -->
      <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
          <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
              <!-- Header -->
              <div class="px-4 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
                <div>
                  <h2 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">
                    Senarai 
                  </h2>
                  <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Tambah pengguna, ubah info pengguna, dan lain lain.
                  </p>
                </div>

                <div>
                  <div class="inline-flex gap-x-2">
                    <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" href="{{ route('admin.create-qr') }}">
                      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                      </svg>
                      Tambah Tugasan
                    </a>
                  </div>
                </div>
              </div>

              <!-- Table -->
              <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                  <thead class="bg-gray-50 dark:bg-neutral-800">
                    <tr>
                      <th scope="col" class="ps-4 py-3 text-start">
                        <span class="sr-only">Checkbox</span>
                      </th>

                      <th scope="col" class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3 text-start">
                        <div class="flex items-center gap-x-2">
                          <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                            No.
                          </span>
                        </div>
                      </th>

                      <th scope="col" class="px-4 py-3 text-start">
                        <div class="flex items-center gap-x-2">
                          <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                            Peringkat
                          </span>
                        </div>
                      </th>

                      <th scope="col" class="px-4 py-3 text-start">
                        <div class="flex items-center gap-x-2">
                          <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                            Blok
                          </span>
                        </div>
                      </th>

                      <th scope="col" class="px-4 py-3 text-start">
                        <div class="flex items-center gap-x-2">
                          <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                            No Lot
                          </span>
                        </div>
                      </th>

                      <th scope="col" class="px-4 py-3 text-start">
                        <div class="flex items-center gap-x-2">
                          <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                            No Pentas Tuai
                          </span>
                        </div>
                      </th>

                      <th scope="col" class="px-4 py-3 text-start">
                        <div class="flex items-center gap-x-2">
                          <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                            Status
                          </span>
                        </div>
                      </th>

                      <th scope="col" class="px-4 py-3 text-end">Actions</th>
                    </tr>
                  </thead>

                  <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                    @php($i=1)
                    @foreach($assignments as $assignment)
                      <tr>
                        <td class="size-px whitespace-nowrap">
                          <div class="ps-4 py-3">
                            <label for="hs-at-with-checkboxes-1" class="flex">
                              <span class="sr-only">Checkbox</span>
                            </label>
                          </div>
                        </td>
                        <td class="size-px whitespace-nowrap">
                          <div class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3">
                            <div class="flex items-center gap-x-3">
                              <div class="grow">
                                <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">{{$i++}}</span> 
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class="size-px whitespace-nowrap">
                          <div class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3">
                            <div class="flex items-center gap-x-3">
                              <div class="grow">
                                <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">{{ $assignment->peringkat }}</span> 
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class="h-px w-56 whitespace-nowrap px-4 py-3">
                          <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">{{$assignment->blok}}</span>
                        </td>
                        <td class="h-px w-56 whitespace-nowrap px-4 py-3">
                          <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">{{$assignment->n_lot}}</span>
                        </td>
                        <td class="h-px w-56 whitespace-nowrap px-4 py-3">
                          <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">{{$assignment->n_p_tuai}}</span>
                        </td>
                        <td class="size-px whitespace-nowrap px-4 py-3">
                          @if($assignment->status == 'pending')
                            <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
                              <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                              </svg>
                              Pending
                            </span>
                          @else
                            <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-red-100 text-red-800 rounded-full dark:bg-red-500/10 dark:text-red-500">
                              <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6.002a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                              </svg>
                              Selesai
                            </span>
                          @endif
                        </td>
                        <td class="h-px w-px whitespace-nowrap text-center">
                          <a class="inline-flex items-center gap-x-1.5 text-sm font-medium text-blue-600 decoration-2 hover:underline focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 dark:text-blue-500 dark:focus:ring-offset-neutral-800" href="{{ route('mandor-update-fruit-details', ['assignment_id' => $assignment->id]) }}">
                            Update
                          </a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

              <!-- Pagination -->
              {{-- <div class="px-6 py-4 border-t border-gray-200 dark:border-neutral-700">
                <div class="flex justify-center items-center">
                  {{ $assignments->links() }}
                </div>
              </div> --}}
            </div>
          </div>
        </div>
      </div>
@endsection
