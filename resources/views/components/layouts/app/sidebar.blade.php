<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    </head>
       <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/semantic.min.css"/>
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.min.css"/>
    <style>
        .hidden {
            display: none;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <body class="font-sans antialiased bg-[#0E121B]" style="font-family: 'Inter', 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">


    <nav class="fixed top-0 z-50 w-full bg-[#0E121B] text-white  dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                    <a href="{{ route('dashboard') }}" class="flex ms-2 md:me-24">
                         <div>
                            <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white"> {{ config('app.name') }}</span>
                         </div>
                        <span
                            class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white"></span>
                    </a>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ms-3">
                        <div>
                            <button type="button"
                                class="flex text-sm focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                aria-expanded="false" data-dropdown-toggle="dropdown-noti">
                                <span class="sr-only">Open notification</span>
                                <svg class="flex-shrink-0 w-8 h-8 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5.365V3m0 2.365a5.338 5.338 0 0 1 5.133 5.368v1.8c0 2.386 1.867 2.982 1.867 4.175 0 .593 0 1.292-.538 1.292H5.538C5 18 5 17.301 5 16.708c0-1.193 1.867-1.789 1.867-4.175v-1.8A5.338 5.338 0 0 1 12 5.365ZM8.733 18c.094.852.306 1.54.944 2.112a3.48 3.48 0 0 0 4.646 0c.638-.572 1.236-1.26 1.33-2.112h-6.92Z"/>
                                </svg>                                  
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-[#131824] divide-y divide-gray-500 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                            id="dropdown-noti">
                            <div class="px-8 py-3" role="none">
                                <p class="text-lg  text-white font-bold dark:text-white" role="none">
                                    Notifications
                                </p>
                            </div>
                            <ul class="py-1 px-2" role="none">
                                <li>
                                    <a href="#"
                                        class="block px-6 py-2 text-lg text-white hover:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-600 rounded-md dark:hover:text-white"
                                        role="menuitem">No Notifications right now.</a>
                                </li>
                            </ul>
                        </div>
                        
                    </div>
                    <div class="flex items-center ms-3">
                        <div>
                            <button type="button"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                @if (Auth::user()->profile_pic)
                                    <div class="relative w-10 h-10">
                                        <img 
                                            width="64" height="64"
                                            class="rounded-full object-cover w-10 h-10 border-4 border-blue-500 shadow-lg"
                                            src="{{ asset('storage/' . Auth::user()->profile_pic) }}"
                                            alt="Profile Photo"
                                        >
                                        <span class="absolute bottom-0 right-0 block w-4 h-4 bg-green-500 border-2 border-white rounded-full"></span>
                                    </div>
                                @else
                                    <div>
                                        <img 
                                            width="64" height="64"
                                            class="rounded-full object-cover w-10 h-10 border-4 border-blue-500 shadow-lg"
                                            src="data:image/png;base64,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"
                                            alt="Profile Photo"
                                        >
                                        
                                    </div>
                                @endif
                            </button>
                        </div>
                        <div class="z-50 hidden p-5 my-4 text-base list-none bg-[#131824]  rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                            id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-md text-white font-bold dark:text-white" role="none">
                                    {{ auth()->user()?->fname.' '.auth()->user()?->lname }}
                                </p>
                                <p class="text-sm text-gray-400 font-bold truncate dark:text-gray-300" role="none">
                                    {{ auth()->user()?->email }}
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="{{ route('dashboard') }}" wire:navigate
                                        class="block px-4 py-2 text-md font-bold text-white hover:bg-gray-800 hover:rounded-md dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Home</a>
                                </li>
                                <li>
                                    <a href="{{ route('profile') }}" wire:navigate
                                        class="block px-4 py-2 text-md font-bold text-white hover:bg-gray-800 hover:rounded-md dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Profile</a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="flex items-center p-3 text-white rounded-lg transition ease-in-out hover:bg-gray-700 hover:translate-x-2 group cursor-pointer">

                                            <svg class="flex-shrink-0 w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/>
                                            </svg>

                                            <span class="ms-3">Logout</span>
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-72 h-screen pt-20 transition-transform -translate-x-full bg-[#131824] text-white  sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidebar">
        <div class="h-full px-5 pb-4 overflow-y-auto bg-[#131824] text-white dark:bg-gray-800">
            <ul class="font-bold text-md">
                <li class="p-1 hover:rounded-md hover:translate-x-4 transition ease-in-out {{ Request::is('dashboard') ? 'bg-blue-500  rounded-md hover:translate-x-4 transition ease-in-out' : '' }}">
                    <a href="{{ route('dashboard') }}" wire:navigate
                        class="flex items-center p-2 text-white rounded-lg dark:text-white  dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z" clip-rule="evenodd"/>
                        </svg>                          
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                {{-- <li class="p-1 hover:rounded-md hover:translate-x-4 transition ease-in-out {{ Request::is('') ? 'bg-blue-500 rounded-md hover:translate-x-4 transition ease-in-out' : '' }}">
                    <a href="{{ route('profile') }}" wire:navigate
                        class="flex items-center p-2 text-white rounded-lg dark:text-white  dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M7 6a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2h-2v-4a3 3 0 0 0-3-3H7V6Z" clip-rule="evenodd"/>
                            <path fill-rule="evenodd" d="M2 11a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-7Zm7.5 1a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5Z" clip-rule="evenodd"/>
                            <path d="M10.5 14.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"/>
                        </svg>                                              
                        <span class="ms-3">Assets</span>
                    </a>
                </li> --}}
                {{-- <li class="p-1 hover:rounded-md hover:translate-x-4 transition ease-in-out {{ Request::is('') ? 'bg-blue-500 rounded-md hover:translate-x-4 transition ease-in-out' : '' }}">
                    <a href="{{ route('profile') }}" wire:navigate
                        class="flex items-center p-2 text-white rounded-lg dark:text-white  dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5V3m0 18v-2M7.05 7.05 5.636 5.636m12.728 12.728L16.95 16.95M5 12H3m18 0h-2M7.05 16.95l-1.414 1.414M18.364 5.636 16.95 7.05M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"/>
                        </svg>                                                 
                        <span class="ms-3">Signals</span>
                    </a>
                </li> --}}
                {{-- <li class="p-1 hover:rounded-md hover:translate-x-4 transition ease-in-out {{ Request::is('') ? 'bg-blue-500 rounded-md hover:translate-x-4 transition ease-in-out' : '' }}">
                    <a href="{{ route('profile') }}" wire:navigate
                        class="flex items-center p-2 text-white rounded-lg dark:text-white  dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M13.5 2c-.178 0-.356.013-.492.022l-.074.005a1 1 0 0 0-.934.998V11a1 1 0 0 0 1 1h7.975a1 1 0 0 0 .998-.934l.005-.074A7.04 7.04 0 0 0 22 10.5 8.5 8.5 0 0 0 13.5 2Z"/>
                            <path d="M11 6.025a1 1 0 0 0-1.065-.998 8.5 8.5 0 1 0 9.038 9.039A1 1 0 0 0 17.975 13H11V6.025Z"/>
                        </svg>
                                                                        
                        <span class="ms-3">Markets</span>
                    </a>
                </li> --}}
                <li class="p-1 hover:rounded-md hover:translate-x-4 transition ease-in-out {{ Request::is('trades') ? 'bg-blue-500 rounded-md hover:translate-x-4 transition ease-in-out' : '' }}">
                    <a href="{{ route('trades') }}" wire:navigate
                        class="flex items-center p-2 text-white rounded-lg dark:text-white  dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15v4m6-6v6m6-4v4m6-6v6M3 11l6-5 6 5 5.5-5.5"/>
                        </svg>                         
                                                                        
                        <span class="ms-3">Trades</span>
                    </a>
                </li>
                <li class="p-1 hover:rounded-md hover:translate-x-4 transition ease-in-out {{ Request::is('deposit') ? 'bg-blue-500 rounded-md hover:translate-x-4 transition ease-in-out' : '' }}">
                    <a href="{{ route('deposit') }}" wire:navigate
                        class="flex items-center p-2 text-white rounded-lg dark:text-white  dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z" clip-rule="evenodd"/>
                        </svg>                                                  
                                                                        
                        <span class="ms-3">Deposit</span>
                    </a>
                </li>
                {{-- <li class="p-1 hover:rounded-md hover:translate-x-4 transition ease-in-out {{ Request::is('') ? 'bg-blue-500 rounded-md hover:translate-x-4 transition ease-in-out' : '' }}">
                    <a href="{{ route('profile') }}" wire:navigate
                        class="flex items-center p-2 text-white rounded-lg dark:text-white  dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 7.205c4.418 0 8-1.165 8-2.602C20 3.165 16.418 2 12 2S4 3.165 4 4.603c0 1.437 3.582 2.602 8 2.602ZM12 22c4.963 0 8-1.686 8-2.603v-4.404c-.052.032-.112.06-.165.09a7.75 7.75 0 0 1-.745.387c-.193.088-.394.173-.6.253-.063.024-.124.05-.189.073a18.934 18.934 0 0 1-6.3.998c-2.135.027-4.26-.31-6.3-.998-.065-.024-.126-.05-.189-.073a10.143 10.143 0 0 1-.852-.373 7.75 7.75 0 0 1-.493-.267c-.053-.03-.113-.058-.165-.09v4.404C4 20.315 7.037 22 12 22Zm7.09-13.928a9.91 9.91 0 0 1-.6.253c-.063.025-.124.05-.189.074a18.935 18.935 0 0 1-6.3.998c-2.135.027-4.26-.31-6.3-.998-.065-.024-.126-.05-.189-.074a10.163 10.163 0 0 1-.852-.372 7.816 7.816 0 0 1-.493-.268c-.055-.03-.115-.058-.167-.09V12c0 .917 3.037 2.603 8 2.603s8-1.686 8-2.603V7.596c-.052.031-.112.059-.165.09a7.816 7.816 0 0 1-.745.386Z"/>
                        </svg>                                                                           
                                                                        
                        <span class="ms-3">Staking</span>
                    </a>
                </li> --}}
                <li class="p-1 hover:rounded-md hover:translate-x-4 transition ease-in-out {{ Request::is('withdraw') ? 'bg-blue-500 rounded-md hover:translate-x-4 transition ease-in-out' : '' }}">
                    <a href="{{ route('withdraw') }}" wire:navigate
                        class="flex items-center p-2 text-white rounded-lg dark:text-white  dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm5.757-1a1 1 0 1 0 0 2h8.486a1 1 0 1 0 0-2H7.757Z" clip-rule="evenodd"/>
                        </svg>                                                                                                  
                                                                        
                        <span class="ms-3">Withdrawal</span>
                    </a>
                </li>
                <li class="p-1 hover:rounded-md hover:translate-x-4 transition ease-in-out {{ Request::is('subscribe') ? 'bg-blue-500 rounded-md hover:translate-x-4 transition ease-in-out' : '' }}">
                    <a href="{{ route('subscribe') }}" wire:navigate
                        class="flex items-center p-2 text-white rounded-lg dark:text-white  dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M5.005 10.19a1 1 0 0 1 1 1v.233l5.998 3.464L18 11.423v-.232a1 1 0 1 1 2 0V12a1 1 0 0 1-.5.866l-6.997 4.042a1 1 0 0 1-1 0l-6.998-4.042a1 1 0 0 1-.5-.866v-.81a1 1 0 0 1 1-1ZM5 15.15a1 1 0 0 1 1 1v.232l5.997 3.464 5.998-3.464v-.232a1 1 0 1 1 2 0v.81a1 1 0 0 1-.5.865l-6.998 4.042a1 1 0 0 1-1 0L4.5 17.824a1 1 0 0 1-.5-.866v-.81a1 1 0 0 1 1-1Z" clip-rule="evenodd"/>
                            <path d="M12.503 2.134a1 1 0 0 0-1 0L4.501 6.17A1 1 0 0 0 4.5 7.902l7.002 4.047a1 1 0 0 0 1 0l6.998-4.04a1 1 0 0 0 0-1.732l-6.997-4.042Z"/>
                        </svg>                                                                                                                          
                                                                
                        <span class="ms-3">Subscription</span>
                    </a>
                </li>
                {{-- <li class="p-1 hover:rounded-md hover:translate-x-4 transition ease-in-out {{ Request::is('copy') ? 'bg-blue-500 rounded-md hover:translate-x-4 transition ease-in-out' : '' }}">
                    <a href="{{ route('copy') }}" wire:navigate
                        class="flex items-center p-2 text-white rounded-lg dark:text-white  dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M18 3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1V9a4 4 0 0 0-4-4h-3a1.99 1.99 0 0 0-1 .267V5a2 2 0 0 1 2-2h7Z" clip-rule="evenodd"/>
                            <path fill-rule="evenodd" d="M8 7.054V11H4.2a2 2 0 0 1 .281-.432l2.46-2.87A2 2 0 0 1 8 7.054ZM10 7v4a2 2 0 0 1-2 2H4v6a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3Z" clip-rule="evenodd"/>
                        </svg>                                                                                                                                                   
                                                                
                        <span class="ms-3">Copy Experts</span>
                    </a>
                </li> --}}
                <li class="p-1 hover:rounded-md hover:translate-x-4 transition ease-in-out {{ Request::is('verify') ? 'bg-blue-500 rounded-md hover:translate-x-4 transition ease-in-out' : '' }}">
                    <a href="{{ route('verify') }}" wire:navigate
                        class="flex items-center p-2 text-white rounded-lg dark:text-white  dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z" clip-rule="evenodd"/>
                        </svg>                                                                                                                                                                             
                                                                
                        <span class="ms-3">Verify Account</span>
                    </a>
                </li>
                <a href="{{ route('profile') }}" wire:navigate>
                    <div class="bg-[#1F273A] p-5 rounded-md flex space-x-4 my-6 items-center font-bold">
                        <div>
                            @if (Auth::user()->profile_pic)
                                <div class="relative w-10 h-10">
                                    <img 
                                        width="64" height="64"
                                        class="rounded-full object-cover w-10 h-10 border-4 border-blue-500 shadow-lg"
                                        src="{{ asset('storage/' . Auth::user()->profile_pic) }}"
                                        alt="Profile Photo"
                                    >
                                    <span class="absolute bottom-0 right-0 block w-4 h-4 bg-green-500 border-2 border-white rounded-full"></span>
                                </div>
                            @else
                                <div class="relative w-10 h-10">
                                    <img 
                                        width="64" height="64"
                                        class="rounded-full object-cover w-10 h-10 border-4 border-blue-500 shadow-lg"
                                        src="data:image/png;base64,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"
                                        alt="Profile Photo"
                                    >
                                    <span class="absolute bottom-0 right-0 block w-4 h-4 bg-green-500 border-2 border-white rounded-full"></span>
                                
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="text-white text-md">{{ auth()->user()->fname. ' '. auth()->user()->lname }}</p>
                            <p class="text-gray-500 text-sm">Account Type</p>
                        </div>
                    </div>
                </a>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="flex items-center p-3 text-white rounded-lg transition ease-in-out hover:bg-gray-700 hover:translate-x-2 group cursor-pointer">

                            <svg class="flex-shrink-0 w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/>
                            </svg>

                            <span class="ms-3">Logout</span>
                        </a>
                    </form>
                </li>
            </ul>
            
        </div>
        
    </aside>

    <div class="sm:ml-64">
        <div class="rounded-lg dark:border-gray-700 mt-14">
            {{ $slot }}
        </div>
    </div>
    <script>
        document.addEventListener("livewire:navigating", () => {
                // Mutate the HTML before the page is navigated away...
                initFlowbite();
        });
    
        document.addEventListener("livewire:navigated", () => {
            // Reinitialize Flowbite components
            initFlowbite();
        });
        </script>
    <script>
    function attachCopyListeners() {
        const copyPairs = [
            { btn: 'copyButton1', txt: 'textToCopy1' },
            { btn: 'copyButton2', txt: 'textToCopy2' },
            { btn: 'copyButton3', txt: 'textToCopy3' },
            { btn: 'copyButton4', txt: 'textToCopy4' },
        ];
        copyPairs.forEach(pair => {
            const btn = document.getElementById(pair.btn);
            const txt = document.getElementById(pair.txt);
            if (btn && txt && !btn.hasAttribute('data-copy-listener')) {
                btn.setAttribute('data-copy-listener', 'true');
                btn.addEventListener('click', () => {
                    txt.setSelectionRange(0, 99999);
                    navigator.clipboard.writeText(txt.value)
                        .then(() => {
                            alertify.set('notifier','position', 'top-right');
                            alertify.set('notifier','delay', 1);
                            alertify.success('Copied Successfully ');
                        })
                        .catch(err => {
                            console.error('Error copying text: ', err);
                        });
                });
            }
        });
    }
    document.addEventListener('DOMContentLoaded', attachCopyListeners);
    document.addEventListener('livewire:navigated', attachCopyListeners);

    function showCoinImage() {
    const coinSelect = document.getElementById('coinSelect');
    const coinImage = document.getElementById('coinImage');
    const selectedCoin = coinSelect.value;

    switch (selectedCoin) {
        case 'BTC':
            coinImage.src = 'data:image/jpeg;base64,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'; // Replace with actual image URL
            break;
        case 'ETH':
            coinImage.src = 'data:image/png;base64,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'; // Replace with actual image URL
            break;
        case 'DOGE':
            coinImage.src = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR2teRvse5HKyzu4d2iEuiwp7I7ABmj2H6jKQ&s'; // Replace with actual image URL
            break;
        case 'BCH':
            coinImage.src = 'data:image/jpeg;base64,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'
            break;
        default:
            coinImage.src = '';
            break;
    }

    coinImage.style.display = selectedCoin ? 'block' : 'none';
    }

   

   
    </script>
    
    @yield('scripts')

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>
</html>
