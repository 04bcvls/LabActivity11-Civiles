<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tagNames = [
            'Purok Civiles',
            'Urgent',
            'Libre',
            'Schedule',
            'Bayanihan',
        ];

        $tags = collect($tagNames)->mapWithKeys(function (string $name) {
            $tag = Tag::create(['name' => $name]);
            return [$name => $tag];
        });

        $allTagIds = $tags->pluck('id');

        Post::all()->each(function (Post $post) use ($tags, $allTagIds) {
            if ($post->is_pinned) {
                $post->tags()->sync([
                    $tags['Purok Civiles']->id,
                    $tags['Urgent']->id,
                ]);
            } else {
                $randomIds = $allTagIds->random(rand(1, 3))->all();
                $post->tags()->attach($randomIds);
            }
        });
    }
}