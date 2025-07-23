<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-24 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-900 dark:border-gray-700" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-900">
       <ul class="space-y-4 font-medium">
          <li>
            <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ (request()->is('admin/dashboard')) ? 'text-white bg-gray-100 dark:bg-gray-700' : '' }}">
                <svg class="w-5 h-5 text-gray-800 dark:text-white {{ (request()->is('admin/dashboard*')) ? 'text-[#0891b2]' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8v10a1 1 0 0 0 1 1h4v-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v5h4a1 1 0 0 0 1-1V8M1 10l9-9 9 9"/>
                </svg>
                <span class="flex-1 ml-3 whitespace-nowrap  {{ (request()->is('admin/dashboard')) ? 'text-[#0891B2]' : '' }}">Dashboard</span>
             </a>
          </li>
           <li>
             <a href="{{ route('admin.user.index') }}" wire:navigate class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ (request()->is('admin/user*')) ? 'text-white bg-gray-100 dark:bg-gray-700' : '' }}">
                <svg class="w-5 h-5 text-gray-800 dark:text-white {{ (request()->is('admin/user*')) ? 'text-[#0891b2]' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3a3 3 0 1 1-1.614 5.53M15 12a4 4 0 0 1 4 4v1h-3.348M10 4.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0ZM5 11h3a4 4 0 0 1 4 4v2H1v-2a4 4 0 0 1 4-4Z"/>
                </svg>
                <span class="flex-1 ml-3 whitespace-nowrap {{ (request()->is('admin/user*')) ? 'text-[#0891B2]' : '' }}">Users</span>
             </a>
          </li>
          
          <li>
             <a href="{{ route('admin.deposit.index') }}" wire:navigate class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ (request()->is('admin/deposit*')) ? 'text-white bg-gray-100 dark:bg-gray-700' : '' }}">
                <svg class="w-5 h-5 text-gray-800 dark:text-white {{ (request()->is('admin/deposit*')) ? 'text-[#0891b2]' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 1h12M3 1v16M3 1H2m13 0v16m0-16h1m-1 16H3m12 0h2M3 17H1M6 4h1v1H6V4Zm5 0h1v1h-1V4ZM6 8h1v1H6V8Zm5 0h1v1h-1V8Zm-3 4h2a1 1 0 0 1 1 1v4H7v-4a1 1 0 0 1 1-1Z"/>
                  </svg>
                <span class="flex-1 ml-3 whitespace-nowrap {{ (request()->is('admin/deposit*')) ? 'text-[#0891B2]' : '' }}">Deposits</span>
             </a>
         </li>
          <li>
             <a href="{{ route('admin.subscription') }}" wire:navigate class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ (request()->is('admin/subscription*')) ? 'text-white bg-gray-100 dark:bg-gray-700' : '' }}">
                  <svg class="w-5 h-5 text-gray-800 dark:text-white {{ (request()->is('admin/subscription*')) ? 'text-[#0891b2]' : '' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                  </svg>

                <span class="flex-1 ml-3 whitespace-nowrap {{ (request()->is('admin/subscription*')) ? 'text-[#0891B2]' : '' }}">Subscriptions</span>
             </a>
         </li>
          <li>
             <a href="{{ route('admin.withdraw') }}" wire:navigate class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ (request()->is('admin/withdraw')) ? 'text-white bg-gray-100 dark:bg-gray-700' : '' }}">
                <svg class="w-5 h-5 text-gray-800 dark:text-white {{ (request()->is('admin/withdraw')) ? 'text-[#0891b2]' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M1 10c1.5 1.5 5.25 3 9 3s7.5-1.5 9-3m-9-1h.01M2 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1ZM14 5V3a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v2h8Z"/>
                  </svg>
                <span class="flex-1 ml-3 whitespace-nowrap {{ (request()->is('admin/withdraw*')) ? 'text-[#0891B2]' : '' }}">Withdrawal</span>
             </a>
          </li>

          <li>
             <a href="{{ route('logout') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                <svg class="w-5 h-5 text-gray-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h11m0 0-4-4m4 4-4 4m-5 3H3a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h3"/>
                </svg>
                <span class="flex-1 ml-3 whitespace-nowrap text-gray-500">Sign out</span>
             </a>
          </li>
       </ul>
    </div>
 </aside>
