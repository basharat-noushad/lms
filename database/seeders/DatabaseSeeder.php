<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            AdminSeeder::class,
            CategorySeeder::class,
            DemoDataSeeder::class,
        ]);

        $this->command->info('✅ All seeders completed successfully!');
        $this->command->info('📧 Admin: admin@learnhub.com / password');
        $this->command->info('📧 Instructors: john@learnhub.com, sarah@learnhub.com, michael@learnhub.com / password');
        $this->command->info('📧 Students: alice@example.com, bob@example.com, etc. / password');
    }
}
