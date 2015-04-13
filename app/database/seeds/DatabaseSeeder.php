<?php

class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

        $this->call('SentrySeeder');
        $this->command->info("sentry数据填充完成");
        $this->call('MenuSeeder');
        $this->command->info("Menu数据填充完成");
        $this->call('OptionSeeder');
        $this->command->info("Option数据填充完成");
	}

}
