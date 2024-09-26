<?php
$user=['users', 'create', 'roles', 'permission'];
$appication_setup=['categories', 'currencies', 'product_types', 'products', 'regions',
    'currency_api','currency_history','sources','clients', 'continents', 'countries',
    'division','district', 'cities', 'province', 'areas','mosques'];
$accounts=['root_accounts', 'dashboard', 'head_accounts', 'subhead_accounts',
    'trans_accounts', 'payment_vouchers', 'receipt_vouchers','journal_vouchers','ledger','index',
    'financial_year','agent_wallet','service_providors','rider_pv'];
$account_reports=['ledger_report','trail_balance','account_day_book','balance_sheet',
    'income_statement'];
$hr=['designation', 'department', 'employee'];
$bus_setup=['company_setup', 'branches'];
$sale=['Sale'];
$vendor=['vendors'];
$rider=['rider','assign_rider','assign_price','rider-document'];
$item=['item','item_assign_rv','assign_price_edit'];
$invoices=['vendor_invoices','rider_invoices'];
$bikes=['bike','rta_fine','lease_company','bike_rent'];
$sims=['sim','sim_charges'];
$reports=['vendor_invoice_report','rider_invoice_report','rider_list','rider_report'];
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 bg-navy">
    <!-- Brand Logo -->
    <a href="{{ url('home') }}" class="brand-link elevation-4 navbar-purple" style="padding: 12px !important;">
                <img src="{{ URL::asset('public/dist/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image">
{{--        <span class="brand-text font-weight-light">Express-Fast</span>--}}
    </a>
    <!-- Sidebar -->
    <div class="sidebar bg-navy">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ URL::asset('public/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-flat nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview">
                    <a href="{{ route('home') }}" class="nav-link {{ (request()->is('home')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p> Dashboard </p>
                    </a>
                </li>

                {{-- <li class="nav-item has-treeview <?php //if(in_array(Request::segment(1), $item)) echo 'menu-open';?>">
                    <a href="#" class="nav-link">
                        <i class='nav-icon fas fa-users-cog fa-xs'></i>
                        <p>
                            Items
                            <i class="nav-icon fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview"> --}}
                        @can('items_view')
                        <li class="nav-item">
                            <a href="{{ route('item.index') }}" class="nav-link {{ (request()->is('item')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users-cog fa-xs"></i>
                                <p>Items</p>
                            </a>
                        </li>
                        @endcan
                        <li class="nav-item">
                            <a href="#" class="nav-link ">
                                <i class="nav-icon fas fa-star fa-xs"></i>
                                <p>Banks</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link ">
                                <i class="nav-icon fas fa-star fa-xs"></i>
                                <p>Inventory</p>
                            </a>
                        </li>

                        @can('projects_view')
                        <li class="nav-item">
                            <a href="{{ route('projects.index') }}" class="nav-link {{ (request()->is('projects')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-star fa-xs"></i>
                                <p>Customers/Projects</p>
                            </a>
                        </li>
                        @endcan
                  {{--
                    </ul>
                </li> --}}
                {{-- <li class="nav-item has-treeview @php if(in_array(Request::segment(1), $vendor)) echo 'menu-open';
                else if(in_array(Request::segment(2), $vendor)) echo 'menu-open'; @endphp">
                    <a href="#" class="nav-link">
                        <i class='nav-icon fas fa-users-cog fa-xs'></i>
                        <p>
                            Vendors
                            <i class="nav-icon fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview"> --}}
                        @can('vendors_view')
                        <li class="nav-item">
                            <a href="{{ route('vendors.index') }}" class="nav-link {{ (request()->is('vendors')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users-cog fa-xs"></i>
                                <p>Vendors</p>
                            </a>
                        </li>
                        @endcan


                    {{-- </ul>
                </li> --}}
                  <li class="nav-item has-treeview <?php //if(in_array(Request::segment(2), $invoices)) echo 'menu-open';?>">
                    <a href="#" class="nav-link">
                        <i class='nav-icon fas fa-users-cog fa-xs'></i>
                        <p>
                            Invoices
                            <i class="nav-icon fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('invoices_view')
                        <li class="nav-item">
                            <a href="{{ route('rider_invoices.index') }}" class="nav-link {{ (request()->is('invoices/rider_invoices')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file fa-xs"></i>
                                <p>Rider Invoices</p>
                            </a>
                        </li>
                        @endcan
                        @can('invoices_view')
                        <li class="nav-item">
                            <a href="{{ route('project_invoices.index') }}" class="nav-link {{ (request()->is('invoices/project_invoices')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file fa-xs"></i>
                                <p>Customer/Project Invoices</p>
                            </a>
                        </li>
                        @endcan
                        @can('invoices_view')
                        <li class="nav-item">
                            <a href="javascript:void(0);" class="nav-link show-modal" data-action="{{route('tax_invoice')}}" data-size="lg" data-title="Generate Tax Invoice">
                                <i class="nav-icon fas fa-file fa-xs"></i>
                                <p>Tax Invoice</p>
                            </a>
                        </li>
                        @endcan

                    </ul>
                </li>
                @can('riders_view')
                 <li class="nav-item">
                            <a href="{{ route('rider.index') }}" class="nav-link {{ (request()->is('rider')) ? 'active' : '' }} {{ (request()->is('rider-document')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-secret fa-xs"></i>
                                <p>Rider List</p>
                            </a>
                        </li>
                        @endcan
                {{-- <li class="nav-item has-treeview <?php //if(in_array(Request::segment(1), $rider)) echo 'menu-open';?>">
                    <a href="#" class="nav-link ">
                        <i class='nav-icon fas fa-user-secret fa-xs'></i>
                        <p>
                            Riders
                            <i class="nav-icon fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('rider.index') }}" class="nav-link {{ (request()->is('rider')) ? 'active' : '' }} {{ (request()->is('rider-document')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Rider List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('vendor.assign_rider') }}" class="nav-link {{ (request()->is('assign_rider')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Assign Vendor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('item.assign_price') }}" class="nav-link {{ (request()->is('assign_price')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Assign Price</p>
                            </a>
                        </li>

                    </ul>
                </li> --}}
                @can("bikes_view")
                <li class="nav-item has-treeview <?php if(in_array(Request::segment(1), $bikes)) echo 'menu-open'; ?>">
                    <a href="#" class="nav-link">
                        <i class='nav-icon fas fa-motorcycle fa-xs'></i>
                        <p>
                            Bikes
                            <i class="nav-icon fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can("bikes_view")
                        <li class="nav-item">
                            <a href="{{ route('bike.index') }}" class="nav-link {{ (request()->is('bike')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Bike List</p>
                            </a>
                        </li>
                        @endcan
                        @can('rtafinevoucher_view')
                       {{--  <li class="nav-item">
                            <a href="{{ route('rta_fine.index') }}" class="nav-link {{ (request()->is('rta_fine')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>RTA Fine Voucher</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('bike_rent.index') }}" class="nav-link {{ (request()->is('bike_rent')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Bike Rent Voucher</p>
                            </a>
                        </li> --}}

                        @endcan
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('lease_company.index') }}" class="nav-link {{ (request()->is('lease_company')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                        <p>Lease Company</p>
                    </a>
                </li>
                @endcan
                <li class="nav-item">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-star fa-xs"></i>
                        <p>Garage</p>
                    </a>
                </li>
                @can('sims_view')
                <li class="nav-item has-treeview <?php if(in_array(Request::segment(1), $sims)) echo 'menu-open';?>">
                    <a href="#" class="nav-link">
                        <i class='nav-icon fas fa-motorcycle fa-xs'></i>
                        <p>
                            Sims
                            <i class="nav-icon fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('sim.index') }}" class="nav-link {{ (request()->is('sim')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Sim List</p>
                            </a>
                        </li>

                       {{--  <li class="nav-item">
                            <a href="{{ route('sim_charges.index') }}" class="nav-link {{ (request()->is('sim_charges')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Sim Charges</p>
                            </a>
                        </li> --}}
                    </ul>
                </li>
                @endcan
                @can('jv_view')
                <li class="nav-item">
                    <a href="{{ route('vouchers.index') }}" class="nav-link {{ (request()->is('vouchers'))? 'active':'' }}">
                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                        <p>Vouchers</p>
                    </a>
                </li>
            @endcan
                @can('reports_view')
                <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $reports)) echo 'menu-open';?>">
                    <a href="#" class="nav-link">
                        <i class='nav-icon fas fa-chart-bar fa-xs'></i>
                        <p>
                            Reports
                            <i class="nav-icon fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('reports/rider_invoice_report') }}" class="nav-link {{ (request()->is('reports/rider_invoice_report')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Rider Invoice Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('reports/vendor_invoice_report') }}" class="nav-link {{ (request()->is('reports/vendor_invoice_report')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Vendor Invoice Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('reports/rider_list') }}" class="nav-link {{ (request()->is('reports/rider_list')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Rider List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('reports/rider_report') }}" class="nav-link {{ (request()->is('reports/rider_report')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Rider Report</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $accounts)) echo 'menu-open';
                elseif(in_array(Request::segment(3), $accounts)) echo 'menu-open'; elseif(in_array(Request::segment(1), $sale)) echo 'menu-open';
                elseif(in_array(Request::segment(3), $account_reports)) echo 'menu-open'; ?>">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-key fa-xs"></i>
                        <p>{{ __('accounts.account') }}
                            <i class="nav-icon fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('accounts_view')
                        @can('account_dashboard_view')
                        <li class="nav-item">
                            <a href="{{ route('dashboard.index') }}" class="nav-link {{ (request()->is('Accounts/dashboard')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Accounts Dashboard</p>
                            </a>
                        </li>
                        @endcan
                        @can('accounts_view')
                        <li class="nav-item has-treeview <?php if(in_array(Request::segment(2), $accounts)) echo 'menu-open'; ?>">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cog fa-xs"></i>
                                <p>
                                    Master Account
                                    <i class="nav-icon fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('financial_year.index') }}" class="nav-link {{ (request()->is('Accounts/financial_year')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Financial Years</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('root_accounts.index') }}" class="nav-link {{ (request()->is('Accounts/root_accounts')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Root Accounts</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('head_accounts.index') }}" class="nav-link {{ (request()->is('Accounts/head_accounts')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Head Accounts</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('subhead_accounts.index') }}" class="nav-link {{ (request()->is('Accounts/subhead_accounts')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Subhead Accounts</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('trans_accounts.index') }}" class="nav-link {{ (request()->is('Accounts/trans_accounts')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Transaction Accounts</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endcan
                        @endcan

                        <li class="nav-item has-treeview <?php if(in_array(Request::segment(3), $accounts)) echo 'menu-open'; ?>">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-dollar-sign"></i>
                                <p>
                                    Vouchers
                                    <i class="nav-icon fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('rv_view')
                                    <li class="nav-item">
                                        <a href="{{ route('receipt_vouchers.index') }}" class="nav-link {{ (request()->is('Accounts/vouchers/receipt_vouchers')) ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Receipt Voucher</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('pv_view')
                                    <li class="nav-item">
                                        <a href="{{ route('payment_vouchers.index') }}" class="nav-link {{ (request()->is('Accounts/vouchers/payment_vouchers')) ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Payment Voucher</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('rider_pv.index') }}" class="nav-link {{ (request()->is('Accounts/vouchers/rider_pv')) ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Invoice Payment Voucher</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('jv_view')
                                    <li class="nav-item">
                                        <a href="{{ route('journal_vouchers.index') }}" class="nav-link {{ (request()->is('Accounts/vouchers/journal_vouchers'))? 'active':'' }}">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Journal Voucher</p>
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </li>

                         @can('general_ledger_view')
                         <li class="nav-item">
                            <a href="{{ url('Accounts/index') }}" class="nav-link {{ (request()->is('Accounts/index')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Ledger</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('Accounts/ledger') }}" class="nav-link {{ (request()->is('Accounts/ledger')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>General Ledger</p>
                            </a>
                        </li>
                        @endcan
                        @can('reports_view')
                        <li class="nav-item <?php if(in_array(Request::segment(3), $account_reports)) echo 'menu-open'; ?>">
                            <a href="{{ route('users.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                <p>Account Reports
                                    <i class="nav-icon right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('Accounts/reports/ledger_report') }}" class="nav-link {{ (request()->is('Accounts/reports/ledger_report')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Ledger Reports</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('trail_balance.index') }}" class="nav-link {{ (request()->is('Accounts/reports/trail_balance')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Traial Balance</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('account_day_book.index') }}" class="nav-link {{ (request()->is('Accounts/reports/account_day_book')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Accounts Day Book</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('income_statement.index') }}" class="nav-link {{ (request()->is('Accounts/reports/income_statement')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Income Statement</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('balance_sheet.index') }}" class="nav-link {{ (request()->is('Accounts/reports/balance_sheet')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Balance Sheet</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endcan
                    </ul>
                </li>

                <li class="nav-item has-treeview <?php if(in_array(Request::segment(1), $appication_setup)){ echo 'menu-open'; } elseif(in_array(Request::segment(3), $appication_setup)) echo 'menu-open'; elseif(in_array(Request::segment(2), $appication_setup)) echo 'menu-open';
                elseif(in_array(Request::segment(3), $user)){ echo 'menu-open'; } elseif(in_array(Request::segment(2), $hr)){ echo 'menu-open'; }
                elseif(in_array(Request::segment(1), $bus_setup)){ echo 'menu-open'; } ?>">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs fa-xs"></i>
                        <p>
                            Application Setting
                            <i class="nav-icon fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('user_list_view')
                        <li class="nav-item has-treeview <?php if(in_array(Request::segment(3), $user)) echo 'menu-open'; ?>">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    {{ __('user_management.user_management') }}
                                    <i class="nav-icon fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link {{ (request()->is('Application_Setup/user_management/users')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>User List</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('users.create') }}" class="nav-link {{ (request()->is('Application_Setup/user_management/users/create')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Create New User</p>
                                    </a>
                                </li>
                                @can('role_view')
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}" class="nav-link {{ (request()->is('Application_Setup/user_management/roles')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>

                                {{-- <li class="nav-item">
                                    <a href="{{ route('permission.index') }}" class="nav-link {{ (request()->is('Application_Setup/user_management/permission')) ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                        <p>Permissions</p>
                                    </a>
                                </li> --}}
                                @endcan
                            </ul>
                           {{--  <li class="nav-item">
                                <a href="{{ route('settings') }}" class="nav-link {{ (request()->is('settings')) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-cog fa-xs"></i>
                                    <p>Settings</p>
                                </a>
                            </li> --}}
                        </li>
                        @endcan
                        @can('business_setup_view')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                    <p>
                                        Projects
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="3" class="nav-link {{ (request()->is('company_setup/create')) ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-angle-double-right fa-xs"></i>
                                            <p>Company Setup</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan
                    </ul>
                </li>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
