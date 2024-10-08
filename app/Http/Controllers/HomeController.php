<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Jobs\UmrahVoucherEmailJob;
use App\Mail\UmrahVouhcerEmail;
use App\Models\Accounts\Agent;
use App\Models\Accounts\SubHeadAccount;
use App\Models\Accounts\TransactionAccount;
use App\Models\Bike;
use App\Models\Crm\AgentUmrah;
use App\Models\Currency;
use App\Models\Files;
use App\Models\Item;
use App\Models\Rider;
use App\Models\Settings;
use App\Models\Sim;
use App\Models\Umrah\GroupDetail;
use App\Models\User;
use App\Models\Vendor;
use App\Notifications\GeneralNotification;
use App\Notifications\LeadNotification;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Carbon;
use Notification;
use Spatie\Permission\Models\Permission;
use Session;
use DB;
use Illuminate\Support\Facades\Mail;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //        $result=Permission::all();
//        $html='';
//        foreach ($result as $item){
//            $html.="Permission::create([
//            'form' => $item->form,
//            'menu' => $item->menu,
//            'parent_id' =>'".$item->parent_id."',
//            'name' => '".$item->name."',
//            'guard_name' => '".$item->guard_name."',
//            'created_at' => \Carbon\Carbon::now(),
//            'updated_at' => \Carbon\Carbon::now()
//            ]);";
//            $html.='<br>';
//        }
//        echo $html;
//        dd();
//        UmrahVoucherEmailJob::dispatch()->delay(now()->addSeconds(2));
//        Mail::to('azeemkhalidg3@gmail.com')->send(new UmrahVouhcerEmail());
        //if(Auth::user()->getRoleNames()[0]=='Admin') {
        $this->middleware('permission:dashboard_view', ['only' => ['index']]);
        $vendors = Vendor::all()->count();
        $riders = Rider::all()->count();
        $bikes = Bike::all()->count();
        $sims = Sim::all()->count();
        $items = Item::all()->count();
        return view('home', compact('vendors', 'riders', 'bikes', 'items', 'sims'));
        /* }else if(Auth::user()->getRoleNames()[0]=='Accountant'){
            return view('Accounts.index');
        } */
        /* else{
//            return redirect()->route('lead.index');
            return view('home');
        } */
    }
    //all main menu noticfication
    public function menu_notification()
    {
        //count umrah group unseen by master
        $countUmrahGroups = GroupDetail::where('seen', 0)->count();
        $countAgents = Agent::where('seen', 0)->count();
        $countUmrahTrips = DB::table('agent_umrahs')->where('seen', 0)->count();
        //wallet
        $countAgentWallet = DB::table('agent_wallets')->where('seen', 0)->count();
        $total_agents = $countAgents + $countUmrahTrips + $countAgentWallet;
        return compact(
            'countUmrahGroups',
            'countAgents',
            'total_agents',
            'countUmrahTrips',
            'countAgentWallet'
        );
    }
    public function seen_notification($tn)
    {
        return DB::table($tn)->where('seen', 0)->update(['seen' => 1]);
    }

    public function expiry_checker()
    {

        $expired = Files::whereDate('expiry_date', Carbon::parse('+10 days'))->get();
        $user = User::find(1);
        foreach ($expired as $item) {
            $notify =
                [
                    'name' => CommonHelper::file_types($item->type) . ' expired ',
                    'id' => $item->id,
                    'type' => 'document',
                    'url' => url('rider-document/' . $item->type_id)
                ];

            $user->notify(new GeneralNotification($notify));

        }
    }

    public function redirect_url()
    {
        if (request('id')) {
            $notification = auth()->user()->notifications()->where('id', request('id'))->first();
            if ($notification) {
                $notification->markAsRead();
                return redirect(request('url'));
            }
        }
    }

    public function settings(Request $request)
    {

        if ($request->post('settings')) {

            foreach ($request->post('settings') as $key => $value) {
                //echo $key.'-'.$value;
                Settings::updateOrCreate(['name' => $key], ['name' => $key, 'value' => $value]);
                session()->flash('success', 'Settings updated successfully.');

            }
        }
        $settings = Settings::pluck('value', 'name');
        return view('settings', compact('settings'));
    }

}
