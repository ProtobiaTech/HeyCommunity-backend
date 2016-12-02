<?php

use Illuminate\Database\Seeder;

class TopicNodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tenants = \App\Tenant::lists('id')->toArray();
        $faker = Faker\Factory::create();

        foreach ($tenants as $tenantId) {
            $rootNodes = [];

            $Node = \App\TopicNode::create(['tenant_id' => $tenantId, 'name' => 'Node 1']);
            $rootNodes[] = $Node->makeRoot();

            $Node = \App\TopicNode::create(['tenant_id' => $tenantId, 'name' => 'Node 2']);
            $rootNodes[] = $Node->makeRoot();

            $Node = \App\TopicNode::create(['tenant_id' => $tenantId, 'name' => 'Node 3']);
            $rootNodes[] = $Node->makeRoot();

            foreach (range(1, 6) as $index) {
                $Node = \App\TopicNode::create([
                    'tenant_id'     =>      $tenantId,
                    'name'          =>      $faker->word(),
                ]);

                $Node->makeChildOf($rootNodes[array_rand($rootNodes)]);
            }
        }
    }
}
