<?php

use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\Verification;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    
    public function with(): array
    {
        $user_id = Auth::id();

        $credit = Deposit::where('user_id', $user_id)->where('status', 1)->pluck('amount')->sum();

        $trades = Transaction::where('user_id', Auth::id())->get();

        $total_trade = Transaction::where('user_id', Auth::id())->pluck('amount')->sum();

        $total_profit = $total_trade;

        return [
            'total_balance' => $total_trade,
            'trades' => $trades,
            'total_profit' => $total_profit,
            'verified' => $verified = Verification::where('user_id', Auth::id())->where('status', 1)->first(),
        ];
    }
}; ?>

<div>
    <div class="text-white">
    <div class="md:grid md:grid-cols-3 p-0 md:gap-6 md:p-6">
        {{-- total balance --}}
        <div class="col-span-2">
            <div class="flex justify-between bg-[#131824] rounded-lg px-4 pt-4 pb-16">
                <div>
                    <div class="flex items-center space-x-2">
                        <div class="flex items-center bg-[#19202F] border border-[#19202F] rounded-full h-14 w-14">
                            <svg class="w-8 h-8 m-3 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M7 6a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2h-2v-4a3 3 0 0 0-3-3H7V6Z" clip-rule="evenodd"/>
                                <path fill-rule="evenodd" d="M2 11a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-7Zm7.5 1a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5Z" clip-rule="evenodd"/>
                                <path d="M10.5 14.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"/>
                            </svg>                    
                        </div>
                        <div>
                            <p class="text-sm font-light 4">Total Balance</p>
                            <p class="text-xl font-bold">${{ number_format($total_balance, 2) }}</p>
                        </div>
                    </div>
                </div>
                <div>
                    <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Live</span>
                </div>
            </div>
            {{-- trading progress --}}
            <div class="mt-5 bg-[#131824] rounded-lg px-4 pt-4 pb-16">
                <div class="flex items-center space-x-2">
                    <div class="flex items-center bg-[#19202F] border border-[#19202F] rounded-full h-14 w-14">
                        <svg class="w-8 h-8 m-3 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M7 6a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2h-2v-4a3 3 0 0 0-3-3H7V6Z" clip-rule="evenodd"/>
                            <path fill-rule="evenodd" d="M2 11a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-7Zm7.5 1a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5Z" clip-rule="evenodd"/>
                            <path d="M10.5 14.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"/>
                        </svg>                    
                    </div>
                    <div>
                        <p class="text-sm font-light 4">Trading Progress</p>
                        <p class="text-xl font-bold">0%</p>
                    </div>

                </div>
                <div class="w-full mt-4 bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                    <div class="bg-white h-2.5 rounded-full" style="width: 45%"></div>
                </div>
            </div>
            {{-- deposit withdraw --}}
          
            {{-- tradind view --}}
            <div class="h-96 mt-5">
                <!-- TradingView Widget BEGIN -->
                <div class="tradingview-widget-container" style="height:100%;width:100%">
                    <div class="tradingview-widget-container__widget" style="height:calc(100% - 32px);width:100%"></div>
                    <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/" rel="noopener nofollow" target="_blank"></a></div>
                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                    {
                        "autosize": true,
                        "symbol": "NASDAQ:AAPL",
                        "interval": "D",
                        "timezone": "Etc/UTC",
                        "theme": "dark",
                        "style": "1",
                        "locale": "en",
                        "allow_symbol_change": true,
                        "calendar": false,
                        "support_host": "https://www.tradingview.com"
                    }
                    </script>
                </div>
                <!-- TradingView Widget END -->
            </div>
            {{-- trades --}}
            <div class="">
                <div class="bg-[#131824] h-72 rounded-lg text-gray-400">
                    <p class="bg-[#19202F] font-bold  p-3 rounded-t-lg">Trades</p>
                    @forelse ($trades as $trade)
                        <div class="flex space-x-4 py-2 px-4 justify-center">
                            <div class="text-[17px] font-medium text-white">
                                <span class="text-white">${{ number_format($trade->amount) }}</span> has been
                                @if ($trade->transaction_type == 'Credit')
                                    <span class="text-green-700">Credited</span>
                                @elseif($trade->transaction_type == 'Bonus')
                                    <span class="text-blue-700">Bonused</span>
                                @else
                                    <span class="text-red-700">Debited</span>
                                @endif
                                to your Account
                                @ {{ $trade->created_at }}
                            </div>
                        </div>
                    @empty
                        <div class="flex space-x-4 py-2 px-4 justify-center">
                            <p class="text-white font-bold mb-96">You havent placed any trades yet</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{----------- trade  -------}}

        <div class="pt-5 md:pt-0">
            <div class="bg-[#131824] rounded-lg">
                <p class="bg-[#19202F] p-4 font-lg rounded-t-lg">Trade</p>
                <form action="" class="p-4">
                    <div class="">
                        {{-- <p class="">BUY SELL</p> --}}
                    </div>
                    <div class="mt-2">
                        <label for="type" class="mb-2 text-gray-400 inline-block font-bold">Type</label>
                        <select name="type" class="block w-full rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800" id="">
                            <option value="Stocks">Stocks</option>
                            <option value="Crypto">Crypto</option>
                            <option value="Forex">Forex</option>
                        </select>
                    </div>
                    <div class="mt-2">
                        <label for="type" class="mb-2 text-gray-400 inline-block font-bold">Asset</label>
                        <select name="type" class="block w-full rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800" id="">
                            <option value="Apple">Apple</option>
                            <option value="Abbot Labs">Abbot Labs</option>
                            <option value="Adobe">Adobe</option>
                            <option value="Analog Devices">Analog Devices</option>
                            <option value="Aethlon Medical">Aethlon Medical</option>
                            <option value="American International Group">American International Group</option>
                            <option value="AMC Holdings">AMC Holdings</option>
                            <option value="AMD">AMD</option>
                            <option value="American Tower">American Tower</option>
                            <option value="Amazon">Amazon</option>
                            <option value="Alpha Pro Tech">Alpha Pro Tech</option>
                            <option value="ASML">ASML</option>
                            <option value="Aterian Inc">Aterian Inc</option>
                            <option value="American Express">American Express</option>
                            <option value="Boeing">Boeing</option>
                            <option value="Alibaba">Alibaba</option>
                            <option value="Bank of America">Bank of America</option>
                            <option value="Baidu Inc">Baidu Inc</option>
                            <option value="Bristol Myers">Bristol Myers</option>
                            <option value="Citigroup">Citigroup</option>
                            <option value="Caterpillar">Caterpillar</option>
                            <option value="Clear Channel Outdoor">Clear Channel Outdoor</option>
                            <option value="Camber Energy">Camber Energy</option>
                            <option value="Chewy Inc">Chewy Inc</option>
                            <option value="Colgate-Palmolive">Colgate-Palmolive</option>
                            <option value="Comcast">Comcast</option>
                            <option value="Costco">Costco</option>
                            <option value="Cardiff Oncology Inc">Cardiff Oncology Inc</option>
                            <option value="Salesforce Inc">Salesforce Inc</option>
                            <option value="Cisco">Cisco</option>
                            <option value="Chevron">Chevron</option>
                            <option value="Disney">Disney</option>
                            <option value="Ebay">Ebay</option>
                            <option value="Meta Platforms Inc">Meta Platforms Inc</option>
                            <option value="Fastly Inc" >Fastly Inc</option>
                            <option value="General Electric">General Electric</option>
                            <option value="Gevo Inc">Gevo Inc</option>
                            <option value="General Motors">General Motors</option>
                            <option value="Google">Google</option>
                            <option value="Goldman">Goldman Sachs</option>
                            <option value="Home Sachs">Home Depot</option>
                            <option value="Honeywell">Honeywell</option>
                            <option value="IBM">IBM</option>
                            <option value="Inmode">Inmode</option>
                            <option value="Intel">Intel</option>
                            <option value="Johnson &amp; Johnson">Johnson &amp; Johnson</option>
                            <option value="JP Morgain">JP Morgain</option>
                            <option value="Coca Cola">Coca Cola</option>
                            <option value="Lennar Corporation">Lennar Corporation</option>
                            <option value="Las Sands">Las vegas Sands</option>
                            <option value="MasterCard">MasterCard</option>
                            <option value="Mondelez">Mondelez</option>
                            <option value="3M Company">3M Company</option>
                            <option value="Monster">Monster</option>
                            <option value="Attria Group">Attria Group</option>
                            <option value="Marin Software">Marin Software</option>
                            <option value="Merck">Merck</option>
                            <option value="Morgan Stanley">Morgan Stanley</option>
                            <option value="Microsoft">Microsoft</option>
                            <option value="Motorola">Motorola</option>
                            <option value="Netflix">Netflix</option>
                            <option value="Nike">Nike</option>
                            <option value="Nvidia">Nvidia</option>
                            <option value="Novartis">Novartis</option>
                            <option value="Oracle">Oracle</option>
                            <option value="Pepsico">Pepsico</option>
                            <option value="Pfizer">Pfizer</option>
                            <option value="Procter &amp; Gamble">Procter &amp; Gamble</option>
                            <option value="PayPal">PayPal</option>
                            <option value="Ferrari">Ferrari</option>
                            <option value="Rocket Lab">Rocket Lab</option>
                            <option value="Ralph lauren">Ralph lauren</option>
                            <option value="Rewalk Robotics">Rewalk Robotics</option>
                            <option value="Starbucks">Starbucks</option>
                            <option value="SSR Mining">SSR Mining</option>
                            <option value="Square">Square</option>
                            <option value="At&amp;t">At&amp;t</option>
                            <option value="Teva">Teva</option>
                            <option value="Toyota Motor">Toyota Motor</option>
                            <option value="T-Mobile">T-Mobile</option>
                            <option value="TripAdvisor">TripAdvisor</option>
                            <option value="Tesla">Tesla</option>
                            <option value="TSMC">TSMC</option>
                            <option value="Twitter">Twitter</option>
                            <option value="United Health Group">United Health Group</option>
                            <option value="Visa">Visa</option>
                            <option value="Verizon">Verizon</option>
                            <option value="Wells Fargo">Wells Fargo</option>
                            <option value="Walmart">Walmart</option>
                            <option value="Exxon Mobil">Exxon Mobil</option>
                        </select>
                    </div>
                    <div class="mt-2">
                        <label for="type" class="mb-2 text-gray-400 inline-block font-bold">Amount</label>
                        <input type="text" class="block w-full rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800" placeholder="1000">
                    </div>
                    <div class="mt-2">
                        <label for="type" class="mb-2 text-gray-400 inline-block font-bold">Duration(minutes)</label>
                        <select name="type" class="block w-full rounded-lg p-3 bg-[#1F273A] text-white border-gray-800 focus:ring-gray-800 focus:border-gray-800" id="">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="30">30</option>
                        </select>
                    </div>
                    <p class="mt-3 border rounded-lg p-2 text-sm border-gray-800">Your trade will auto close in 5 minutes.</p>
                    <button class="bg-[#808080] w-full text-center font-bold text-lg p-2 rounded-lg mt-3">Place Buy Order</button>
                </form>
            </div>
            {{-- Account Summary --}}
            <div>
                <div class="mt-5 bg-[#131824] pb-2 rounded-lg">
                    <p class="bg-[#19202F] p-4 font-lg rounded-t-lg">Account Summary</p>
                    <div class="flex space-x-4 bg-[#161C2A] shadow p-4 rounded-lg m-2">
                        <p class="bg-[#19202F] w-12 h-12 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17.345a4.76 4.76 0 0 0 2.558 1.618c2.274.589 4.512-.446 4.999-2.31.487-1.866-1.273-3.9-3.546-4.49-2.273-.59-4.034-2.623-3.547-4.488.486-1.865 2.724-2.899 4.998-2.31.982.236 1.87.793 2.538 1.592m-3.879 12.171V21m0-18v2.2"/>
                            </svg>      
                        </p>
                        <div>
                            <p class="text-sm text-gray-400">Total Profits</p>
                            <p>{{number_format($total_profit, 2)}}</p>
                        </div>
                    </div>
                    <div class="flex bg-[#161C2A] shadow rounded-lg m-2 items-center justify-between">
                        <div class="flex space-x-4  p-4 ">
                            <p class="bg-[#19202F] w-12 h-12 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z" clip-rule="evenodd"/>
                                </svg>                                       
                            </p>
                            <div>
                                <p class="text-sm text-gray-400">Total Deposits</p>
                                <p>${{ number_format($total_balance, 2) }}</p>
                            </div>
                        </div>
                        <div class="">
                            <a href="{{ route('deposit') }}" wire:navigate class="mx-4 bg-[#152A40] text-blue-500 font-bold px-4 py-2 rounded-lg">Deposit</a>
                        </div>
                    </div>
                    <div class="flex bg-[#161C2A] shadow rounded-lg m-2 items-center justify-between">
                        <div class="flex space-x-4  p-4 ">
                            <p class="bg-[#19202F] w-12 h-12 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm5.757-1a1 1 0 1 0 0 2h8.486a1 1 0 1 0 0-2H7.757Z" clip-rule="evenodd"/>
                                </svg>                                                                         
                            </p>
                            <div>
                                <p class="text-sm text-gray-400">Total Withdrawals</p>
                                <p>$0.00</p>
                            </div>
                        </div>
                        <div class="">
                            <a href="{{ route('withdraw') }}" wire:navigate class="mx-4 bg-[#152A40] text-blue-500 font-bold px-4 py-2 rounded-lg">New</a>
                        </div>
                    </div>
                    <div class="flex bg-[#161C2A] shadow rounded-lg m-2 items-center justify-between">
                        <div class="flex space-x-4  p-4 ">
                            <p class="bg-[#19202F] w-12 h-12 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z" clip-rule="evenodd"/>
                                </svg>                                                                                                        
                            </p>
                            <div>
                                <p class="text-sm text-gray-400">Verification</p>
                                @if ($verified)
                                    Verified
                                @else
                                    <p>Your account is not verified.</p>
                                @endif
                            </div>
                        </div>
                        <div class="">
                            <a href="{{ route('verify') }}" wire:navigate class="mx-4 bg-[#152A40] text-blue-500 font-bold px-4 py-2 rounded-lg">
                                {{ $verified ? 'Verified': 'verify' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- footer --}}
    <footer class="mx-2 mt-10">
        <div class="bg-[#131824] text-gray-300 p-7 rounded-lg">
            <p>{{ config('app.name') }} Ltd 2018</p>
        </div>
    </footer>

</div>

</div>
