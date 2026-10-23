<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use App\Models\Weblog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Storage::disk('public')->deleteDirectory('weblogs');
        Storage::disk('public')->makeDirectory('weblogs');

        $testUser = User::factory()->create([
            'username' => 'test',
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $users = User::factory()->count(6)->create();

        $users->take(2)->each(function (User $user): void {
            $user->is_subscriber = true;
            $user->save();
        });

        $users->push($testUser);

        $categories = collect([
            'Technologie',
            'Reizen',
            'Eten en drinken',
            'Gezondheid',
            'Cultuur',
            'Nieuws',
        ])->map(fn(string $title): Category => Category::factory()->create([
            'title' => $title,
        ]));

        $weblogs = Weblog::factory()
            ->count(4)
            ->for($testUser)
            ->create()
            ->concat(
                Weblog::factory()->count(16)->create([
                    'user_id' => fn(): int => $users->random()->id,
                ])
            );

        $weblogs->each(function (Weblog $weblog, int $index) use ($categories): void {
            $weblog->categories()->attach(
                $categories->random(random_int(1, 3))->pluck('id')->all()
            );

            if ($index % 4 === 0) {
                $weblog->is_premium = true;
                $weblog->save();
            }

            if ($index % 3 === 0) {
                $this->createImage($weblog);
            }
        });

        $weblogs->each(function (Weblog $weblog) use ($users): void {
            Comment::factory()
                ->count(random_int(0, 3))
                ->create([
                    'weblog_id' => $weblog->id,
                    'user_id' => fn(): int => $users->random()->id,
                    'published_at' => now()->subDays(random_int(0, 30)),
                ]);
        });
    }

    /**
     * Create a placeholder image for the given article.
     */
    private function createImage(Weblog $weblog): void
    {
        if (! function_exists('imagecreatetruecolor')) {
            return;
        }

        $width = 800;
        $height = 450;
        $path = "weblogs/seed-{$weblog->id}.png";

        $image = imagecreatetruecolor($width, $height);
        $background = imagecolorallocate($image, random_int(40, 200), random_int(40, 200), random_int(40, 200));
        imagefilledrectangle($image, 0, 0, $width, $height, $background);

        $textColor = imagecolorallocate($image, 255, 255, 255);
        $label = Str::ascii(Str::limit($weblog->title, 50));
        imagestring($image, 5, 30, 30, $label, $textColor);

        imagepng($image, Storage::disk('public')->path($path));
        imagedestroy($image);

        $weblog->images()->create([
            'url' => $path,
            'alt_text' => $weblog->title,
            'uploaded_at' => now(),
        ]);
    }
}
