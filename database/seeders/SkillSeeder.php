<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            [
                'title' => 'Laravel API 設計レビュー',
                'description' => 'Laravel で作る REST API の設計、バリデーション、テスト方針を一緒に整理します。',
                'price' => 8000,
                'category' => 'PROGRAMMING',
                'area' => 'Tokyo',
            ],
            [
                'title' => 'Next.js ポートフォリオ相談',
                'description' => 'Next.js を使ったポートフォリオ制作の構成、画面設計、API 連携をサポートします。',
                'price' => 7000,
                'category' => 'PROGRAMMING',
                'area' => 'Kanagawa',
            ],
            [
                'title' => 'React コンポーネント設計入門',
                'description' => '状態管理、props 設計、コンポーネント分割の考え方をハンズオンで学びます。',
                'price' => 6000,
                'category' => 'PROGRAMMING',
                'area' => 'Tokyo',
            ],
            [
                'title' => 'UI デザインフィードバック',
                'description' => 'Web 画面の余白、情報設計、配色、ボタン導線をレビューします。',
                'price' => 5000,
                'category' => 'DESIGN',
                'area' => 'Chiba',
            ],
            [
                'title' => 'Figma ワイヤーフレーム作成',
                'description' => 'サービス画面のワイヤーフレームを一緒に作り、実装しやすい形へ整理します。',
                'price' => 6500,
                'category' => 'DESIGN',
                'area' => 'Tokyo',
            ],
            [
                'title' => '英語ドキュメント読解サポート',
                'description' => '公式ドキュメントや技術記事を読みながら、重要な表現と内容理解をサポートします。',
                'price' => 4000,
                'category' => 'LANGUAGE',
                'area' => 'Kanagawa',
            ],
            [
                'title' => '英会話ロールプレイ',
                'description' => '日常会話や仕事で使う英語を、実践的なロールプレイで練習します。',
                'price' => 3500,
                'category' => 'LANGUAGE',
                'area' => 'Tokyo',
            ],
            [
                'title' => 'Docker デプロイ相談',
                'description' => 'Dockerfile、環境変数、ビルドエラー、簡易デプロイの確認を一緒に行います。',
                'price' => 7500,
                'category' => 'PROGRAMMING',
                'area' => 'Chiba',
            ],
            [
                'title' => 'Web サービス画面改善レビュー',
                'description' => '既存画面を見ながら、ポートフォリオとして伝わりやすい見せ方へ改善します。',
                'price' => 5500,
                'category' => 'DESIGN',
                'area' => 'Kanagawa',
            ],
        ];

        foreach ($skills as $index => $skill) {
            Skill::query()->create([
                'owner_id' => 'demo-owner-' . ($index + 1),
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
