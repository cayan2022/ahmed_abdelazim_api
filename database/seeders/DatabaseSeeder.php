<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Country;
use App\Models\Doctor;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Source;
use App\Models\Status;
use App\Models\SubStatus;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $counter = config('database.seeder_count');
        Country::factory()->count($counter)->create();
        $customerRole =  Role::firstOrCreate(['name'=>'customer','guard_name'=>'api']);
        $customerRole->givePermissionTo(Permission::whereType('Customers')->get());
        $users = User::factory()->count($counter)->create()->each(fn($user) => $user->assignRole($customerRole));
        About::factory()->count(3)->create();
        Setting::factory()->count(3)->create();
        $categories = Category::factory()->count($counter)->create();
        Service::factory()->count(4)->for($categories->first())->create();
        Offer::factory()->count($counter)->create();
        Doctor::factory()->count($counter)->create();
        $sources = Source::factory()->count($counter)->create();
        Branch::factory()->count($counter)->create();
        $statuses = Status::factory()->count($counter)->create();
        $subStatuses = SubStatus::factory()->count($counter)->for($statuses->first())->create();
        $orders = Order::factory([
                                     'category_id' => $categories->first()->id,
                                     'source_id' => $sources->first()->id,
                                     'status_id' => $statuses->first()->id
                                 ])->count($counter)->create();
        OrderHistory::factory([
                                  'order_id' => $orders->first()->id,
                                  'sub_status_id' => $subStatuses->first()->id,
                              ])->count($counter)->create();
        Testimonial::factory()->count($counter)->create();

        $this->call(RolesAndPermissionsSeeder::class);

        //create roles
        $adminRole =  Role::firstOrCreate(['name'=>'super-admin','guard_name'=>'api']);
        $adminRole->givePermissionTo(Permission::all());
        $admin = User::factory()->create(['email'=>'super-admin@gmail.com']);
        $admin->assignRole($adminRole);

    }
}
