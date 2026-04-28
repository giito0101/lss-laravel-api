<?php

namespace Database\Seeders;

use App\Enums\SkillCategory;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $users = collect([
            ['id' => 'provider-english-1', 'name' => 'Emma', 'email' => 'emma@example.com'],
            ['id' => 'provider-dog-1', 'name' => 'Kai', 'email' => 'kai@example.com'],
            ['id' => 'provider-pc-1', 'name' => 'Sora', 'email' => 'sora@example.com'],
            ['id' => 'provider-photo-1', 'name' => 'Yuna', 'email' => 'yuna@example.com'],
            ['id' => 'provider-other-1', 'name' => 'Haru', 'email' => 'haru@example.com'],
        ])->map(function (array $user): User {
            return User::query()->updateOrCreate(
                ['id' => $user['id']],
                [
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password_hash' => null,
                    'image' => null,
                    'bio' => null,
                ],
            );
        })->keyBy('id');

        $skills = [
            [
                'owner_id' => 'provider-pc-1',
                'title' => 'Laravel API 設計レビュー',
                'description' => 'Laravel で作る REST API の設計、バリデーション、テスト方針を一緒に整理します。',
                'price' => 8000,
                'category' => SkillCategory::PcSupport->value,
                'area' => 'Tokyo',
            ],
            [
                'owner_id' => 'provider-pc-1',
                'title' => 'Next.js ポートフォリオ相談',
                'description' => 'Next.js を使ったポートフォリオ制作の構成、画面設計、API 連携をサポートします。',
                'price' => 7000,
                'category' => SkillCategory::PcSupport->value,
                'area' => 'Kanagawa',
            ],
            [
                'owner_id' => 'provider-pc-1',
                'title' => 'React コンポーネント設計入門',
                'description' => '状態管理、props 設計、コンポーネント分割の考え方をハンズオンで学びます。',
                'price' => 6000,
                'category' => SkillCategory::PcSupport->value,
                'area' => 'Tokyo',
            ],
            [
                'owner_id' => 'provider-photo-1',
                'title' => 'UI デザインフィードバック',
                'description' => 'Web 画面の余白、情報設計、配色、ボタン導線をレビューします。',
                'price' => 5000,
                'category' => SkillCategory::Photo->value,
                'area' => 'Chiba',
            ],
            [
                'owner_id' => 'provider-photo-1',
                'title' => 'Figma ワイヤーフレーム作成',
                'description' => 'サービス画面のワイヤーフレームを一緒に作り、実装しやすい形へ整理します。',
                'price' => 6500,
                'category' => SkillCategory::Photo->value,
                'area' => 'Tokyo',
            ],
            [
                'owner_id' => 'provider-english-1',
                'title' => '英語ドキュメント読解サポート',
                'description' => '公式ドキュメントや技術記事を読みながら、重要な表現と内容理解をサポートします。',
                'price' => 4000,
                'category' => SkillCategory::English->value,
                'area' => 'Kanagawa',
            ],
            [
                'owner_id' => 'provider-english-1',
                'title' => '英会話ロールプレイ',
                'description' => '日常会話や仕事で使う英語を、実践的なロールプレイで練習します。',
                'price' => 3500,
                'category' => SkillCategory::English->value,
                'area' => 'Tokyo',
            ],
            [
                'owner_id' => 'provider-dog-1',
                'title' => 'Docker デプロイ相談',
                'description' => 'Dockerfile、環境変数、ビルドエラー、簡易デプロイの確認を一緒に行います。',
                'price' => 7500,
                'category' => SkillCategory::DogTraining->value,
                'area' => 'Chiba',
            ],
            [
                'owner_id' => 'provider-other-1',
                'title' => 'Web サービス画面改善レビュー',
                'description' => '既存画面を見ながら、ポートフォリオとして伝わりやすい見せ方へ改善します。',
                'price' => 5500,
                'category' => SkillCategory::Other->value,
                'area' => 'Kanagawa',
            ],
        ];

        foreach ($skills as $skill) {
            Skill::query()->create([
                'owner_id' => $users[$skill['owner_id']]->id,
                'title' => $skill['title'],
                'description' => $skill['description'],
                'price' => $skill['price'],
                'category' => $skill['category'],
                'area' => $skill['area'],
                'image_url' => null,
            ]);
        }
    }
}
