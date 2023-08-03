<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Accounts\TransactionAccount;

class TransAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Discount Allowed', 'PID' => 20, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'WH Tax', 'PID' => 4, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Unappropriated Profit', 'PID' => 16, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
    }
}
