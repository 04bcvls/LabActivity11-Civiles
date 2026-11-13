<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = User::pluck('id');
        $lola = User::where('email', 'lola.civiles@bulletin.test')->firstOrFail();

        Post::where('is_published', true)->get()->each(function (Post $post) use ($userIds, $lola) {
            if ($post->is_pinned) {
                Comment::factory()->create([
                    'post_id' => $post->id,
                    'user_id' => $lola->id,
                    'body'    => 'Happy birthday Kagawad! Salamat sa serbisyo diri sa Purok Civiles.',
                ]);

                $otherUserIds = $userIds->reject(fn ($id) => $id === $lola->id);

                Comment::factory()->count(2)->create([
                    'post_id' => $post->id,
                    'user_id' => fn () => $otherUserIds->random(),
                ]);
            } else {
                $count = rand(0, 5);
                if ($count > 0) {
                    Comment::factory()->count($count)->create([
                        'post_id' => $post->id,
                        'user_id' => fn () => $userIds->random(),
                    ]);
                }
            }
        });
    }
}