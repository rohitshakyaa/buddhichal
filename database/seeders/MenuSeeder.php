<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menuItems = [
            [
                'title' => "Dashboard",
                'icon' => "fa-solid fa-gauge-high",
                'link' => "/admin/dashboard",
            ],
            [
                'title' => "Tournaments",
                'icon' => "fa-solid fa-chess-knight",
                'link' => "/admin/tournaments",
            ],
            [
                'title' => "NCA Members",
                'icon' => "fa-solid fa-people-group",
                'link' => "/admin/ncas",
            ],
        ];
        foreach ($menuItems as $item) {
            Menu::create($item);
        }
    }
}
