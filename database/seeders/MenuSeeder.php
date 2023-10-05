<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menuItems = [
            [
                'id' => 1,
                'title' => "Dashboard",
                'icon' => "fa-solid fa-gauge-high",
                'link' => "/admin/dashboard",
            ],
            [
                'id' => 2,
                'title' => "Tournaments",
                'icon' => "fa-solid fa-chess-knight",
                'link' => "/admin/tournaments",
            ],
            [
                'id' => 3,
                'title' => "Tournament Players",
                'icon' => "fa-solid fa-chess-knight",
                'link' => "/admin/tournaments/players",
            ],
            [
                'id' => 4,
                'title' => "NCA Members",
                'icon' => "fa-solid fa-people-group",
                'link' => "/admin/ncas",
            ],
            [
                'id' => 5,
                'title' => "Banners",
                'icon' => "fa-solid fa-people-group",
                'link' => "/admin/banners",
            ],
            [
                'id' => 6,
                'title' => "Champions",
                'icon' => "fa-solid fa-people-group",
                'link' => "/admin/champions",
            ],
            [
                'id' => 7,
                'title' => "Champions",
                'icon' => "fa-solid fa-people-group",
                'link' => "/admin/champions",
            ],
        ];
        foreach ($menuItems as $item) {
            if ($menu = Menu::find($item['id'])) {
                $menu->update($item);
            } else {
                Menu::create($item);
            }
        }
    }
}
